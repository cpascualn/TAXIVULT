<template>
  <div class="chart">
    <canvas :id="id" class="chart-canvas" :height="height"></canvas>
  </div>
</template>
<script>
import Chart from "chart.js/auto";

export default {
  name: "ReportsPieChart",
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
        label: String,
        data: Array,
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
        type: "pie",
        data: {
          labels: this.chart.labels,
          datasets: [
            {
              label: this.chart.datasets.label,
              data: this.chart.datasets.data,
              backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4BC0C0",
                "#9966FF",
              ],
              hoverOffset: 4,
              fill: true,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: "top",
              labels: { color: "white" },
            },
            tooltip: {
              callbacks: {
                label: function (tooltipItem) {
                  return `${tooltipItem.label}: ${tooltipItem.raw} viajes`;
                },
              },
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
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
