<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="mb-3 d-flex justify-content-between align-items-center">
          <select
            v-model="length"
            @change="getUserList(), $loading()"
            class="form-select mx-0"
          >
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <div class="d-flex align-items-center">
            <span>검색</span>
            <label for="search" class="d-flex">
              <select v-model="selected" class="form-select">
                <option value="1">ID</option>
                <option value="2">라이선스</option>
                <option value="3">상태</option>
                <option value="4">최종 수정</option>
                <option value="5">최종 다운로드</option>
                <option value="6">스토리지 사용률</option>
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
                <th>라이선스</th>
                <th>상태</th>
                <th>최종 수정</th>
                <th>최종 다운로드</th>
                <th>스토리지 사용률</th>
                <th>탐색기</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr v-for="userList in userList" :key="userList.SEQ_ID">
                <td>{{ userList.SEQ_ID }}</td>
                <td>{{ userList.USER_ID }}</td>
                <td>{{ userList.LICENSE_TYPE }}</td>
                <td>{{ userList.USER_STATUS }}</td>
                <td>{{ $dateFormat(userList.LAST_WORK_DATE) }}</td>
                <td>
                  {{ $dateFormat(userList.LAST_EDIT_DATE) }}
                  ({{ userList.LAST_WORK_TYPE }})
                </td>
                <td>
                  <b>{{ userList.STORAGE_USE }}MB</b> /
                  {{ userList.STORAGE_QUOTA }}MB ({{
                    sotorageFormat(
                      (userList.STORAGE_QUOTA * userList.STORAGE_USE) / 100
                    )
                  }}%)
                </td>
                <td>
                  <a
                    href=""
                    data-bs-toggle="modal"
                    data-bs-target="#storage"
                    @click="
                      selectStorage(userList);
                      getFile(userList.USER_ID);
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
        </div>

        <div class="d-flex justify-content-between align-items-start my-3">
          <button
            type="button"
            class="btn btn-success"
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
      </div>

      <!-- 모달 스토리지 상세 내역 -->
      <div class="modal fade" id="storage" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                스토리지 상세 내역 - {{ currentStorage.USER_ID }}
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="progress" v-if="showProgress">
              <div
                class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar"
                :style="{ width: progress + '%' }"
              ></div>
            </div>
            <div class="modal-body">
              <table-loading v-if="tableLoading" />
              <div class="table_wrap">
                <table class="table table-bordered table-striped">
                  <thead class="text-center">
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">파일명</th>
                      <th scope="col">확장자</th>
                      <th scope="col">파일크기</th>
                      <th scope="col">다운로드</th>
                      <th scope="col">삭제</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <tr v-for="(file, i) in file" :key="file.SEQ_ID">
                      <td>{{ i + 1 }}</td>
                      <td class="text-start">{{ file.FILE_NAME }}</td>
                      <td>{{ file.FILE_EXTENSION }}</td>
                      <td class="text-end">
                        {{ fileSizeFormat(file.FILE_SIZE) }}
                      </td>
                      <td>
                        <a href="" @click.prevent="fileDownload(file.SEQ_ID)">
                          <img
                            width="25"
                            height="25"
                            src="@/assets/download.png"
                            alt=""
                          />
                        </a>
                      </td>
                      <td>
                        <a href="" @click.prevent="fileDelete(file.SEQ_ID)">
                          <img
                            width="25"
                            height="25"
                            src="@/assets/delete.png"
                            alt="delete"
                          />
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
import * as XLSX from "xlsx";

