const { defineConfig } = require("@vue/cli-service");
const path = require("path");

module.exports = defineConfig({
  transpileDependencies: true,
});

const target = "nemolabs.iptime.org";
module.exports = {
  outputDir: path.resolve(__dirname, "../server/dist"),
  devServer: {
    port: 1022,
    proxy: {
      "^/api": {
        target,
        changeOrigin: true,
      },
    },
  },
  // publicPath: process.env.NODE_ENV === "production" ? "" : "/",
};
