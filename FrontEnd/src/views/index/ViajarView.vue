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
import showSwal from "@/mixins/showSwal";
import ModalStepperViaje from "@/components/index/ModalStepperViaje.vue";
import { ref, watch } from "vue";
import { jwtDecode } from "jwt-decode";
import horarioService from "@/services/horario.service";
import ciudadService from "@/services/ciudad.service";
import conductoresService from "@/services/conductores.service";
import viajeService from "@/services/viaje.service";
import profileService from "@/services/profile.service";

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
    showSwal.methods.showSwal({
      type: "error",
      message: "rellena todos los datos de la busqueda",
      width: 1000,
    });
  }
};

const gestionarModal = async (step, metodoPago = "", idConductor = "") => {
  // mostrar en un modal con steps
  // step 1 mostrar precios con detalles (nombre sitio inicio, nombre sitio final, duracion,distancia)
  // seleccionar metodo de pago (desplegable obligatorio)
  if (step == 1) {
    stepData.value = await verPrecios();
  }
  //step 2 mostrar conductores
  if (step == 2) {
    // asignar el metodo de pago que viene del step 1
    viaje.value.metodo_pago = metodoPago;
    // si ya tiene conductores (de una llamada anterior) no lo vuelves a llamar
    if (!stepData.value.conductores) {
      const conductores = await verConductores();
      stepData.value = {
        ...stepData.value,
        conductores: conductores,
      };
    }
  }

  //step 3 mostrar toda la informacion del viaje y boton reservar
  if (step == 3) {
    viaje.value.id_conductor = idConductor;
    const datosFinales = generarViaje();
    stepData.value = {
      ...stepData.value,
      ...datosFinales,
    };
  }

  if (step == 4) {
    reservarViaje();
  }
};

async function verPrecios() {
  // llamar a la api para ver la tarifa por minuto del horario correspondiente a  la hora de inicio
  // calcular el precio del viaje multiplicando la (duracion/60) * tarifa_min del horario

  const horario = await horarioService.getHorario({
    horario: searchParams.value.time,
  });

  const tarifa = horario.horario.tarifa_minuto;
  const duracion = Math.round(searchParams.value.duration / 60);
  const precio = (duracion * tarifa).toFixed(2);
  const desde = searchParams.value.startLocation.name;
  const hasta = searchParams.value.endLocation.name;
  const distancia = searchParams.value.distance;

  // asignar valores a viaje
  viaje.value = Object.assign(viaje.value, {
    distancia: distancia,
    duracion_min: duracion,
    precio_total: precio,
    lugar_salida: desde,
    lugar_llegada: hasta,
  });

  return { precio, duracion, tarifa, desde, hasta, distancia };
}

async function verConductores() {
  const fecha_ini = new Date(
    `${searchParams.value.date}T${searchParams.value.time}:00`
  );
  const fecha_fin = new Date(
    fecha_ini.getTime() + viaje.value.duracion_min * 60000
  );

  const ciudad = await ciudadService.getCiudadUsuario();

  viaje.value = Object.assign(viaje.value, {
    fecha_ini: fecha_ini.getTime(),
    fecha_fin: fecha_fin.getTime(),
    ciudad: ciudad.id,
  });
  const conductores = await conductoresService.getConductoresDisponiblesCiudad(
    viaje.value.fecha_ini,
    viaje.value.fecha_fin,
    ciudad.id
  );

  if (!conductores) return null;
  if (!conductores.conductores) return null;
  if (conductores.conductores.length === 0) return null;
  return conductores.conductores;
}

function generarViaje() {
  // guardar todos los valores restantes en viaje y mandar viaje  como params viajeFinal para mostrar sus datos en el step 3 y final
  // asignar valores a viaje
  const TOKEN = JSON.parse(localStorage.getItem("authToken"));
  const decoded = jwtDecode(TOKEN);
  const pasajero = decoded.data.email;
  const startLoc = searchParams.value.startLocation;
  const endLoc = searchParams.value.endLocation;
  viaje.value = Object.assign(viaje.value, {
    id_pasajero: decoded.data.userId,
    lati_ini: startLoc.latLng.lat,
    longi_ini: startLoc.latLng.lng,
    lati_fin: endLoc.latLng.lat,
    longi_fin: endLoc.latLng.lng,
  });
  const fecha_ini = new Date(viaje.value.fecha_ini);
  const fecha_fin = new Date(viaje.value.fecha_fin);
  const fechaIniString = ` ${fecha_ini.toTimeString().split(" ")[0]}`;
  const fechaFinString = `${fecha_fin.toTimeString().split(" ")[0]}`;

  return { pasajero, fecha_ini: fechaIniString, fecha_fin: fechaFinString };
}

async function reservarViaje() {
  const viajesActivos = await profileService.verViajes();

  if (viajesActivos && viajesActivos.activos > 0) {
    showSwal.methods.showSwal({
      type: "error",
      message: "Ya tienes un viaje programado",
      width: 1000,
    });
    return;
  }

  // mandar a la api el post del viaje con los datos
  const respuesta = await viajeService.InsertarViaje(viaje.value);
  if (respuesta && respuesta.success) {
    showSwal.methods.showSwal({
      type: "success",
      message: respuesta.message + " ,Redirigiendo a viajes",
      width: 1000,
    });
    setTimeout(() => {
      window.location.href = "/dashboard/viajes";
    }, 5500);
    // redireccionar a la pagina de viajes
  } else {
    showSwal.methods.showSwal({
      type: "danger",
      message: "no se pudo reservar el viaje,intentalo de nuevo",
      width: 1000,
    });
  }
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
