<template>
  <LoadingPage ref="loading"></LoadingPage>
  <DataTable
    :item-type="'Vehiculos'"
    :columns="columns"
    :items="vehiculos"
    v-on:add="addVehiculo"
    v-on:edit="editVehiculo"
    v-on:delete="deleteVehiculo"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import vehiculoService from "@/services/vehiculos.service";
import showSwal from "@/mixins/showSwal";
import LoadingPage from "@/components/index/LoadingPage.vue";
import { watch } from "vue";
const loading = ref(null);
const isReady = ref(false);

const columns = [
  "Imagen",
  "Matricula",
  "Capacidad",
  "Fabricante",
  "Modelo",
  "Tipo",
];
const vehiculos = ref([]);

onMounted(async () => {
  const data = await vehiculoService.getVehiculos();
  vehiculos.value = data.vehiculos;
  isReady.value = true;
});

async function addVehiculo() {
  const datos = await showSwal.methods.showAddVehiculo();
  if (!datos) return;

  const data = await vehiculoService.addVehiculo(datos);
  if (!data.success) {
    let finalMessage = data.error ? `ERROR: ${data.error}` : "ERROR";
    showSwal.methods.showSwal({
      type: "error",
      message: finalMessage,
      width: 500,
    });
  } else {
    showSwal.methods.showSwal({
      type: "success",
      message: "Vehiculo creado",
      width: 500,
    });
  }
}
async function editVehiculo(vehiculo) {
  let data;
  const newVehiculo = {
    id: vehiculo.id,
    matricula: vehiculo.matricula,
    capacidad: vehiculo.capacidad,
    fabricante: vehiculo.fabricante,
    modelo: vehiculo.modelo,
    tipo: vehiculo.tipo,
  };
  const datos = await showSwal.methods.showEditVehiculo(newVehiculo);
  if (!datos) return;
  data = datos;

  vehiculoService
    .actualizarVehiculo(data)
    .then((result) => {
      if (result.success) {
        showSwal.methods.showSwal({
          type: "success",
          message: "Vehiculo actualizado correctamente",
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al editar el vehiculo",
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
async function deleteVehiculo(vehiculo) {
  showSwal.methods
    .showSwalConfirmationDelete()
    .then((result) => {
      if (result.isConfirmed) {
        vehiculoService
          .eliminarVehiculo(vehiculo.id)
          .then((result) => {
            if (result.success) {
              showSwal.methods.showSwal({
                type: "success",
                message: "Vehiculo eliminado correctamente",
                width: 500,
              });
            } else {
              showSwal.methods.showSwal({
                type: "error",
                message: "Error al eliminar el vehiculo",
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
  const data = await vehiculoService.getVehiculos();
  vehiculos.value = data.vehiculos;
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
