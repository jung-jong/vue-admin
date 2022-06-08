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
              @change="selectOption(selected)"
            >
              <option v-for="(contents, i) in contents" :key="i" :value="i + 1">
                {{ contents.CONTENTS_TYPE_NAME }}
              </option>
            </select>

            <div class="card">
              <ul class="list-group list-group-flush overflow-auto h-100">
                <li
                  class="list-group-item"
                  v-for="(contents, i) in contents"
                  :key="i"
                  :class="[{ active: i === activeContents }, { hover: hover }]"
                  @click="selectContents(i, contents)"
                  @mouseenter="hoverType(contents.CONTENTS_TYPE_NAME)"
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
                  @click="
                    activeContents = false;
                    themeListShow = false;
                    contentsListShow = false;
                  "
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
                  @click="
                    activeContents = false;
                    themeListShow = false;
                    contentsListShow = false;
                  "
                />
                <label class="form-check-label" for="flexCheckChecked">
                  자체 설정
                </label>
              </div>
            </div>
            <div class="alert alert-danger my-3" role="alert" v-if="warnning">
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
                  data-bs-auto-close="true"
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
                    <button
                      type="button"
                      class="btn btn-secondary me-3"
                      @click="themeName = ''"
                    >
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
                  @click="
                    selectThemeList(i, themeList);
                    getContentsList();
                  "
                  class="list-group-item d-flex justify-content-between align-items-center hover"
                >
                  {{ themeList.THEME_NAME }}
                  <div class="d-flex">
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="deleteTheme(themeList.SEQ_ID)"
                    >
                      delete
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="
                        upCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_upward
                    </span>
                    <span
                      role="button"
                      class="material-symbols-rounded"
                      @click.stop="
                        downCurrentTheme(i);
                        orderTheme();
                      "
                    >
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
              <div
                @click="
                  getCurrentPage();
                  activeThemeList = false;
                "
              >
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

        <div
          id="bottom"
          class="d-flex flex-column position-relative"
          v-if="contentsListShow"
        >
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold my-3">콘텐츠 리스트</h5>
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              @click="
                getSizeCategory();
                thumbPathFormat();
                contentsPathFormat();
              "
            >
              + 콘텐츠 추가
            </button>
          </div>
          <div class="card px-3 flex-row flex-wrap overflow-auto">
            <div
              class="d-flex flex-column m-2"
              v-for="(contentsList, i) in contentsList"
              :key="i"
            >
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                :src="contentsListImg + contentsList.THUMB_PATH"
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
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="conname"
                      :class="{ 'is-invalid': invalidContentsName }"
                      v-model="contentsName"
                      @change="
                        contentsName !== ''
                          ? (invalidContentsName = false)
                          : (invalidContentsName = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidContentsName },
                        { 'd-none': contentsName !== '' },
                      ]"
                    >
                      콘텐츠 이름을 입력하세요.
                    </div>
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
                  <div class="col-10 position-relative">
                    <input
                      type="text"
                      class="form-control"
                      id="keyword"
                      :class="{ 'is-invalid': invalidKeyword }"
                      v-model="keyword"
                      @change="
                        keyword !== ''
                          ? (invalidKeyword = false)
                          : (invalidKeyword = true)
                      "
                    />
                    <div
                      class="invalid-tooltip"
                      :class="[
                        { 'd-block': invalidKeyword },
                        { 'd-none': keyword !== '' },
                      ]"
                    >
                      키워드를 입력하세요.
                    </div>
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
                          accept="image/*"
                          :class="{ 'is-invalid': invalidThumbnail }"
                          @change="
                            thumbFileSelect($event);
                            invalidThumbnail = false;
                          "
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
                          accept=".json"
                          :class="{ 'is-invalid': invalidContents }"
                          @change="
                            contentsFileSelect($event);
                            invalidContents = false;
                          "
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center mb-3">
                  <div class="col-2 col-form-label fw-bold">콘텐츠 용도</div>
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="useWeb"
                        value="web"
                        v-model="typeCheck"
                      />
                      <label class="form-check-label" for="useWeb">웹용</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="usePrint"
                        value="print"
                        v-model="typeCheck"
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
                        <select
                          class="form-select"
                          v-model="selectSize"
                          @change="getSize()"
                        >
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
                  <div class="col-10 position-relative">
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicTrue"
                        value="true"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicTrue"
                        >사용</label
                      >
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        id="publicFalse"
                        value="false"
                        v-model="publicFlage"
                      />
                      <label class="form-check-label" for="publicFalse"
                        >미사용</label
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-lg btn-primary m-auto"
                  @click="templateUpload()"
                >
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
      warnning: false,
      contentsList: [],
      contentsListImg: {}, //로컬서버
      themeListShow: false,
      contentsListShow: false,
      hover: true,

      // 콘텐츠 추가
      contentsName: "",
      keyword: "",
      thumbnail: null,
      extension: null,
      contentsFile: null,
      sizeCategory: [],
      selectWorkingSize: 1,
      size: [],
      selectSize: 1,
      width: null,
      height: null,
      scale: null,
      typeCheck: "web",
      publicFlage: "true",
      thumbPath: null,
      contentsPath: null,
      jsonFileName: null,
      invalidContentsName: false,
      invalidKeyword: false,
      invalidThumbnail: false,
      invalidContents: false,
    };
  },
  mixins: [table],
  computed: {},
  methods: {
    getContents() {
      this.$axios.get("/admin/api/contents_category.php").then((response) => {
        this.contents = response.data;
        this.$endloading();
      });
    },
    selectContents(i, contents) {
      this.warnning = false;
      if (this.listCheck == "1") {
        const contentsType = contents.CONTENTS_TYPE_NAME;
        const warnning =
          contentsType == "템플릿" ||
          contentsType == "텍스트" ||
          contentsType == "도형" ||
          contentsType == "표" ||
          contentsType == "차트" ||
          contentsType == "스타일";
        if (warnning) return (this.warnning = true);
      }
      this.activeContents = i;
      this.selected = i + 1;
      this.currentContents = contents;
      this.activeThemeList = false;
      this.themeListShow = true;
      this.contentsListShow = false;
      this.getTheme();
    },
    hoverType(value) {
      if (this.listCheck == "1") {
        const hover =
          value == "사진" ||
          value == "일러스트" ||
          value == "3D" ||
          value == "아이콘" ||
          value == "논텍스트" ||
          value == "배경" ||
          value == "동영상" ||
          value == "모션그래픽" ||
          value == "GIF" ||
          value == "사운드";
        if (hover) {
          this.hover = true;
        } else {
          this.hover = false;
        }
      } else {
        this.hover = true;
      }
    },
    selectOption(i) {
      if (
        (this.listCheck == "1") & (i == 1) ||
        (this.listCheck == "1") & (i == 12) ||
        (this.listCheck == "1") & (i == 13) ||
        (this.listCheck == "1") & (i == 14) ||
        (this.listCheck == "1") & (i == 15) ||
        (this.listCheck == "1") & (i == 16)
      ) {
        return (this.warnning = true);
      } else {
        this.warnning = false;
      }
      this.currentContents = this.contents[i - 1];
      this.activeContents = i - 1;
      this.activeThemeList = false;
      this.themeListShow = true;
      this.contentsListShow = false;
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
      if (this.themeList[i].ORDER == 0) return;
      this.currentThemeList = this.themeList[i].SEQ_ID;
      if (i !== 0) {
        this.prevSEQ_ID = this.themeList[i - 1].SEQ_ID;
        this.indexTheme = this.themeList[i].ORDER - 1;
        this.orderThemePrev();
      } else if (i === 0) {
        //2페이지 이상
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
        this.indexTheme = parseInt(this.themeList[i].ORDER) + 1;
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
        if (this.totalPages > 2) {
          fd.append("ORDER", this.themeList.length);
        } else {
          let lastOrder = (this.totalPages - 1) * 10;
          fd.append("ORDER", this.themeList.length + lastOrder);
        }
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
      this.contentsListShow = true;
      this.$loading();
      this.$axios
        .get("/admin/api/contents.php", {
          params: {
            id: this.currentThemeList.SEQ_ID,
          },
        })
        .then((response) => {
          this.contentsList = response.data;
          this.contentsListImg = "http://localhost/admin"; //로컬서버
          this.$endloading();
        });
    },
    thumbFileSelect(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.thumbnail = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.extension = input.files[0].name;
        this.thumbPath = this.thumbPath + this.extension.split(".", 2)[1];
      }
    },
    contentsFileSelect(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.contentsFile = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.jsonFileName = input.files[0].name;
        this.$axios
          .get("/admin/api/theme-thumb-file-name.php")
          .then((response) => {
            this.jsonFileName = `${parseInt(response.data[0].SEQ_ID) + 1}_${
              this.jsonFileName
            }`;
          });
      }
    },
    getSizeCategory() {
      if (this.currentContents.CONTENTS_TYPE_NAME == "템플릿") {
        this.$axios.get("/admin/api/size_category.php").then((response) => {
          this.sizeCategory = response.data;
          this.getSize();
          this.$endloading();
        });
      }
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
    contentsPathFormat() {
      const contentsType = this.currentContents.CONTENTS_TYPE_NAME;
      if (contentsType == "템플릿")
        return (this.contentsPath = "./contents/template/");
      if (contentsType == "텍스트")
        return (this.contentsPath = "./contents/text/");
      if (contentsType == "도형")
        return (this.contentsPath = "./contents/shape/");
      if (contentsType == "표")
        return (this.contentsPath = "./contents/table/");
      if (contentsType == "차트")
        return (this.contentsPath = "./contents/chart/");
      if (contentsType == "스타일")
        return (this.contentsPath = "./contents/style/");
    },
    thumbPathFormat() {
      this.$axios
        .get("/admin/api/theme-thumb-file-name.php")
        .then((response) => {
          if (response.data.length == 0) {
            this.thumbPath = 1;
          } else {
            this.thumbPath = parseInt(response.data[0].SEQ_ID) + 1;
          }
          this.thumbPath = `${this.contentsPath}thumb/${this.thumbPath}.`;
        });
    },
    templateUpload() {
      if (this.contentsName === "") return (this.invalidContentsName = true);
      if (this.keyword === "") return (this.invalidKeyword = true);
      if (this.thumbnail === null) return (this.invalidThumbnail = true);
      if (this.contentsFile === null) return (this.invalidContents = true);
      this.$loading();
      const fd = new FormData();
      fd.append("CONTENTS_NAME", this.contentsName);
      fd.append("THEME_ID", this.currentThemeList.SEQ_ID);
      fd.append("KEYWORD", this.keyword);
      fd.append("THUMB_PATH", this.thumbPath);
      fd.append("CONTENTS_PATH", this.contentsPath);
      if (this.typeCheck === "web") {
        fd.append("USE_TYPE", 1);
      } else if (this.typeCheck === "print") {
        fd.append("USE_TYPE", 2);
      }
      fd.append(
        "SIZE_CATEGORY_ID",
        this.sizeCategory[this.selectWorkingSize - 1].SEQ_ID
      );
      fd.append("SIZE_INFO_ID", this.size[this.selectSize - 1].SEQ_ID);
      if (this.publicFlage === "true") {
        fd.append("PUBLIC_FLAG", 1);
      } else if (this.publicFlage === "false") {
        fd.append("PUBLIC_FLAG", 0);
      }
      fd.append("A_ID", 0);
      fd.append("U_ID", 0);
      const img = document.querySelector("#thumbFile");
      const json = document.querySelector("#contentsFile");
      this.$axios.post("/admin/api/theme_template_upload.php", fd).then(() => {
        this.thumbnailUpload();
        this.contentsFileUpload();
        this.contentsName = "";
        this.keyword = "";
        this.thumbnail = null;
        this.contentsFile = null;
        img.value = "";
        json.value = "";
      });
    },
    thumbnailUpload() {
      const fd = new FormData();
      fd.append("base64", this.thumbnail);
      fd.append("thumbnail", this.thumbPath);
      this.$axios.post("/admin/api/theme-file-upload.php", fd).then(() => {
        alert("썸네일");
      });
    },
    contentsFileUpload() {
      const fd = new FormData();
      fd.append("base64", this.contentsFile);
      fd.append("contents", this.contentsPath + this.jsonFileName);
      this.$axios.post("/admin/api/theme-file-upload.php", fd).then(() => {
        alert("콘텐츠");
      });
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
.hover:hover {
  cursor: pointer;
  background-color: var(--bs-blue);
  color: var(--bs-white);
}
</style>
