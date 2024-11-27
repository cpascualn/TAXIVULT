<template>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="row mt-4">
          <div class="col-xl-6 mb-xl-0 mb-4">
            <master-card />
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
    <div class="row">
      <div class="col-md-2">
        <billing-card />
      </div>
      <div class="col-md-5">
        <chart-holder-card
          title="Viajes por dias"
          subtitle="Viajes que se han realizado cada dia"
          color="secondary"
        >
          <reports-pie-chart id="tasks-chart" :chart="PieChartData" />
        </chart-holder-card>
      </div>
      <div class="col-md-5">
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
      datasets: {
        label1: "dineros",

        data1: [10,20,15],

      },
    };
  },
  },

};
</script>
