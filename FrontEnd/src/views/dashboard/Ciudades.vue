<template>
  <DataTable
    :item-type="'Ciudades'"
    :columns="columns"
    :items="ciudades"
    v-on:add="addciudad"
    v-on:edit="editciudad"
    v-on:delete="deleteciudad"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import ciudadService from "@/services/ciudad.service";
import showSwal from "@/mixins/showSwal";
import authService from "@/services/auth.service";
const columns = ["Nombre", "Comunidad", "Pais", "Lat", "Long"];
const ciudades = ref([]);

onMounted(async () => {
  const data = await ciudadService.getCiudades();
  ciudades.value = data.ciudades;
});

async function addciudad() {
  //https://nominatim.openstreetmap.org/search?city=barcelona&country=es&format=json&limit=1
  //recoger de esa api los lat,long y boundingbox con valores ["latMin","latMax","LongMin","LongMax"]
  const datos = await showSwal.methods.showAddciudad();
  if (!datos) return;
  console.log(datos);
  const data = await ciudadService.addCiudad(datos);
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
      message: "Ciudad creado",
      width: 500,
    });
  }
}
async function editciudad(ciudad) {
  console.log(ciudad);

  if (this.rol !== "administrador") {
    showSwal.methods.showSwal({
      type: "error",
      message: "Solo puedes editar Administradores",
      width: 500,
    });
    return;
  }
  const newciudad = {
    id: this.id,
    email: this.email,
    nombre: this.nombre,
    apellidos: this.apellidos,
    telefono: this.telefono,
  };

  const datos = await showSwal.methods.showEditciudad(newciudad);
  if (!datos) return;

  ciudadeservice
    .actualizarCiudad(datos)
    .then((result) => {
      if (result.success) {
        showSwal.methods.showSwal({
          type: "success",
          message: "Ciudad actualizado correctamente",
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al editar el Ciudad",
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
async function deleteciudad(ciudad) {
  console.log(ciudad);

  if (this.rol === "administrador") {
    showSwal.methods.showSwal({
      type: "error",
      message: "No puedes borrar a un administrador",
      width: 500,
    });
  } else {
    showSwal.methods
      .showSwalConfirmationDelete()
      .then((result) => {
        if (result.isConfirmed) {
          ciudadservice
            .eliminarCiudad(this.id)
            .then((result) => {
              if (result.success) {
                showSwal.methods.showSwal({
                  type: "success",
                  message: "Ciudad eliminado correctamente",
                  width: 500,
                });
              } else {
                showSwal.methods.showSwal({
                  type: "error",
                  message: "Error al eliminar el Ciudad",
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
        alert(err);
      });
  }
}
async function reload() {
  const data = await ciudadservice.getCiudades();
  ciudades.value = data.ciudades;
}
</script>
