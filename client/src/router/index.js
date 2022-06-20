import Vue from "vue";
import VueRouter from "vue-router";
import ProjectList from "@/views/ProjectList";
import UserList from "@/views/UserList";
import AdminID from "@/views/AdminID";
import WorkingSize from "@/views/WorkingSize";
import ThemeManamement from "@/views/ThemeManagement";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    component: ProjectList,
  },
  {
    path: "/user-list",
    component: UserList,
  },
  {
    path: "/admin-id",
    component: AdminID,
  },
  {
    path: "/woking-size",
    component: WorkingSize,
  },
  {
    path: "/theme",
    component: ThemeManamement,
  },
  { path: "*", redirect: "/" },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
