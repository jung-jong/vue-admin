<template>
  <div>
    <div class="d-flex flex-wrap align-items-center" id="rgb">
      <input
        type="color"
        class="form-control form-control-color color"
        id="color"
        v-model="color"
        @change="changeColor(color)"
      />
      <label id="color" class="fs-6 ms-2">{{ color }}</label>
      <span
        class="material-symbols-rounded fs-4 ms-2"
        role="button"
        @click="deleteColor"
      >
        close
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "ColorPicker",
  data() {
    return {
      color: "#000000",
      propsRgb: this.rgb,
    };
  },
  props: { index: Number, rgb: Array },
  methods: {
    changeColor() {
      this.$emit("index", this.index);
      this.$emit("input", this.color);
    },
    deleteColor() {
      this.$emit("delete", this.index);
    },
  },
  mounted() {
    if (this.index !== undefined && this.propsRgb !== undefined) {
      this.color = this.propsRgb[this.index];
    }
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
