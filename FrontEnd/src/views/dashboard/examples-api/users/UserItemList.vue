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

export default {
  name: "UserItemList",
  components: {
    MaterialButton,
  },
  props: {
    id: {
      type: String,
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
      type: String,
      required: true,
    },
    creado: {
      type: String,
      required: true,
    },
    rol: {
      type: String,
      required: true,
    },
  },
  methods: {
    eliminarUsuario() {
      showSwal.methods.showSwalConfirmationDelete();
    },
    editarUsuario() {
      showSwal.methods.showSwal({
        type: "error",
        message: "Solo puedes editar Administradores",
        width: 500,
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
