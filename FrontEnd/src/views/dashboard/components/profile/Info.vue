<template>
  <div
    class="multisteps-form__panel border-radius-xl bg-white"
    data-animation="FadeIn"
  >
    <h5 class="font-weight-bolder mb-0">Mis Datos</h5>
    <div class="multisteps-form__content">
      <div class="row mt-5">
        <material-input
          id="name"
          label="Name"
          variant="static"
          :value="user.nombre"
          name="name"
        />
        <validation-error :errors="apiValidationErrors.name" />
      </div>
      <div class="row mt-5">
        <material-input
          id="apellidos"
          label="apellidos"
          variant="static"
          :value="user.apellidos"
          name="apellidos"
        />
        <validation-error :errors="apiValidationErrors.name" />
      </div>

      <div class="row mt-5">
        <material-input
          id="email"
          type="email"
          label="Email Address"
          variant="static"
          :value="user.email"
          name="email"
        />

        <validation-error :errors="apiValidationErrors.email" />
      </div>

      <div class="row mt-5">
        <material-input
          id="telefono"
          label="teléfono"
          variant="static"
          :value="user.telefono"
          name="telefono"
        />
        <validation-error :errors="apiValidationErrors.name" />
      </div>

      <div class="row mt-5" v-if="user.rol != 1">
        <material-input
          id="ciudad"
          label="ciudad"
          variant="static"
          :value="user.ciudad"
          name="ciudad"
        />
        <validation-error :errors="apiValidationErrors.name" />
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
import ValidationError from "@/components/dashboard/ValidationError.vue";
import formMixin from "@/mixins/formMixin.js";
import showSwal from "@/mixins/showSwal.js";
import _ from "lodash";
import profileService from "@/services/profile.service";
import ciudadService from "@/services/ciudad.service";

export default {
  name: "Info",
  components: {
    MaterialInput,
    MaterialButton,
    MaterialAvatar,
    ValidationError,
  },
  data() {
    return {
      user: {},
      file: null,
      loading: null,
    };
  },
  mixins: [formMixin],
  async mounted() {
    this.loading = true;
    try {
      const usuario = await profileService.getProfile();
      if (usuario.rol !== 1) {
        const ciudad = await ciudadService.getCiudadUsuario();
        usuario.ciudad = ciudad ? ciudad.nombre : "";
      }
      this.user = usuario;
      console.log(this.user);
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
      if (false) {
        showSwal.methods.showSwal({
          type: "error",
          message: "You are not allowed to change data of default users.",
          width: 500,
        });
      } else {
        this.resetApiValidation();

        try {
          await this.$store.dispatch("profile/editProfile", this.user);
          this.user = _.omit(
            this.$store.getters["profile/getUserProfile"],
            "links"
          );
          showSwal.methods.showSwal({
            type: "success",
            message: "Profile updated successfully!",
            width: 500,
          });
        } catch (error) {
          this.setApiValidation(error.response.data.errors);
          showSwal.methods.showSwal({
            type: "error",
            message: "Oops, something went wrong!",
            width: 500,
          });
        }
      }
    },
  },
};
</script>
