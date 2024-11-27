<template>
  <nav
    class="shadow-none navbar navbar-main navbar-expand-lg border-radius-xl"
    v-bind="$attrs"
    id="navbarBlur"
    data-scroll="true"
    :class="isAbsolute ? 'mt-4' : 'mt-0'"
  >
    <div class="px-3 py-1 container-fluid">
      <breadcrumbs :currentPage="currentRouteName" :color="color" />
      <div
        class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4"
        id="navbar"
      >
        <div class="pe-md-3 d-flex align-items-center ms-md-auto"></div>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle d-flex align-items-center py-0"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              :class="color ? color : 'text-body'"
            >
              <i class="material-icons me-sm-1">account_circle</i>
            </a>

            <ul class="dropdown-menu">
              <!--Profile-->
              <li class="nav-item d-flex align-items-center">
                <router-link
                  :to="{ name: 'perfil' }"
                  class="px-0 nav-link font-weight-bold lh-1 d-flex align-items-center"
                >
                  <i class="material-icons ms-2 me-sm-1"> account_circle </i>
                  My Profile
                </router-link>
              </li>

              <hr class="m-0" />

              <!--Logout-->
              <li class="nav-item d-flex align-items-center">
                <div
                  @click="logout"
                  class="px-0 nav-link font-weight-bold lh-1 d-flex align-items-center"
                >
                  <i class="material-icons ms-2 me-sm-1"> logout </i>
                  Logout
                </div>
              </li>
            </ul>
          </li>

          <li class="nav-item d-xl-none px-3 d-flex align-items-center">
            <a
              @click="toggleSidebar"
              class="p-0 nav-link text-body lh-1"
              id="iconNavbarSidenav"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>

          <li class="nav-item dropdown d-flex align-items-center pe-5"></li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
import Breadcrumbs from "@/components/dashboard/Breadcrumbs.vue";
import AuthService from '@/services/auth.service';
import { mapMutations } from "vuex";

export default {
  name: "navbar",
  data() {
    return {
      showMenu: false,
    };
  },
  props: ["minNav", "color"],
  created() {
    this.minNav;
  },
  methods: {
    ...mapMutations(["navbarMinimize"]),

    toggleSidebar() {
      this.navbarMinimize();
    },

    logout() {
      AuthService.logout();
      location.reload();
    },
  },
  components: {
    Breadcrumbs,
  },
  computed: {

    currentRouteName() {
      return this.$route.name;
    },
  },
};
</script>
