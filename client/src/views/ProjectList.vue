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
                  <th>제목</th>
                  <th>단위</th>
                  <th>가로</th>
                  <th>세로</th>
                  <th>공유URL</th>
                  <th>생성일</th>
                  <th>수정일</th>
                  <th>에디터</th>
                  <th>삭제</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr
                  v-for="(projectList, i) in projectList"
                  :key="projectList.SEQ_ID"
                >
                  <td>{{ i + 1 }}</td>
                  <td>{{ projectList.USER_ID }}</td>
                  <td class="text-start">{{ projectList.TITLE }}</td>
                  <td>{{ sacleFormat(projectList.SCALE_CD) }}</td>
                  <td>{{ projectList.WIDTH }}</td>
                  <td>{{ projectList.HEIGHT }}</td>
                  <td class="text-start">{{ projectList.SHARE_URL }}</td>
                  <td>{{ projectList.A_DATE }}</td>
                  <td>{{ projectList.U_DATE }}</td>
                  <td>
                    <a href="">
                      <img
                        width="30"
                        height="30"
                        src="@/assets/editor.png"
                        alt="editor"
                      />
                    </a>
                  </td>
                  <td>
                    <a
                      href=""
                      data-bs-toggle="modal"
                      data-bs-target="#exampleModal"
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
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">프로젝트 삭제</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              {{ currentProject.TITLE }} 삭제하시겠습니까?
            </div>
            <div class="modal-footer">
              <button
                @click="deleteProject()"
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="modal"
              >
                삭제
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                닫기
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
import tableLoading from "@/mixins.js";

export default {
  name: "ProjectList",
  components: {
    PageName,
  },
  data() {
    return {
      projectList: [],
      currentProject: {},
      main: "작업모니터링",
      sub: "프로젝트 현황",
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
    deleteProject() {
      this.loading();
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
    selectProject(project) {
      this.currentProject = project;
    },
  },
  mounted() {
    this.getProjectList();
  },
};
</script>

<style scoped></style>
