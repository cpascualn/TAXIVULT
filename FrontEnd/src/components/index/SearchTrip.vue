<template>
  <form class="trip-booking__form" @submit="handleSubmit">
    <div class="trip-booking__form-container">
      <h2 class="trip-booking__title">Consigue un viaje</h2>
      <div class="trip-booking__inputs">
        <div class="trip-booking__input-group" id="start">
          <img
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/fcafba4e0cf3c74e2c7474823eb15a538cfd1653ff2bbf1f023eedf28fd4d5b7?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
            alt="Pickup location icon"
            class="trip-booking__icon"
          />
          <!-- <input
            type="text"
            class="trip-booking__input-label"
            placeholder=" aUbicación de recogida"
          /> -->
        </div>
        <div class="trip-booking__input-group" id="end">
          <img
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/1556693e9937325d0df6c1ed8d094db6e780f90308f699ba09080b0679612811?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
            alt="Destination location icon"
            class="trip-booking__icon trip-booking__icon--destination"
          />
        </div>
        <button
          class="trip-booking__input-group trip-booking__input-group--datetime"
          type="button"
          @click="openDatetimeSelection"
        >
          <div class="trip-booking__datetime">
            <img
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/afe5a4162f9c7ce570476fa73e405da096d14194273672bc75493620662219d9?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Clock icon"
              class="trip-booking__icon"
            />
            <p>¿Cuando?</p>
          </div>

          <img
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/d0b219658ea78712624c17e2878d82d65be05f6c6dc9275f9736d106b1708a3a?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
            alt="Right arrow icon"
            class="trip-booking__arrow-icon"
          />
        </button>
        <div
          :class="[
            'datetimeSel',
            mostrarCuando ? 'activeCuando' : 'inactiveCuando',
          ]"
        >
          <h2>Seleccione la fecha de recogida</h2>
          <div class="datetimeWrapper">
            <div class="trip-booking__dates-group">
              <label for="dateInput">seleccione una fecha:</label>
              <input
                type="date"
                id="dateInput"
                v-model="date"
                :min="minDate"
                :max="maxDate"
              />
            </div>
            <div class="trip-booking__dates-group">
              <label for="timeInput">seleccione una hora:</label>
              <input type="time" id="timeInput" v-model="time" :min="minTime" />
            </div>
          </div>
        </div>
      </div>
      <button class="trip-booking__search-button">Buscar</button>
    </div>
  </form>
</template>

<script setup>
import horarioService from "@/services/horario.service";
import { jwtDecode } from "jwt-decode";
import { ref, defineProps, onMounted, computed, defineEmits } from "vue";
import { useRouter } from "vue-router";

// Definir los eventos que puede emitir este componente
const emits = defineEmits(["send-datos"]);
const props = defineProps(["data"]); // Definir las props esperadas
const entradas = ref(props.data);
const mostrarCuando = ref(false);
let start, end;

const date = ref("");
const time = ref("");
const token = localStorage.getItem("authToken");
const router = useRouter();

const openDatetimeSelection = () => {
  mostrarCuando.value = !mostrarCuando.value;
};

const handleSubmit = async (e) => {
  e.preventDefault();
  let datos = { date: date.value, time: time.value };

  if (!token) {
    router.push({ name: "login" });
  }

  const decoded = jwtDecode(token);

  const userRol = decoded.data.rol;
  if (userRol == 2) {
    alert("Solo para pasajeros");
    window.location.href = "/dashboard/";
  }

  // llamar a la api para ver si ya tiene viajes programados
  if (userRol == 2) {
    alert("Ya tienes un viaje programado");
    window.location.href = "/dashboard/";
  }
  const horario = await horarioService.getHorario({
    horario: datos.time,
  });
  if (!horario.success) {
    alert("Nuestros servicios no estan disponibles a esa hora");
    return;
  }

  emits("send-datos", datos);
};

const minDate = computed(() => {
  // Calcular la fecha mínima permitida (hoy)
  const today = new Date();
  return today.toISOString().split("T")[0]; // Formato YYYY-MM-DD
});

const maxDate = computed(() => {
  // Calcular la fecha máxima permitida (hoy + 1 dia)
  const maxDate = new Date();
  maxDate.setDate(maxDate.getDate() + 1);
  return maxDate.toISOString().split("T")[0]; // Formato YYYY-MM-DD
});

