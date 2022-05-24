<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-5">
          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button
                class="btn btn-primary"
                type="button"
                @click="showAddTemplate = !showAddTemplate"
              >
                템플릿 타입 추가
              </button>
              <button
                class="btn btn-danger ms-auto me-2"
                type="button"
                @click="deleteTemplate()"
              >
                ❌ 삭제
              </button>
              <button
                class="btn btn-secondary"
                type="button"
                @click="addTemplate()"
              >
                저장
              </button>
            </div>
            <input
              class="form-control mb-3"
              type="text"
              placeholder="템플릿 타입 이름"
              v-if="showAddTemplate"
              v-model="templateName"
            />
            <div class="card">
              <ul class="list-group list-group-flush">
                <li
                  v-for="(sizeCategory, i) in sizeCategory"
                  :key="i"
                  :class="{ active: i === activeCategory }"
                  @click="activeTemplate(i)"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  {{ sizeCategory.TEMPLATE_TYPE_NAME }}
                  <div class="d-flex">
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="
                        upCurrentTemplate(i),
                          orderTemplate(),
                          orderTemplatePrev()
                      "
                    >
                      arrow_upward
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="
                        downCurrentTemplate(i);
                        orderTemplate(), orderTemplateNext();
                      "
                    >
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button
                class="btn btn-primary"
                type="button"
                @click="showAddSize = !showAddSize"
              >
                분류 추가
              </button>
              <button
                class="btn btn-danger ms-auto me-2"
                type="button"
                @click="deleteSize()"
              >
                ❌ 삭제
              </button>
              <button
                class="btn btn-secondary"
                type="button"
                @click="addSize()"
              >
                저장
              </button>
            </div>
            <input
              class="form-control mb-3"
              type="text"
              placeholder="분류 이름"
              v-if="showAddSize"
              v-model="sizeName"
            />
            <div class="card">
              <ul class="list-group list-group-flush">
                <li
                  v-for="(size, i) in size"
                  :key="i"
                  :class="{ active: i === activeSize }"
                  @click="activeSizeName(i)"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  {{ size.ORDER }}
                  {{ size.SIZE_NAME }}
                  <div class="d-flex">
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="upCurrentSize(i), orderSize(), orderSizePrev()"
                    >
                      arrow_upward
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="downCurrentSize(i), orderSize(), orderSizeNext()"
                    >
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="col">
            <div
              class="d-flex flex-wrap justify-content-between alingn-items-center my-3"
            >
              <h5 class="fw-bold d-flex align-items-end">작업크기</h5>
              <button
                class="btn btn-secondary"
                type="button"
                @click="changeSize()"
              >
                저장
              </button>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5>가로</h5>
                    <input type="text" class="form-control" v-model="width" />
                  </div>
                  <div
                    class="col-1 d-flex align-items-end justify-content-center"
                  >
                    <h5>X</h5>
                  </div>
                  <div class="col">
                    <h5>세로</h5>
                    <input type="text" class="form-control" v-model="height" />
                  </div>
                  <div class="col">
                    <h5>단위</h5>
                    <select v-model="selected" class="form-select m-0">
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
      currentSizeCategory: {},
      prevSEQ_ID: null,
      nextSEQ_ID: null,
      size: [],
      currentSize: {},
      activeCategory: false,
      activeSize: false,
      selected: 1,
      indexTemplate: null,
      indexSize: null,
      width: null,
      height: null,
      showAddTemplate: false,
      showAddSize: false,
      templateName: null,
      sizeName: null,
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
    addTemplate() {
      this.$loading();
      const fd = new FormData();
      fd.append("TEMPLATE_TYPE_NAME", this.templateName);
      fd.append("ORDER", this.sizeCategory.length);
      if (this.templateName === null) {
        alert("템플릿 타입 이름을 입력하세요.");
        this.$endloading();
      } else {
        this.$axios.post("/admin/api/size_category_insert.php", fd).then(() => {
          this.getSizeCategory();
        });
      }
    },
    deleteTemplate() {
      const fd = new FormData();
      fd.append("SEQ_ID", this.currentSizeCategory);
      fd.append("SIZE_CATEGORY_ID", this.currentSizeCategory);
      if (window.confirm("정말 삭제하시겠습니까? 분류도 같이 삭제됩니다.")) {
        this.$loading();
        this.$axios.post("/admin/api/size_category_delete.php", fd).then(() => {
          this.$axios.post("/admin/api/size_delete.php", fd).then(() => {
            this.getSizeCategory();
            this.getSize(this.activeCategory);
          });
        });
      }
    },
    upCurrentTemplate(i) {
      this.currentSizeCategory = this.sizeCategory[i].SEQ_ID;
      this.prevSEQ_ID = this.sizeCategory[i - 1].SEQ_ID;
      i = i - 1;
      if (i == -1) i = 0;
      this.indexTemplate = i;
    },
    downCurrentTemplate(i) {
      this.currentSizeCategory = this.sizeCategory[i].SEQ_ID;
      this.nextSEQ_ID = this.sizeCategory[i + 1].SEQ_ID;
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
      fd.append("SEQ_ID", this.currentSizeCategory);
      this.$axios.post("/admin/api/size_category_order.php", fd).then(() => {
        this.getSizeCategory();
      });
    },
    orderTemplateNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTemplate - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/size_category_order.php", fd).then(() => {});
    },
    orderTemplatePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTemplate + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/size_category_order.php", fd).then(() => {});
    },
    activeTemplate(i) {
      this.activeCategory = i;
      this.currentSizeCategory = this.sizeCategory[i].SEQ_ID;
      this.getSize(i);
    },
    getSize(i) {
      this.$loading();
      this.$axios
        .get("/admin/api/size.php", {
          params: {
            template: this.sizeCategory[i].SEQ_ID,
          },
        })
        .then((response) => {
          this.size = response.data;
          this.$endloading();
        });
    },
    upCurrentSize(i) {
      this.currentSize = this.size[i].SEQ_ID;
      this.prevSEQ_ID = this.size[i - 1].SEQ_ID;
      i = i - 1;
      if (i == -1) i = 0;
      this.indexSize = i;
    },
    downCurrentSize(i) {
      this.currentSize = this.size[i].SEQ_ID;
      this.nextSEQ_ID = this.size[i + 1].SEQ_ID;
      i = i + 1;
      if (this.size.length == i) {
        i = i - 1;
      }
      this.indexSize = i;
    },
    addSize() {
      this.$loading();
      const fd = new FormData();
      fd.append("SIZE_CATEGORY_ID", this.currentSizeCategory);
      fd.append("SIZE_NAME", this.sizeName);
      fd.append("ORDER", this.size.length);
      if (this.sizeName === null) {
        alert("분류 이름을 입력하세요.");
        this.$endloading();
      } else if (this.activeCategory === false) {
        alert("템플릿 타입을 선택하세요.");
      } else {
        this.$axios.post("/admin/api/size_insert.php", fd).then(() => {
          this.getSize(this.activeCategory);
        });
      }
    },
    deleteSize() {
      this.$loading();
      const fd = new FormData();
      fd.append("SIZE", this.currentSize);
      if (window.confirm("정말 삭제하시겠습니까?")) {
        this.$axios.post("/admin/api/size_delete.php", fd).then(() => {
          this.getSize(this.activeCategory);
        });
      }
    },
    orderSize() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize);
      fd.append("SEQ_ID", this.currentSize);
      this.$axios.post("/admin/api/size_order.php", fd).then(() => {
        this.getSize(this.activeCategory);
      });
    },
    orderSizeNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/size_order.php", fd).then(() => {});
    },
    orderSizePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/size_order.php", fd).then(() => {});
    },
    activeSizeName(i) {
      this.$loading();
      this.activeSize = i;
      this.currentSize = this.size[i].SEQ_ID;
      this.$axios
        .get("/admin/api/size.php", {
          params: {
            size: this.size[i].SEQ_ID,
          },
        })
        .then((response) => {
          this.width = response.data[0].PAGE_WIDTH;
          this.height = response.data[0].PAGE_HEIGHT;
          this.selected = response.data[0].SCALE_CD;
          this.$endloading();
        });
    },
    changeSize() {
      this.$loading();
      const fd = new FormData();
      fd.append("SEQ_ID", this.currentSize);
      fd.append("PAGE_WIDTH", this.width);
      fd.append("PAGE_HEIGHT", this.height);
      fd.append("SCALE_CD", this.selected);
      this.$axios.post("/admin/api/size_update.php", fd).then(() => {
        this.activeSizeName(this.activeSize);
      });
    },
  },
  mounted() {
    this.getSizeCategory();
  },
};
</script>

<style scoped></style>
