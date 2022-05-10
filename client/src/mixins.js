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
    $dateFormat(e) {
      let str = e.slice(0, 10);
      return str;
    },
  },
};
export default table;
