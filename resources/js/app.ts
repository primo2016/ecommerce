// import './bootstrap';
import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import App from './App.vue';

import 'vuetify/styles'; // Vuetify's CSS styles
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
});

const app = createApp(App);
app.use(vuetify);
app.mount('#app');
