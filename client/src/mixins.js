const table = {
  data() {
    return {
      tableLoading: true,
    };
  },
  methods: {
    loading() {
      this.tableLoading = true;
    },
    endloading() {
      this.tableLoading = false;
    },
    table() {
      setTimeout(() => {
        // eslint-disable-next-line no-undef
        let table = new DataTable("#example", {
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
      }, 100);
    },
  },
};
export default table;
