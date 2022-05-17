<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" :subMenu="sub" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-5">
          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button class="btn btn-primary" type="button">
                템플릿 타입 추가
              </button>
              <button class="btn btn-danger" type="button">❌ 삭제</button>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <ul class="list-group">
              <li
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                프레젠테이션
                <span class="badge bg-primary rounded-pill">2</span>
              </li>
            </ul>
          </div>

          <div class="col">
            <div class="d-flex flex-wrap justify-content-between my-3">
              <button class="btn btn-primary" type="button">분류 추가</button>
              <button class="btn btn-danger" type="button">❌ 삭제</button>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <ul class="list-group">
              <li
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                프레젠테이션
                <span class="badge bg-primary rounded-pill">2</span>
              </li>
            </ul>
          </div>

          <div class="col">
            <div
              class="d-flex flex-wrap justify-content-between alingn-items-center my-3"
            >
              <b class="pt-2">작업크기</b>
              <button class="btn btn-secondary" type="button">저장</button>
            </div>
            <ul class="list-group">
              <li
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                프레젠테이션
                <span class="badge bg-primary rounded-pill">2</span>
              </li>
            </ul>
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

export default {
  name: "AdminID",
  components: { PageName, TableLoading },
  data() {
    return {
      main: "시스템 설정 >",
      sub: "작업크기 관리",
    };
  },
  mixins: [table],
  methods: {},
};
</script>

<style scoped></style>
