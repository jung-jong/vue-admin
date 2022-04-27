import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";
import StorageList from "@/views/StorageList";
import TableView from "@/views/TableView";

Vue.use(VueRouter);

const routes = [
  { path: "/", component: ProjectList },
  {
    path: "/storage",
    component: StorageList,
  },
  {
    path: "/table",
    component: TableView,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
