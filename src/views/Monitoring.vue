<template>
  <body class="sb-nav-fixed">
    <NavBar></NavBar>
    <div id="layoutSidenav">
      <SideNav></SideNav>
      <ProjectList></ProjectList>
    </div>
  </body>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import SideNav from "@/components/SideNav.vue";
import ProjectList from "@/components/ProjectList.vue";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: "Monitoring",
  components: {
    NavBar,
    SideNav,
    ProjectList,
  },
};
</script>

<style></style>
