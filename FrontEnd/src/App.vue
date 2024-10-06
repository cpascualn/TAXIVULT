<script setup>
import { RouterView } from "vue-router";
// solo para desarrollo
const currentUrl = window.location.href;
if (currentUrl.includes("/dashboard/")) {
  const newUrl = currentUrl.replace(/\/dashboard\/.*/, "/dashboard");
  window.location.href = newUrl;
}

</script>

<template>
  <RouterView />
</template>

<style scoped></style>