export default {
  name: "UserList",
  components: { PageName, TableLoading, vPagination },
  data() {
    return {
      main: "작업모니터링 >",
      sub: "회원 현황",
      userList: [],
      currentStorage: {},
      file: [],
      fileSize: {},
      start: 0,
      length: 10,
      selected: "1",
      search: "",
      progress: 0,
      showProgress: false,
    };
  },
  mixins: [table],
  methods: {
    getUserList() {
      this.$axios
        .get("/admin/api/user.php", {
          params: {
            start: this.start,
            length: this.length,
          },
        })
        .then((response) => {
          this.userList = response.data;
          this.$endloading();
          this.totalPage();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    totalPage() {
      this.$axios.get("/admin/api/user_page.php").then((response) => {
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
        this.getUserList();
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
              this.userList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "2") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lisense: "LICENSE_TYPE",
                search: this.search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "3") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                status: "USER_STATUS",
                search: this.search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "4") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lastWork: "LAST_WORK_DATE",
                search: this.search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "5") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lastDown: "LAST_EDIT_DATE",
                search: this.search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
        } else if (this.selected == "6") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                storage: "STORAGE_USE",
                search: this.search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
        }
      }
    },
    searchUser(search) {
      if (window.event.code === "Enter" && search !== "") {
        if (this.selected == "1") {
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
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
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
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lisense: "LICENSE_TYPE",
                search: search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
              params: {
                lisense: "LICENSE_TYPE",
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
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                status: "USER_STATUS",
                search: search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
              params: {
                status: "USER_STATUS",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        } else if (this.selected == "4") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lastWork: "LAST_WORK_DATE",
                search: search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
              params: {
                lastWork: "LAST_WORK_DATE",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        } else if (this.selected == "5") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                lastDown: "LAST_EDIT_DATE",
                search: search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
              params: {
                lastDown: "LAST_EDIT_DATE",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        } else if (this.selected == "6") {
          this.$loading();
          this.$axios
            .get("/admin/api/user.php", {
              params: {
                start: this.start,
                length: this.length,
                storage: "STORAGE_USE",
                search: search,
              },
            })
            .then((response) => {
              this.userList = response.data;
              this.$endloading();
            });
          this.$axios
            .get("/admin/api/user_page.php", {
              params: {
                storage: "STORAGE_USE",
                search: search,
              },
            })
            .then((response) => {
              this.totalPages = response.data;
              this.$endloading();
            });
        }
      } else if (window.event.code === "Enter" && search == "") {
        this.getUserList();
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
    storageUse() {
      this.$axios
        .get("/admin/api/file_storage_update.php", {
          params: {
            id: this.currentStorage.USER_ID,
          },
        })
        .then((response) => {
          this.fileSize = response.data;
          const storageUse = this.useSize(this.fileSize);
          const fd = new FormData();
          fd.append("STORAGE_USE", storageUse);
          this.$axios
            .post("/admin/api/file_storage_update.php", fd)
            .then(() => {});
        });
    },
    fileDownload(id) {
      const fd = new FormData();
      fd.append("SEQ_ID", id);
      var down_url = "";
      this.$axios.post("/admin/api/download.php", fd).then((response) => {
        down_url = response.data; //배포
        // down_url = "http://localhost/admin/" + response.data;

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
        xhr.onprogress = (e) => {
          if (e.lengthComputable) {
            // 다운로드 진행률 계산
            var percentComplete = Math.floor((e.loaded / e.total) * 100);
            this.progress = percentComplete;
            if (this.progress == 100) {
              this.showProgress = false;
            } else if (this.progress == 0) {
              this.showProgress = true;
            }
          }
        };
      });

      // const response = this.$axios.post("/admin/api/download.php", fd, {
      //   responseType: "blob",
      // });
      // const name = response.headers["content-disposition"]
      //   .split("filename=")[1]
      //   .replace(/"/g, "");
      // const url = window.URL.createObjectURL(new Blob([response.data]));
      // const link = document.createElement("a");
      // link.href = url;
      // link.setAttribute("download", name);
      // document.body.appendChild(link);
      // link.click();
      // link.remove();
      // window.URL.revokeObjectURL(url);
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
      const workSheet = XLSX.utils.json_to_sheet(this.userList);
      XLSX.utils.book_append_sheet(workBook, workSheet, "user");
      XLSX.writeFile(workBook, "user.xlsx");
    },
    sotorageFormat(e) {
      return Math.floor(e);
    },
    fileSizeFormat(x) {
      let s = ["Byte", "KB", "MB", "GB", "TB", "PB"];
      let e = Math.floor(Math.log(x) / Math.log(1024));
      return (x / Math.pow(1024, e)).toFixed(0) + s[e];
    },
    useSize(e) {
      let size = e / 1024 / 1024;
      return Math.floor(size);
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
    this.getUserList();
  },
};
</script>

<style scoped></style>
