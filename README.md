# Prueba Tecnica Laravel - API de Tareas

API REST para crear, listar, actualizar y eliminar tareas. El proyecto usa Laravel, MariaDB, Nginx, PHP-FPM y Vite mediante Docker Compose.

## Requisitos

- Docker Engine con Docker Compose v2
- Puertos locales `8000`, `5173` y `3306` disponibles
- Si usas Windows O MAC , usar WSL con la distro de Ubuntu de preferencia
  


## Instalacion

1. Clona el repositorio y entra al directorio del proyecto.


2. Crea el archivo de entorno.

```
.env.example .env
```

3. Ajusta la conexion a la base de datos en `.env` para usar los valores del servicio `mariadb` de Docker Compose o ajustalos segun te convenga.

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

4. Construye e inicia los contenedores.

```bash
docker compose up --build -d
```

5. Instala las dependencias PHP y prepara Laravel.

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

6. Abre la aplicacion en `http://localhost:8000`.

El servidor de Vite queda disponible en `http://localhost:5173` para desarrollo de assets.

## Servicios

| Servicio | Contenedor | URL o puerto |
| --- | --- | --- |
| Laravel PHP-FPM | `laravel_app` | Interno: `9000` |
| Nginx | `laravel_nginx` | `http://localhost:8000` |
| MariaDB | `laravel_db` | `localhost:3306` |
| Vite | `laravel_node` | `http://localhost:5173` |

## API

Base URL: `http://localhost:8000/api`

Los estados validos son `pending`, `in_progress` y `done`.

| Metodo | Endpoint | Descripcion |
| --- | --- | --- |
| `GET` | `/task` | Lista las tareas |
| `GET` | `/task?status=done` | Filtra tareas por estado |
| `POST` | `/task` | Crea una tarea |
| `PATCH` | `/task/{id}` | Actualiza parcialmente una tarea |
| `PUT` | `/task/{id}` | Actualiza una tarea |
| `DELETE` | `/task/{id}` | Elimina una tarea |

### Crear una tarea

```bash
curl --request POST http://localhost:8000/api/task \
  --header "Content-Type: application/json" \
  --data '{
    "title": "Preparar entrega",
    "description": "Documentar la API",
    "status": "pending"
  }'
```

`title` es obligatorio y admite hasta 255 caracteres. `description` es opcional. Si no se indica `status`, se usa `pending`.

### Actualizar una tarea

```bash
curl --request PATCH http://localhost:8000/api/task/1 \
  --header "Content-Type: application/json" \
  --data '{"status":"done"}'
```

### Eliminar una tarea

```bash
curl --request DELETE http://localhost:8000/api/task/1
```

Las respuestas de validacion usan HTTP `422`; una tarea inexistente devuelve HTTP `404`.

## Solucion de problemas

Si Laravel muestra un error de permisos para `storage` o `bootstrap/cache`, ejecuta:

```bash
docker compose exec app sh -c 'chgrp -R www-data storage bootstrap/cache && chmod -R ug+rwX storage bootstrap/cache'
```

Si los estilos no cargan, confirma que el servicio `node`  este activo y con el puerto libre `http://localhost:5173`.
