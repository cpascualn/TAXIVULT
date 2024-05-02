<template>
  <div>
    <Header></Header>
    <section class="trip-booking">
      <div class="trip-booking__container">
        <div class="trip-booking__content">
          <form class="trip-booking__form">
            <div class="trip-booking__form-container">
              <h2 class="trip-booking__title">Consigue un viaje</h2>
              <div class="trip-booking__inputs">
                <div class="trip-booking__input-group">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/fcafba4e0cf3c74e2c7474823eb15a538cfd1653ff2bbf1f023eedf28fd4d5b7?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
                    alt="Pickup location icon"
                    class="trip-booking__icon"
                  />
                  <input
                    type="text"
                    class="trip-booking__input-label"
                    placeholder=" Ubicación de recogida"
                  />
                </div>
                <div class="trip-booking__input-group">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/1556693e9937325d0df6c1ed8d094db6e780f90308f699ba09080b0679612811?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
                    alt="Destination location icon"
                    class="trip-booking__icon trip-booking__icon--destination"
                  />
                  <input
                    type="text"
                    class="trip-booking__input-label"
                    placeholder="  Ubicación de destino"
                  />
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
          <div class="trip-booking__map">
            <div class="trip-booking__map-container">
              <div class="leafMap">
                <l-map ref="map" :zoom="zoom" :center="[40, -4]">
                  <l-tile-layer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    layer-type="base"
                    name="OpenStreetMap"
                  ></l-tile-layer>
                </l-map>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";

import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet";

export default {
  components: {
    Header,
    LMap,
    LTileLayer,
  },
  data() {
    return {
      zoom: 6,
    };
  },
};
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

.trip-booking__input-group {
  border-radius: 6px;
  background-color: rgba(242, 242, 242, 1);
  display: flex;
  gap: 20px;
  padding: 9px 15px;
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

.trip-booking__map {
  width: 75%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .trip-booking__map {
    width: 100%;
    margin-left: 0;
  }
}

.trip-booking__map-container {
  background-color: #d9d9d9;
  flex-grow: 1;
  align-items: center;
  color: var(--negro, #000);
  text-align: center;
  justify-content: center;
  width: 100%;
  font: 700 64px/25% K2D, sans-serif;
}

@media (max-width: 991px) {
  .trip-booking__map-container {
    max-width: 100%;
    font-size: 40px;
    margin-top: 40px;
  }
}

.leafMap {
  width: 100%;
  height: 75vh;
}
</style>
