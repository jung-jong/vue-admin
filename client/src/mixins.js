const table = {
  data() {
    return {
      tableLoading: true,
      baseURL: "http://localhost:3000",
      projectList: [],
    };
  },
  methods: {
    $loading() {
      this.tableLoading = true;
    },
    $endloading() {
      this.tableLoading = false;
    },
    $table() {
      this.$endloading();
      // eslint-disable-next-line no-undef
      let table = new DataTable("#example", {
        processing: true,
        serverSide: true,
        ajax: this.baseURL + "/admin/api/table2.php",
        // columns: [
        //   { data: "SEQ_ID" },
        //   { data: "USER_ID" },
        //   { data: "TITLE" },
        //   { data: "SCALE_CD" },
        //   { data: "WIDTH" },
        //   { data: "HEIGHT" },
        //   { data: "SHARE_URL" },
        //   { data: "A_DATE" },
        //   { data: "U_DATE" },
        // ],
        // {
        //   dataSrc: function (response) {
        //     let data = response.data;
        //     console.log(response);
        //     return data;
        //   },
        // },
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
    },
  },
};
export default table;
