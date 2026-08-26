<p align="center">
  <img src="./public/assets/images/sunat.png" alt="SUNAT Logo" width="250">
</p>

# API de Facturación Electrónica SUNAT - Perú

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Greenter-5.1-4CAF50?style=for-the-badge" alt="Greenter 5.1">
  <img src="https://img.shields.io/badge/SUNAT-Compatible-0066CC?style=for-the-badge" alt="SUNAT Compatible">
</p>

Sistema completo de facturación electrónica para SUNAT Perú desarrollado con **Laravel 12** y la librería **Greenter 5.1**. Este proyecto implementa todas las funcionalidades necesarias para la generación, envío y gestión de comprobantes de pago electrónicos según las normativas de SUNAT.

## 🚀 Características Principales

### Documentos Electrónicos Soportados
- ✅ **Facturas** (Tipo 01)
- ✅ **Boletas de Venta** (Tipo 03) 

### Funcionalidades del Sistema
- 🏢 **Multi-empresa**: Gestión de múltiples empresas y sucursales
- 🔐 **Autenticación OAuth2** para APIs de SUNAT
- 📄 **Generación automática de PDF** con diseño profesional

### Tecnologías Utilizadas
- **Framework**: Laravel 12 con PHP 8.2+
- **SUNAT Integration**: Greenter 5.1
- **Base de Datos**: MySQL/PostgreSQL compatible
- **PDF Generation**: DomPDF con plantillas personalizadas
- **QR Codes**: Endroid QR Code
- **Authentication**: Laravel Sanctum
- **Testing**: PestPHP

## 🛠️ Instalación

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- MySQL 8.0+ o PostgreSQL
- Certificado digital SUNAT (.pfx)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone clone https://github.com/yorchavez9/Api-de-facturacion-electronica-sunat-Peru.git
cd Api-de-facturacion-electronica-sunat-Peru
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=facturacion_sunat
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

5. **Ejecutar migraciones**
```bash
php artisan migrate
```

6. **Configurar certificados SUNAT**
- Colocar certificado .pfx en `storage/certificates/`
- Configurar rutas en el archivo .env

### Conversión de Certificado .pfx a .pem

Si necesitas convertir tu certificado de formato .pfx a .pem, ejecuta el siguiente comando en terminal:

```bash
# Convertir de .PFX a .PEM
openssl pkcs12 -in certificado.pfx -out certificado_correcto.pem -nodes
```

**Nota:** Este comando te pedirá la contraseña de tu certificado .pfx y generará un archivo .pem que puedes usar directamente en el sistema.

## Pruebas locales e integración SUNAT

El panel de pruebas está disponible en `http://127.0.0.1:8000` cuando se levanta Laravel con `php artisan serve`.

Flujo mínimo en localhost:

1. Ejecutar migraciones y seeders.
2. Inicializar usuario administrador.
3. Guardar empresa en ambiente `beta`.
4. Crear factura o boleta.
5. Generar PDF.
6. Validar servicios SUNAT.
7. Enviar a SUNAT solo si el checklist indica certificado y configuración válidos.

Para SUNAT BETA se usan las credenciales publicadas por SUNAT:

- Endpoint facturación: `https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService`
- Usuario SOL: `MODDATOS` (Greenter envía internamente `[RUC]MODDATOS`)
- Clave SOL: `MODDATOS`

SUNAT indica que el servicio BETA sirve para probar estructuras XML UBL 2.1 y no debe usarse para comprobantes reales, pruebas de estrés o envíos masivos. Para usar Greenter igual se necesita un archivo PEM válido con clave privada y certificado, porque el XML debe firmarse digitalmente. En BETA ese certificado no necesita estar registrado en SUNAT.

Para generar un PEM local solo para BETA:

```bash
mkdir -p storage/app/public/certificado
openssl req -x509 -newkey rsa:2048 -sha256 -days 365 -nodes \
  -subj "/C=PE/ST=Lima/L=Lima/O=Facturador SUNAT Beta/CN=20161515648" \
  -keyout storage/app/public/certificado/beta.key \
  -out storage/app/public/certificado/beta.crt
cat storage/app/public/certificado/beta.key storage/app/public/certificado/beta.crt \
  > storage/app/public/certificado/certificado.pem
chmod 600 storage/app/public/certificado/certificado.pem
```

