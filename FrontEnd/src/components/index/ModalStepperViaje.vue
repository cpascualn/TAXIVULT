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
              <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                  <i class="bi bi-fast-forward fs-4 text-secondary"></i>
                  <strong> Distancia:</strong>
                  <p class="badge bg-secondary">
                    {{ jsonData.distancia }} metros
                  </p>
                </div>
              </div>
              <div class="row justify-content-center align-items-center">
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
              <div class="row justify-content-center">
                <div class="col-12 text-center">
                  <h4>Método de pago</h4>
                </div>
                <div class="col-6 col-md-4 d-flex justify-content-center">
                  <div class="form-check">
                    &nbsp;
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
                <div class="col-6 col-md-4 d-flex justify-content-center">
                  <div class="form-check">
                    &nbsp;
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
            <div v-if="step == 2">
              <h4>Seleccion de conductor</h4>
              <div
                class="drivers__wrapper justify-content-center align-items-center"
              >
                <button
                  v-for="conductor in conductores"
                  :key="conductor.id"
                  :class="[
                    'driver-button',
                    { active: conductorSeleccionado === conductor.id },
                  ]"
                  @click="selectConductor(conductor)"
                >
                  <div class="image__div">
                    <img
                      :src="
                        conductor.imagen
                          ? conductor.imagen
                          : '/img/taxiIcon.jpg'
                      "
                      alt=""
                      class="car-image"
                    />
                  </div>
                  <div class="contenido-conductor">
                    <div class="conductor-info">
                      <span class="car-nombre">
                        {{ `${conductor.fabricante} ${conductor.modelo} ` }}
                        <span style="margin: 0px 4px">•</span>
                        <span><i class="bi bi-person-fill"></i></span
                        ><span>{{ conductor.capacidad - 1 }}</span>
                      </span>
                      <span class="car_type"
                        ><i class="bi bi-car-front-fill"></i>
                        Tipo :
                        <strong> {{ conductor.tipo }}</strong></span
                      >
                    </div>
                    <div class="conductor-info">
                      <span>
                        <i class="bi bi-taxi-front-fill"></i>

                        Conductor:
                        <span class="conductor-nombre">
                          {{ conductor.nombre }}
                        </span>
                      </span>
                      <span class="car_type">
                        <i class="bi bi-telephone-fill"></i> Telefono :
                        <strong> {{ conductor.telefono }}</strong></span
                      >
                      <span class="car_type">
                        <i class="bi bi-geo-alt-fill"></i>Desde :
                        <strong> {{ conductor.ubicacion }}</strong></span
                      >
                      <div>
                        <div
                          :class="[
                            'badge',
                            { 'bg-success': conductor.estado === 'libre' },
                            { 'bg-danger': conductor.estado === 'ocupado' },
                            {
                              'bg-secondary':
                                conductor.estado === 'fuera de servicio',
                            },
                          ]"
                        >
                          {{ conductor.estado }}
                        </div>
                      </div>
                    </div>
                  </div>
                </button>
              </div>
              <p>Seleccionado: {{ conductorSeleccionado }}</p>
            </div>
            <div v-if="step == 3">
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
              <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                  <i class="bi bi-fast-forward fs-4 text-secondary"></i>
                  <strong> Distancia:</strong>
                  <p class="badge bg-secondary">
                    {{ jsonData.distancia }} metros
                  </p>
                </div>
              </div>
              <div class="row justify-content-center align-items-center">
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
              <div class="row justify-content-center">
                <div class="col-12 text-center">
                  <h4>Método de pago</h4>
                </div>
                <div class="col-6 col-md-4 d-flex justify-content-center">
                  <div class="form-check">
                    &nbsp;
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
                <div class="col-6 col-md-4 d-flex justify-content-center">
                  <div class="form-check">
                    &nbsp;
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
import { ref, defineEmits, defineProps, watch } from "vue";

