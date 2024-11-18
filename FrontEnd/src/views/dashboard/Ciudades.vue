<template>
  <DataTable
    :item-type="'Usuarios'"
    :columns="columns"
    :items="users"
    v-on:add="addUser"
    v-on:edit="editUser"
    v-on:delete="deleteUser"
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
  "Email",
  "Nombre",
  "Apellidos",
  "Telefono",
  "Ciudad",
  "Fecha_creacion",
  "Rol",
];
const users = ref([]);

onMounted(async () => {
  const data = await userService.getUsuarios();
  users.value = data.usuarios;
});

async function addUser() {
  const datos = await showSwal.methods.showAddUser();
  if (!datos) return;
  console.log(datos);
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
  console.log(user);

  if (this.rol !== "administrador") {
    showSwal.methods.showSwal({
      type: "error",
      message: "Solo puedes editar Administradores",
      width: 500,
    });
    return;
  }
  const newUser = {
    id: this.id,
    email: this.email,
    nombre: this.nombre,
    apellidos: this.apellidos,
    telefono: this.telefono,
  };

  const datos = await showSwal.methods.showEditUser(newUser);
  if (!datos) return;

  userService
    .actualizarUsuario(datos)
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
  console.log(user);

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
          userService
            .eliminarUsuario(this.id)
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
        alert(err);
      });
  }
}
async function reload() {
  const data = await userService.getUsuarios();
  users.value = data.usuarios;
}
</script>
