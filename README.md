# Proyecto Laravel con Jetstream y Livewire

Este proyecto es una aplicación desarrollada en **Laravel**, utilizando **Jetstream** con **Livewire** para proporcionar una experiencia dinámica y moderna.

## Características principales

- **Jetstream**: 
  - Utilizado para gestionar el esquema de autenticación, rutas y diseño del layout principal.
  - Proporciona una base sólida y segura para el manejo de usuarios y sesiones.

- **Livewire**: 
  - Implementado para aprovechar su dinamismo, logrando una **SPA** (Single Page Application).
  - Evita el uso tradicional de llamadas AJAX mediante un enfoque más eficiente y elegante.

## Usuarios para pruebas

La aplicación incluye dos usuarios preconfigurados para facilitar las pruebas:

1. **Usuario Test**  
   - Correo: `test@example.com`  
   - Contraseña: `test`

2. **Roberto**  
   - Correo: `robertogc320@gmail.com`  
   - Contraseña: `test`

## Requisitos previos

Antes de ejecutar el proyecto, asegúrate de contar con lo siguiente:

- **PHP 8.1 o superior**
- **Composer**
- **MariaDB** o cualquier otra base de datos compatible
- **Node.js y npm** (para manejar los assets de frontend)

## Configuración inicial

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/robertogc320/todoapp2025.git
   cd todoapp2025

2. Instalar dependencias de PHP y JavaScript:
   ```bash
   composer install
   npm install
   npm run build

3. Configurar el archivo .env, copia el archivo .env.example y renómbralo a .env:
   ```bash
   cp .env.example .env

    Configura tus credenciales de base de datos
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=todoapp2025
    DB_USERNAME=admin
    DB_PASSWORD=tsj2024

4. Ejecutar las migraciones y seeders:
   ``` bash
   php artisan migrate --seed

## Ejecución del proyecto

1. Iniciar el servidor de desarrollo:
   ```bash
   php artisan serve

5. Accede a la aplicación en tu navegador:
   http://localhost:8000
