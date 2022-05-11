import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";
import MemberList from "@/views/MemberList";
import ContentManagement from "@/views/ContentManagement";

Vue.use(VueRouter);

const routes = [
  { path: "*", redirect: "/" },
  {
    path: "/",
    component: ProjectList,
  },
  {
    path: "/member",
    component: MemberList,
  },
  {
    path: "/content",
    component: ContentManagement,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
