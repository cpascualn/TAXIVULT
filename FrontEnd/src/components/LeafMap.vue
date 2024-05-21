<template>
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
</template>

<script>
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet";

export default {
  components: {
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

<style>
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
