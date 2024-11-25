<template>
  <div
    class="multisteps-form__panel border-radius-xl bg-white"
    data-animation="FadeIn"
  >
    <h5 class="font-weight-bolder mb-0">Mis Datos</h5>
    <div class="multisteps-form__content">
      <div class="row mt-5">
        <material-input
          id="email"
          type="email"
          label="Email Address"
          variant="static"
          :value="user.email"
          name="email"
          @update:value="(e) => upval(e, 'email')"
        />
        <div class="validFeedback" v-if="validacion.email === true">
          Correcto
        </div>
        <div class="invalidFeedback" v-if="validacion.email === false">
          El mail debe tener formato usuario@dominio.**
        </div>
      </div>

      <div class="row mt-5">
        <material-input
          id="name"
          label="Nombre"
          variant="static"
          :value="user.nombre"
          name="name"
          @update:value="(e) => upval(e, 'nombre')"
        />
        <div class="validFeedback" v-if="validacion.nombre === true">
          Correcto
        </div>
        <div class="invalidFeedback" v-if="validacion.nombre === false">
          El nombre no es valido
        </div>
      </div>
      <div class="row mt-5">
        <material-input
          id="apellidos"
          label="Apellidos"
          variant="static"
          :value="user.apellidos"
          name="apellidos"
          @update:value="(e) => upval(e, 'apellidos')"
        />
        <div class="validFeedback" v-if="validacion.apellidos === true">
          Correcto
        </div>
        <div class="invalidFeedback" v-if="validacion.apellidos === false">
          Los Apellidos no son validos
        </div>
      </div>

      <div class="row mt-5">
        <material-input
          id="telefono"
          label="Teléfono"
          variant="static"
          :value="user.telefono"
          name="telefono"
          @update:value="(e) => upval(e, 'telefono')"
        />
        <div class="validFeedback" v-if="validacion.telefono === true">
          Correcto
        </div>
        <div class="invalidFeedback" v-if="validacion.telefono === false">
          El telefono no es correcto
        </div>
      </div>

      <div class="row mt-5" v-if="user.ciudad">
        <material-input
          id="ciudad"
          label="Ciudad"
          variant="static"
          value="Solicite el cambio de Ciudad a un administrador: admin@taxivult.app"
          name="ciudad"
          disabled="true"
        />
      </div>

      <div class="button-row d-flex mt-4">
        <material-button
          type="button"
          color="dark"
          variant="gradient"
          class="ms-auto mb-0 js-btn-next"
          @click="handleSubmit"
          >Submit Changes</material-button
        >
      </div>
    </div>
  </div>
</template>

<script>
import MaterialInput from "@/components/dashboard/MaterialInput.vue";
import MaterialButton from "@/components/dashboard/MaterialButton.vue";
import MaterialAvatar from "@/components/dashboard/MaterialAvatar.vue";
import showSwal from "@/mixins/showSwal.js";
import regFormCheck from "@/mixins/regFormCheck.js";

import profileService from "@/services/profile.service";
import ciudadService from "@/services/ciudad.service";
import userService from "@/services/user.service";

export default {
  name: "Info",
  components: {
    MaterialInput,
    MaterialButton,
    MaterialAvatar,
  },
  data() {
    return {
      user: {},
      validacion: {
        email: null,
        nombre: null,
        apellidos: null,
        telefono: null,
      },
    };
  },
  async mounted() {
    this.loading = true;
    try {
      const usuario = await profileService.getProfile();
      if (usuario.rol !== 1) {
        const ciudad = await ciudadService.getCiudadUsuario();
        usuario.ciudad = ciudad ? ciudad.nombre : "";
      }
      this.user = usuario;
    } catch (error) {
      showSwal.methods.showSwal({
        type: "error",
        message: "Oops, something went wrong!",
        width: 500,
      });
    } finally {
      this.loading = false;
    }
    this.loading = false;
  },
  methods: {
    async handleSubmit() {
      // validar valores
      if (!regFormCheck.checkMail(this.user.email))
        this.validacion.email = false;
      else this.validacion.email = true;
      if (!regFormCheck.checkNombre(this.user.nombre))
        this.validacion.nombre = false;
      else this.validacion.nombre = true;
      if (!regFormCheck.checkTelefono(this.user.telefono))
        this.validacion.telefono = false;
      else this.validacion.telefono = true;
      if (!regFormCheck.checkNombre(this.user.apellidos))
        this.validacion.apellidos = false;
      else this.validacion.apellidos = true;

      if (
        !this.user.email ||
        !this.user.nombre ||
        !this.user.apellidos ||
        !this.user.telefono
      ) {
        showSwal.methods.showSwal({
          type: "error",
          message: "Todos los campos son obligatorios.",
          width: 500,
        });
        return false;
      }

      const algunaInvalida = Object.values(this.validacion).some(
        (valor) => valor === null || valor === false
      );
      if (algunaInvalida) return;
      const newUser = {
        id: this.user.id,
        email: this.user.email,
        nombre: this.user.nombre,
        apellidos: this.user.apellidos,
        telefono: this.user.telefono,
      };
      try {
        userService
          .actualizarUsuario(newUser)
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
      } catch (error) {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al editar el usuario",
          width: 500,
        });
      }
    },
    upval(e, propiedad = " ") {
      this.user[propiedad] = e;
    },
  },
};
</script>

<style scoped>
.validFeedback {
  color: green;
  display: block;
  text-align: center;
  width: 100%;
  max-width: 12rem;
  margin: 0.5rem;
  overflow-wrap: break-word;
}

.invalidFeedback {
  color: red;
  display: block;
  text-align: center;
  width: 100%;
  max-width: 12rem;
  margin: 0.5rem;
  overflow-wrap: break-word;
}
</style>
