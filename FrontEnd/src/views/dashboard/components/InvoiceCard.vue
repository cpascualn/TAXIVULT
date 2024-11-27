<template>
  <div class="card mt-4">
    <div class="card-header pb-0 p-3">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Ultimos Viajes</h6>
        </div>
        <div class="col-6 text-end">
          <material-button
            color="primary"
            size="sm"
            variant="outline"
            @click="redirigir"
            >Ver Todos
          </material-button>
        </div>
      </div>
    </div>
    <div class="card-body p-3 mb-0">
      <ul class="list-group">
        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg" style="color: red" v-if="viajes.length == 0">No tienes viajes</li>

        <li
          class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg"
          v-for="viaje in viajes"
          :key="viaje.id"
        >
          <div class="d-flex flex-column">
            <h6 class="mb-1 text-dark font-weight-bold text-sm">
              {{ viaje.fin }}
            </h6>
            <span class="text-xs">{{ viaje.ciudad }}</span>
          </div>
          <div class="d-flex align-items-center text-sm">
            <i
              class="fa fa-credit-card text-lg me-1"
              aria-hidden="true"
              v-if="viaje.metodo_pago == 'efectivo'"
            ></i>
            <i
              class="fa fa-coins text-lg me-1"
              aria-hidden="true"
              v-if="viaje.metodo_pago == 'tarjeta'"
            ></i>
            {{ viaje.precio }}€
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";

export default {
  name: "invoice-card",
  components: {
    MaterialButton,
  },
  props: {
    viajes: Array,
  },
  methods: {
    redirigir() {
      window.location.href = "/dashboard/viajes";
    },
  },
};
</script>
