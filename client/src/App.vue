<template>
  <div>
    <body class="sb-nav-fixed">
      <nav-bar></nav-bar>
      <div id="layoutSidenav">
        <side-nav></side-nav>
        <keep-alive>
          <router-view :key="$route.fullPath"></router-view>
        </keep-alive>
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

<style>
.modal-dialog {
  max-width: none !important;
  justify-content: center;
}
.modal-content {
  width: auto !important;
  min-width: 500px;
}
.form-select {
  width: auto !important;
  display: inline-block !important;
  margin: 0 1rem;
}
.overflow-auto {
  max-height: 70vh;
}
td {
  vertical-align: middle;
}
</style>
