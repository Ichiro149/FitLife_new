/* Šis skripts nodrošina "bootstrap" interaktivitāti un klienta puses loģiku. */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
