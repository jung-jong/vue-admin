<template>
  <div id="app">
    <Monitoring></Monitoring>
    <!-- <router-link to="/"></router-link>
    <router-view /> -->
  </div>
</template>

<script>
import Monitoring from "@/views/Monitoring.vue";

export default {
  name: "app",
  components: {
    Monitoring,
  },
};
</script>

<style></style>
