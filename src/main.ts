import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";
import { API } from "@/constants/api";

const app = createApp(App);

axios.defaults.baseURL = API.DEFAULT_BASEURL;

app.use(store).use(router).mount("#app");
