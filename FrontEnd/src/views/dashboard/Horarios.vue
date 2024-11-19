<template>
  <DataTable
    :item-type="'Horarios'"
    :columns="columns"
    :items="horarios"
    v-on:edit="editHorario"
    v-on:reload="reload"
  />
</template>

<script setup>
import DataTable from "@/views/dashboard/components/DataTable.vue";
import { onMounted, ref } from "vue";
import horarioService from "@/services/horario.service";
import showSwal from "@/mixins/showSwal";
const columns = [
  "Nombre",
  "Hora_ini1",
  "Hora_fin1",
  "Hora_ini2",
  "Hora_fin2",
  "Tarifa_dia",
  "Tarifa_minuto",
];
const horarios = ref([]);

onMounted(async () => {
  const data = await horarioService.getHorarios();
  horarios.value = data.horarios;
});

async function editHorario(horario) {
  const newhorario = {
    id: horario.id,
    nombre: horario.nombre,
    tarifa_dia: horario.tarifa_dia,
    tarifa_minuto: horario.tarifa_minuto,
  };
  const datos = await showSwal.methods.showEditHorario(newhorario);
  if (!datos) return;
  horarioService
    .actualizarHorario(datos)
    .then((result) => {
      if (result.success) {
        showSwal.methods.showSwal({
          type: "success",
          message: "Horario actualizado correctamente",
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al editar el horario",
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
  const data = await horarioService.getHorarios();
  horarios.value = data.horarios;
}
</script>
