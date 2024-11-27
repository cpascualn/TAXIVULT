<template>
  <LoadingPage ref="loading"></LoadingPage>
  <div class="container-fluid">
    <div
      class="page-header min-height-300 border-radius-xl mt-4"
      style="
        background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
      "
    >
      <span class="mask bg-gradient-primary opacity-8"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img
              :src="profileImgs[profile.rol]"
              alt="profile_image"
              class="shadow-sm w-100 border-radius-lg"
            />
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1" style="text-transform: capitalize">
              {{ profile.nombre }}
            </h5>
            <p class="mb-0 font-weight-normal text-sm">
              {{ roles[profile.rol] }}
            </p>
            <span
              :class="[
                'badge',
                'badge-sm',
                `bg-gradient-${colores[profile.estado]}`,
              ]"
              v-if="profile.rol == 2"
              >{{ profile.estado }}</span
            >
          </div>
        </div>
        <div
          class="mx-auto mt-3 col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0"
        ></div>
      </div>
      <div class="row">
        <div class="mt-3 row">
          <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
            <profile-info-card title="Sobre mi" :info="infoUser" />
            <hr class="vertical dark" />
          </div>
          <div class="mt-4 col-12 col-xl-4 mt-xl-0" v-if="profile.rol == 2">
            <div class="card card-plain h-100 list__users">
              <div class="p-3 pb-0 card-header">
                <h6 class="mb-0">Pasajeros Recientes</h6>
              </div>
              <div class="p-3 card-body">
                <ul class="list-group">
                  <li
                    class="px-0 mb-2 border-0 list-group-item d-flex align-items-center"
                    v-for="viaje in viajes"
                    :key="viaje.pasajero"
                  >
                    <material-avatar
                      class="me-3"
                      :img="usrImg"
                      alt="kal"
                      border-radius="lg"
                      shadow="regular"
                    />
                    <div
                      class="d-flex align-items-start flex-column justify-content-center"
                    >
                      <h6 class="mb-0 text-sm">{{ viaje.pasajero }}</h6>
                      <p class="mb-0 text-xs">{{ viaje.fin }}</p>
                    </div>
                    <span class="mb-0 btn btn-link pe-3 ps-0 ms-auto"
                      >{{ viaje.precio }}€</span
                    >
                  </li>
                </ul>
                <p v-if="viajes.length == 0" style="color: red !important">
                  No hay pasajeros recientes
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProfileInfoCard from "./components/ProfileInfoCard.vue";
import DefaultProjectCard from "./components/DefaultProjectCard.vue";
import MaterialAvatar from "@/components/dashboard/MaterialAvatar.vue";
import usrImg from "@/assets/img/usrImg.jpg";
import LoadingPage from "@/components/index/LoadingPage.vue";

import driverImg from "@/assets/img/driverImg.jpg";
import adminImg from "@/assets/img/adminImg.jpg";
import passengerImg from "@/assets/img/passengerImg.jpg";

import profileService from "@/services/profile.service";
import ciudadService from "@/services/ciudad.service";
import conductoresService from "@/services/conductores.service";
import viajeService from "@/services/viaje.service";

import setNavPills from "@/assets/js/nav-pills.js";
import setTooltip from "@/assets/js/tooltip.js";

export default {
  name: "profile-overview",
  components: {
    ProfileInfoCard,
    DefaultProjectCard,
    MaterialAvatar,
    LoadingPage,
  },
  data() {
    return {
      showMenu: false,
      usrImg,
      profile: {},
      roles: {
        1: "Administrador",
        2: "Conductor",
        3: "Pasajero",
      },
      profileImgs: {
        1: adminImg,
        2: driverImg,
        3: passengerImg,
      },
      viajes: [],
      colores: {
        libre: "success",
        "fuera de servicio": "secondary",
        ocupado: "danger",
      },
      isReady: false,
    };
  },
  watch: {
    isReady(newVal) {
      if (newVal) {
        this.loadFinished();
      }
    },
  },
  methods: {
    loadFinished() {
      if (this.$refs.loading) {
        this.$refs.loading.closeModal();
      }
    },
  },
  computed: {
    infoUser() {
      let info = {};
      if (this.profile.rol == 2) {
        info = {
          fullName: this.profile.nombre + " " + this.profile.apellidos,
          mobile: this.profile.telefono,
          email: this.profile.email,
          location: this.profile.ciudad,
          desde: this.profile.fecha_creacion,
          horario: this.profile.horario,
          ubi_espera: this.profile.ubi_espera,
        };
      } else {
        info = {
          fullName: this.profile.nombre + " " + this.profile.apellidos,
          mobile: this.profile.telefono,
          email: this.profile.email,
          location: this.profile.ciudad,
          desde: this.profile.fecha_creacion,
        };
      }
      return info;
    },
  },

  async mounted() {
    this.$store.state.isAbsolute = true;
    setNavPills();
    setTooltip();
    const ciudad = await ciudadService.getCiudadUsuario();
    this.profile = await profileService.getProfile();
    const date = new Date(this.profile.fecha_creacion);
    this.profile.fecha_creacion = new Intl.DateTimeFormat("es-ES").format(date);
    this.profile.ciudad = ciudad ? ciudad.nombre : "";
    if (this.profile.rol == 2) {
      const conductor = await conductoresService.obtenerConductor(this.profile);
      this.profile.horario = conductor.horario;
      this.profile.ubi_espera = conductor.ubi_espera;
      this.profile.estado = conductor.estado;
      this.viajes = await viajeService.getViajesUsuario(conductor);
      this.viajes= this.viajes.slice(0,5);
    }
    this.isReady = true;
  },
  beforeUnmount() {
    this.$store.state.isAbsolute = false;
  },
};
</script>

<style scoped>
.list__users {
  max-height: 60vh;
  overflow: auto;
}
</style>
