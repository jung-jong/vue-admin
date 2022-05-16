<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="my-3 d-flex align-items-center justify-content-between">
          <select
            v-model="length"
            @change="getAdminID(), $loading()"
            class="form-select mx-0"
          >
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <button
            type="button"
            class="btn btn-primary ms-3"
            data-bs-toggle="modal"
            data-bs-target="#addID"
          >
            + 관리자 ID 추가
          </button>
          <div class="d-flex align-items-center ms-auto">
            <span>검색</span>
            <label for="search" class="d-flex">
              <select v-model="selected" class="form-select">
                <option value="1" selected>ID</option>
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
        </div>

        <div class="overflow-auto">
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
                    data-bs-target="#level"
                    @click="selectAdminID(admin)"
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
                    @click="selectAdminID(admin)"
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
        </div>

        <!-- 관리자 ID 추가 -->
        <div class="modal fade" id="addID" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered" id="addModal">
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
                      <input
                        type="text"
                        class="form-control"
                        id="inputID"
                        v-model="id"
                      />
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
                      <select
                        id="inputState"
                        class="form-select w-100 m-0"
                        v-model="selected"
                      >
                        <option value="1">1</option>
                        <option value="2">2</option>
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
                  @click="addAdminID()"
                >
                  추가
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- level 변경-->
        <div class="modal fade" id="level" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered" id="addSize">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><b>관리자ID 수정</b></h5>
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
                      for="adminID"
                      class="col-sm-2 col-form-label text-start fw-bold"
                    >
                      ID
                    </label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        class="form-control"
                        id="adminID"
                        :value="currentUser.USER_ID"
                        readonly
                      />
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
                      <select
                        id="inputState"
                        class="form-select w-100 m-0"
                        v-model="selected"
                      >
                        <option value="1">1</option>
                        <option value="2">2</option>
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
                  @click="adminLevel(currentUser.USER_ID)"
                >
                  적용
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
                <h5 class="modal-title"><b>관리자ID 삭제</b></h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body text-center">
                <h3 id="title">
                  "{{ currentUser.USER_ID }}" ID를 사용자 Level로 변경 합니다.
                </h3>
              </div>
              <div class="modal-footer justify-content-center">
                <button
                  @click="deleteAdminID(currentUser.USER_ID)"
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
      id: "",
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
        this.totalPages = Math.ceil(this.totalPages / this.length);
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
    addAdminID() {
      this.$loading();
      this.$axios
        .get("/admin/api/admin_level.php", {
          params: {
            search: this.id,
          },
        })
        .then((response) => {
          if (response.data.length == 0) {
            alert("존재하지 않는 ID 혹은 관리자 ID 입니다.");
            this.$endloading();
          } else {
            const fd = new FormData();
            fd.append("id", this.id);
            fd.append("level", this.selected);
            this.$axios.post("/admin/api/admin_level.php", fd).then(() => {
              this.getAdminID();
              this.$endloading();
            });
          }
        });
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
    selectAdminID(admin) {
      this.currentUser = admin;
    },
    adminLevel(id) {
      this.$loading();
      const fd = new FormData();
      fd.append("id", id);
      fd.append("level", this.selected);
      this.$axios.post("/admin/api/admin_level.php", fd).then(() => {
        this.getAdminID();
        this.$endloading();
      });
    },
    deleteAdminID(id) {
      this.$loading();
      const fd = new FormData();
      fd.append("id", id);
      fd.append("level", 9);
      this.$axios.post("/admin/api/admin_level.php", fd).then(() => {
        this.getAdminID();
        this.$endloading();
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
      if (value == 9) return "사용자";
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

<style scoped></style>
