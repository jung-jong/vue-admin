import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";
import memberList from "@/views/memberList";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    component: ProjectList,
  },
  {
    path: "/member",
    component: memberList,
  },
  { path: "*", redirect: "/" },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
