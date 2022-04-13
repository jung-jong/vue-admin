<template>
  <div>
    <h1 class="mt-4">{{ mainMenu }}</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">{{ subMenu }}</li>
    </ol>
  </div>
</template>

<script>
export default {
  props: ["mainMenu", "subMenu"],
};
</script>

<style lang="scss" scoped></style>
