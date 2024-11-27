<template>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="row mt-4">
          <div class="col-xl-6 mb-xl-0 mb-4">
            <master-card :card="mastercardData" v-if="user.rol == 3" />
            <billing-card v-if="user.rol == 2" />
          </div>
          <div class="col-xl-6">
            <div class="row">
              <div class="col-md-6">
                <default-info-card
                  icon="account_balance"
                  title="Salary"
                  description="Belong Interactive"
                  value="+$2000"
                />
              </div>
              <div class="col-md-6">
                <default-info-card
                  icon="account_balance_wallet"
                  title="Paypal"
                  description="Freelance Payment"
                  value="$455.00"
                />
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-4">
            <payment-card />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <invoice-card />
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-6">
        <chart-holder-card
          title="Viajes por dias"
          subtitle="Viajes que se han realizado cada dia"
          color="secondary"
        >
          <reports-pie-chart id="tasks-chart" :chart="PieChartData" />
        </chart-holder-card>
      </div>
      <div class="col-md-6">
        <chart-holder-card
          title="Dinero ganado cada dia"
          subtitle="diario"
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

import ChartHolderCard from "./components/ChartHolderCard.vue";
import ReportsBarChart from "@/components/dashboard/Charts/ReportsBarChart.vue";
import ReportsPieChart from "@/components/dashboard/Charts/ReportsPieChart.vue";

import profileService from "@/services/profile.service";
import pasajerosService from "@/services/pasajeros.service";
import conductoresService from "@/services/conductores.service";
import viajeService from "@/services/viaje.service";

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
  computed: {
    PieChartData() {
      return {
        labels: ["ayer", "hoy", "mañana"],
        datasets: {
          label: "viajes",
          data: [20, 10, 30],
        },
      };
    },
    barChartData() {
      return {
        labels: ["ayer", "hoy", "mañana"],
        datasets: [
          {
            label: "dineros",
            data: [10, 20, 15],
            backgroundColor: "#5DB461",
            borderColor: "#D7AB23",
            borderWidth: 1,
          },
        ],
      };
    },
    mastercardData() {
      return {
        number: "4562   1122   4594   7852",
        holderName: "Jackasd Peterson",
        expiryDate: "11/22",
        background: "dark",
        cvv: "123",
      };
    },
  },
  async mounted() {
    this.loading = true;
    try {
      const usuario = await profileService.getProfile();

      if (usuario.rol == 2) {
        const conductor = await conductoresService.obtenerConductor(usuario);
        console.log(conductor);
    //     licencia_taxista: '33334123W',
    // titular_tarjeta: 'jhondoe',
    // iban_tarjeta: 'ES33 12341234123412341234',
        usuario.ubi_espera = conductor.ubi_espera;
      }

      if (usuario.rol == 3) {
        const pasajero = await pasajerosService.obtenerPasajero(usuario);
        console.log(pasajero);

        usuario.cvv = pasajero.cvv;
      }
      this.user = usuario;
      console.log(this.user);
    } catch (error) {
    } finally {
      this.loading = false;
    }
    this.isReady = true;
  },
};
</script>
