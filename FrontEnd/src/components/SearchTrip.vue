<template>
  <form class="trip-booking__form">
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
          <!-- <input
            type="text"
            class="trip-booking__input-label"
            placeholder="  Ubicación de destino"
          /> -->
        </div>
        <div
          class="trip-booking__input-group trip-booking__input-group--datetime"
        >
          <div class="trip-booking__datetime">
            <img
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/afe5a4162f9c7ce570476fa73e405da096d14194273672bc75493620662219d9?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Clock icon"
              class="trip-booking__icon"
            />
            <!-- esto sera un desplegable q primero te deje coger el dia, luego la hora -->
            <input
              type="text"
              class="trip-booking__input-label"
              placeholder="Ahora"
            />
          </div>
          <img
            src="https://cdn.builder.io/api/v1/image/assets/TEMP/d0b219658ea78712624c17e2878d82d65be05f6c6dc9275f9736d106b1708a3a?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
            alt="Right arrow icon"
            class="trip-booking__arrow-icon"
          />
        </div>
      </div>
      <button class="trip-booking__search-button">Buscar</button>
    </div>
  </form>
</template>

<script setup>
import { ref, defineProps, onMounted, onUpdated } from "vue";

const props = defineProps(["data"]); // Definir las props esperadas
const entradas = ref(props.data);
let start, end;

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
  .trip-booking__search-text {
    white-space: initial;
  }
}

.leaflet-routing-geocoder  {
  width: 100%;
}
.leaflet-routing-geocoder input {
  width: 100%;
  height: 100%;
}
</style>
