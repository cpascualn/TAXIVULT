<template>
    <LoadingPage ref="loading"></LoadingPage>
  <DataTable
    :item-type="'Ciudades'"
    :columns="columns"
    :items="ciudades"
    v-on:add="addciudad"
    v-on:delete="deleteciudad"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import ciudadService from "@/services/ciudad.service";
import showSwal from "@/mixins/showSwal";
import LoadingPage from "@/components/index/LoadingPage.vue";
import { watch } from "vue";
const loading = ref(null);
const isReady = ref(false);

const columns = [
  "Nombre",
  "Comunidad",
  "Pais",
  "Lat",
  "Long",
  "Usuarios",
  "Viajes",
];
const ciudades = ref([]);

onMounted(async () => {
  const data = await ciudadService.getCiudades();
  ciudades.value = data.ciudades;
  isReady.value = true;
});

async function addciudad() {
  const nombreCiu = await showSwal.methods.showAddciudad();
  if (!nombreCiu) return;
  const ciudad = await obtenerDatosCiudad(nombreCiu.ciudad);
  if (!ciudad) {
    showSwal.methods.showSwal({
      type: "error",
      message: "No se encontró información para esta ciudad.",
      width: 500,
    });
    return;
  }
  const response = await ciudadService.addCiudad(ciudad);
  if (!response.success) {
    let finalMessage = response.error ? `ERROR: ${response.error}` : "ERROR";
    showSwal.methods.showSwal({
      type: "error",
      message: finalMessage,
      width: 500,
    });
  } else {
    showSwal.methods.showSwal({
      type: "success",
      message: "Ciudad creada",
      width: 500,
    });
  }
}
async function deleteciudad(ciudad) {
  // si la ciudad tiene algun usuario no se puede borrar
  if (ciudad.usuarios > 0) {
    showSwal.methods.showSwal({
      type: "error",
      message: "No puedes borrar una ciudad con usuarios",
      width: 500,
    });
    return;
  }
  showSwal.methods
    .showSwalConfirmationDelete(
      "¡Se ELIMINARÁN todos los VIAJES relacionados! , "
    )
    .then((result) => {
      if (result.isConfirmed) {
        ciudadService
          .deleteCiudad(ciudad.id)
          .then((result) => {
            if (result.success) {
              showSwal.methods.showSwal({
                type: "success",
                message: "Ciudad eliminada correctamente",
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
      showSwal.methods.showSwal({
        type: "error",
        message: err,
        width: 500,
      });
    });
}
async function reload() {
  const data = await ciudadService.getCiudades();
  ciudades.value = data.ciudades;
}

//recoger de esa api los datos:nombre,comunidad, lat,long y boundingbox con valores ["latMin","latMax","LongMin","LongMax"]
async function obtenerDatosCiudad(ciudad) {
  // Lista de comunidades autónomas
  const url = `https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(ciudad)}&country=es&format=json&limit=1`;

  try {
    const respuesta = await fetch(url);
    const datos = await respuesta.json();
    if (datos.length === 0) return null;
    const comunidades = [
      "Andalucía",
      "Aragón",
      "Asturias",
      "Cantabria",
      "Castilla-La Mancha",
      "Castilla y León",
      "Cataluña",
      "Extremadura",
      "Galicia",
      "Madrid",
      "Murcia",
      "Navarra",
      "La Rioja",
      "País Vasco",
      "Valencia",
      "Islas Baleares",
      "Islas Canarias",
      "Ceuta",
      "Melilla",
    ];

    const nombre = datos[0].name;
    const displayName = datos[0].display_name;
    const partes = displayName.split(",").map((p) => p.trim());
    // Buscar la comunidad autónoma en las partes del display_name
    let comunidad = partes.find((parte) => comunidades.includes(parte));
    if (!comunidad) {
      comunidad = datos.display_name;
    }
    let lat = datos[0].lat;
    let long = datos[0].lon;
    let lat_min = datos[0].boundingbox[0];
    let lat_max = datos[0].boundingbox[1];
    let long_min = datos[0].boundingbox[2];
    let long_max = datos[0].boundingbox[3];

    // limitar la cadena a 12 digitos
    lat = lat.length > 12 ? lat.slice(0, 12) : lat;
    long = long.length > 12 ? long.slice(0, 12) : long;
    lat_min = lat_min.length > 12 ? lat_min.slice(0, 12) : lat_min;
    lat_max = lat_max.length > 12 ? lat_max.slice(0, 12) : lat_max;
    long_min = long_min.length > 12 ? long_min.slice(0, 12) : long_min;
    long_max = long_max.length > 12 ? long_max.slice(0, 12) : long_max;

    return {
      nombre,
      comunidad,
      pais: "España",
      lat,
      long,
      lat_min,
      lat_max,
      long_min,
      long_max,
    };
  } catch (error) {
    return null;
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
