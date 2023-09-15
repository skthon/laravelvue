import "primevue/resources/themes/saga-blue/theme.css";
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import 'bootstrap/scss/bootstrap.scss';
import App from './Components/App.vue'

createApp(App).use(PrimeVue)
    .mount("#app")
