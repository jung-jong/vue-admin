<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <page-name :mainMenu="main" />
        <table-loading v-if="tableLoading" />
        <div class="row gx-4 my-3 overflow-auto" id="top">
          <div class="col-2">
            <h5 class="fw-bold my-3">컨텐츠 타입</h5>
            <select v-model="selected" class="form-select m-0 mb-1 w-100">
              <option value="1">px</option>
              <option value="2">mm</option>
              <option value="3">cm</option>
              <option value="4">inch</option>
            </select>
            <div class="card">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">템플릿</li>
              </ul>
            </div>
          </div>

          <div class="col-2">
            <h5 class="fw-bold my-3">리스트 방식</h5>
            <div class="card p-3">
              <div class="form-check mb-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="flexCheckDefault"
                  v-model="apiCheck"
                />
                <label class="form-check-label" for="flexCheckDefault">
                  API 기준
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                  id="flexCheckChecked"
                  v-model="adminCheck"
                />
                <label class="form-check-label" for="flexCheckChecked">
                  자체 설정
                </label>
              </div>
            </div>
          </div>

          <div class="col-8">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="fw-bold my-3">테마 리스트</h5>
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addID"
              >
                + 테마 추가
              </button>
            </div>
            <div class="card">
              <ul class="list-group list-group-flush">
                <li
                  :class="{ active: i === activeTheme }"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  <div class="d-flex">
                    <span class="material-symbols-rounded"> delete </span>
                    <span role="button" class="material-symbols-rounded">
                      arrow_upward
                    </span>
                    <span role="button" class="material-symbols-rounded">
                      arrow_downward
                    </span>
                  </div>
                </li>
              </ul>
              <v-pagination
                v-model="currentPage"
                :page-count="totalPages"
                :classes="bootstrapPaginationClasses"
                :labels="paginationAnchorTexts"
              ></v-pagination>
            </div>
          </div>
        </div>

        <div id="bottom" class="d-flex flex-column">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold my-3">콘텐츠 리스트</h5>
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#addID"
            >
              + 콘텐츠 추가
            </button>
          </div>
          <div class="card p-3 flex-row flex-wrap overflow-auto">
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
            <div class="d-flex flex-column m-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" />
                <span class="material-symbols-rounded"> delete </span>
              </div>
              <img
                src="../assets/memo.png"
                class="img-thumbnail"
                style="width: 200px; height: 200px"
                alt="../assets/memo.png"
              />
            </div>
          </div>
          <button
            type="button"
            class="btn btn-secondary text-center btn-lg my-3 mx-auto"
            style="width: 200px"
          >
            저 장
          </button>
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

export default {
  name: "ThemeManagement",
  components: { PageName, TableLoading, vPagination },
  data() {
    return {
      main: "테마 관리",
      selected: 1,
      apiCheck: false,
      adminCheck: true,
      activeTheme: false,
    };
  },
  mixins: [table],
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
#top {
  height: 50vh;
}
.overflow-auto {
  max-height: 50vh;
}
#bottom {
  height: 450px;
  background-color: antiquewhite;
}
</style>
