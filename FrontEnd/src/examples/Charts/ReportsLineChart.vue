<template>
  <div class="chart">
    <canvas :id="id" class="chart-canvas" :height="height"></canvas>
  </div>
</template>
<script>
import Chart from "chart.js/auto";

export default {
  name: "ReportsLineChart",
  props: {
    id: {
      type: String,
      default: "line-chart",
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
        ciudades: [Array],
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
      var ctx = document.getElementById(this.id).getContext("2d");

      let chartStatus = Chart.getChart(this.id);
      if (chartStatus != undefined) {
        chartStatus.destroy();
      }

      new Chart(ctx, {
        type: "line",
        data: {
          labels: this.chart.labels,
          datasets: this.chart.datasets.ciudades.map((ciudad) => ({
            label: ciudad.nombre,
            data: ciudad.data,
            backgroundColor: getRandomColor(),
            borderColor: getRandomColor(true),
            borderWidth: 1,
            tension: 0.2,
          })),
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: top,
              labels: { color: "white" },
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
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5],
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

function getRandomColor(isBorder = false) {
  const opacity = isBorder ? 1 : 0.6;
  const r = Math.floor(Math.random() * 255);
  const g = Math.floor(Math.random() * 255);
  const b = Math.floor(Math.random() * 255);
  return `rgba(${r}, ${g}, ${b}, ${opacity})`;
}
</script>
