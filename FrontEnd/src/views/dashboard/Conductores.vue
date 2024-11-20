<template>
    <LoadingPage ref="loading"></LoadingPage>
  <DataTable
    :item-type="'Conductores'"
    :columns="columns"
    :items="conductores"
    v-on:edit="editConductor"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import conductoresService from "@/services/conductores.service";
import showSwal from "@/mixins/showSwal";
import LoadingPage from "@/components/index/LoadingPage.vue";
import { watch } from "vue";
const loading = ref(null);
const isReady = ref(false);

const columns = [
  "Dni",
  "Email",
  "Nombre",
  "Apellidos",
  "Licencia_taxista",
  "Coche",
  "Ciudad",
  "Horario",
  "Estado",
  "Viajes"
];
const conductores = ref([]);

onMounted(async () => {
  const data = await conductoresService.getConductores();
  conductores.value = data.conductores;
  isReady.value = true;
});

async function editConductor(conductor) {
  let data;

  const newConductor = {
    id: conductor.id,
    coche: conductor.coche,
    horario: conductor.horario,
  };
  const datos = await showSwal.methods.showEditConductor(newConductor);
  if (!datos) return;
  data = datos;

  conductoresService
    .actualizarConductor(data)
    .then((result) => {
      if (result.success) {
        showSwal.methods.showSwal({
          type: "success",
          message: "Conductor actualizado correctamente",
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al editar el conductor",
          width: 500,
        });
      }
    })
    .catch((err) => {
      showSwal.methods.showSwal({
        type: "error",
        message: err,
        width: 500,
      });
    });
}
async function reload() {
  const data = await conductoresService.getConductores();
  conductores.value = data.conductores;
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
