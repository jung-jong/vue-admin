<template>
  <div>
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <!-- <div class="sb-sidenav-menu-heading">Interface</div> -->
            <a
              class="nav-link"
              href=""
              data-bs-toggle="collapse"
              data-bs-target="#monitoring"
              aria-expanded="true"
              aria-controls="monitoring"
            >
              <!-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> -->
              작업모니터링
              <div class="sb-sidenav-collapse-arrow">
                <i class="fas fa-angle-down"></i>
              </div>
            </a>
            <div
              class="collapse show"
              id="monitoring"
              aria-labelledby="headingOne"
              data-bs-parent="#sidenavAccordion"
            >
              <nav class="sb-sidenav-menu-nested nav">
                <router-link to="/" class="nav-link">
                  프로젝트 현황
                </router-link>
                <router-link to="/user" class="nav-link">
                  회원 현황
                </router-link>
              </nav>
            </div>
            <router-link class="nav-link" to="/theme">테마 관리</router-link>
            <a
              class="nav-link collapsed"
              href=""
              data-bs-toggle="collapse"
              data-bs-target="#systemSetting"
              aria-expanded="false"
              aria-controls="systemSetting"
            >
              <!-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> -->
              시스템 설정
              <div class="sb-sidenav-collapse-arrow">
                <i class="fas fa-angle-down"></i>
              </div>
            </a>
            <div
              class="collapse"
              id="systemSetting"
              aria-labelledby="headingOne"
              data-bs-parent="#sidenavAccordion"
            >
              <nav class="sb-sidenav-menu-nested nav">
                <router-link class="nav-link" to="/woking-size"
                  >작업크기 관리</router-link
                >
                <router-link class="nav-link" to="/admin-id"
                  >관리자 ID 설정</router-link
                >
              </nav>
            </div>
            <!-- <div class="sb-sidenav-menu-heading">Addons</div> -->
          </div>
        </div>
        <div class="sb-sidenav-footer"></div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  name: "SideNav",
  methods: {
    refreshAll() {
      setTimeout(() => {
        this.$router.go();
      }, 500);
    },
  },
};
</script>

<style lang="scss" scoped></style>