Para producción no se deben usar credenciales ni certificado beta. Se requiere:

- RUC activo, habido y habilitado como emisor electrónico.
- Usuario SOL y clave SOL válidos para el RUC emisor.
- Certificado digital válido del contribuyente o de un PSE autorizado.
- Series y correlativos reales configurados por tipo de comprobante.
- Endpoint de producción según el servicio que corresponda.
- Validación de reglas SUNAT vigentes antes del go-live.

Referencias oficiales:

- Servicio BETA SUNAT: https://orientacion.sunat.gob.pe/12-pautas-servicio-beta
- Certificado Digital SUNAT: https://cpe.sunat.gob.pe/certificado-digital
- Guías, manuales y reglas de validación CPE: https://cpe.sunat.gob.pe/guias-y-manuales

## 🏗️ Arquitectura del Sistema

### Estructura de Modelos
- **Company**: Empresas emisoras
- **Branch**: Sucursales por empresa
- **Client**: Clientes y proveedores
- **Invoice/Boleta/CreditNote/DebitNote**: Documentos electrónicos
- **DailySummary**: Resúmenes diarios de boletas
- **CompanyConfiguration**: Configuraciones por empresa

### Servicios Principales
- **DocumentService**: Lógica de negocio para documentos
- **SunatService**: Integración con APIs de SUNAT  
- **PdfService**: Generación de documentos PDF
- **FileService**: Gestión de archivos XML/PDF
- **TaxCalculationService**: Cálculo de impuestos
- **SeriesService**: Gestión de series documentarias

## 📚 Documentación de la API

### 🎥 Video Tutorial Completo
**Aprende a implementar el sistema paso a paso:**
👉 **[Ver Playlist Completa en YouTube](https://www.youtube.com/watch?v=HrrEdjY_7MU&list=PLfwfiNJ5Qw-ZlCfGnWjnILOI4OJfJkGp5)**

Esta playlist incluye:
- Instalación completa del sistema
- Configuración de certificados SUNAT
- Ejemplos reales de implementación
- Casos de uso prácticos
- Resolución de problemas comunes

### 📖 Documentación y Ejemplos

**Documentación completa y actualizada:**
👉 **[https://apigo.apuuraydev.com/](https://apigo.apuuraydev.com/)**

**Ejemplos listos para usar:**
En el directorio `ejemplos-postman/` encontrarás colecciones completas listas para importar en Postman o herramientas similares, con ejemplos de:
- Facturas, boletas y notas
- Guías de remisión
- Consultas CPE
- Configuraciones avanzadas

## ⚖️ Licencia y Uso

**Este proyecto es de uso libre bajo las siguientes condiciones:**

- ✅ Puedes usar, modificar y distribuir el código libremente
- ✅ Puedes usarlo para proyectos comerciales y personales
- ⚠️ **Todo el uso es bajo tu propia responsabilidad**
- ⚠️ No se ofrece garantía ni soporte oficial
- ⚠️ Debes cumplir con las normativas de SUNAT de tu país

### Importante
- Asegúrate de tener los certificados digitales válidos de SUNAT
- Configura correctamente los endpoints según tu ambiente (beta/producción)
- Realiza pruebas exhaustivas antes de usar en producción
- Mantén actualizadas las librerías de seguridad

## 🤝 Soporte y Donaciones

Si este proyecto te ha sido útil y deseas apoyar su desarrollo:

### 💰 Yape (Perú)
<p align="center">
  <img src="./public/assets/images/yape.png" alt="Yape" width="100">
</p>

**Número:** `920468502`

### 💬 WhatsApp
**Contacto:** [https://wa.link/z50dwk](https://wa.link/z50dwk)

### 📧 Contribuciones
- Fork el proyecto
- Crea una rama para tu feature
- Envía un pull request

---

## 📞 Contacto

Para consultas técnicas o colaboraciones:
- **WhatsApp**: [https://wa.link/z50dwk](https://wa.link/z50dwk)
- **Yape**: 920468502

---

**⚡ Desarrollado con Laravel 12 y Greenter 5.1 para la comunidad peruana**

*"Facilitando la facturación electrónica en Perú - Un documento a la vez"*
