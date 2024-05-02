<script setup>
import Header from "@/components/Header.vue";
</script>

<template>
  <div class="div">
    <img loading="lazy" srcSet="/img/hero.jpg" class="img" />
    <Header></Header>
    <router-link to="login" class="button">RESERVA YA</router-link>
  </div>
</template>

<style scoped>
.div {
  display: flex;
  flex-direction: column;
  overflow: hidden;
  position: relative;
  width: 100%;
  padding-bottom: 80px;
  text-align: center;
}

@media (max-width: 991px) {
  .div {
    max-width: 100%;
  }
}

.img {
  position: absolute;
  inset: 0;
  height: 100%;
  width: 100%;
  object-fit: cover;
  object-position: center;
}

.button {
  position: relative;
  border-radius: 50px;
  box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;
  border-color: rgba(0, 0, 0, 1);
  border-style: solid;
  border-width: 3px;
  background-color: var(--primario, #ffc000);
  align-self: start;
  color: var(--negro, #000);
  justify-content: center;
  margin: 25% 0 0 20%;
  padding: 40px 28px;
  font: italic 800 30px K2D, sans-serif;
  text-decoration: none;
}

@media (max-width: 991px) {
  .button {
    margin: 40px 0 40px 10px;
    padding: 0 20px;
  }
}
</style>
