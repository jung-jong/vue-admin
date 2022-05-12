import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";
import UserList from "@/views/UserList";
import ContentManagement from "@/views/ContentManagement";
import AdminID from "@/views/AdminID";

Vue.use(VueRouter);

const routes = [
  { path: "*", redirect: "/" },
  {
    path: "/",
    component: ProjectList,
  },
  {
    path: "/user",
    component: UserList,
  },
  {
    path: "/content",
    component: ContentManagement,
  },
  {
    path: "/admin-id",
    component: AdminID,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
