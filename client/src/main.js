import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import "@/assets/css/styles.css";
import mixin from "@/mixins";
import axios from "axios";
import "bootstrap";

//url:포트번호
// axios.defaults.baseURL = "http://nemolabs.iptime.org:1080";
axios.defaults.baseURL = "http://localhost:3000";
axios.defaults.headers.post["Content-Type"] = "application/json;charset=utf-8";
axios.defaults.headers.post["Access-Control-Allow-Origin"] = "*";

Vue.prototype.$axios = axios;
Vue.config.productionTip = false;
Vue.mixin(mixin);

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
