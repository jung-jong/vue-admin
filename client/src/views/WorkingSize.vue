<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-5">
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
                @click="
                  addTemplate();
                  templateName = '';
                  sizeCategoryUseUnused();
                "
              >
                저장
              </button>
            </div>
            <div class="mb-3">
              <input
                class="form-control"
                :class="{ 'is-invalid': templateName === '' }"
                type="text"
                v-if="showAddTemplate"
                v-model="templateName"
              />
              <div v-if="templateName === ''" class="invalid-feedback">
                템플릿 타입 제목을 입력하세요.
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <h6 class="ms-3">이름</h6>
              </div>
              <div class="col-3">
                <h6 class="text-center me-3">정렬순</h6>
              </div>
              <div class="col-3">
                <h6 class="text-end">검색 적용 여부</h6>
              </div>
            </div>
            <div class="card">
              <ul class="list-group list-group-flush overflow-auto">
                <li class="list-group-item" v-if="noSizeCategory">
                  <h6>템플릿 타입을 추가하세요.</h6>
                </li>
                <li
                  v-for="(sizeCategory, i) in sizeCategory"
                  :key="i"
                  :class="{ active: i === activeCategory }"
                  @click="activeTemplate(i)"
                  class="list-group-item hover"
                >
                  <div class="row justify-content-between align-items-center">
                    <div class="col-6">
                      {{ sizeCategory.TEMPLATE_TYPE_NAME }}
                    </div>
                    <div class="col-3">
                      <div class="d-flex justify-content-center">
                        <span
                          role="button"
                          class="material-symbols-rounded"
                          @click="
                            upCurrentTemplate(i);
                            orderTemplate();
                            orderTemplatePrev();
                          "
                        >
                          arrow_upward
                        </span>
                        <span
                          role="button"
                          class="material-symbols-rounded"
                          @click="
                            downCurrentTemplate(i);
                            orderTemplate();
                            orderTemplateNext();
                          "
                        >
                          arrow_downward
                        </span>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="d-flex justify-content-end">
                        <input
                          class="form-check-input fs-6"
                          type="checkbox"
                          id="checkboxNoLabel"
                          :value="sizeCategory.SEQ_ID"
                          v-model="useSizeCategory"
                          @click.stop="
                            sizeCategoryCheck($event);
                            activeTemplate(false);
                          "
                        />
                      </div>
                    </div>
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
                @click="
                  addSize();
                  sizeName = '';
                  sizeUseUnused();
                "
              >
                저장
              </button>
            </div>
            <div class="mb-3">
              <input
                class="form-control"
                :class="[
                  { 'is-invalid': sizeName === '' },
                  { 'is-invalid': activeCategory === false },
                ]"
                type="text"
                v-if="showAddSize"
                v-model="sizeName"
              />
              <div v-if="activeCategory === false" class="invalid-feedback">
                템플릿 타입을 선택하세요.
              </div>
              <div v-if="sizeName === ''" class="invalid-feedback">
                분류 제목을 입력하세요.
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <h6 class="ms-3">이름</h6>
              </div>
              <div class="col-3">
                <h6 class="text-center me-3">정렬순</h6>
              </div>
              <div class="col-3">
                <h6 class="text-end">검색 적용 여부</h6>
              </div>
            </div>
            <div class="card">
              <ul class="list-group list-group-flush overflow-auto">
                <li class="list-group-item" v-if="noSize">
                  <h6>분류를 추가하세요.</h6>
                </li>
                <li
                  v-for="(size, i) in size"
                  :key="i"
                  :class="{ active: i === activeSize }"
                  @click="activeSizeName(i)"
                  class="list-group-item hover"
                >
                  <div class="row justify-content-between align-items-center">
                    <div class="col-6">
                      {{ size.SIZE_NAME }}
                    </div>
                    <div class="col-3">
                      <div class="d-flex justify-content-center">
                        <span
                          role="button"
                          class="material-symbols-rounded"
                          @click="
                            upCurrentSize(i);
                            orderSize();
                            orderSizePrev();
                          "
                        >
                          arrow_upward
                        </span>
                        <span
                          role="button"
                          class="material-symbols-rounded"
                          @click="
                            downCurrentSize(i);
                            orderSize();
                            orderSizeNext();
                          "
                        >
                          arrow_downward
                        </span>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="d-flex justify-content-end">
                        <input
                          class="form-check-input fs-6"
                          type="checkbox"
                          id="checkboxNoLabel"
                          :value="size.SEQ_ID"
                          v-model="useSize"
                          @click.stop="
                            sizeCheck($event);
                            activeSizeName(false);
                          "
                        />
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="col">
            <div
              class="d-flex flex-wrap justify-content-between alingn-items-center my-3"
            >
              <h5 class="fw-bold">작업크기</h5>
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
                    <select v-model="selected" class="form-select m-0 fs-6">
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
      selected: "1",
      indexTemplate: null,
      indexSize: null,
      width: null,
      height: null,
      showAddTemplate: false,
      showAddSize: false,
      templateName: "",
      sizeName: "",
      useSizeCategory: [],
      unusedSizeCategory: [],
      useSize: [],
      unusedSize: [],
      noSizeCategory: false,
      noSize: false,
    };
  },
  mixins: [table],
  methods: {
    getSizeCategory() {
      this.$axios.get("/admin/api/size-category.php").then((response) => {
        if (response.data == null) return (this.noSizeCategory = true);
        else this.noSizeCategory = false;
        this.sizeCategory = response.data;
        this.$endloading();
        this.useSizeCategory = [];
        this.unusedSizeCategory = [];
        // 사용 컨텐츠 보여줌
        for (const i in this.sizeCategory) {
          if (this.sizeCategory[i].PUBLIC_FLAG == 1) {
            this.useSizeCategory.push(this.sizeCategory[i].SEQ_ID);
          }
        }
      });
    },
    addTemplate() {
      if (this.templateName !== "") {
        this.$loading();
        const fd = new FormData();
        fd.append("TEMPLATE_TYPE_NAME", this.templateName);
        fd.append("ORDER", this.sizeCategory.length);
        this.$axios
          .post("/admin/api/size-category.php", fd)
          .then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
            this.getSizeCategory();
          });
      }
    },
    deleteTemplate() {
      if (this.activeCategory === false) return;
      const fd = new FormData();
      fd.append("deleteTemplate", this.currentSizeCategory);
      fd.append("SIZE_CATEGORY_ID", this.currentSizeCategory);
      if (window.confirm("정말 삭제하시겠습니까? 분류도 같이 삭제됩니다.")) {
        this.$loading();
        this.$axios
          .post("/admin/api/size-category.php", fd)
          .then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
            this.$axios.post("/admin/api/size.php", fd).then((response) => {
              if (response.data.DB !== "success")
                return alert("API Error: " + response.data);
              this.getSizeCategory();
              this.getSize(this.activeCategory);
            });
          });
      }
    },
    upCurrentTemplate(i) {
      if (i !== 0) {
        this.currentSizeCategory = this.sizeCategory[i].SEQ_ID;
        this.prevSEQ_ID = this.sizeCategory[i - 1].SEQ_ID;
        i = i - 1;
        if (i == -1) i = 0;
        this.indexTemplate = i;
      }
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
      this.$axios.post("/admin/api/size-category-order.php", fd).then(() => {
        this.getSizeCategory();
      });
    },
    orderTemplateNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTemplate - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/size-category-order.php", fd).then(() => {});
    },
    orderTemplatePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTemplate + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/size-category-order.php", fd).then(() => {});
    },
    activeTemplate(i) {
      if (i === false) return;
      this.activeCategory = i;
      this.currentSizeCategory = this.sizeCategory[i].SEQ_ID;
      this.getSize(i);
      this.activeSize = false;
      this.width = null;
      this.height = null;
      this.selected = "1";
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
          if (response.data == null) this.noSize = true;
          else this.noSize = false;
          this.size = response.data;
          this.$endloading();
          this.useSize = [];
          this.unusedSize = [];
          // 사용 컨텐츠 보여줌
          for (const i in this.size) {
            if (this.size[i].PUBLIC_FLAG == 1) {
              this.useSize.push(this.size[i].SEQ_ID);
            }
          }
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
      if (this.activeCategory !== false && this.sizeName !== "") {
        this.$loading();
        const fd = new FormData();
        fd.append("SIZE_CATEGORY_ID", this.currentSizeCategory);
        fd.append("addSize", this.sizeName);
        fd.append("ORDER", this.size.length);
        this.$axios.post("/admin/api/size.php", fd).then((response) => {
          if (response.data.DB !== "success")
            return alert("API Error: " + response.data);
          this.getSize(this.activeCategory);
        });
      }
    },
    deleteSize() {
      if (this.activeSize === false) return;
      this.$loading();
      const fd = new FormData();
      fd.append("deleteSize", this.currentSize);
      if (window.confirm("정말 삭제하시겠습니까?")) {
        this.$axios.post("/admin/api/size.php", fd).then((response) => {
          if (response.data.DB !== "success")
            return alert("API Error: " + response.data);
          this.getSize(this.activeCategory);
        });
      }
    },
    orderSize() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize);
      fd.append("SEQ_ID", this.currentSize);
      this.$axios.post("/admin/api/size-order.php", fd).then(() => {
        this.getSize(this.activeCategory);
      });
    },
    orderSizeNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/size-order.php", fd).then(() => {});
    },
    orderSizePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexSize + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/size-order.php", fd).then(() => {});
    },
    activeSizeName(i) {
      if (i === false) return;
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
      this.$axios.post("/admin/api/size.php", fd).then((response) => {
        if (response.data.DB !== "success")
          return alert("API Error: " + response.data);
        this.activeSizeName(this.activeSize);
      });
    },
    sizeCategoryCheck(event) {
      let value = event.target.value;
      if (event.target.checked === false) {
        this.unusedSizeCategory.push(value);
        let set = new Set(this.unusedSizeCategory);
        this.unusedSizeCategory = [...set];
        const index = this.useSizeCategory.indexOf(value);
        if (index > -1) this.useSizeCategory.splice(index, 1);
      } else if (event.target.checked === true) {
        this.useSizeCategory.push(value);
        let set = new Set(this.useSizeCategory);
        this.useSizeCategory = [...set];
        const index = this.unusedSizeCategory.indexOf(value);
        if (index > -1) this.unusedSizeCategory.splice(index, 1);
      }
    },
    sizeCategoryUseUnused() {
      if (this.useSizeCategory !== []) {
        for (const i in this.useSizeCategory) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 1);
          fd.append("SEQ_ID", this.useSizeCategory[i]);
          this.$axios
            .post("/admin/api/size-category.php", fd)
            .then((response) => {
              if (response.data.DB !== "success")
                return alert("API Error: " + response.data);
            });
        }
      }
      if (this.unusedSizeCategory !== []) {
        for (const i in this.unusedSizeCategory) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 0);
          fd.append("SEQ_ID", this.unusedSizeCategory[i]);
          this.$axios
            .post("/admin/api/size-category.php", fd)
            .then((response) => {
              if (response.data.DB !== "success")
                return alert("API Error: " + response.data);
            });
        }
      }
      if (
        this.useSizeCategory.length != 0 ||
        this.unusedSizeCategory.length != 0
      )
        alert("검색 적용 여부 변경됨");
    },
    sizeCheck(event) {
      let value = event.target.value;
      if (event.target.checked === false) {
        this.unusedSize.push(value);
        let set = new Set(this.unusedSize);
        this.unusedSize = [...set];
        const index = this.useSize.indexOf(value);
        if (index > -1) this.useSize.splice(index, 1);
      } else if (event.target.checked === true) {
        this.useSize.push(value);
        let set = new Set(this.useSize);
        this.useSize = [...set];
        const index = this.unusedSize.indexOf(value);
        if (index > -1) this.unusedSize.splice(index, 1);
      }
    },
    sizeUseUnused() {
      if (this.useSize !== []) {
        for (const i in this.useSize) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 1);
          fd.append("SEQ_ID", this.useSize[i]);
          this.$axios.post("/admin/api/size.php", fd).then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
          });
        }
      }
      if (this.unusedSize !== []) {
        for (const i in this.unusedSize) {
          const fd = new FormData();
          fd.append("PUBLIC_FLAG", 0);
          fd.append("SEQ_ID", this.unusedSize[i]);
          this.$axios.post("/admin/api/size.php", fd).then((response) => {
            if (response.data.DB !== "success")
              return alert("API Error: " + response.data);
          });
        }
      }
      if (this.useSize.length != 0 || this.unusedSize.length != 0)
        alert("검색 적용 여부 변경됨");
    },
  },
  mounted() {
    this.getSizeCategory();
  },
};
</script>

<style scoped>
.hover:hover {
  cursor: pointer;
  background-color: var(--bs-blue);
  color: var(--bs-white);
}
</style>
