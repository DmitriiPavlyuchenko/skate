import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "home",
    component: () => import("@/views/HomePage.vue"),
  },
  {
    path: "/news",
    name: "news",
    component: () => import("/src/views/NewsPage.vue"),
  },
  {
    path: "/series",
    name: "series",
    component: () => import("@/views/SeriesPage.vue"),
  },
  {
    path: "/skaters",
    name: "skaters",
    component: () => import("@/views/SkatersPage.vue"),
  },
  {
    path: "/brands",
    name: "brands",
    component: () => import("@/views/BrandsPage.vue"),
  },
  {
    path: "/videos",
    name: "videos",
    component: () => import("@/views/VideosPage.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
