import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";

Vue.use(VueRouter);

const routes = [{ path: "/", component: ProjectList }];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
