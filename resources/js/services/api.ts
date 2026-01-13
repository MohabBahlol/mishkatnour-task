import axios from 'axios';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken }),
    },
    withCredentials: true
});

api.defaults.withCredentials = true;

export default api;
