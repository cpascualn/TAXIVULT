<template>
  <div>
    <div :class="modalClass">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalStepper">
              {{ titulos[step - 1] }}
            </h1>
            <button
              type="button"
              class="btn-close btn-close-white"
              @click="closeModal"
            ></button>
          </div>
          <div class="modal-body">
            <div v-if="step == 1" class="container">
              <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                  <ul class="list-unstyled">
                    <li>
                      <i class="bi bi-pin-map fs-4 text-info"></i>
                      <strong> Desde:</strong>
                      <p class="list-unstyled ms-5">
                        {{ jsonData.start }}
                      </p>
                    </li>
                    <li>
                      <i class="bi bi-pin-map-fill fs-4 text-info"></i>
                      <strong> Hasta:</strong>
                      <p class="list-unstyled ms-5">{{ jsonData.end }}</p>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row justify-content-center align-items-center mt-2">
                <div class="col-md-12">
                  <i class="bi bi-fast-forward fs-4 text-secondary"></i>
                  <strong> Distancia:</strong>
                  <p class="badge bg-secondary">
                    {{ jsonData.distancia }} metros
                  </p>
                </div>
              </div>
              <div class="row justify-content-center align-items-center mt-4">
                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <div class="text-center">
                    <i class="bi bi-receipt fs-1 text-primary"></i>
                    <p>
                      <strong> Tarifa x Minuto:</strong>
                      <span class="badge bg-primary"
                        >{{ jsonData.tarifa }}€</span
                      >
                    </p>
                  </div>
                </div>

                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <div class="text-center">
                    <i class="bi bi-cash-stack fs-1 text-success"></i>
                    <p>
                      <strong> Precio:</strong>
                      <span class="badge bg-success"
                        >{{ jsonData.precio }}€</span
                      >
                    </p>
                  </div>
                </div>

                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <div class="text-center">
                    <i class="bi bi-clock-history fs-1 text-warning"></i>
                    <p>
                      <strong> Duracion:</strong>
                      <span class="badge bg-warning"
                        >{{ jsonData.duracion }} mins</span
                      >
                    </p>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12 text-center">
                  <h4>Método de pago</h4>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-6 col-md-4">
                  <div class="form-check text-center">
                    <i class="bi bi-wallet fs-3"></i> &nbsp;
                    <label class="form-check-label" for="efectivo">
                      Efectivo
                    </label>
                    <input
                      class="form-check-input"
                      type="radio"
                      name="paymentMethod"
                      value="efectivo"
                      v-model="metodoPago"
                    />
                  </div>
                </div>
                <div class="col-6 col-md-4">
                  <div class="form-check text-center">
                    <i class="bi bi-credit-card fs-3"></i>&nbsp;
                    <label class="form-check-label" for="tarjeta">
                      Tarjeta
                    </label>
                    <input
                      class="form-check-input"
                      type="radio"
                      name="paymentMethod"
                      value="tarjeta"
                      v-model="metodoPago"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div v-if="step == 2"></div>
            <div v-if="step == 3"></div>
          </div>
          <div class="modal-footer">
            <button class="btn" @click="back" v-if="step > 1">ATRAS</button>
            <button class="btn" @click="next">
              {{ step == titulos.length ? "RESERVAR" : "CONTINUAR" }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, defineProps } from "vue";

const emit = defineEmits(["step-change"]);
const params = defineProps(["params"]); // Definir las props esperadas
const jsonData = ref(params.params);
const modalClass = ref("modal fade");
const titulos = [
  "Precio del viaje",
  "Conductores disponibles",
  "Confirmar Viaje",
];

const step = ref(1);
const metodoPago = ref("");

const openModal = () => {
  modalClass.value = "modal fade show";
  emit("step-change", step.value);
};

const closeModal = () => {
  modalClass.value = "modal fade";
};

const next = () => {
  console.log(jsonData.value);
  if (step.value < titulos.length) {
    if (step.value == 1 && metodoPago.value == "") {
      alert("selecciona un metodo de pago");
      return;
    }
    step.value++;
    emit("step-change", step.value, metodoPago.value);
  } else {
    emit("step-change", step.value + 1);
    closeModal();
    step.value = 1;
  }
};

const back = () => {
  if (step.value > 1) {
    step.value--;
  }
};

const viaje = {
  precio: "13.50",
  duracion: 9,
  tarifa: 1.5,
  start:
    "Sol, Puerta del Sol, Barrio de los Austrias, Sol, Centro, Madrid, Comunidad de Madrid, 28013, España",
  end: "Metropolitano, Calle Aravaca, Ciudad Universitaria, Moncloa-Aravaca, Madrid, Comunidad de Madrid, 28040, España",
  distancia: 4417.4,
};

defineExpose({
  openModal, // Exponer el método para que pueda ser llamado desde el padre
});
</script>

<style scoped>
.modal-content {
  background-color: #0b151c;
  color: white;
}
.btn {
  background-color: #ffc000;
  color: #0b151c;
}
.btn:hover {
  color: #0b151c;
  background-color: #ffcb2d;
  transform: scale(1.1);
  box-shadow: 0 18px 25px #162430;
}
.btn-close-white {
  filter: brightness(0) invert(1);
}

.modal {
  background: #282828de;
}
.modal-dialog {
  margin-left: 0;
  margin-right: 0;
}

.modal-content {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
  height: 80%;
}

.modal-header {
  border: none;
}

.modal-footer {
  border: none;
  justify-content: space-evenly;
}

.show {
  display: block;
}

.card {
  background-color: transparent;
}
.bg-warning {
  background-color: #ffc107a2 !important;
}
.badge {
  font-size: 1em;
}
</style>
