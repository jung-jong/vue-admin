const { defineConfig } = require("@vue/cli-service");
const path = require("path");

module.exports = defineConfig({
  transpileDependencies: true,
});

const target = "http://nemolabs.iptime.org:1080/admin/";
module.exports = {
  // outputDir: path.resolve(__dirname, "../server/dist"),
  devServer: {
    port: 3000,
    proxy: {
      "^api": {
        target,
        changeOrigin: true,
      },
    },
  },
  publicPath: process.env.NODE_ENV === "production" ? "/admin/" : "/",
};
