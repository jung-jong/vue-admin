<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ sub }}
          </div>
          <div class="card-body">
            <table-loading v-if="tableLoading" />
            <table id="example" class="table table-striped" style="width: 100%">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>ID</th>
                  <th>스토리지 사용률</th>
                  <th>파일 개수</th>
                  <th>상세 내역</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr
                  v-for="(storageList, i) in storageList"
                  :key="storageList.SEQ_ID"
                >
                  <td>{{ i + 1 }}</td>
                  <td>{{ storageList.ID }}</td>
                  <td>
                    <b>{{ sizeFormat(storageList.USE_STORAGE) }}</b> / 100MB ({{
                      useSize(storageList.USE_STORAGE)
                    }}%)
                  </td>
                  <td>{{ storageList.FILE_NUMS }}</td>
                  <td>
                    <a
                      href=""
                      data-bs-toggle="modal"
                      data-bs-target="#storage"
                      @click="
                        selectStorage(storageList);
                        getFile(storageList.ID);
                      "
                    >
                      <img
                        width="30"
                        height="30"
                        src="@/assets/editor.png"
                        alt="editor"
                      />
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- 모달 스토리지 상세 내역 -->
      <div class="modal fade" id="storage" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                스토리지 상세 내역 - {{ currentStorage.ID }}
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
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
                      <td class="text-end">{{ file.FILE_SIZE }}</td>
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
import loading from "@/mixins.js";

export default {
  name: "StorageList",
  components: { PageName, TableLoading },
  data() {
    return {
      main: "작업모니터링",
      sub: "스토리지 현황",
      storageList: [],
      currentStorage: {},
      file: [],
      fileSize: {},
    };
  },
  mixins: [loading],
  computed: {},
  methods: {
    getStorageList() {
      this.storageList = this.$axios
        .get("/admin/api/storage.php")
        .then((response) => {
          this.storageList = response.data;
          this.endloading();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    selectStorage(storage) {
      this.currentStorage = storage;
    },
    //tb_file 테이블 전부 받음
    getFile(USER_ID) {
      this.loading();
      const fd = new FormData();
      fd.append("id", USER_ID);
      this.$axios
        .post("/admin/api/file.php", fd)
        .then((response) => {
          this.file = response.data;
          this.endloading();
        })
        .catch((e) => {
          console.log(e);
        });
      return this.file;
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
              down_url.lastIndexOf("/") + 30,
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
      this.$axios.post("/admin/api/file_delete.php", fd).then((response) => {
        alert("삭제 성공");
        return response;
      });
    },
    sizeFormat(x) {
      var s = ["Byte", "KB", "MB", "GB", "TB", "PB"];
      var e = Math.floor(Math.log(x) / Math.log(1024));
      return (x / Math.pow(1024, e)).toFixed(0) + s[e];
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
    this.getStorageList();
  },
};
</script>

<style scoped></style>
