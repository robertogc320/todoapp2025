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
   - Correo: `admin@example.com`  
   - Contraseña: `test`

## Requisitos previos

Antes de ejecutar el proyecto, asegúrate de contar con lo siguiente:

- **PHP 8.1 o superior**
- **Composer**
- **MariaDB** o cualquier otra base de datos compatible
- **Node.js y npm** (para manejar los assets de frontend)
- **Docker** (opcional, pero recomendado para entornos más distribuidos)

## Configuración inicial

1. Clonar el repositorio:
   ```bash
   git clone <URL_DE_TU_REPOSITORIO>
   cd <NOMBRE_DEL_PROYECTO>


        --Ejecutar Scripts en SQL:
            INSERT INTO recurso_role (role_id, recurso_id)
            SELECT 1, id FROM recursos;

            INSERT INTO role_has_permissions (role_id, permission_id)
            SELECT 1, id FROM permissions;

            INSERT INTO `recurso_role` (`role_id`, `recurso_id`) VALUES ('2', '1');
            INSERT INTO `recurso_role` (`role_id`, `recurso_id`) VALUES ('2', '2');
            INSERT INTO `recurso_role` (`role_id`, `recurso_id`) VALUES ('2', '3');
            INSERT INTO `recurso_role` (`role_id`, `recurso_id`) VALUES ('2', '4');

            INSERT INTO role_has_permissions (role_id, permission_id)
            SELECT 2, id FROM permissions WHERE id>4;
        
        --Datos acceso:
            isc.sergio.dg@gmail.com : password
            --Desde este perfil se pueden crear más usuarios con el perfil de administrador o publicador:
                El perfil de publicador, puede agregar, editar y eliminar: Tipos de Documento y Autoridades Remitentes
                Puede agregar o editar registros de documentos, pero no puede eliminarlos, para ello debe referirse con el administrador.
