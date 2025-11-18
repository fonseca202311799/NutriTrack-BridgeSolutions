import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Attach CSRF token automatically if meta tag present
const csrfTokenMeta = document.head.querySelector('meta[name="csrf-token"]');
if (csrfTokenMeta) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfTokenMeta.content;
}
