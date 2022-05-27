<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-4 my-3" id="top">
          <div class="col-2">
            <h5 class="fw-bold my-3">컨텐츠 타입</h5>
            <select v-model="selected" class="form-select m-0 mb-1 w-100">
              <option v-for="(contents, i) in contents" :key="i" :value="i + 1">
                {{ contents.CONTENTS_TYPE_NAME }}
              </option>
            </select>
            <div class="card">
              <ul class="list-group list-group-flush overflow-auto h-100">
                <li
                  v-for="(contents, i) in contents"
                  :key="i"
                  :class="{ active: i === activeContents }"
                  @click="
                    selectContents(i, contents);
                    getTheme();
                    totalPage();
                    $loading();
                  "
                  class="list-group-item"
                >
                  {{ contents.CONTENTS_TYPE_NAME }}
                </li>
              </ul>
            </div>
          </div>

          <div class="col-2">
            <h5 class="fw-bold my-3">리스트 방식</h5>
            <div class="card p-3">
              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  type="radio"
                  value="1"
                  id="flexCheckDefault"
                  v-model="check"
                />
                <label class="form-check-label" for="flexCheckDefault">
                  API 기준
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  value="2"
                  id="flexCheckChecked"
                  v-model="check"
                />
                <label class="form-check-label" for="flexCheckChecked">
                  자체 설정
                </label>
              </div>
            </div>
          </div>

          <div class="col-8">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="fw-bold my-3">테마 리스트</h5>
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="outside"
                >
                  + 테마 추가
                </button>
                <ul class="dropdown-menu p-3" style="width: 300px">
                  <li class="mb-3">
                    <input
                      class="form-control"
                      :class="[
                        { 'is-invalid': themeName === '' },
                        { 'is-invalid': activeContents === false },
                      ]"
                      type="text"
                      v-model="themeName"
                    />
                    <div
                      v-if="activeContents === false"
                      class="invalid-feedback"
                    >
                      컨텐츠 타입을 선택하세요.
                    </div>
                    <div v-if="themeName === ''" class="invalid-feedback">
                      테마 제목을 입력하세요.
                    </div>
                  </li>
                  <li class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-3">
                      취소
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="addTheme(), (themeName = '')"
                    >
                      등록
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card justify-content-between" id="theme">
              <ul class="list-group list-group-flush overflow-auto">
                <li
                  v-for="(themeList, i) in themeList"
                  :key="i"
                  :class="{ active: i === activeThemeList }"
                  @click="selectThemeList(i, themeList)"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  {{ themeList.THEME_NAME }}
                  <div class="d-flex">
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="deleteTheme(themeList.SEQ_ID)"
                    >
                      delete
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="
                        upCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_upward
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click="
                        downCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
              <div @click="getCurrentPage()">
                <v-pagination
                  v-model="currentPage"
                  :page-count="totalPages"
                  :classes="bootstrapPaginationClasses"
                  :labels="paginationAnchorTexts"
                ></v-pagination>
              </div>
            </div>
          </div>
        </div>

        <div id="bottom" class="d-flex flex-column position-relative">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold my-3">콘텐츠 리스트</h5>
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#addID"
            >
              + 콘텐츠 추가
            </button>
          </div>
          <div class="card p-3 flex-row flex-wrap overflow-auto">
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
          </div>
          <button
            type="button"
            class="btn btn-secondary text-center btn-lg my-3 mx-auto"
            style="width: 200px"
          >
            저 장
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import PageName from "../components/PageName.vue";
import TableLoading from "../components/TableLoading.vue";
import table from "@/mixins.js";
import vPagination from "vue-plain-pagination";

