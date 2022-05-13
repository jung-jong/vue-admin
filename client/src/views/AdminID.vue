<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <button
          type="button"
          class="btn btn-primary btn-lg position-absolute"
          data-bs-toggle="modal"
          data-bs-target="#addID"
        >
          + 관리자 ID 추가
        </button>
        <div class="my-3 d-flex justify-content-end align-items-center">
          <span>검색</span>
          <label for="search" class="d-flex">
            <select v-model="selected" class="form-select">
              <option value="1">ID</option>
            </select>
            <input
              type="text"
              class="form-control"
              id="search"
              v-model="search"
              @keyup="searchUser(search)"
            />
          </label>
        </div>
        <table
          id="example"
          class="table table-striped table-bordered table-hover"
          style="width: 100%"
        >
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>ID</th>
              <th>Level</th>
              <th>수정</th>
              <th>삭제</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="admin in admin" :key="admin.SEQ_ID">
              <td>{{ admin.SEQ_ID }}</td>
              <td>{{ admin.USER_ID }}</td>
              <td>
                {{ admin.USER_LEVEL }} ({{ userLevel(admin.USER_LEVEL) }})
              </td>
              <td>
                <a
                  href=""
                  data-bs-toggle="modal"
                  data-bs-target="#storage"
                  @click="
                    selectStorage(admin);
                    getFile(admin.USER_ID);
                  "
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
                <a
                  href=""
                  data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  @click="selectUser(admin)"
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

        <!-- 관리자 ID 추가 -->
        <div class="modal fade" id="addID" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered" id="addSize">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><b>관리자ID 추가</b></h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body text-center">
                <form>
                  <div class="row mb-3">
                    <label
                      for="inputID"
                      class="col-sm-2 col-form-label text-start fw-bold"
                    >
                      ID
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputID" />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label
                      for="inputState"
                      class="col-sm-2 col-form-label text-start fw-bold"
                    >
                      LEVEL
                    </label>
                    <div class="col-sm-10">
                      <select id="inputState" class="form-select w-100 m-0">
                        <option>1</option>
                        <option>2</option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer justify-content-center">
                <button
                  type="button"
                  class="btn btn-primary btn-lg"
                  data-bs-dismiss="modal"
                >
                  추가
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
                  "{{ currentUser.USER_ID }}" 프로젝트를 삭제 하시겠습니까?
                </h3>
                <br />
                <p class="text-danger">
                  <strong>영구히 삭제되며 복원 불가능 합니다!!!</strong>
                </p>
              </div>
              <div class="modal-footer justify-content-center">
                <button
                  @click="deleteProject(currentUser), $loading()"
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
    </main>
  </div>
</template>

<script>
import PageName from "../components/PageName.vue";
import TableLoading from "../components/TableLoading.vue";
import table from "@/mixins.js";
import vPagination from "vue-plain-pagination";
import * as XLSX from "xlsx";

export default {
  name: "AdminID",
  components: { PageName, TableLoading, vPagination },
  data() {
    return {
      main: "시스템 설정 >",
      sub: "관리자 ID 설정",
      admin: [],
      currentUser: {},
      file: [],
      fileSize: {},
      start: 0,
      length: 10,
      selected: "1",
      search: "",
    };
  },
  mixins: [table],
  methods: {
    getAdminID() {
      this.$axios
        .get("/admin/api/adminID.php", {
          params: {
            start: this.start,
            length: this.length,
          },
        })
        .then((response) => {
          this.admin = response.data;
          this.$endloading();
          this.totalPage();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    totalPage() {
      this.$axios.get("/admin/api/adminID_page.php").then((response) => {
        this.totalPages = response.data;
      });
    },
    getCurrentPage() {
      this.$loading();
      let i = this.currentPage;
      i = 10 * i - 10;
      this.start = i;
      if (this.search == "") {
        this.getAdminID();
      } else {
        if (this.selected == "1") {
          this.$loading();
          this.$axios
            .get("/admin/api/adminID.php", {
              params: {
                start: this.start,
                length: this.length,
                id: "USER_ID",
                search: this.search,
              },
            })
            .then((response) => {
              this.admin = response.data;
              this.$endloading();
            });
        }
      }
    },
    searchUser(search) {
      if (window.event.code === "Enter" && search !== "") {
        this.$loading();
        this.$axios
          .get("/admin/api/adminID.php", {
            params: {
              start: this.start,
              length: this.length,
              id: "USER_ID",
              search: search,
            },
          })
          .then((response) => {
            this.admin = response.data;
            this.$endloading();
          });
        this.$axios
          .get("/admin/api/adminID_page.php", {
            params: {
              id: "USER_ID",
              search: search,
            },
          })
          .then((response) => {
            this.totalPages = response.data;
            this.$endloading();
          });
      } else if (window.event.code === "Enter" && search == "") {
        this.getAdminID();
      }
    },
    selectUser(admin) {
      this.currentUser = admin;
    },
    deleteProject() {
      const fd = this.formData(this.currentUser);
      this.$axios
        .post("/admin/api/delete.php", fd)
        .then(() => {
          this.currentUser = {};
          this.getProjectList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    excelDownload() {
      const workBook = XLSX.utils.book_new();
      const workSheet = XLSX.utils.json_to_sheet(this.admin);
      XLSX.utils.book_append_sheet(workBook, workSheet, "adminID");
      XLSX.writeFile(workBook, "adminID.xlsx");
    },
    userLevel(value) {
      if (value == 1) return "마스터";
      if (value == 2) return "작업자";
      if (value == 9) return "회원";
    },
    formData(id) {
      let fd = new FormData();
      for (let i in id) {
        fd.append(i, id[i]);
      }
      return fd;
    },
  },
  mounted() {
    this.getAdminID();
  },
};
</script>

<style scoped>
#addSize {
  max-width: 500px !important;
}
</style>
