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
              <!-- <tbody class="text-center">
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
                  <td>{{ dateFormat(projectList.A_DATE) }}</td>
                  <td>{{ dateFormat(projectList.U_DATE) }}</td>
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
              </tbody> -->
            </table>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><b>프로젝트 삭제</b></h5>
              <div id="no" class="d-none"></div>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body text-center">
              <h3 id="title"></h3>
              <br />
              <p class="text-danger">
                <strong>영구히 삭제되며 복원 불가능 합니다!!!</strong>
              </p>
            </div>
            <div class="modal-footer justify-content-center">
              <button
                @click="deleteProject()"
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

export default {
  name: "ProjectList",
  components: {
    PageName,
    TableLoading,
  },
  data() {
    return {
      projectList: [],
      currentProject: {},
      main: "작업모니터링",
      sub: "프로젝트 현황",
    };
  },
  mixins: [table],
  methods: {
    table() {
      this.$endloading();
      // eslint-disable-next-line no-undef
      let table = new DataTable("#table", {
        processing: true,
        serverSide: true,
        ordering: false,
        serach: false,
        ajax: this.baseURL + "/admin/api/project_table.php",
        // dataSrc: function (response) {
        //   let data = response.data;
        //   this.projectList = data;
        //   console.log(this.projectList);
        //   return data;
        // },
        columns: [
          { data: "SEQ_ID" },
          { data: "USER_ID" },
          { data: "TITLE" },
          {
            data: "SCALE_CD",
            render: function (value) {
              if (value == 0) return "px";
              if (value == 1) return "mm";
              if (value == 2) return "cm";
              if (value == 3) return "in";
            },
          },
          { data: "WIDTH" },
          { data: "HEIGHT" },
          { data: "SHARE_URL" },
          {
            data: "A_DATE",
            render: function (e) {
              let str = e.slice(0, 10);
              return str;
            },
          },
          {
            data: "U_DATE",
            render: function (e) {
              let str = e.slice(0, 10);
              return str;
            },
          },
          { data: "MEMO" },
          { data: "editor" },
          { data: "delete" },
        ],
        columnDefs: [
          { targets: 2, className: "dt-body-left" },
          { targets: 6, className: "dt-body-left" },
        ],
        language: {
          emptyTable: "데이터가 없음.",
          lengthMenu: "페이지당 _MENU_ 개씩 보기",
          info: "현재 _START_ - _END_ / _TOTAL_건",
          infoEmpty: "데이터 없음",
          infoFiltered: "( _MAX_건의 데이터에서 필터링됨 )",
          search: "검색",
          zeroRecords: "일치하는 데이터가 없음.",
          loadingRecords: "로딩중...",
          processing: "잠시만 기다려 주세요...",
          paginate: {
            next: "다음",
            previous: "이전",
          },
        },
      });
      table.on("xhr", function () {
        let json = table.ajax.json();
        // console.log(this.projectList);
        // for (let i = 0; i < this.projectList.length; i++) {
        //   const projectList = json.data[i].TITLE;
        //   this.currentProject = projectList;
        //   console.log(this.currentProject);
        //   return this.currentProject;
        // }
      });
      table.on("click", "td", function () {
        let data = table.row(this).data();
        const title = document.querySelector("#title");
        title.innerText = `"${data.TITLE}" 프로젝트를 삭제 하시겠습니까?`;
        const no = document.querySelector("#no");
        no.innerText = data.SEQ_ID;
        console.log(data);
        // fetch("http://localhost/admin/api/delete.php", {
        //   method: "post",
        //   body: data,
        // })
        //   .then((response) => response.json())
        //   .then((data) => console.log(data));
      });

      const serach = document.querySelector("#table_filter input");
      serach.addEventListener("keyup", function () {
        let colIndex = document.querySelector("#select").selectedIndex;
        if (colIndex === 2) {
          table.columns([4, 5]).search(this.value).draw();
        } else {
          table
            .column(colIndex + 1)
            .search(this.value)
            .draw();
        }
      });

      createSelectBox();

      function createSelectBox() {
        const filter = document.querySelector("#table_filter");
        const select = document.createElement("select");
        let value = ["USER_ID", "TITLE", "WIDTH"];
        let text = ["ID", "제목", "가로 / 세로"];
        filter.prepend(select);
        select.id = "select";
        select.className = "form-select";

        for (let i = 0; i < 3; i++) {
          const option = document.createElement("option");
          option.value = value[i];
          option.text = text[i];
          select.appendChild(option);
        }
      }
    },
    // getProjectList() {
    //   this.projectList = this.$axios
    //     .get("/admin/api/project.php")
    //     .then((response) => {
    //       this.projectList = response.data;
    //       this.$endloading();
    //       this.$table();
    //     })
    //     .catch((e) => {
    //       console.log(e);
    //     });
    // },
    deleteProject() {
      const delete_img = document.querySelector("delete_img");
      const no = document.querySelector("#no");
      // delete_img.addEventListener("click", function () {
      //   console.log(no.innerHTML);
      // });
      // this.$loading();
      // const fd = this.formData(this.currentProject);
      // this.$axios
      //   .post("/admin/api/delete.php", fd)
      //   .then(() => {
      //     this.currentProject = {};
      //     this.getProjectList();
      //   })
      //   .catch((error) => {
      //     console.log(error);
      //   });
    },
    sacleFormat(value) {
      if (value == 0) return "px";
      if (value == 1) return "mm";
      if (value == 2) return "cm";
      if (value == 3) return "in";
    },
    dateFormat(e) {
      let str = e.slice(0, 10);
      return str;
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
    // deleteImg() {
    //   const delete_img = document.createElement("img");
    //   delete_img.src = "http://localhost/admin/api/img/delete.png";
    //   const src = document.getElementById("#delete");
    //   src.appendChild(delete_img);
    // },
  },
  mounted() {
    // this.getProjectList();
    this.table();
  },
};
</script>

<style>
td {
  text-align: center;
}
.project_img {
  width: 30px;
  height: 30px;
}
.modal-dialog {
  max-width: 1000px !important;
}
.form-select {
  width: auto !important;
  display: inline-block !important;
  margin-right: 10px;
}
</style>
