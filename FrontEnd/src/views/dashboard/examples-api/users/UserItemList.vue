<template>
  <tr>
    <td
      v-for="(value, key) in Object.entries($props).slice(1)"
      :key="key"
      class="text-sm font-weight-normal"
    >
      {{ value[1] }}
    </td>
    <td class="text-sm font-weight-normal">
      <div class="text-end">
        <material-button
          class="m-1 btn-circle"
          title="edit"
          size="sm"
          @click="editarUsuario"
        >
          <i class="fas fa-pen"></i>
        </material-button>
        <material-button
          id="delBut"
          class="m-1 btn-circle"
          size="sm"
          color="danger"
          title="delete"
          @click="eliminarUsuario()"
        >
          <i class="fas fa-trash"></i>
        </material-button>
      </div>
    </td>
  </tr>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";
import showSwal from "@/mixins/showSwal";
import userService from "@/services/user.service";

export default {
  name: "UserItemList",
  components: {
    MaterialButton,
  },
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
    email: {
      type: String,
      required: true,
    },

    nombre: {
      type: String,
      required: true,
    },
    apellidos: {
      type: String,
      required: true,
    },
    telefono: {
      type: String,
      required: true,
    },
    ciudad: {
      type: [String, Number, null],
      required: true,
    },
    creado: {
      type: String,
      required: true,
    },
    rol: {
      type: [String, Number],
      required: true,
    },
  },
  methods: {
    eliminarUsuario() {
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
    },
    async editarUsuario() {
      if (this.rol !== "administrador") {
        showSwal.methods.showSwal({
          type: "error",
          message: "Solo puedes editar Administradores",
          width: 500,
        });
        return;
      }
      const user = {
        id: this.id,
        email: this.email,
        nombre: this.nombre,
        apellidos: this.apellidos,
        telefono: this.telefono,
      };


      const datos = await showSwal.methods.showEditUser(user);
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
    },
  },
};
</script>

<style scoped>
.btn-circle.btn-sm {
  width: 30px;
  height: 30px;
  padding: 6px 0px;
  border-radius: 15px;
  font-size: 8px;
  text-align: center;
}

table tbody tr td {
  padding-left: 1.5rem !important;
}
</style>
