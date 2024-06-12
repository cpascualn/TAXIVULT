<template>
  <div>
    <header>
      <Hero
        :imagen="img"
        :botones="$route.path === '/conduce' ? false : true"
      ></Hero>
    </header>
    <RouterView></RouterView>
    <Footer></Footer>
  </div>
</template>

<script setup>
import Hero from "./components/Hero.vue";
import Footer from "./components/Footer.vue";
import { RouterView, useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();

const img = computed(() => {
  if (route.path === "/") {
    return "/img/hero.jpg";
  } else if (route.path === "/conduce") {
    return "/img/heroConducir.jpg";
  } else {
    return "/img/hero.jpg";
  }
});

</script>

<style scoped></style>
