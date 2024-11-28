<template>
  <LoadingPage ref="loading"></LoadingPage>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="row mt-4">
          <div class="col-xl-6 mb-xl-0 mb-4">
            <billing-card :card="billingcardData" v-if="user.rol == 2" />
            <master-card :card="mastercardData" v-if="user.rol == 3" />
          </div>
          <div class="col-xl-6">
            <div class="row">
              <div class="col-md-6" v-if="user.rol == 2">
                <default-info-card
                  icon="account_balance"
                  title="Salario Fijo Mensual"
                  description="Por tarifa horaria este mes"
                  :value="user.salarioFijo + '€'"
                />
              </div>
              <div class="col-md-6" v-if="user.rol == 3">
                <default-info-card
                  icon="airplane_ticket"
                  title="Viajes"
                  description="Viajes de este mes"
                  :value="user.viajesMes"
                />
              </div>
              <div class="col-md-6">
                <default-info-card
                  icon="account_balance_wallet"
                  title="Por Viajes"
                  :description="
                    user.rol === 3
                      ? 'total gastado'
                      : 'total ganado conduciendo'
                  "
                  :value="user.totalViajes + '€'"
                />
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-4">
            <payment-card v-on:edit="editarInformacion" />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <invoice-card :viajes="viajes" />
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-6">
        <chart-holder-card
          title="Viajes por dias"
          subtitle="Viajes que se han realizado cada dia del mes"
          color="secondary"
        >
          <reports-pie-chart :chart="PieChartData" />
        </chart-holder-card>
      </div>
      <div class="col-md-6">
        <chart-holder-card
          :title="
            user.rol == 3 ? 'Dinero gastado cada dia' : 'Dinero ganado cada dia'
          "
          subtitle="Este Mes"
          update="ultima semana"
          color="dark"
        >
          <reports-bar-chart :chart="barChartData" />
        </chart-holder-card>
      </div>
    </div>
  </div>
</template>

<script>
import MasterCard from "@/components/dashboard/Cards/MasterCard.vue";
import DefaultInfoCard from "@/components/dashboard/Cards/DefaultInfoCard.vue";
import PaymentCard from "./components/PaymentCard.vue";
import InvoiceCard from "./components/InvoiceCard.vue";
import BillingCard from "./components/BillingCard.vue";
import LoadingPage from "@/components/index/LoadingPage.vue";

import ChartHolderCard from "./components/ChartHolderCard.vue";
import ReportsBarChart from "@/components/dashboard/Charts/ReportsBarChart.vue";
import ReportsPieChart from "@/components/dashboard/Charts/ReportsPieChart.vue";

import profileService from "@/services/profile.service";
import pasajerosService from "@/services/pasajeros.service";
import conductoresService from "@/services/conductores.service";
import viajeService from "@/services/viaje.service";
import horarioService from "@/services/horario.service";
import showSwal from "@/mixins/showSwal";

