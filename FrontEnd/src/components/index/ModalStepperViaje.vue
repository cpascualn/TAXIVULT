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
                        {{ jsonData.desde }}
                      </p>
                    </li>
                    <li>
                      <i class="bi bi-pin-map-fill fs-4 text-info"></i>
                      <strong> Hasta:</strong>
                      <p class="list-unstyled ms-5">{{ jsonData.hasta }}</p>
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
                <div class="col-sm-12  col-md-4 d-flex justify-content-center">
                  &nbsp;
                  <button
                    :class="[
                      'driver-button',
                      { active: metodoPago === 'efectivo' },
                    ]"
                    @click="selectPayment('efectivo')"
                  >
                    <i class="bi bi-wallet fs-3"></i> &nbsp;
                    <label class="form-check-label" for="efectivo">
                      Efectivo
                    </label>
                  </button>
                </div>
                <div class="col-sm-12 col-md-4 d-flex justify-content-center">
                  <button
                    :class="[
                      'driver-button',
                      { active: metodoPago === 'tarjeta' },
                    ]"
                    @click="selectPayment('tarjeta')"
                  >
                    <i class="bi bi-credit-card fs-3"></i>&nbsp;
                    <label class="form-check-label" for="tarjeta">
                      Tarjeta
                    </label>
                  </button>
                </div>
              </div>
            </div>
            <div v-if="step == 2">
              <h4>Seleccion de conductor</h4>
              <div
                class="drivers__wrapper justify-content-center align-items-center"
              >
                <div v-if="!jsonData.conductores" style="color: red">
                  NO SE HAN ENCONTRADO CONDUCTORES DISPONIBLES
                </div>
                <button
                  v-if="jsonData.conductores"
                  v-for="conductor in jsonData.conductores"
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
                        <strong> {{ conductor.ubi_espera }}</strong></span
                      >
                      <div>
                        Ahora mismo esta:
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
            </div>
            <div v-if="step == 3">
              <div class="row justify-content-center align-items-center mb-3">
                <div
                  class="col-sm-12 col-lg-6 col-md-4 d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-person-vcard fs-2"></i>
                  <strong> Conductor:</strong>&nbsp;
                  {{ selecConductor.nombre }}
                </div>
                <div
                  class="col-sm-12 col-lg-6 col-md-4 d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-person-square fs-2"></i>
                  <strong> Pasajero:</strong>&nbsp;
                  {{ jsonData.pasajero }}
                </div>
              </div>
              <div class="row justify-content-center align-items-center mb-5">
                <div class="col-md-9">
                  <ul class="list-unstyled">
                    <li>
                      <i class="bi bi-pin-map fs-4 text-info"></i>
                      <strong> Desde:</strong>
                      <p class="list-unstyled ms-5">
                        {{ jsonData.desde }}
                      </p>
                    </li>
                    <li>
                      <i class="bi bi-pin-map-fill fs-4 text-info"></i>
                      <strong> Hasta:</strong>
                      <p class="list-unstyled ms-5">{{ jsonData.hasta }}</p>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="row justify-content-center align-items-center mb-5">
                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-fast-forward fs-4 text-secondary"></i>
                  <strong> Distancia:</strong>
                  <span class="badge bg-secondary">
                    {{ jsonData.distancia }} metros
                  </span>
                </div>
                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <strong>
                    <i class="bi bi-stopwatch fs-4"></i> Hora de salida:</strong
                  >
                  <span class="badge bg-secondary">
                    {{ jsonData.fecha_ini }}
                  </span>
                </div>
                <div
                  class="col-md-4 d-flex justify-content-center align-items-center"
                >
                  <strong
                    ><i class="bi bi-stopwatch-fill fs-4"></i> Hora de
                    llegada:</strong
                  >
                  <span class="badge bg-secondary">
                    {{ jsonData.fecha_fin }}
                  </span>
                </div>
              </div>
              <div class="row justify-content-center align-items-center mb-3">
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
                    <i
                      v-if="metodoPago == 'tarjeta'"
                      class="bi bi-credit-card fs-1 text-info"
                    ></i>
                    <i
                      v-if="metodoPago == 'efectivo'"
                      class="bi bi-cash-coin fs-1 text-info"
                    ></i>
                    <p>
                      <strong> Metodo Pago:</strong>
                      <span class="badge bg-info"> {{ metodoPago }}</span>
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
              </div>
            </div>
            <div v-if="step == 4">
              <h1>VIAJE RESERVADO CON EXITO!!!</h1>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn" @click="back" v-if="step > 1">ATRAS</button>
            <button :class="['btn', nextButtonClass]" @click="next">
              {{ step == titulos.length - 1 ? "RESERVAR" : "CONTINUAR" }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, defineProps, watch } from "vue";
import showSwal from "@/mixins/showSwal";

const emit = defineEmits(["step-change"]);
const props = defineProps(["params"]); // Definir las props esperadas
const jsonData = ref({});
const selecConductor = ref({ nombre: "" });

const modalClass = ref("modal fade ");
const nextButtonClass = ref("btn-noAllowed");
const titulos = [
  "Precio del viaje",
  "Conductores disponibles",
  "Confirmar Viaje",
  "Viaje Reservado",
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
  if (step.value < titulos.length) {
    if (step.value == 1 && metodoPago.value == "") {
      showSwal.methods.showSwal({
        type: "error",
        message: "selecciona un metodo de pago",
        width: 500,
      });
      return;
    }
    if (step.value == 2 && conductorSeleccionado.value == 0) {
      showSwal.methods.showSwal({
        type: "error",
        message: "selecciona un conductor",
        width: 500,
      });
      return;
    }
    step.value++;
    if (step.value == 2 && conductorSeleccionado.value == 0)
      nextButtonClass.value = "btn-noAllowed";
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

const selectPayment = (metodo) => {
  metodoPago.value = metodo;
  nextButtonClass.value = "";
};

const selectConductor = (conductor) => {
  conductorSeleccionado.value = conductor.id;
  selecConductor.value.nombre = conductor.nombre;
  nextButtonClass.value = "";
};

const back = () => {
  if (step.value > 1) {
    step.value--;
  }
  if (nextButtonClass.value != "") {
    nextButtonClass.value = "";
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
.btn-noAllowed {
  background-color: gray;
  color: #0b151c;
}
.btn-noAllowed:hover {
  color: #0b151c;
  transform: scale(1.1);
  background-color: rgb(61, 61, 61);
  box-shadow: 0 18px 25px #162430;
  cursor: not-allowed;
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
  overflow: auto;
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
.bg-info {
  background-color: #0dcaf0ad !important;
}
.badge {
  font-size: 1em;
}

.drivers__wrapper {
  display: flex;
  flex-wrap: wrap;
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

@media (max-width: 768px) {
  .contenido-conductor{
    display: contents  !important;
  }
  .driver-button {
    flex-direction: column;
    overflow: auto;
  }

  .car_type{
    display: none !important;
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
  height: 12vh;
  border-radius: 5px;
  width: 10rem;
  object-fit: contain;
}
.car_type {
  max-width: 30rem;
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
