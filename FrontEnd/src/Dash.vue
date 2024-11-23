<script>
import Sidenav from "@/components/dashboard/Sidenav/index.vue";
import Navbar from "@/components/dashboard/Navbars/Navbar.vue";
import { mapMutations, mapState } from "vuex";

export default {
  name: "Dashboard",
  components: {
    Sidenav,
    Navbar,
  },
  methods: {
    ...mapMutations(["navbarMinimize"]),
  },
  computed: {
    ...mapState([
      "isRTL",
      "color",
      "isAbsolute",
      "isNavFixed",
      "navbarFixed",
      "absolute",
      "showSidenav",
      "showNavbar",
      "showFooter",
      "showConfig",
      "hideConfigButton",
    ]),
  },
  beforeMount() {
    this.$store.state.isTransparent = "bg-transparent";

    const sidenav = document.getElementsByClassName("g-sidenav-show")[0];
    if (sidenav) {
      if (window.innerWidth > 1200) {
        sidenav.classList.add("g-sidenav-pinned");
      }
    }
  },
};
</script>

<template>
  <div>
    <sidenav
      :custom_class="color"
      :class="[isRTL ? 'fixed-end' : 'fixed-start']"
      v-if="true"
    />
    <main
      class="main-content position-relative max-height-vh-100 h-100 overflow-x-hidden"
    >
      <!-- nav -->
      <navbar
        :class="[isNavFixed ? navbarFixed : '', isAbsolute ? absolute : '']"
        :color="isAbsolute ? 'text-white opacity-8' : ''"
        :minNav="navbarMinimize"
        v-if="showNavbar"
      />
    
      <router-view />
    </main>
  </div>
</template>
