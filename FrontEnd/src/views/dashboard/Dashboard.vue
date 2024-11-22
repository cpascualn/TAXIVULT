<template>
  <div class="py-4 container-fluid">
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
            >
              <reports-bar-chart
                :chart="{
                  labels: ['Madrid', 'Barcelona', 'Sevilla', 'Valencia'],
                  datasets: {
                    label1: 'Conductores',
                    label2: 'Pasajeros',
                    backgroundColor: ['#3e95cd', '#8e5ea2'],
                    data1: [120, 150, 90, 110],
                    data2: [200, 180, 130, 170],
                  },
                }"
              />
            </chart-holder-card>
          </div>
          <div class="col-lg-4 col-md-6 mt-4">
            <chart-holder-card
              title="Viajes por ciudad"
              subtitle="Viajes totales que se han realizado en total"
              color="secondary"
            >
              <reports-pie-chart
                id="tasks-chart"
                :chart="{
                  labels: ['Madrid', 'Barcelona', 'Ciudad Real'],
                  datasets: {
                    label: 'viajes',
                    data: [150, 200, 120],
                  },
                }"
              />
            </chart-holder-card>
          </div>
          <div class="col-lg-4 mt-4">
            <chart-holder-card
              title="Dinero por Ciudad"
              subtitle="Evolución mensual"
              color="dark"
            >
              <reports-line-chart
                :chart="{
                  labels: [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre',
                  ],
                  datasets: {
                    ciudades: [
                      {
                        nombre: 'Madrid',
                        data: [
                          50, 40, 300, 320, 500, 350, 200, 230, 500, 200, 230,
                          500,
                        ],
                      },
                      {
                        nombre: 'Barcelona',
                        data: [
                          70, 20, 200, 220, 300, 450, 500, 730, 200, 500, 730,
                          200,
                        ],
                      },
                    ],
                  },
                }"
              />
            </chart-holder-card>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <project-card
          title="Ciudades"
          :headers="['Ciudad', 'Usuarios', 'dinero Total', 'viajes']"
          :projects="[
            {
              title: 'Material XD Material XD Version',
              members: [],
              budget: '$14,000',
              progress: { percentage: 100, color: 'info' },
            },
            {
              title: 'Launch our Mobile App',
              members: [],
              budget: '$20,500',
              progress: { percentage: 100, color: 'success' },
            },
          ]"
        />
      </div>
      <div class="col-lg-4 col-md-6">
        <timeline-list
          class="h-100"
          title="Horarios"
          description="<i class='fa fa-arrow-up text-success' aria-hidden='true'></i>
        <span class='font-weight-bold'>24%</span> this month"
        >
          <timeline-item
            :icon="{
              component: 'light_mode',
              class: 'text-warning',
            }"
            title="$2400 nombre horario y dinero generado"
            date-time="22 DEC 7:20 PM"
          />
          <TimelineItem
            :icon="{
              component: 'dark_mode',
              class: 'text-dark',
            }"
            title="New order #1832412"
            date-time="21 DEC 11 PM"
          />
        </timeline-list>
      </div>
    </div>
  </div>
</template>
<script>
import ChartHolderCard from "./components/ChartHolderCard.vue";
import ReportsBarChart from "@/examples/Charts/ReportsBarChart.vue";
import ReportsLineChart from "@/examples/Charts/ReportsLineChart.vue";
import ReportsPieChart from "@/examples/Charts/ReportsPieChart.vue";
import MiniStatisticsCard from "./components/MiniStatisticsCard.vue";
import ProjectCard from "./components/ProjectCard.vue";
import TimelineList from "@/examples/Cards/TimelineList.vue";
import TimelineItem from "@/examples/Cards/TimelineItem.vue";

import userService from "@/services/user.service";
import viajeService from "@/services/viaje.service";
import vehiculosService from "@/services/vehiculos.service";

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
  },
  async mounted() {
    this.usuariosTotal = await userService.getUsuariosTotales();
    const viajeTotales = await viajeService.getTotales();
    this.dineroTotal = viajeTotales.dinero;
    this.viajesTotal = viajeTotales.viajes;
    this.VehiculosTotal = await vehiculosService.getVehiculosTotales();
  },
  data() {
    return {
      dineroTotal: 0,
      usuariosTotal: 0,
      viajesTotal: 0,
      VehiculosTotal: 0,
    };
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
  },
};
</script>
