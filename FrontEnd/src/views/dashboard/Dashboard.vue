<template>
  <LoadingPage ref="loading" v-if="usrRol == 1"></LoadingPage>
  <div class="py-4 container-fluid" v-if="usrRol == 1">
    <div class="row mb-4">
      <div class="col-lg-12 position-relative z-index-2">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <mini-statistics-card
              :title="{
                text: 'Total de Dinero generado',
                value: `${dineroTotal}€`,
              }"
              :detail="detailMediaDinero"
              :icon="{
                name: 'payments',
                color: 'text-white',
                background: 'success',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
            <mini-statistics-card
              :title="{ text: 'Total Viajes', value: viajesTotal }"
              :detail="detailMediaViajes"
              :icon="{
                name: 'airplane_ticket',
                color: 'text-white',
                background: 'dark',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
            <mini-statistics-card
              :title="{ text: 'Total de Usuarios', value: usuariosTotal }"
              :detail="detailMediaUsuarios"
              :icon="{
                name: 'person_add',
                color: 'text-white',
                background: 'primary',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mt-lg-0 mt-4">
            <mini-statistics-card
              :title="{ text: 'Total de Vehiculos', value: VehiculosTotal }"
              :detail="detailMediaVehiculos"
              :icon="{
                name: 'commute',
                color: 'text-white',
                background: 'info',
              }"
            />
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-4 col-md-6 mt-4">
            <chart-holder-card
              title="Usuarios por ciudad"
              subtitle="Pasajeros y Conductores"
              update="campaign sent 2 days ago"
              color="dark"
            >
              <reports-bar-chart :chart="barChartData" />
            </chart-holder-card>
          </div>
          <div class="col-lg-4 col-md-6 mt-4">
            <chart-holder-card
              title="Viajes por ciudad"
              subtitle="Viajes totales que se han realizado en total"
              color="secondary"
            >
              <reports-pie-chart id="tasks-chart" :chart="PieChartData" />
            </chart-holder-card>
          </div>
          <div class="col-lg-4 mt-4">
            <chart-holder-card
              title="Dinero por Ciudad"
              subtitle="Evolución mensual"
              color="dark"
            >
              <reports-line-chart :chart="lineChartData" />
            </chart-holder-card>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <project-card
          title="Ciudades"
          :headers="['Ciudad', 'Dinero Total', 'viajes', 'Usuarios']"
          :projects="ciudades"
        />
      </div>
      <div class="col-lg-4 col-md-6">
        <timeline-list
          class="h-100"
          title="Horarios"
          description="Conductores y beneficios"
        >
          <timeline-item
            :icon="{
              component: 'light_mode',
              class: 'text-warning',
            }"
            title="Diurno"
            date-time="DE 08:00 A 19:59 (con descansos)"
          />
          <TimelineItem
            :icon="{
              component: 'dark_mode',
              class: 'text-dark',
            }"
            title="Nocturno"
            date-time="DE 20:00 A 7:59 (con descansos)"
          />
        </timeline-list>
      </div>
    </div>
  </div>
  <div class="py-4 container-fluid" v-if="usrRol != 1">
    <div class="modal-body">
      <div style="color: #c00000">Acceso Denegado</div>
    </div>
  </div>
</template>
<script>
import ChartHolderCard from "./components/ChartHolderCard.vue";
import ReportsBarChart from "@/components/dashboard/Charts/ReportsBarChart.vue";
import ReportsLineChart from "@/components/dashboard/Charts/ReportsLineChart.vue";
import ReportsPieChart from "@/components/dashboard/Charts/ReportsPieChart.vue";
import MiniStatisticsCard from "./components/MiniStatisticsCard.vue";
import ProjectCard from "./components/ProjectCard.vue";
import TimelineList from "@/components/dashboard/Cards/TimelineList.vue";
import TimelineItem from "@/components/dashboard/Cards/TimelineItem.vue";
import LoadingPage from "@/components/index/LoadingPage.vue";

import userService from "@/services/user.service";
import viajeService from "@/services/viaje.service";
import vehiculosService from "@/services/vehiculos.service";
import ciudadService from "@/services/ciudad.service";
import profileService from "@/services/profile.service";

