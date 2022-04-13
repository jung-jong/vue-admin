<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <PageName :mainMenu="main" :subMenu="sub" />
        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ sub }}
          </div>
          <div class="card-body">
            <div v-if="tableLoding" class="d-flex justify-content-center">
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
                <tr :key="i" v-for="(projectList, i) in projectList">
                  <td>{{ projectList.SEQ_ID }}</td>
                  <td>{{ projectList.USER_ID }}</td>
                  <td>{{ projectList.TITLE }}</td>
                  <td>{{ sacleFormat(projectList.SCALE_CD) }}</td>
                  <td>{{ projectList.WIDTH }}</td>
                  <td>{{ projectList.HEIGHT }}</td>
                  <td>{{ projectList.SHARE_URL }}</td>
                  <td>{{ projectList.A_DATE }}</td>
                  <td>{{ projectList.U_DATE }}</td>
                  <td>
                    <img
                      width="30"
                      height="30"
                      src="@/assets/editor.png"
                      alt="editor"
                    />
                  </td>
                  <td>
                    <img
                      width="30"
                      height="30"
                      src="@/assets/delete.png"
                      alt="delete"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import axios from "axios";
import PageName from "@/components/PageName.vue";

export default {
  name: "ProjectList",
  components: {
    PageName,
  },
  data() {
    return {
      projectList: [],
      tableLoding: true,
      main: "작업모니터링",
      sub: "프로젝트 현황",
    };
  },
  created() {
    // this.id = this.$route.query.SEQ_ID;
    this.getProjectList();
    // this.deleteProject();
  },
  methods: {
    async getProjectList() {
      this.projectList = await axios
        .get(
          // eslint-disable-next-line
          "http://localhost/api/project.php?action=read"
        )
        .catch((e) => {
          console.log(e);
        });
      this.tableLoding = false;
      this.projectList = this.projectList.data;
    },
    // async deleteProject() {
    //   this.deleteProject = await axios
    //     .delete("http://localhost/api/project.php", {
    //       data: {},
    //     })
    //     .catch((e) => {
    //       console.log(e);
    //     });
    // },
    sacleFormat(value) {
      if (value == 0) return "px";
      if (value == 1) return "mm";
      if (value == 2) return "cm";
      if (value == 3) return "in";
    },
  },
};
</script>

<style lang="scss" scoped></style>
