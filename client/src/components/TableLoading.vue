<template>
  <button class="btn btn-primary" type="button" disabled>
    <span
      class="spinner-border spinner-border-sm"
      role="status"
      aria-hidden="true"
    ></span>
    Loading...
  </button>
</template>

<script>
export default {
  name: "TableLoading",
};
</script>

<style scoped>
.btn {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 1000;
}
</style>
