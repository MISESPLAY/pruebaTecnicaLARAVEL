import { statusOptions } from './Status.js';

const taskList = document.querySelector('#task-list');
const emptyState = document.querySelector('#empty-state');
const message = document.querySelector('#message');
const taskTemplate = document.querySelector('#task-template');

export const showMessage = (text = '', type = '') => {
    message.textContent = text;
    message.className = type === 'error' ? 'alert alert-danger' : type === 'success' ? 'alert alert-success' : '';
};

const createStatusOptions = (select, selectedStatus) => {
    Object.entries(statusOptions).forEach(([value, label]) => {
        const option = document.createElement('option');

        option.value = value;
        option.textContent = label;
        option.selected = value === selectedStatus;
        select.appendChild(option);
    });
};

const createTaskCard = (task, { onUpdate, onDelete }) => {
    const fragment = taskTemplate.content.cloneNode(true);
    const card = fragment.querySelector('.task-card');
    const title = fragment.querySelector('[data-task-title]');
    const description = fragment.querySelector('[data-task-description]');
    const status = fragment.querySelector('[data-task-status]');
    const form = fragment.querySelector('[data-task-edit-form]');
    const titleInput = fragment.querySelector('[data-task-title-input]');
    const descriptionInput = fragment.querySelector('[data-task-description-input]');
    const statusSelect = fragment.querySelector('[data-task-status-input]');
    const editButton = fragment.querySelector('[data-task-edit]');
    const cancelButton = fragment.querySelector('[data-task-cancel]');
    const deleteButton = fragment.querySelector('[data-task-delete]');

    title.textContent = task.title;
    description.textContent = task.description || 'Sin descripcion';
    status.textContent = statusOptions[task.status] ?? task.status;
    titleInput.value = task.title;
    descriptionInput.value = task.description ?? '';
    createStatusOptions(statusSelect, task.status);

    const toggleEditForm = (show) => {
        form.hidden = !show;
        editButton.hidden = show;
    };

    editButton.addEventListener('click', () => toggleEditForm(true));
    cancelButton.addEventListener('click', () => toggleEditForm(false));

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        await onUpdate(task.id, {
            title: titleInput.value,
            description: descriptionInput.value || null,
            status: statusSelect.value,
        });
    });

    deleteButton.addEventListener('click', () => onDelete(task));

    return card;
};

export const renderTasks = (tasks, handlers) => {
    taskList.replaceChildren(...tasks.map((task) => createTaskCard(task, handlers)));
    emptyState.hidden = tasks.length > 0;
};
