import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import transitions from "@/components/transitions";

const app = createApp(App);

transitions.forEach((component) => {
  app.component(component.name, component);
});

app.use(store).use(router).mount("#app");