const emit = defineEmits(["step-change"]);
const props = defineProps(["params"]); // Definir las props esperadas
const jsonData = ref({});
const conductores = ref([
  {
    id: 1,
    nombre: "Paco",
    telefono: "123456789",
    estado: "libre",
    fabricante: "ford",
    modelo: "fiesta",
    capacidad: 5,
    tipo: "comun",
    ubicacion: "salamanca,madrid",
    imagen:
      "data:image/jpeg;base64,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",
  },
  {
    id: 2,
    nombre: "Paco",
    telefono: "123456789",
    estado: "libre",
    fabricante: "ford",
    modelo: "fiesta",
    capacidad: 5,
    tipo: "comun",
    ubicacion: "salamanca,madrid",
    imagen:
      "data:image/jpeg;base64,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",
  },
  {
    id: 3,
    nombre: "Paco",
    telefono: "123456789",
    estado: "libre",
    fabricante: "ford",
    modelo: "fiesta",
    capacidad: 5,
    tipo: "comun",
    ubicacion: "salamanca,madrid",
    imagen: null,
  },
]);

const modalClass = ref("modal fade");
const titulos = [
  "Precio del viaje",
  "Conductores disponibles",
  "Confirmar Viaje",
];

const step = ref(1);
const metodoPago = ref("");
const conductorSeleccionado = ref(0);

watch(
  () => props.params,
  (newParams) => {
    if (newParams) {
      jsonData.value = newParams;
    }
  },
  { immediate: true } // Ejecuta el watcher inmediatamente si `params` ya tiene valor
);

const openModal = (reset = false) => {
  if (reset) {
    jsonData.value = {};
    step.value = 1;
    metodoPago.value = "";
    conductorSeleccionado.value = 0;
  }
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
    if (step.value == 2 && conductorSeleccionado.value == 0) {
      alert("selecciona un conductor");
      return;
    }
    step.value++;
    emit(
      "step-change",
      step.value,
      metodoPago.value,
      conductorSeleccionado.value
    );
  } else {
    emit("step-change", step.value + 1);
    closeModal();
    step.value = 1;
  }
};

const selectConductor = (conductor) => {
  console.log(conductor);
  conductorSeleccionado.value = conductor.id;
};

const back = () => {
  if (step.value > 1) {
    step.value--;
  }
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

.modal-body {
  background: #0b151c;
}

.modal-footer {
  background: #0b151c;
  border: none;
  justify-content: space-evenly;
}

.show {
  display: block;
}

.container {
  height: 100%;
  display: grid;
}
.bg-warning {
  background-color: #ffc107a2 !important;
}
.badge {
  font-size: 1em;
}

.drivers__wrapper {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  max-height: 60vh;
  overflow: auto;
}

.driver-button {
  -webkit-box-align: center;
  align-items: center;
  background-color: rgb(255, 255, 255);
  cursor: pointer;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  flex-direction: row;
  list-style-type: none;
  margin-bottom: 8px;
  min-height: unset;
  position: relative;
  width: 70%;
  gap: 1rem;
  padding-right: calc(13px);
  border-color: transparent;
  border-radius: 12px;
  border-style: solid;
  border-width: 3px;
}

@media (max-width: 750px) {
  .driver-button {
    /* flex-wrap: wrap; */
    overflow: auto;
  }
}
.driver-button:first-child {
  margin-top: 7vh;
}
.driver-button.active {
  background-color: #ffc000;
  border: 0.3rem solid black;
  color: #0b151c;
}
.driver-button:hover {
  color: #0b151c;
  background-color: #ffcb2d;
  transform: scale(1.05);
  box-shadow: 0 18px 25px #162430;
}

.image__div {
  -webkit-box-align: center;
  align-items: center;
  display: flex;
  flex-shrink: 0;
  -webkit-box-pack: center;
}
.car-image {
  border: 1px solid black;
  height: 15vh;
  border-radius: 5px;
  width: 10rem;
  object-fit: contain;
}
.car-type {
  text-align: left;
  margin-top: 1rem;
  margin-bottom: 1rem;
}
.car-nombre {
  font-size: 1.7rem;
  font-weight: 700;
  text-transform: uppercase;
}
.contenido-conductor {
  -webkit-box-align: center;
  align-items: center;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  flex-direction: row;
  -webkit-box-flex: 1;
  flex-grow: 1;
  height: 100%;
  -webkit-box-pack: justify;
  justify-content: space-between;
  padding-bottom: 0.1rem;
  padding-top: 0.1rem;
}
.conductor-info {
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  flex-direction: column;
}

.conductor-nombre {
  font-size: 1.2rem;
  font-weight: 500;
}
</style>
