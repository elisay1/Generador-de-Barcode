<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Generador de Cantidades Requeridas de Barcode en Laravel

**Descripción:**

El **"Generador de Cantidades Requeridas de Barcode en Laravel"** es una aplicación web desarrollada utilizando el framework Laravel, diseñada para generar y gestionar códigos de barras en función de las necesidades específicas del usuario. Esta herramienta permite a los usuarios generar múltiples etiquetas de código de barras para productos, según la cantidad requerida, y proporciona una interfaz sencilla para la visualización y posterior impresión de las etiquetas.

## Características Principales

1. **Generación Dinámica de Códigos de Barras:**
   - Permite generar códigos de barras en formato PNG utilizando la librería **milon/barcode**.
   - Admite varios formatos de código de barras, incluyendo C128 y PHARMA2T.

2. **Interfaz de Usuario Intuitiva:**
   - Formulario de entrada para especificar la cantidad de etiquetas requeridas.
   - Modal para previsualizar las etiquetas generadas antes de imprimir.

3. **Impresión de Etiquetas:**
   - Funcionalidad para imprimir etiquetas directamente desde la aplicación.
   - Opciones de formato para personalizar la apariencia de las etiquetas.

4. **Almacenamiento y Gestión:**
   - Posibilidad de almacenar la imagen generada del código de barras en la base de datos.
   - Gestión eficiente de los productos y sus códigos de barras asociados.

## Beneficios

- **Eficiencia:** Facilita la generación de múltiples etiquetas de código de barras de manera rápida y sencilla.
- **Flexibilidad:** Ofrece opciones de personalización para satisfacer las necesidades específicas de los usuarios.
- **Integración:** Se integra perfectamente con la base de datos para gestionar y almacenar la información de los productos y sus códigos de barras.
- **Usabilidad:** La interfaz de usuario amigable permite una experiencia fluida, incluso para usuarios sin conocimientos técnicos avanzados.

## Tecnologías Utilizadas

- **Backend:** Laravel
- **Frontend:** Bootstrap, JavaScript
- **Librerías:** milon/barcode
- **Base de Datos:** MySQL

## Requisitos del Sistema

- PHP >= 8.1
- Composer
- MySQL
- Extensiones de PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/elisay1/Generador-de-Barcode.git
   cd generador-barcode-laravel

## Configuraciones 
2. Instalar las dependencias:
   ```bash
   composer install
3. Configurar el archivo .env:
   ```bash
   cp .env.example .env  
4. Genera tu clave
    ```bash
     php artisan key:generate
5. Instala la libreria milon/barcode
    ```bash
    composer require milon/barcode
6. Configurar la base de datos en el archivo .env:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_base_de_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
7. Migrar la base de datos:
   ```bash
   php artisan migrate
8. Iniciar el servidor de desarrollo:
    - Iniciar el servidor de desarrollo:
    ```bash
    php artisan serve
9. Uso
    - Accede a la aplicación en tu navegador:
    ```bash
    http://127.0.0.1:8000
## Contribuciones

¡Las contribuciones son bienvenidas! Si deseas contribuir a este proyecto, por favor sigue estos pasos:

1. Haz un fork del proyecto.
2. Crea una nueva rama:
   ```bash
   git checkout -b feature/nueva-funcionalidad
3. Realiza tus cambios y haz commit:
   ```bash
   git commit -am 'Añadir nueva funcionalidad'

5. Sube tus cambios:
   ```bash
   git push origin feature/nueva-funcionalidad

   
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