export default {
  name: "Billing",
  components: {
    MasterCard,
    DefaultInfoCard,
    PaymentCard,
    InvoiceCard,
    BillingCard,
    ReportsBarChart,
    ReportsPieChart,
    ChartHolderCard,
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
      viajes: [],
      isReady: false,
    };
  },
  async mounted() {
    try {
      const usuario = await profileService.getProfile();

      if (usuario.rol == 2) {
        const conductor = await conductoresService.obtenerConductor(usuario);
        const sanitizedInput = conductor.iban_tarjeta.replace(/\s+/g, "");

        usuario.iban_tarjeta = sanitizedInput.match(/.{1,4}/g)?.join(" ") || "";
        usuario.licencia_taxista = conductor.licencia_taxista;
        usuario.titular_tarjeta = conductor.titular_tarjeta;
        const horario = await horarioService.getHorarioUsuario(usuario);
        // tarifa diaria por dia del mes que estemos
        usuario.salarioFijo =
          parseInt(horario.tarifa_dia) * new Date().getDate();
      }

      if (usuario.rol == 3) {
        const pasajero = await pasajerosService.obtenerPasajero(usuario);
        // Dividir en grupos de 4 caracteres y unir con espacios
        const sanitizedInput = pasajero.n_tarjeta.replace(/\s+/g, "");
        usuario.n_tarjeta = sanitizedInput.match(/.{1,4}/g)?.join(" ") || "";

        usuario.titular_tarjeta = pasajero.titular_tarjeta;
        usuario.caducidad_tarjeta = pasajero.caducidad_tarjeta;
        usuario.cvv_tarjeta = pasajero.cvv_tarjeta;
      }

      const viajes = await viajeService.getViajesUsuario(usuario);
      this.viajes = viajes.slice(0, 5);
      let totalViajes = 0;
      let viajesMes;
      viajes.forEach((viaje) => {
        totalViajes += parseFloat(viaje.precio);
      });

      usuario.viajesMes = viajes.reduce((cantidad, viaje) => {
        const fechaFin = viaje.fin.trim().split(" ")[0]; // Obtener solo la fecha (dd/mm/yyyy)
        const [dia, mes, anio] = fechaFin.split("/"); // Dividir la fecha en día, mes y año
        const fechaActual = new Date(); // Obtener la fecha actual

        const mesActual = fechaActual.getMonth(); // Mes actual (0-11)
        const anioActual = fechaActual.getFullYear(); // Año actual

        // Verificar si el viaje es del mes y año actual
        if (parseInt(mes) - 1 === mesActual && parseInt(anio) === anioActual) {
          cantidad += 1; // Incrementar la cantidad de viajes
        }
        return cantidad;
      }, 0);
      usuario.viajes = viajes;
      usuario.totalViajes = totalViajes.toFixed(2);

      this.user = usuario;
    } catch (error) {
    } 
    this.isReady = true;
  },
  watch: {
    isReady(newVal) {
      if (newVal) {
        this.loadFinished();
      }
    },
  },
  methods: {
    async editarInformacion() {
      let result = false;
      if (this.user.rol == 2) {
        const nuevosDatos = await showSwal.methods.showEditBankInfo(
          this.billingcardData
        );
        nuevosDatos.id = this.user.id;
        const response = await conductoresService.actualizarConductor(
          nuevosDatos
        );
        result = response ? response.success : false;
      }
      if (this.user.rol == 3) {
        const nuevosDatos = await showSwal.methods.showEditCreditCard(
          this.mastercardData
        );
        nuevosDatos.id = this.user.id;

        const response = await pasajerosService.actualizarPasajero(nuevosDatos);
        result = response ? response.success : false;
      }
      if (result) {
        showSwal.methods.showSwal({
          type: "success",
          message: "actualizado correctamente",
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "error",
          message: "Error al actualizar",
          width: 500,
        });
      }
    },
    loadFinished() {
      if (this.$refs.loading) {
        this.$refs.loading.closeModal();
      }
    },
  },
  computed: {
    PieChartData() {
      const labels = [];
      const data = [];
      const viajesFecha = {};
      const viajes = this.user.viajes;
      const mesActual = new Date().getMonth(); // Obtener el mes actual (0-11)
      const anioActual = new Date().getFullYear(); // Obtener el año actual

      if (viajes)
        viajes.forEach((viaje) => {
          const fechaFin = viaje.fin.trim().split(" ")[0]; // Obtener solo la fecha (dd/mm/yyyy)
          const [dia, mes, anio] = fechaFin.split("/");
          if (
            parseInt(mes) - 1 === mesActual &&
            parseInt(anio) === anioActual
          ) {
            if (viajesFecha[fechaFin]) {
              // Si la fecha ya existe, sumamos el precio al acumulado
              viajesFecha[fechaFin] += 1;
            } else {
              // Si la fecha no existe, la inicializamos con el precio actual
              viajesFecha[fechaFin] = 1;
            }
          }
        });
      for (const [fecha, totalViajes] of Object.entries(viajesFecha)) {
        labels.push(fecha);
        data.push(totalViajes);
      }
      return {
        labels,
        datasets: {
          label: "viajes",
          data,
        },
      };
    },
    barChartData() {
      const labels = [];
      const data = [];
      const preciosFecha = {};
      const viajes = this.user.viajes;
      const mesActual = new Date().getMonth(); // Obtener el mes actual (0-11)
      const anioActual = new Date().getFullYear(); // Obtener el año actual

      if (viajes)
        viajes.forEach((viaje) => {
          const fechaFin = viaje.fin.trim().split(" ")[0]; // Obtener solo la fecha (dd/mm/yyyy)
          const [dia, mes, anio] = fechaFin.split("/");
          if (
            parseInt(mes) - 1 === mesActual &&
            parseInt(anio) === anioActual
          ) {
            if (preciosFecha[fechaFin]) {
              // Si la fecha ya existe, sumamos el precio al acumulado
              preciosFecha[fechaFin] += parseFloat(viaje.precio);
            } else {
              // Si la fecha no existe, la inicializamos con el precio actual
              preciosFecha[fechaFin] = parseFloat(viaje.precio);
            }
          }
        });
      for (const [fecha, totalPrecio] of Object.entries(preciosFecha)) {
        labels.push(fecha);
        data.push(totalPrecio);
      }

      return {
        labels,
        datasets: [
          {
            label: "euros",
            data,
            backgroundColor: "#5DB461",
            borderColor: "#D7AB23",
            borderWidth: 1,
          },
        ],
      };
    },
    mastercardData() {
      return {
        number: this.user.n_tarjeta,
        holderName: this.user.titular_tarjeta,
        expiryDate: this.user.caducidad_tarjeta,
        background: "dark",
        cvv: this.user.cvv_tarjeta,
      };
    },
    billingcardData() {
      return {
        iban: this.user.iban_tarjeta,
        titular: this.user.titular_tarjeta,
        licencia: this.user.licencia_taxista,
      };
    },
  },
};
</script>
