import './bootstrap';
import * as bootstrap from 'bootstrap';
import {createApp} from "vue";
import 'vue3-toastify/dist/index.css';

import App from "./App.vue";
import router from "./router";

createApp(App).use(router).mount("#app")
