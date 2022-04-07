<template>
  <body class="sb-nav-fixed">
    <NavBar></NavBar>
    <div id="layoutSidenav">
      <SideNav></SideNav>
    </div>
  </body>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import SideNav from "@/components/SideNav.vue";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Monitoring",
  components: {
    NavBar,
    SideNav,
  },
};
</script>

<style></style>
