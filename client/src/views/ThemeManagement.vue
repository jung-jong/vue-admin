<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-4 mb-3" id="top">
          <div class="col-2">
            <h5 class="fw-bold my-3">콘텐츠 타입</h5>
            <select
              v-model="selected"
              class="form-select m-0 mb-1 w-100"
              @change="selectContents(selected - 1), selectOption(selected)"
            >
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
                  v-model="listCheck"
                  @change="getTheme()"
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
                  v-model="listCheck"
                  @change="getTheme()"
                />
                <label class="form-check-label" for="flexCheckChecked">
                  자체 설정
                </label>
              </div>
            </div>
            <div class="alert alert-danger my-3" role="alert" v-if="apiCheck">
              API 기준에서 선택할 수 없습니다.
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
                  data-bs-auto-close="inside"
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
                      콘텐츠 타입을 선택하세요.
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
              data-bs-target="#staticBackdrop"
              @click="getSizeCategory()"
            >
              + 콘텐츠 추가
            </button>
          </div>
          <div class="card px-3 flex-row flex-wrap overflow-auto">
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 150px; height: 150px"
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

        <!-- 콘텐츠 추가 -->
        <div
          class="modal fade"
          id="staticBackdrop"
          data-bs-backdrop="static"
          data-bs-keyboard="false"
        >
          <!-- 템플릿 -->
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                  콘텐츠 추가 - {{ currentContents.CONTENTS_TYPE_NAME }}
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body p-5">
                <div class="mb-3 row">
                  <label for="conname" class="col-2 col-form-label fw-bold"
                    >콘텐츠 이름</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="conname"
                      v-model="contentsName"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="contype" class="col-2 col-form-label fw-bold"
                    >콘텐츠 타입</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contype"
                      readonly
                      :value="currentContents.CONTENTS_TYPE_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="contheme" class="col-2 col-form-label fw-bold"
                    >콘텐츠 테마</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="contheme"
                      readonly
                      :value="currentThemeList.THEME_NAME"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="keyword" class="col-2 col-form-label fw-bold"
                    >키워드</label
                  >
                  <div class="col-10">
                    <input
                      type="text"
                      class="form-control"
                      id="keyword"
                      v-model="keyword"
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col-2 col-form-label fw-bold">썸네일</div>
                  <div class="col-10">
                    <div class="row flex-column">
                      <img
                        :src="thumbnail"
                        id="thumbnail"
                        :class="{ thubnail: thumbnail != null }"
                        class="p-0"
                        alt=""
                      />
                      <div class="input-group w-50">
                        <input
                          type="file"
                          class="form-control"
                          id="thumbFile"
                          @change="onFileSelected($event)"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-2 col-form-label fw-bold">콘텐츠</div>
                  <div class="col-10">
                    <div class="row">
                      <div class="input-group w-50">
                        <input
                          type="file"
                          class="form-control"
                          id="contentsFile"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold">콘텐츠 용도</div>
                  <div class="col-10">
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="useWeb"
                        value="web"
                        v-model="useType"
                      />
                      <label class="form-check-label" for="useWeb">웹용</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="usePrint"
                        value="print"
                        v-model="useType"
                      />
                      <label class="form-check-label" for="usePrint"
                        >인쇄용</label
                      >
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-2 col-form-label fw-bold">작업크기</div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col">
                        <select
                          class="form-select me-3"
                          v-model="selectWorkingSize"
                          @change="getSize()"
                        >
                          <option
                            :value="i + 1"
                            v-for="(sizeCategory, i) in sizeCategory"
                            :key="i"
                          >
                            {{ sizeCategory.TEMPLATE_TYPE_NAME }}
                          </option>
                        </select>
                        <select class="form-select" v-model="selectSize">
                          <option
                            :value="i + 1"
                            v-for="(size, i) in size"
                            :key="i"
                          >
                            {{ size.SIZE_NAME }}
                          </option>
                        </select>
                      </div>
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <p>가로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="width"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>세로</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="height"
                              readonly
                            />
                          </div>
                          <div class="col">
                            <p>단위</p>
                            <input
                              type="text"
                              class="form-control"
                              v-model="scale"
                              readonly
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold">사용여부</div>
                  <div class="col-10">
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="publicTrue"
                        value="true"
                        v-model="publicFlag"
                      />
                      <label class="form-check-label" for="publicTrue"
                        >사용</label
                      >
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        id="publicFalse"
                        value="false"
                        v-model="publicFlag"
                      />
                      <label class="form-check-label" for="publicFalse"
                        >미사용</label
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-primary m-auto">
                  업로드
                </button>
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
      listCheck: "2",
      activeContents: false,
      activeThemeList: false,
      start: 0,
      length: 10,
      indexTheme: null,
      prevSEQ_ID: null,
      nextSEQ_ID: null,
      themeName: "",
      apiCheck: false,
      contentsList: [],

      // 콘텐츠 추가
      contentsName: "",
      keyword: "",
      thumbnail: null,
      sizeCategory: [],
      selectWorkingSize: 1,
      size: [],
      selectSize: 1,
      width: null,
      height: null,
      scale: null,
      useType: [],
      publicFlag: [],
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
      this.apiCheck = false;
      if (this.listCheck == "1") {
        const contentsType = contents.CONTENTS_TYPE_NAME;
        const warnning =
          contentsType == "템플릿" ||
          contentsType == "텍스트" ||
          contentsType == "도형" ||
          contentsType == "표" ||
          contentsType == "차트" ||
          contentsType == "스타일";
        if (warnning) return (this.apiCheck = true);
      }
      this.activeContents = i;
      this.selected = i + 1;
      this.currentContents = contents;
    },
    selectOption(i) {
      if (
        (this.listCheck == "1") & (i == 1) ||
        i == 12 ||
        i == 13 ||
        i == 14 ||
        i == 15 ||
        i == 16
      ) {
        return (this.apiCheck = true);
      } else {
        this.apiCheck = false;
      }
      this.currentContents = this.contents[i - 1];
      this.getTheme();
    },
    getTheme() {
      if (this.listCheck == "2") {
        this.themeList = [];
        this.$loading();
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
            this.totalPage();
            this.$endloading();
          });
      } else if (this.listCheck == "1") {
        this.themeList = [];
      }
    },
    selectThemeList(i, themeList) {
      this.activeThemeList = i;
      this.currentThemeList = themeList;
    },
    totalPage() {
      if (this.listCheck == "2") {
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
      if (this.listCheck == "2") {
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
        fd.append("ORDER", this.themeList.length);
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
    getContentsList() {
      this.$axios.get("/admin/api/contents.php").then((response) => {
        this.contentsList = response.data;
      });
    },
    onFileSelected(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.thumbnail = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    },
    getSizeCategory() {
      this.$axios.get("/admin/api/size_category.php").then((response) => {
        this.sizeCategory = response.data;
        this.getSize();
        this.$endloading();
      });
    },
    getSize() {
      this.$loading();
      this.$axios
        .get("/admin/api/size.php", {
          params: {
            template: this.sizeCategory[this.selectWorkingSize - 1].SEQ_ID,
          },
        })
        .then((response) => {
          this.size = response.data;
          this.activeSizeName();
          this.$endloading();
        });
    },
    activeSizeName() {
      this.$loading();
      this.$axios
        .get("/admin/api/size.php", {
          params: {
            size: this.size[this.selectSize - 1].SEQ_ID,
          },
        })
        .then((response) => {
          this.width = response.data[0].PAGE_WIDTH;
          this.height = response.data[0].PAGE_HEIGHT;
          this.scale = response.data[0].SCALE_CD;
          this.scaleFormat(this.scale);
          this.$endloading();
        });
    },
    templateUpload() {
      this.$loading();
      const fd = new FormData();
      fd.append("CONTENTS_NAME", this.contentsName);
      fd.append("THEME_ID", this.currentThemeList.THEME_ID);
      fd.append("KEYWORD", this.keyword);
      fd.append("THUMB_PATH", "./contents/template/thumb/SEQ_ID.png");
      fd.append("CONTENTS_PATH", "./contents/template/");
      fd.append("USE_TYPE", this.useType);
      fd.append(
        "SIZE_CATEGORY_ID",
        this.sizeCategory[this.selectWorkingSize - 1].SEQ_ID
      );
      fd.append("SIZE_INFO_ID", this.size[this.selectSize - 1].SEQ_ID);
      fd.append("PUBLIC_FLAG", this.publicFlag);
      fd.append("A_ID", 0);
      fd.append("U_ID", 0);
      this.$axios
        .post("/admin/api/theme_template_upload.php", fd)
        .then(() => {});
    },
    scaleFormat(value) {
      if (value == 1) return (this.scale = "px");
      if (value == 2) return (this.scale = "mm");
      if (value == 3) return (this.scale = "cm");
      if (value == 4) return (this.scale = "inch");
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
  height: 35vh;
}
#theme {
  height: calc(40vh + 42px);
}
.alert {
  animation: 0.3s warnning;
}
@keyframes warnning {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
.modal-dialog {
  max-width: 1000px !important;
}
.modal-content {
  width: 100% !important;
}
.form-select {
  margin: 0;
}
.thubnail {
  width: 100px;
  height: 100px;
}
</style>
