<template>
  <div>
    <div class="d-flex flex-wrap align-items-center" id="rgb">
      <input
        type="color"
        class="form-control form-control-color color"
        id="color"
        v-model="color"
        @change="chageColor(color)"
      />
      <label id="color" class="fs-6 ms-2">{{ color }}</label>
    </div>
  </div>
</template>

<script>
export default {
  name: "ColorPicker",
  data() {
    return {
      color: "#000000",
      i: 0,
    };
  },
  props: { index: Number },
  methods: {
    chageColor() {
      this.$emit("index", this.index);
      this.$emit("input", this.color);
    },
  },
};
</script>

<style scoped>
.color {
  -webkit-appearance: none;
  font-size: inherit;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 100%;
}
.color:focus {
  box-shadow: none;
}
.color::-webkit-color-swatch {
  border: none;
  border-radius: 100%;
  padding: 0;
}
.color::-webkit-color-swatch-wrapper {
  border: none;
  border-radius: 100%;
  padding: 0;
}
</style>