export default {
  name: "dashboard-default",
  components: {
    ChartHolderCard,
    ReportsBarChart,
    ReportsLineChart,
    MiniStatisticsCard,
    ProjectCard,
    TimelineList,
    TimelineItem,
    ReportsPieChart,
    LoadingPage,
  },
  async mounted() {
    this.usrRol = await profileService.getRol();
    if (this.usrRol != 1) return;

    this.usuariosTotal = await userService.getUsuariosTotales();

    const viajeTotales = await viajeService.getTotales();
    this.dineroTotal = viajeTotales.dinero;
    this.viajesTotal = viajeTotales.viajes;

    this.VehiculosTotal = await vehiculosService.getVehiculosTotales();

    const ciusers = await ciudadService.getUsuariosPorCiudad();
    this.usuarioCiudad = ciusers.reduce(
      (acumulador, item) => {
        acumulador.ciudades.push(item.ciudad);
        acumulador.conductores.push(item.conductores);
        acumulador.pasajeros.push(item.pasajeros);
        return acumulador;
      },
      { ciudades: [], conductores: [], pasajeros: [] }
    );

    const viajesCiu = await viajeService.getTotalesCiudad();
    this.ciudades = viajesCiu;
    this.viajesCiudad = viajesCiu.reduce(
      (acumulador, item) => {
        acumulador.ciudades.push(item.ciudad);
        acumulador.viajes.push(item.viajes);
        return acumulador;
      },
      { ciudades: [], viajes: [] }
    );
    this.ciudadesMeses = await viajeService.getTotalesCiudadMes();

    this.isReady = true;
  },
  data() {
    return {
      dineroTotal: 0,
      usuariosTotal: 0,
      viajesTotal: 0,
      VehiculosTotal: 0,
      usuarioCiudad: { ciudades: [], conductores: [], pasajeros: [] },
      viajesCiudad: { ciudades: [], viajes: [] },
      ciudades: {},
      ciudadesMeses: [],
      usrRol: 0,
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
  computed: {
    detailMediaDinero() {
      return `<span class='text-success text-sm font-weight-bolder'>${(
        this.dineroTotal / 12
      ).toFixed(2)}€</span> de media al mes`;
    },
    detailMediaUsuarios() {
      return `<span class='text-success text-sm font-weight-bolder'>${(
        this.usuariosTotal / 12
      ).toFixed(1)}</span> de media al mes`;
    },
    detailMediaViajes() {
      return `<span class='text-success text-sm font-weight-bolder'>${(
        this.viajesTotal / 12
      ).toFixed(2)}</span> de media al mes`;
    },
    detailMediaVehiculos() {
      return `<span class='text-success text-sm font-weight-bolder'>${(
        this.VehiculosTotal / 12
      ).toFixed(2)}</span> de media al mes`;
    },
    barChartData() {
      return {
        labels: this.usuarioCiudad.ciudades,
        datasets: [
          {
            label: "Conductores",
            data: this.usuarioCiudad.conductores,
            backgroundColor: "#5DB461",
            borderColor: "#D7AB23",
            borderWidth: 1,
          },
          {
            label: "Pasajeros",
            data: this.usuarioCiudad.pasajeros,
            backgroundColor: "#D7AB23",
            borderColor: "#5DB461",
            borderWidth: 1,
          },
        ],
      };
    },
    PieChartData() {
      return {
        labels: this.viajesCiudad.ciudades,
        datasets: {
          label: "viajes",
          data: this.viajesCiudad.viajes,
        },
      };
    },
    lineChartData() {
      const meses = [...new Set(this.ciudadesMeses.map((item) => item.mes))];

      // Agrupar los datos por ciudad
      const ciudadesData = this.ciudadesMeses.reduce((acc, item) => {
        const mesIndex = meses.indexOf(item.mes); // Encontrar el índice del mes
        const ciudadIndex = acc.findIndex((c) => c.nombre === item.ciudad);

        if (ciudadIndex === -1) {
          // Si la ciudad no está en el array de ciudades, agregarla
          acc.push({
            nombre: item.ciudad,
            data: Array(meses.length).fill(0), // Crear un array de la longitud de meses con 0
          });
        }

        // Asignar el valor de 'dinero' en el índice correspondiente
        acc[ciudadIndex === -1 ? acc.length - 1 : ciudadIndex].data[mesIndex] =
          parseFloat(item.dinero);

        return acc;
      }, []);

      return {
        labels: meses,
        datasets: {
          ciudades: ciudadesData,
        },
      };
    },
  },
  methods: {
    loadFinished() {
      if (this.$refs.loading) {
        this.$refs.loading.closeModal();
      }
    },
  },
};
</script>

<style scoped>
.modal-content {
  background-color: #0b151c;
  color: white;
  border: none;
}

.modal-body {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.btn {
  background-color: #ffc000;
  color: #0b151c;
}

.show {
  display: block;
  background-color: #0b151c;
}
</style>
