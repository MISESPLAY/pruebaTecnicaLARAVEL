import { Modal } from 'bootstrap';
import { createTask, deleteTask, getTasks, updateTask } from './services';
import { renderTasks, showMessage } from './task-view';

const taskForm = document.querySelector('#task-form');
const reloadButton = document.querySelector('#reload-button');
const deleteModalElement = document.querySelector('#delete-modal');
const deleteTaskTitle = document.querySelector('#delete-task-title');
const confirmDeleteButton = document.querySelector('#confirm-delete-button');
const deleteModal = new Modal(deleteModalElement);
let taskToDelete = null;

const loadTasks = async () => {
    reloadButton.disabled = true;

    try {
        const tasks = await getTasks();

        renderTasks(tasks, { onUpdate: handleUpdate, onDelete: requestDelete });
    } catch (error) {
        showMessage(error.message, 'error');
    } finally {
        reloadButton.disabled = false;
    }
};

const handleUpdate = async (id, data) => {
    try {
        await updateTask(id, data);
        showMessage('Tarea actualizada.', 'success');
        await loadTasks();
    } catch (error) {
        showMessage(error.message, 'error');
    }
};

const handleDelete = async (id) => {
    try {
        await deleteTask(id);
        showMessage('Tarea eliminada.', 'success');
        await loadTasks();
        return true;
    } catch (error) {
        showMessage(error.message, 'error');
        return false;
    }
};

const requestDelete = (task) => {
    taskToDelete = task;
    deleteTaskTitle.textContent = task.title;
    deleteModal.show();
};

confirmDeleteButton.addEventListener('click', async () => {
    if (!taskToDelete) {
        return;
    }

    confirmDeleteButton.disabled = true;
    const deleted = await handleDelete(taskToDelete.id);

    if (deleted) {
        deleteModal.hide();
        taskToDelete = null;
    }

    confirmDeleteButton.disabled = false;
});

taskForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const submitButton = taskForm.querySelector('button[type="submit"]');
    const formData = new FormData(taskForm);

    submitButton.disabled = true;

    try {
        await createTask(Object.fromEntries(formData));
        taskForm.reset();
        showMessage('Tarea creada.', 'success');
        await loadTasks();
    } catch (error) {
        showMessage(error.message, 'error');
    } finally {
        submitButton.disabled = false;
    }
});

reloadButton.addEventListener('click', loadTasks);

loadTasks();
