const apiUrl = '/api/task';

const getErrorMessage = (result) => {
    const errors = Object.values(result.errors ?? {}).flat();

    return errors[0] ?? result.message ?? 'No fue posible completar la solicitud.';
};

const request = async (url, options = {}) => {
    const response = await fetch(url, options);
    const result = await response.json();

    if (!response.ok) {
        throw new Error(getErrorMessage(result));
    }

    return result;
};

export const getTasks = async () => {
    const result = await request(apiUrl);

    return result.data ?? [];
};

export const createTask = (data) => request(apiUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
});

export const updateTask = (id, data) => request(`${apiUrl}/${id}`, {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
});

export const deleteTask = (id) => request(`${apiUrl}/${id}`, {
    method: 'DELETE',
});
