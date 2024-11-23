<template>
  <div class="chart">
    <canvas :id="id" class="chart-canvas" :height="height"></canvas>
  </div>
</template>
<script>
import Chart from "chart.js/auto";

export default {
  name: "ReportsBarChart",
  props: {
    id: {
      type: String,
      default: "bar-chart",
    },
    height: {
      type: [Number, String],
      default: "170",
    },
    chart: {
      type: Object,
      required: true,
      labels: Array,
      datasets: {
        type: Object,
        label1: String,
        label2: String,
        data1: Array,
        data2: Array,
      },
    },
  },
  data() {
    return {
      chartInstance: null,
    };
  },
  mounted() {
    this.renderChart();
  },
  watch: {
    chart: {
      deep: true, // Observa cambios profundos en el objeto `chart`
      handler() {
        this.updateChart();
      },
    },
  },
  methods: {
    renderChart() {
      const ctx = document.getElementById(this.id).getContext("2d");

      // Asegúrate de destruir cualquier gráfico existente
      if (this.chartInstance) {
        this.chartInstance.destroy();
      }

      // Crea una nueva instancia del gráfico
      this.chartInstance = new Chart(ctx, {
        type: "bar",
        data: {
          labels: this.chart.labels,
          datasets: [
            {
              label: this.chart.datasets.label1,
              data: this.chart.datasets.data1,
              backgroundColor: "#5DB461",
              borderColor: "#D7AB23",
              borderWidth: 1,
            },
            {
              label: this.chart.datasets.label2,
              data: this.chart.datasets.data2,
              backgroundColor: "#D7AB23",
              borderColor: "#5DB461",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
                color: "rgba(255, 255, 255, .2)",
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 10,
                font: {
                  size: 14,
                  weight: 300,
                  family: "Roboto",
                  style: "normal",
                  lineHeight: 2,
                },
                color: "#fff",
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
                color: "rgba(255, 255, 255, .2)",
              },
              ticks: {
                display: true,
                color: "#f8f9fa",
                padding: 10,
                font: {
                  size: 14,
                  weight: 300,
                  family: "Roboto",
                  style: "normal",
                  lineHeight: 2,
                },
              },
            },
          },
        },
      });
    },
    updateChart() {
      // Si ya hay una instancia, destruye y vuelve a crear el gráfico
      if (this.chartInstance) {
        this.chartInstance.destroy();
      }
      this.renderChart();
    },
  },
};
</script>