export default {
  name: "ThemeManagement",
  components: { PageName, TableLoading, vPagination },
  data() {
    return {
      main: "테마 관리",
      contents: [],
      currentContents: {},
      themeList: [],
      currentThemeList: {},
      selected: 0,
      check: 2,
      activeContents: false,
      activeThemeList: false,
      start: 0,
      length: 10,
      indexTheme: null,
      prevSEQ_ID: null,
      nextSEQ_ID: null,
      themeName: "",
    };
  },
  mixins: [table],
  methods: {
    getContents() {
      this.$axios.get("/admin/api/contents_category.php").then((response) => {
        this.contents = response.data;
        this.$endloading();
      });
    },
    selectContents(i, contents) {
      this.activeContents = i;
      this.selected = i + 1;
      this.currentContents = contents;
    },
    getTheme() {
      if (this.check === 2) {
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start,
              length: this.length,
            },
          })
          .then((response) => {
            this.themeList = response.data;
            this.$endloading();
          });
      }
    },
    selectThemeList(i, themeList) {
      this.activeThemeList = i;
      this.currentThemeList = themeList;
    },
    totalPage() {
      if (this.check === 2) {
        this.$axios
          .get("/admin/api/theme_page.php", {
            params: { contents: this.currentContents.SEQ_ID },
          })
          .then((response) => {
            this.totalPages = response.data;
            this.totalPages = Math.ceil(this.totalPages / this.length);
          });
      }
    },
    getCurrentPage() {
      if (this.check === 2) {
        this.$loading();
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start,
              length: this.length,
            },
          })
          .then((response) => {
            this.themeList = response.data;
            this.$endloading();
          });
      }
    },
    upCurrentTheme(i) {
      this.currentThemeList = this.themeList[i].SEQ_ID;
      if (i !== 0) {
        this.prevSEQ_ID = this.themeList[i - 1].SEQ_ID;
        this.indexTheme = i - 1;
        this.orderThemePrev();
      } else if (i === 0) {
        this.indexTheme = this.start - 1;
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start - 1,
              length: 1,
            },
          })
          .then((response) => {
            this.prevSEQ_ID = response.data[0].SEQ_ID;
            this.orderThemePrev();
          });
      }
    },
    downCurrentTheme(i) {
      this.currentThemeList = this.themeList[i].SEQ_ID;
      if (i <= 8) {
        this.nextSEQ_ID = this.themeList[i + 1].SEQ_ID;
        this.indexTheme = i + 1;
        this.orderThemeNext();
      } else if (i === 9) {
        this.indexTheme = this.start + this.length;
        let i = this.currentPage;
        let page = this.length;
        i = page * i - page;
        this.start = i;
        this.$axios
          .get("/admin/api/theme.php", {
            params: {
              contents: this.currentContents.SEQ_ID,
              start: this.start + this.length,
              length: 1,
            },
          })
          .then((response) => {
            this.nextSEQ_ID = response.data[0].SEQ_ID;
            this.orderThemeNext();
          });
      }
    },
    orderTheme() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme);
      fd.append("SEQ_ID", this.currentThemeList);
      this.$axios.post("/admin/api/theme_order.php", fd).then(() => {
        this.getTheme();
      });
    },
    orderThemeNext() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme - 1);
      fd.append("NEXT", this.nextSEQ_ID);
      this.$axios.post("/admin/api/theme_order.php", fd).then(() => {});
    },
    orderThemePrev() {
      this.$loading();
      const fd = new FormData();
      fd.append("ORDER", this.indexTheme + 1);
      fd.append("PREV", this.prevSEQ_ID);
      this.$axios.post("/admin/api/theme_order.php", fd).then(() => {});
    },
    addTheme() {
      if ((this.activeContents !== false) & (this.themeName !== "")) {
        const fd = new FormData();
        fd.append("CONTENTS_CATEGORY_ID", this.currentContents.SEQ_ID);
        fd.append("THEME_NAME", this.themeName);
        fd.append("ORDER", this.contents.length);
        this.$loading();
        this.$axios.post("/admin/api/theme_insert.php", fd).then(() => {
          this.getTheme();
        });
      }
    },
    deleteTheme(id) {
      const fd = new FormData();
      fd.append("SEQ_ID", id);
      if (window.confirm("정말 삭제하시겠습니까?")) {
        this.$loading();
        this.$axios.post("/admin/api/theme_delete.php", fd).then(() => {
          this.getTheme();
        });
      }
    },
  },
  mounted() {
    this.getContents();
  },
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
#top {
  height: 50vh;
}
.overflow-auto {
  max-height: 40vh;
}
#bottom {
  height: 30vh;
  background-color: antiquewhite;
}
#theme {
  height: calc(40vh + 42px);
}
</style>
