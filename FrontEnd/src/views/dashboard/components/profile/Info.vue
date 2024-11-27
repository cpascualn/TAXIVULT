<template>
  <LoadingPage ref="loading"></LoadingPage>
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
          value="Solicite el traslado de Ciudad a un administrador: admin@taxivult.app"
          name="ciudad"
          :disabled="true"
        />
      </div>
      <div class="row mt-5" v-if="user.rol == 2">
        <material-input
          id="horario"
          label="Horario"
          variant="static"
          value="Solicite el cambio de Horario a un administrador: admin@taxivult.app"
          name="horario"
          :disabled="true"
        />
      </div>
      <div class="row mt-5" v-if="user.ciudad">
        <material-input
          id="barrio"
          label="Barrio"
          variant="static"
          :value="user.ubi_espera"
          name="barrio"
          placeholder="Barrio habitual"
          @update:value="(e) => upval(e, 'ubi_espera')"
        />
        <div class="buscador">
          <p v-if="validacion.errorMessage" style="color: red">
            {{ validacion.errorMessage }}
          </p>
          <ul v-if="locations.length > 0" class="desplegable">
            <li
              v-if="locations"
              v-for="location in locations"
              :key="location.place_id"
              @click="selectLocation(location)"
            >
              {{ location.display_name }}
            </li>
          </ul>
        </div>
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
import userService from "@/services/user.service";
import conductoresService from "@/services/conductores.service";
import ciudadService from "@/services/ciudad.service";
import LoadingPage from "@/components/index/LoadingPage.vue";

export default {
  name: "Info",
  components: {
    MaterialInput,
    MaterialButton,
    MaterialAvatar,
    LoadingPage,
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
      locations: [],
      isReady: false,
    };
  },
  async mounted() {
    this.loading = true;
    try {
      const usuario = await profileService.getProfile();

      if (usuario.rol == 2) {
        const ciudad = await ciudadService.getCiudadUsuario();
        usuario.ciudad = ciudad ? ciudad.nombre : "";
        const conductor = await conductoresService.obtenerConductor(usuario);
        usuario.ubi_espera = conductor.ubi_espera;
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

    this.isReady = true;
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
      //actualizar la ubicacion de espera
      if (this.user.rol == 2) {
        const newConductor = {
          id: this.user.id,
          ubiEspera: this.user.ubiEspera,
          lonEspera: this.user.lonEspera,
          latEspera: this.user.latEspera,
        };
        conductoresService
          .actualizarConductor(newConductor)
          .then((result) => {
            if (!result.success) {
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
    async searchLocations() {
      try {
        if (!this.user.ubi_espera || !this.user.ciudad) return;
        const url = `https://nominatim.openstreetmap.org/search.php?street=${this.user.ubi_espera}&city=${this.user.ciudad}&countrycodes=ES&format=jsonv2`;

        const response = await fetch(url);
        const data = await response.json();

        this.locations = data;
        this.validacion.errorMessage = "";
      } catch (error) {
        console.error("Error al buscar ubicaciones:", error);
        this.validacion.errorMessage =
          "Hubo un error al buscar las ubicaciones.";
      }
    },
    selectLocation(location) {
      this.user.ubi_espera = location.display_name;

      this.locations = [];

      // limitar la cadena a 12 digitos
      this.user.latEspera =
        location.lat.length > 12 ? location.lat.slice(0, 12) : location.lat;
      this.user.lonEspera =
        location.lon.length > 12 ? location.lon.slice(0, 12) : location.lon;
      this.user.ubiEspera = location.display_name;
    },
    upval(e, propiedad = " ") {
      this.user[propiedad] = e;
    },
    loadFinished() {
      if (this.$refs.loading) {
        this.$refs.loading.closeModal();
      }
    },
  },
  watch: {
    "user.ubi_espera"(newValue, oldValue) {
      this.searchLocations();
    },
    isReady(newVal) {
      if (newVal) {
        this.loadFinished();
      }
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

.buscador {
  border: 0;
  padding: 0;
  width: 100%;
  margin: 0;
}

.desplegable {
  display: flex;
  flex-direction: column;
  gap: 1px;
  list-style: none;
  max-height: 100px;
  padding: 0;
  position: absolute;
  background-color: #d4d4d4;
  min-width: 160px;
  max-height: 200px; /* Altura máxima del desplegable */
  overflow-y: auto; /* Habilitar desplazamiento vertical */
  border: 1px solid #ccc;
  z-index: 1;
}
.desplegable li {
  color: black;
  background: white;
  border: 0;
  border-radius: 5px;
  padding: 0.4rem;
  width: 200px;
  margin: 0.2rem 0.5rem;
}
.desplegable li:hover {
  background: #ffc000;
}
</style>
