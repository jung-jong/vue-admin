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
            <div v-if="tableLoading" class="d-flex justify-content-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
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
                  v-for="(projectList, i) in projectList"
                  :key="projectList.SEQ_ID"
                >
                  <td>{{ i + 1 }}</td>
                  <td>{{ projectList.USER_ID }}</td>
                  <td>/ 100MB</td>
                  <td></td>
                  <td>
                    <a
                      href=""
                      data-bs-toggle="modal"
                      data-bs-target="#storage"
                      @click="
                        selectProject(projectList);
                        getFile(projectList.USER_ID);
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
                스토리지 상세 내역 - {{ project.USER_ID }}
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
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
                      <td class="text-end">{{ getFileSize(file) }}KB</td>
                      <td>
                        <a href="">
                          <img
                            width="25"
                            height="25"
                            src="@/assets/download.png"
                            alt=""
                          />
                        </a>
                      </td>
                      <td>
                        <a href="">
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
import tableLoading from "@/mixins.js";

export default {
  name: "StorageList",
  components: { PageName },
  data() {
    return {
      main: "작업모니터링",
      sub: "스토리지 현황",
      projectList: [],
      project: {},
      file: {},
      fileSize: "",
    };
  },
  mixins: [tableLoading],
  methods: {
    getProjectList() {
      this.projectList = this.$axios
        .get("/admin/api/project.php")
        .then((response) => {
          this.projectList = response.data;
          this.endloading();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    selectProject(project) {
      this.project = project;
    },
    getFile(USER_ID) {
      const fd = new FormData();
      fd.append("id", USER_ID);
      console.log(USER_ID);
      this.file = this.$axios
        .post("/admin/api/file.php", fd)
        .then((response) => {
          this.file = response.data;
        })
        .catch((e) => {
          console.log(e);
        });
    },
    getFileSize(dir) {
      const fd = this.formData(dir);
      console.log(dir);
      this.$axios.post("/admin/api/file.php", fd).then((response) => {
        this.fileSize = response.data;
      });
      return this.fileSize;
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
    console.log("mounted");
    this.getProjectList();
  },
};
</script>

<style scoped></style>
