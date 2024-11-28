<script setup>
import { RouterView } from "vue-router";
import { onMounted } from "vue";
// solo para desarrollo
const currentUrl = window.location.href;
if (currentUrl.includes("/dashboard/")) {
  const newUrl = currentUrl.replace(/\/dashboard\/.*/, "/dashboard");
  window.location.href = newUrl;
}
import showSwal from "@/mixins/showSwal.js";
import { getCookie, setCookie } from "@/assets/utils/cookieHelper";

onMounted(() => {
  const cookie = getCookie("acceptedCookieMessage");
  if (!cookie) {
    showSwal.methods.showSwalConfirmationCookies().then((result) => {
      if (result.isConfirmed) {
        setCookie("acceptedCookieMessage", "true", 1);
      } else {
      }
    });
  }
});
</script>

<template>
  <RouterView />
</template>

<style scoped></style>
