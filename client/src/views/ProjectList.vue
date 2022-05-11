<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="mb-3 d-flex justify-content-end align-items-center">
          <span>검색</span>
          <label for="search" class="d-flex">
            <select v-model="selected" class="form-select">
              <option value="1">ID</option>
              <option value="2">제목</option>
              <option value="3">가로 / 세로</option>
            </select>
            <input
              type="text"
              class="form-control"
              id="search"
              v-model="search"
              @keyup="searchProject(search)"
            />
          </label>
        </div>
        <table
          id="table"
          class="table table-striped table-bordered table-hover"
          style="width: 100%"
        >
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>ID</th>
              <th>제목</th>
              <th>단위</th>
              <th>가로</th>
              <th>세로</th>
              <th>공유URL</th>
              <th>생성일</th>
              <th>수정일</th>
              <th>메모</th>
              <th>편집</th>
              <th>삭제</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="projectList in projectList" :key="projectList.SEQ_ID">
              <td>{{ projectList.SEQ_ID }}</td>
              <td>{{ projectList.USER_ID }}</td>
              <td class="text-start">{{ projectList.TITLE }}</td>
              <td>{{ sacleFormat(projectList.SCALE_CD) }}</td>
              <td>{{ projectList.WIDTH }}</td>
              <td>{{ projectList.HEIGHT }}</td>
              <td class="text-start">{{ projectList.SHARE_URL }}</td>
              <td>{{ $dateFormat(projectList.A_DATE) }}</td>
              <td>{{ $dateFormat(projectList.U_DATE) }}</td>
              <td>
                <a
                  href=""
                  data-bs-toggle="modal"
                  data-bs-target="#memoModal"
                  @click="selectProject(projectList)"
                >
                  <img
                    width="30"
                    height="30"
                    src="@/assets/memo.png"
                    alt="editor"
                  />
                </a>
              </td>
              <td>
                <a href="">
                  <img
                    width="30"
                    height="30"
                    src="@/assets/editor.svg"
                    alt="editor"
                  />
                </a>
              </td>
              <td>
                <a
                  href=""
                  data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  @click="selectProject(projectList)"
                >
                  <img
                    width="30"
                    height="30"
                    src="@/assets/delete.png"
                    alt="delete"
                  />
                </a>
              </td>
            </tr>
          </tbody>
        </table>

        <button
          type="button"
          class="btn btn-success position-absolute"
          @click="excelDownload()"
        >
          Excel 저장
        </button>

        <div @click="getCurrentPage(currentPage)">
          <v-pagination
            v-model="currentPage"
            :page-count="totalPages"
            :classes="bootstrapPaginationClasses"
            :labels="paginationAnchorTexts"
          ></v-pagination>
        </div>
      </div>

      <!-- 메모모달 -->
      <div class="modal fade" id="memoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><b>프로젝트 메모</b></h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="card">
                <div class="card-body">
                  {{ currentProject.MEMO }}
                </div>
              </div>
              <br />
            </div>
            <div class="modal-footer justify-content-center">
              <button
                type="button"
                class="btn btn-primary btn-lg me-3"
                data-bs-dismiss="modal"
              >
                확인
              </button>
              <button
                type="button"
                class="btn btn-secondary btn-lg ms-3"
                data-bs-dismiss="modal"
              >
                취소
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- 삭제모달 -->
      <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><b>프로젝트 삭제</b></h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body text-center">
              <h3 id="title">
                "{{ currentProject.TITLE }}" 프로젝트를 삭제 하시겠습니까?
              </h3>
              <br />
              <p class="text-danger">
                <strong>영구히 삭제되며 복원 불가능 합니다!!!</strong>
              </p>
            </div>
            <div class="modal-footer justify-content-center">
              <button
                @click="deleteProject(currentProject), $loading()"
                type="button"
                class="btn btn-danger btn-lg me-3"
                data-bs-dismiss="modal"
              >
                삭제
              </button>
              <button
                type="button"
                class="btn btn-secondary btn-lg ms-3"
                data-bs-dismiss="modal"
              >
                취소
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import PageName from "@/components/PageName.vue";
import table from "@/mixins.js";
import TableLoading from "../components/TableLoading.vue";
import vPagination from "vue-plain-pagination";
import * as XLSX from "xlsx";

export default {
  name: "ProjectList",
  components: {
    PageName,
    TableLoading,
    vPagination,
  },
  data() {
    return {
      main: "작업모니터링 >",
      sub: " 프로젝트 현황",
      currentPage: 1,
      totalPages: 1,
      bootstrapPaginationClasses: {
        ul: "pagination justify-content-end",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link",
      },
      paginationAnchorTexts: {
        first: "〈〈",
        prev: "Previous",
        next: "Next",
        last: "〉〉",
      },
      projectList: [],
      currentProject: {},
      start: 0,
      length: 10,
      selected: "1",
      search: "",
    };
  },
  mixins: [table],
  computed: {},
  methods: {
    getProjectList() {
      this.$axios
        .get("/admin/api/project.php", {
          params: {
            start: this.start,
            length: this.length,
          },
        })
        .then((response) => {
          this.projectList = response.data;
          this.$endloading();
          this.totalPage();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    totalPage() {
      this.$axios.get("/admin/api/total_page.php").then((response) => {
        this.totalPages = response.data;
      });
    },
    getCurrentPage() {
      this.$loading();
      let i = this.currentPage;
      i = 10 * i - 10;
      this.start = i;
      if (this.search == "") {
        this.getProjectList();
      } else {
        if (this.selected == "1") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                id: "USER_ID",
                search: this.search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "2") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                title: "TITLE",
                search: this.search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "3") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                width: "WIDTH/HEIGHT",
                search: this.search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
        }
      }
    },
    searchProject(search) {
      if (window.event.code === "Enter" && search !== "") {
        if (this.selected == "1") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                id: "USER_ID",
                search: search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/total_page.php", {
              params: {
                id: "USER_ID",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        } else if (this.selected == "2") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                title: "TITLE",
                search: search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/total_page.php", {
              params: {
                title: "TITLE",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        } else if (this.selected == "3") {
          this.$loading();
          this.$axios
            .get("/admin/api/project.php", {
              params: {
                start: this.start,
                length: this.length,
                width: "WIDTH/HEIGHT",
                search: search,
              },
            })
            .then((response) => {
              this.projectList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/total_page.php", {
              params: {
                width: "WIDTH/HEIGHT",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        }
      } else if (window.event.code === "Enter" && search == "") {
        this.getProjectList();
      }
    },
    deleteProject() {
      const fd = this.formData(this.currentProject);
      this.$axios
        .post("/admin/api/delete.php", fd)
        .then(() => {
          this.currentProject = {};
          this.getProjectList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    excelDownload() {
      const workBook = XLSX.utils.book_new();
      const workSheet = XLSX.utils.json_to_sheet(this.projectList);
      XLSX.utils.book_append_sheet(workBook, workSheet, "project");
      XLSX.writeFile(workBook, "project.xlsx");
    },
    sacleFormat(value) {
      if (value == 0) return "px";
      if (value == 1) return "mm";
      if (value == 2) return "cm";
      if (value == 3) return "in";
    },
    formData(id) {
      let fd = new FormData();
      for (let i in id) {
        fd.append(i, id[i]);
      }
      return fd;
    },
    selectProject(data) {
      this.currentProject = data;
    },
  },
  mounted() {
    this.getProjectList();
  },
};
</script>

<style>
td {
  text-align: center;
}
.modal-dialog {
  max-width: 1000px !important;
}
.form-select {
  width: auto !important;
  display: inline-block !important;
  margin: 0 1rem;
}
</style>
