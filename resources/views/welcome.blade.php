<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lista de tareas</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <main class="container py-5">
            <header class="mb-4">
                <p class="text-primary text-uppercase fw-bold mb-1">Prueba tecnica</p>
                <h1>Lista de tareas</h1>
            </header>

            <section class="card mb-4" aria-labelledby="create-task-title">
                <div class="card-body">
                    <h2 id="create-task-title" class="h4">Nueva tarea</h2>
                    <form id="task-form">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titulo</label>
                            <input id="title" name="title" class="form-control" type="text" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripcion</label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending">Pendiente</option>
                                <option value="in_progress">En progreso</option>
                                <option value="done">Completada</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Crear tarea</button>
                    </form>
                </div>
            </section>

            <p id="message" class="fw-semibold" role="status" aria-live="polite"></p>

            <section class="card" aria-labelledby="tasks-title">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 id="tasks-title" class="h4 mb-0">Tareas</h2>
                        <button id="reload-button" class="btn btn-outline-secondary" type="button">Actualizar lista</button>
                    </div>
                    <p id="empty-state" class="text-muted mb-0" hidden>No hay tareas registradas.</p>
                    <div id="task-list" class="vstack gap-3"></div>
                </div>
            </section>
        </main>

        <template id="task-template">
            <article class="task-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <h3 class="h5" data-task-title></h3>
                            <p class="mb-2" data-task-description></p>
                            <span class="badge text-bg-secondary" data-task-status></span>
                        </div>
                        <div class="d-flex gap-2 align-items-start">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-task-edit>Editar</button>
                            <button class="btn btn-outline-danger btn-sm" type="button" data-task-delete>Eliminar</button>
                        </div>
                    </div>

                    <form class="border-top mt-3 pt-3" data-task-edit-form hidden>
                        <div class="mb-3">
                            <label class="form-label">
                                Titulo
                                <input class="form-control" type="text" maxlength="255" required data-task-title-input>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Descripcion
                                <textarea class="form-control" rows="3" data-task-description-input></textarea>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Estado
                                <select class="form-select" data-task-status-input></select>
                            </label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Guardar cambios</button>
                            <button class="btn btn-outline-secondary" type="button" data-task-cancel>Cancelar</button>
                        </div>
                    </form>
                </div>
            </article>
        </template>

        <div id="delete-modal" class="modal fade" tabindex="-1" aria-labelledby="delete-modal-title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="delete-modal-title" class="modal-title fs-5">Eliminar tarea</h2>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        Deseas eliminar la tarea <strong id="delete-task-title"></strong>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button id="confirm-delete-button" class="btn btn-danger" type="button">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
