# Task Manager

REST API para gestionar tareas pendientes

## Requisitos

- Docker
- Docker Compose

## Instalación

```bash
git clone <repositorio>
cd tasks-manager
docker compose up -d
```

La API estará disponible en `http://localhost:8080`.

## Endpoints

| Método | Ruta | Descripción |
|--------|------|-------------|
| `GET` | `/api/v1/tasks` | Listar todas las tareas |
| `GET` | `/api/v1/tasks/{id}` | Obtener una tarea |
| `POST` | `/api/v1/tasks` | Crear una tarea |
| `PUT` | `/api/v1/tasks/{id}` | Actualizar una tarea |
| `PATCH` | `/api/v1/tasks/{id}/complete` | Marcar tarea como completada |

## Uso

### Crear una tarea

```http
POST /api/v1/tasks
Content-Type: application/json

{
  "title": "Revisar pull requests",
  "priority": "Alta",
  "description": "Revisar los PRs pendientes del equipo",
  "dueDate": "2026-04-01 17:00:00"
}
```

### Actualizar una tarea

```http
PUT /api/v1/tasks/{id}
Content-Type: application/json

{
  "title": "Revisar pull requests",
  "priority": "Media"
}
```

### Marcar como completada

```http
PATCH /api/v1/tasks/{id}/complete
```

### Prioridades
```
Baja
Media
Alta
```

## Desarrollo

### Ejecutar tests

```bash
docker compose exec php vendor/bin/phpunit
```

### Corregir estilo de código

```bash
composer fix
```