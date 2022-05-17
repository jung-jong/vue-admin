<template>
  <div>
    <h3 class="m-3 ms-0 fw-bold">
      {{ mainMenu }}
    </h3>
    <h3 class="my-3">{{ subMenu }}</h3>
  </div>
</template>

<script>
export default {
  props: ["mainMenu", "subMenu"],
};
</script>

<style scoped>
h1,
h2,
h3 {
  display: inline-block;
  vertical-align: middle;
}
</style>
