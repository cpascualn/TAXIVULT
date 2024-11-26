<template>
  <LoadingPage ref="loading"></LoadingPage>
  <DataTable
    :item-type="'Viajes'"
    :columns="columns"
    :items="viajes"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import viajeService from "@/services/viaje.service";
import profileService from "@/services/profile.service";
import LoadingPage from "@/components/index/LoadingPage.vue";
import { watch } from "vue";
const loading = ref(null);
const isReady = ref(false);

const columns = [
  "Conductor", //email
  "Pasajero", //email
  "Inicio",
  "Fin",
  "Metodo_pago",
  "Distancia",
  "Duracion",
  "Precio",
  "Ciudad",
  "Salida",
  "Llegada",
];

const viajes = ref([]);

onMounted(async () => {
  let data;
  // get profile rol
  const profile = await profileService.getProfile();
  if (!profile) return;
  //si es admin, mostrar todos los viajes , si no, mostrar solo los suyos
  if (profile.rol === 1) {
    data = await viajeService.getViajes();
    viajes.value = data.viajes;
  } else {
    data = await viajeService.getViajesUsuario(profile);
    viajes.value = data;
  }

  isReady.value = true;
});

async function reload() {
  let data;
  // get profile rol
  const profile = await profileService.getProfile();
  if (!profile) return;
  //si es admin, mostrar todos los viajes , si no, mostrar solo los suyos
  if (profile.rol === 1) {
    data = await viajeService.getViajes();
    viajes.value = data.viajes;
  } else {
    data = await viajeService.getViajesUsuario(profile);
    viajes.value = data;
  }
}

const loadFinished = () => {
  if (loading.value) {
    loading.value.closeModal();
  }
};

// Configuramos un `watch` para observar `isReady`
watch(isReady, (newVal) => {
  if (newVal) {
    loadFinished();
  }
});
</script>
