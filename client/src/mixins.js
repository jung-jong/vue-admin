const table = {
  data() {
    return {
      tableLoading: true,
      currentPage: 1,
      totalPages: 1,
      bootstrapPaginationClasses: {
        ul: "pagination justify-content-end",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link",
      },
      paginationAnchorTexts: {
        first: "〈〈",
        prev: "Previous",
        next: "Next",
        last: "〉〉",
      },
    };
  },
  methods: {
    $loading() {
      this.tableLoading = true;
    },
    $endloading() {
      this.tableLoading = false;
    },
    $dateFormat(e) {
      if (e !== null) {
        let str = e.slice(0, 10);
        return str;
      }
    },
  },
};
export default table;
