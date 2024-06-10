<script setup>
import { RouterView } from "vue-router";

const currentUrl = window.location.href;
if (currentUrl.includes("/dashboard/")) {
  const newUrl = currentUrl.replace(/\/dashboard\/.*/, "/dashboard.html");
  console.log(newUrl);
  window.location.href = newUrl;
}
</script>

<template>
  <RouterView />
</template>

<style scoped></style>
