<template>
  <div
    class="multisteps-form__panel border-radius-xl bg-white"
    data-animation="FadeIn"
  >
    <h5 class="font-weight-bolder mb-0">Cambiar Contraseña</h5>
    <div class="multisteps-form__content mt-4">
      <div class="row">
        <div class="col-12">
          <div class="mt-2">
            <material-input
              id="actualPassword"
              :value="user.current_password"
              type="password"
              label="Contraseña actual"
              name="actualPassword"
              @update:value="(e) => upval(e, 'current_password')"
            />
            <div
              class="validFeedback"
              v-if="validacion.current_password === true"
            >
              Correcto
            </div>
            <div
              class="invalidFeedback"
              v-if="validacion.current_password === false"
            >
              La Contraseña no es correcta
            </div>
          </div>
          <div class="mt-5">
            <material-input
              id="password"
              :value="user.new_password"
              type="password"
              label="Nueva Contraseña"
              name="password"
              @update:value="(e) => upval(e, 'new_password')"
            />
            <div class="validFeedback" v-if="validacion.new_password === true">
              Correcto
            </div>
            <div
              class="invalidFeedback"
              v-if="validacion.new_password === false"
            >
              La Contraseña no es valida
            </div>
          </div>

          <div class="mt-2">
            <material-input
              id="confirmPassword"
              :value="user.password_confirmation"
              type="password"
              label="Confirmar Contraseña"
              name="confirmPassword"
              @update:value="(e) => upval(e, 'password_confirmation')"
            />
            <div
              class="validFeedback"
              v-if="validacion.password_confirmation === true"
            >
              Correcto
            </div>
            <div
              class="invalidFeedback"
              v-if="validacion.password_confirmation === false"
            >
              Las Contraseñas no coinciden
            </div>
          </div>
        </div>
      </div>
      <div class="button-row d-flex mt-4">
        <material-button
          type="button"
          color="dark"
          variant="gradient"
          class="ms-auto mb-0 js-btn-next"
          @click="handleChange"
          >Change Password</material-button
        >
      </div>
    </div>
  </div>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";
import MaterialInput from "@/components/dashboard/MaterialInput.vue";
import showSwal from "@/mixins/showSwal.js";
import regFormCheck from "@/mixins/regFormCheck.js";
import profileService from "@/services/profile.service";
import userService from "@/services/user.service";

export default {
  name: "Password",
  components: {
    MaterialButton,
    MaterialInput,
  },
  data() {
    return {
      usuario: {},
      user: {
        current_password: "",
        new_password: "",
        password_confirmation: "",
      },
      validacion: {
        password: null,
        new_password: null,
        password_confirmation: null,
      },
    };
  },
  async mounted() {
    this.usuario = await profileService.getProfile();
  },
  methods: {
    upval(e, propiedad = " ") {
      this.user[propiedad] = e;
    },
    async handleChange() {
      console.log(this.usuario);
      console.log(this.user.current_password);

      const esCorrecta = await userService.comprobarContrasena({
        email: this.usuario.email,
        password: this.user.current_password,
      });
      this.validacion.current_password = esCorrecta;
      if (!esCorrecta) return;

      if (!regFormCheck.checkContrasena(this.user.new_password)) {
        this.validacion.new_password = false;
        return;
      } else this.validacion.new_password = true;

      if (
        !regFormCheck.checkContrasena(this.user.password_confirmation) &&
        this.user.new_password != this.user.password_confirmation
      ) {
        this.validacion.password_confirmation = false;
        return;
      } else this.validacion.password_confirmation = true;
      this.usuario.contrasena = this.user.new_password;
      const nuevoUsuario = {
        id: this.usuario.id,
        contrasena: this.usuario.contrasena,
      };
      userService
        .actualizarUsuario(nuevoUsuario)
        .then((result) => {
          if (result.success) {
            showSwal.methods.showSwal({
              type: "success",
              message: "Contraseña actualizada correctamente",
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
