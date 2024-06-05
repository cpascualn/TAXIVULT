<template>
  <div>
    <Hero imagen="/img/hero.jpg" :botones="true"></Hero>
    <main>
      <Section1></Section1>
      <Section2></Section2>
      <Section3></Section3>
    </main>
    <Footer></Footer>
  </div>
</template>

<script setup>

import Hero from "./components/Hero.vue";
import Footer from "./components/Footer.vue";
import Section1 from "./components/Section1.vue";
import Section2 from "./components/Section2.vue";
import Section3 from "./components/Section3.vue";
import { RouterView } from "vue-router";
</script>

<style scoped></style>
