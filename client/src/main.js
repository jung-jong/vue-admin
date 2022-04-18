import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import "@/assets/css/styles.css";
import axios from "axios";
import mixin from "@/mixins";

axios.defaults.headers.post["Content-Type"] = "application/json;charset=utf-8";
axios.defaults.headers.post["Access-Control-Allow-Origin"] = "*";

Vue.prototype.$axios = axios;
Vue.config.productionTip = false;
Vue.mixin(mixin);

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
