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
              <td>{{ admin.USER_LEVEL }}</td>
              <td>
                {{ $dateFormat(admin.LAST_WORK_DATE) }}
                {{ admin.LAST_WORK_TYPE }}
              </td>
              <td>
                <b>{{ admin.STORAGE_USE }}MB</b> / {{ admin.STORAGE_QUOTA }}MB
                ({{ sizeFormat(admin.STORAGE_QUOTA / admin.STORAGE_USE) }}%)
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
      admin: [],
      currentStorage: {},
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
    getMemberList() {
      this.$axios
        .get("/admin/api/user.php", {
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
      this.$axios.get("/admin/api/member_page.php").then((response) => {
        this.totalPages = response.data;
      });
    },
    getCurrentPage() {
      this.$loading();
      let i = this.currentPage;
      i = 10 * i - 10;
      this.start = i;
      if (this.search == "") {
        this.getMemberList();
      } else {
        if (this.selected == "1") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
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
          .get("/admin/api/user.php", {
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
      } else if (window.event.code === "Enter" && search == "") {
        this.getMemberList();
      }
    },
    selectStorage(storage) {
      this.currentStorage = storage;
    },
    getFile(USER_ID) {
      this.$loading();
      const fd = new FormData();
      fd.append("id", USER_ID);
      this.$axios
        .post("/admin/api/file.php", fd)
        .then((response) => {
          this.file = response.data;
          this.$endloading();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    fileDownload(id) {
      const fd = new FormData();
      fd.append("SEQ_ID", id);
      var down_url = "";
      this.$axios.post("/admin/api/download.php", fd).then(function (response) {
        down_url = "http://localhost/admin/" + response.data;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            var a = document.createElement("a");
            var url = URL.createObjectURL(this.response);
            a.href = url;
            a.download = down_url.substring(
              down_url.lastIndexOf("/") + 1,
              down_url.lastIndexOf("/") + 30
            );
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
          }
        };
        xhr.open("POST", down_url);
        xhr.responseType = "blob"; // !!필수!!
        xhr.send();
      });
    },
    fileDelete(id) {
      const fd = new FormData();
      fd.append("SEQ_ID", id);
      this.$axios.post("/admin/api/file_delete.php", fd).then(() => {
        this.getFile(this.currentStorage.USER_ID);
        alert("삭제 성공");
      });
    },
    excelDownload() {
      const workBook = XLSX.utils.book_new();
      const workSheet = XLSX.utils.json_to_sheet(this.admin);
      XLSX.utils.book_append_sheet(workBook, workSheet, "user");
      XLSX.writeFile(workBook, "user.xlsx");
    },
    sizeFormat(e) {
      return Math.floor(e);
    },
    useSize(e) {
      let size = e / 1024 / 1024;
      size = size.toFixed(3);
      return Math.ceil(size);
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
    this.getMemberList();
  },
};
</script>

<style scoped></style>
