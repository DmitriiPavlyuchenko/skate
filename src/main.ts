import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";
import { API } from "@/constants/api";
import components from "@/components/Ui";
import Toaster from "@meforma/vue-toaster";

const app = createApp(App);

axios.defaults.baseURL = API.DEFAULT_BASEURL;

components.forEach((component) => {
  app.component(component.name, component);
});

app.use(store).use(Toaster).use(router).mount("#app");