const minTime = computed(() => {
  // Calcular la hora mínima permitida (si es hoy, tienes que pedirlo con un minimo de 5 minutos posterior a la hora actual.Si es mañana puede pedirlo a cualquier hora)
  const today = new Date();
  const currentHour = today.getHours();
  const currentMinute = today.getMinutes() + 5;

  const formattedDate = `${today.getFullYear()}-${String(
    today.getMonth() + 1
  ).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`;

  let min = `00:00`;
  if (date && date.value === formattedDate) {
    min = `${currentHour < 10 ? "0" : ""}${currentHour}:${
      currentMinute < 10 ? "0" : ""
    }${currentMinute}`;
  }

  return min;
});

onMounted(() => {
  if (entradas.value) {
    const array = [...entradas.value];
    start = array[0];
    if (start) {
      const input = start.querySelector("input");
      input.placeholder = "Ubicacion de salida";
      document.getElementById("start").appendChild(start);
    }
    end = array[1];
    if (end) {
      const input = end.querySelector("input");
      input.placeholder = "Ubicacion destino";
      document.getElementById("end").appendChild(end);
    }
  }
});
</script>

<style>
.trip-booking__form {
  width: 25%;
}

@media (max-width: 991px) {
  .trip-booking__form {
    width: 100%;
  }
}

.trip-booking__form-container {
  border-radius: 50px;
  background-color: rgba(10, 21, 27, 0.99);
  display: flex;
  flex-direction: column;
  font-size: 25px;
  font-weight: 700;
  width: 100%;
  padding: 44px 27px;
}

@media (max-width: 991px) {
  .trip-booking__form-container {
    margin-top: 40px;
    padding: 0 20px;
  }
}

.trip-booking__title {
  color: var(--blanco, #fff);
  text-align: center;
  font-family: K2D, sans-serif;
  line-height: 89.6%;
}

.trip-booking__inputs {
  display: flex;
  flex-direction: column;
  margin-top: 27px;
  font-size: 16px;
  color: #808080;
  font-weight: 400;
  gap: 24px;
}

.trip-booking__inputs input {
  background: transparent;
  border: none;
}
.trip-booking__input-group {
  border-radius: 6px;
  background-color: rgba(242, 242, 242, 1);
  display: flex;
  gap: 20px;
  padding: 9px 15px;
  align-items: auto;
}

.trip-booking__dates-group {
  display: flex;
  border-radius: 6px;
  background-color: rgba(242, 242, 242, 1);
  gap: 20px;
  padding: 9px 15px;
  align-items: center;
  height: 3.5rem;
}

.trip-booking__dates-group input {
  max-height: 2rem;
}

.trip-booking__icon {
  width: 30px;
  height: 30px;
  object-fit: contain;
  fill: #ffc700;
}

.trip-booking__input-label {
  font-feature-settings: "clig" off, "liga" off;
  font-family: K2D, sans-serif;
  flex-grow: 1;
  margin: auto 0;
  background: transparent;
  border: none;
  height: 3vh;
}

.trip-booking__icon--destination {
  width: 30px;
  height: 30px;
}

.trip-booking__input-group--datetime {
  justify-content: space-between;
  white-space: nowrap;
}

@media (max-width: 991px) {
  .trip-booking__input-group--datetime {
    white-space: initial;
  }
}

.trip-booking__datetime {
  display: flex;
  gap: 20px;
  align-items: center;
  color: #808080;
}

.trip-booking__arrow-icon {
  width: 15px;
  height: 32px;
  object-fit: contain;
  fill: var(--oscuro1, #0a151b);
  margin: auto 0;
}

.trip-booking__search-button {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
  box-shadow: 999px 999px 0 0 rgba(0, 0, 0, 0.08) inset;
  border: 1px solid rgba(0, 0, 0, 1);
  background-color: #ffc000;
  margin-top: 50px;
  color: var(--Content-contentPrimary, var(--negro, #000));
  white-space: nowrap;
  text-align: center;
  line-height: 64%;
  padding: 15px 60px;
}

@media (max-width: 991px) {
  .trip-booking__search-button {
    margin-top: 40px;
    white-space: initial;
    padding: 20px 20px;
  }
}

.trip-booking__search-text {
  font-family: K2D, sans-serif;
  justify-content: center;
  box-shadow: 999px 999px 0 0 rgba(0, 0, 0, 0.08) inset;
  padding: 0 8px;
}

@media (max-width: 991px) {
  .trip-booking__title {
    padding-top: 1rem;
  }
  .trip-booking__search-text {
    white-space: initial;
  }

  .trip-booking__search-button {
    margin-bottom: 1rem;
  }
}

.leaflet-routing-geocoder {
  width: 100%;
}
.leaflet-routing-geocoder input {
  width: 100%;
  height: 100%;
}

.datetimeSel {
  display: none;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 20px;
}
.activeCuando {
  display: flex;
}
.inactiveCuando {
  display: none;
}

.datetimeWrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: stretch;
  gap: 20px;
}
</style>
