$(document).ready(function () {
  let timeout;

  table();

  //데이터가 없으면 삭제
  deleteTable();
  // 테이블 재생성
  createTable();

  function createTable() {
    if ($(".dataTables_empty").length == 0) {
      timeout = setTimeout(() => {
        table();
        deleteTable();
      }, 1000);
      timeout = setTimeout(() => {
        table();
        deleteTable();
      }, 2000);
      timeout = setTimeout(() => {
        table();
        deleteTable();
      }, 3000);
      timeout = setTimeout(() => {
        table();
        deleteTable();
      }, 4000);
      timeout = setTimeout(() => {
        table();
        deleteTable();
      }, 5000);
    }
  }

  function deleteTable() {
    if ($(".dataTables_empty").length > 0 && $(".dataTables_info").length > 0) {
      $("#example").DataTable().destroy();
    }
  }

  function table() {
    $("#example").DataTable({
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
      destroy: true,
    });
  }
});
