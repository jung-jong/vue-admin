<template>
  <div>
    <body class="sb-nav-fixed">
      <nav-bar></nav-bar>
      <div id="layoutSidenav">
        <side-nav></side-nav>
        <router-view></router-view>
      </div>
    </body>
  </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
import SideNav from "./components/SideNav.vue";

export default {
  name: "app",
  components: {
    NavBar,
    SideNav,
  },
};
</script>

<style></style>
