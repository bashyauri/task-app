import "./bootstrap";
import { createApp } from "vue";
import App from "./src/App.vue";
import router from "./src/router/index";
import "vue-toast-notification/dist/theme-bootstrap.css";
// import { createPinia } from "pinia";

const app = createApp(App);

// app.use(createPinia());
app.use(router);
app.mount("#app");
