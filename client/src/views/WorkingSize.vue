<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-5">
          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button class="btn btn-primary" type="button">
                템플릿 타입 추가
              </button>
              <button class="btn btn-danger ms-auto me-2" type="button">
                ❌ 삭제
              </button>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <ul class="list-group">
              <li
                v-for="(sizeCategory, i) in sizeCategory"
                :key="i"
                :class="{ active: i === activeCategory }"
                @click="activeTemplate(i)"
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                {{ sizeCategory.TEMPLATE_TYPE_NAME }} {{ sizeCategory.ORDER }}
                <div class="d-flex">
                  <span
                    role="button"
                    class="material-symbols-rounded"
                    @click="upCurrentTemplate(i), orderTemplate()"
                  >
                    arrow_upward
                  </span>
                  <span
                    role="button"
                    class="material-symbols-rounded"
                    @click="
                      downCurrentTemplate(i);
                      orderTemplate();
                    "
                  >
                    arrow_downward
                  </span>
                </div>
              </li>
            </ul>
          </div>

          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button class="btn btn-primary" type="button">분류 추가</button>
              <button class="btn btn-danger ms-auto me-2" type="button">
                ❌ 삭제
              </button>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <ul class="list-group">
              <li
                v-for="(size, i) in size"
                :key="i"
                :class="{ active: i === activeSize }"
                @click="activeSizeName(i)"
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                {{ size.SIZE_NAME }}
                <div class="d-flex">
                  <span role="button" class="material-symbols-rounded">
                    arrow_upward
                  </span>
                  <span role="button" class="material-symbols-rounded">
                    arrow_downward
                  </span>
                </div>
              </li>
            </ul>
          </div>

          <div class="col">
            <div
              class="d-flex flex-wrap justify-content-between alingn-items-center my-3"
            >
              <h5 class="fw-bold d-flex align-items-end">작업크기</h5>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5>가로</h5>
                    <input type="text" class="form-control" />
                  </div>
                  <div
                    class="col-1 d-flex align-items-end justify-content-center"
                  >
                    <h5>X</h5>
                  </div>
                  <div class="col">
                    <h5>세로</h5>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="col">
                    <h5>단위</h5>
                    <select v-model="selected" class="form-select">
                      <option value="1">px</option>
                      <option value="2">mm</option>
                      <option value="3">cm</option>
                      <option value="4">inch</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import PageName from "../components/PageName.vue";
import TableLoading from "../components/TableLoading.vue";
import table from "@/mixins.js";

export default {
  name: "AdminID",
  components: { PageName, TableLoading },
  data() {
    return {
      main: "시스템 설정 >",
      sub: "작업크기 관리",
      sizeCategory: [],
      size: [],
      activeCategory: false,
      activeSize: false,
      selected: 1,
      indexTemplate: null,
    };
  },
  mixins: [table],
  methods: {
    getSizeCategory() {
      this.$axios.get("/admin/api/size_category.php").then((response) => {
        this.sizeCategory = response.data;
        this.$endloading();
      });
    },
    addTemplate() {},
    upCurrentTemplate(i) {
      console.log(this.sizeCategory[i].SEQ_ID - 1);
      i = i - 1;
      if (i == -1) i = 0;
      this.indexTemplate = i;
    },
    downCurrentTemplate(i) {
      i = i + 1;
      if (this.sizeCategory.length == i) {
        i = i - 1;
      }
      this.indexTemplate = i;
    },
    orderTemplate() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTemplate);
      // fd.append("SEQ_ID", this.indexTemplate);
      this.$axios.post("/admin/api/order.php", fd).then(() => {
        this.getSizeCategory();
      });
    },
    getSize() {
      this.$axios.get("/admin/api/size.php").then((response) => {
        this.size = response.data;
        this.$endloading();
      });
    },
    activeTemplate(i) {
      this.activeCategory = i;
    },
    activeSizeName(i) {
      this.activeSize = i;
    },
  },
  mounted() {
    this.getSizeCategory();
    this.getSize();
  },
};
</script>

<style scoped></style>
