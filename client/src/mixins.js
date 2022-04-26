const loading = {
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
  },
};

export default loading;
