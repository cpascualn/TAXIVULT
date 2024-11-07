<template>
  <div>
    <Header></Header>
    <LoadingPage ref="loading"></LoadingPage>
    <ModalStepperViaje
      ref="modelStep"
      @step-change="gestionarModal"
      :params="stepData"
    ></ModalStepperViaje>
    <section class="trip-booking">
      <div class="trip-booking__container">
        <div class="trip-booking__content">
          <SearchTrip
            @send-datos="handleFromSearch"
            :data="entradas"
            v-if="entradas && entradas.length > 0"
          ></SearchTrip>
          <LeafMap
            @send-entrys="handleFromMap"
            @send-data="handleMapData"
          ></LeafMap>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import Header from "./components/Header.vue";
import LoadingPage from "@/components/index/LoadingPage.vue";
import SearchTrip from "@/components/index/SearchTrip.vue";
import LeafMap from "@/components/index/LeafMap.vue";
import ModalStepperViaje from "@/components/index/ModalStepperViaje.vue";
import { ref, watch } from "vue";

const entradas = ref();
const stepData = ref();
const searchParams = ref({
  date: "",
  time: "",
  startLocation: "",
  endLocation: "",
  distance: "",
  duration: "",
});
const auxSearchParams = ref({
  date: "",
  time: "",
  startLocation: "",
  endLocation: "",
  distance: "",
  duration: "",
});
const viaje = ref({
  id_conductor: "",
  id_pasajero: "",
  lati_ini: "",
  longi_ini: "",
  lati_fin: "",
  longi_fin: "",
  fecha_ini: "",
  fecha_fin: "",
  metodo_pago: "",
  distancia: "",
  duracion_min: "",
  precio_total: "",
  ciudad: "",
  lugar_salida: "",
  lugar_llegada: "",
});

const loading = ref(null);
const isReady = ref(false);
const modelStep = ref(null);

const handleFromMap = (data) => {
  entradas.value = data;
  isReady.value = true;
};

const handleMapData = (data) => {
  searchParams.value.startLocation = data.startLocation;
  searchParams.value.endLocation = data.endLocation;
  searchParams.value.distance = data.distance;
  searchParams.value.duration = data.duration;
};

const handleFromSearch = (data) => {
  searchParams.value.date = data.date;
  searchParams.value.time = data.time;

  console.log(searchParams.value);
  //si no hay parametros de busqueda no abrir el modal
  if (
    modelStep.value &&
    !Object.values(searchParams.value).some((value) => value === "")
  ) {
    // si algun  parametro de busqueda ha cambiado (se abre el modal con los nuevos datos) se reinician los datos dentro del modal
    if (
      Object.keys(searchParams.value).some(
        (key) => searchParams.value[key] !== auxSearchParams.value[key]
      )
    ) {
      auxSearchParams.value = { ...searchParams.value };
      modelStep.value.openModal(true);
      modelStep.value.params = searchParams.value;
    } else {
      modelStep.value.params = searchParams.value;
      modelStep.value.openModal();
    }
  } else {
    alert(" rellena todos los datos de la busqueda");
  }
};

const gestionarModal = (step, metodoPago = "", idConductor = "") => {
  // mostrar en un modal con steps
  // step 1 mostrar precios con detalles (nombre sitio inicio, nombre sitio final, duracion,distancia)
  // seleccionar metodo de pago (desplegable obligatorio)
  if (step == 1) {
    stepData.value = verPrecios();
  }
  //step 2 mostrar conductores
  if (step == 2) {
    // asignar el metodo de pago que viene del step 1
    viaje.value.metodo_pago = metodoPago;
    verConductores();
  }

  //step 3 mostrar toda la informacion del viaje y boton reservar
  if (step == 3) {
    viaje.value.id_conductor = idConductor;
    generarViaje();
  }

  if (step == 4) {
    reservarViaje();
  }
};

function verPrecios() {
  // llamar a la api para ver la tarifa por minuto del horario correspondiente a  la hora de inicio
  // calcular el precio del viaje multiplicando la (duracion/60) * tarifa_min del horario
  const tarifa = 1.5;
  const duracion = Math.round(searchParams.value.duration / 60);
  const precio = (duracion * tarifa).toFixed(2);
  const start = searchParams.value.startLocation.name;
  const end = searchParams.value.endLocation.name;
  const distancia = searchParams.value.distance;

  // asignar valores a viaje
  viaje.value = Object.assign(viaje.value, {
    distancia: distancia,
    duracion_min: duracion,
    precio_total: precio,
    lugar_salida: start,
    lugar_llegada: end,
  });

  return { precio, duracion, tarifa, start, end, distancia };
}

function verConductores() {
  // mostrar en un modal con steps el precio del viaje, llamar a la api para ver la tarifa por minuto del horario correspondiente a  la hora de inicio
  // calcular el precio del viaje multiplicando la (duracion/60) * tarifa_min del horario
}

function generarViaje() {
  // guardar todos los valores restantes en viaje y mandar viaje  como params viajeFinal para mostrar sus datos en el step 3 y final
}

function reservarViaje() {
  // mandar a la api el post del viaje con los datos
}

const loadFinished = () => {
  if (loading.value) {
    loading.value.closeModal();
  }
};

// Configuramos un `watch` para observar `isReady`
watch(isReady, (newVal) => {
  if (newVal) {
    loadFinished();
  }
});
</script>

<style scoped>
.trip-booking {
  background-color: var(--oscuro2, #162430);
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  padding: 80px 60px;
}

@media (max-width: 991px) {
  .trip-booking {
    max-width: 100%;
    padding: 0 20px;
  }
}

.trip-booking__container {
  width: 100%;
  max-width: 1672px;
  margin: 4px 0 8px;
}

@media (max-width: 991px) {
  .trip-booking__container {
    max-width: 100%;
  }
}

.trip-booking__content {
  display: flex;
  gap: 20px;
}

@media (max-width: 991px) {
  .trip-booking__content {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
  }
}
</style>
