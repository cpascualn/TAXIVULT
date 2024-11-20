<template>
    <DataTable
      :item-type="'Viajes'"
      :columns="columns"
      :items="users"
      v-on:reload="reload"
    />
  </template>
  
  <script setup>
  import DataTable from "@/views/dashboard/components/DataTable.vue";
  import { onMounted, ref } from "vue";
  import userService from "@/services/user.service";
  import showSwal from "@/mixins/showSwal";
  import authService from "@/services/auth.service";
  const columns = [
  "Conductor",//email
  "Pasajero",//email
  "Inicio",
  "Fin",
  "Metodo_pago",
  "Distancia",
  "Duracion_min",
  "Precio_total",
  "Lugar_salida",
  "Lugar_llegada",
  "Ciudad"
];

  const users = ref([]);
  
  onMounted(async () => {
    const data = await userService.getViajes();
    users.value = data.viajes;
  });
  
  async function addUser() {
    const datos = await showSwal.methods.showAddUser();
    if (!datos) return;
    const data = await authService.register(datos);
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
        message: "Usuario creado",
        width: 500,
      });
    }
  }
  async function editUser(user) {
    let data;
    if (user.rol === "administrador") {
      const newUser = {
      id: user.id,
      email: user.email,
      nombre: user.nombre,
      apellidos: user.apellidos,
      telefono: user.telefono,
    };
      const datos = await showSwal.methods.showEditAdmin(newUser);
      if (!datos) return;
      data = datos;
    } else {
      const newUser = {
      id: user.id,
      email: user.email,
      nombre: user.nombre,
      apellidos: user.apellidos,
      telefono: user.telefono,
      ciudad:user.ciudad,
      rol: user.rol,
    };
      const datos = await showSwal.methods.showEditUser(newUser);
      if (!datos) return;
      data = datos;
    }
  
    userService
      .actualizarUsuario(data)
      .then((result) => {
        if (result.success) {
          showSwal.methods.showSwal({
            type: "success",
            message: "Usuario actualizado correctamente",
            width: 500,
          });
        } else {
          showSwal.methods.showSwal({
            type: "error",
            message: "Error al editar el usuario",
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
  async function deleteUser(user) {
    if (user.rol === "administrador") {
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
            userService
              .eliminarUsuario(user.id)
              .then((result) => {
                if (result.success) {
                  showSwal.methods.showSwal({
                    type: "success",
                    message: "Usuario eliminado correctamente",
                    width: 500,
                  });
                } else {
                  showSwal.methods.showSwal({
                    type: "error",
                    message: "Error al eliminar el usuario",
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
  }
  async function reload() {
    const data = await userService.getViajes();
    users.value = data.viajes;
  }
  </script>
  