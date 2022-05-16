const { defineConfig } = require("@vue/cli-service");
const path = require("path");

module.exports = defineConfig({
  transpileDependencies: true,
});

//:서버포트
const target = "http://localhost";
module.exports = {
  // outputDir: path.resolve(__dirname, "../dist"),
  devServer: {
    historyApiFallback: true,
    port: 3000,
    proxy: {
      "/api": {
        target,
        changeOrigin: true,
      },
    },
  },
  publicPath: process.env.NODE_ENV === "production" ? "/admin/" : "/",
};
