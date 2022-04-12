<template>
  <div>
    <h1 class="mt-4">{{ main }}</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">{{ sub }}</li>
    </ol>
  </div>
</template>

<script>
export default {
  props: ["main", "sub"],
};
</script>

<style lang="scss" scoped></style>
