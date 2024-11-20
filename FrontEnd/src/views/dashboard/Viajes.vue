<template>
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
  const data = await viajeService.getViajes();
  viajes.value = data.viajes;
});

async function reload() {
  const data = await viajeService.getViajes();
  viajes.value = data.viajes;
}
</script>
