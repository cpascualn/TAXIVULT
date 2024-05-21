<template>
  <div class="trip-booking__map">
    <div class="trip-booking__map-container">
      <div>
        <input v-model="startLocation" placeholder="Enter start location" />
        <input v-model="endLocation" placeholder="Enter end location" />
        <button @click="setRoute">Set Route</button>
      </div>
      <div class="leafMap">
        <l-map ref="map" :zoom="zoom" :center="center" @ready="onMapReady()">
          <!-- :useGlobalLeaflet="false"
        
                  :zoomControl="false"
          :scrollWheelZoom="false"
          :touchZoom="false"
          :doubleClickZoom="false"-->
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
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";
import L from "leaflet";
import "leaflet-routing-machine";
import "leaflet-control-geocoder";

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
  },
  data: () => ({
    map: null,
    router: null,
    startLocation: "",
    endLocation: "",
    zoom: 5,
    center: [40.422476, -3.696139],
    geocoder: L.Control.Geocoder.nominatim(),
    distance: "", // en metros
    time: "", // en segundos
  }),
  mounted() {
    // DO
    this.$nextTick(() => {
      this.$refs.map.leafletObject; // work as expected
    });
  },
  methods: {
    onMapReady() {
      this.map = this.$refs.map.leafletObject;
      this.map.setMaxZoom(16);
      this.map.setMinZoom(6);

      //   this.map.touchZoom.disable();
      //   this.map.doubleClickZoom.disable();
      //   this.map.scrollWheelZoom.disable();
      //   this.map.boxZoom.disable();
      //   this.map.keyboard.disable();
      //   this.map.zoomControl.remove();

      this.initializeRouter();
    },
    initializeRouter() {
      this.router = L.Routing.control({
        waypoints: [],
        routeWhileDragging: true,
        createMarker: function (i, waypoint, n) {
          return L.marker(waypoint.latLng, {
            draggable: false,
            // icon: L.icon({
            //   iconUrl: "ruta/a/tu/icono.png",
            //   iconSize: [0, 0], // Tamaño del icono
            //   iconAnchor: [16, 32], // Punto de anclaje del icono
            //   popupAnchor: [0, -32], // Punto donde se abrirá el popup
            // }),
          });
        },
        lineOptions: {
          styles: [{ color: "blue", opacity: 0.6, weight: 10 }],
        },
        // fitSelectedRoutes: false,
        showAlternatives: false,
      }).addTo(this.map);

      this.router.on("routesfound", (event) => {
        const route = event.routes[0];
        this.distance = route.summary.totalDistance;
        this.time = route.summary.totalTime;
      });
    },
    setRoute() {
      if (!this.map || !this.router) {
        console.error("Map or router is not initialized");
        return;
      }

      this.router.setWaypoints([]);

      this.addWaypoint(this.startLocation, 0);
      this.addWaypoint(this.endLocation, 1);
    },
    addWaypoint(query, index) {
      this.geocoder.geocode(query, (results) => {
        if (results && results.length > 0) {
          const result = results[0];
          const latlng = result.center;
          const waypoints = this.router.getWaypoints();

          if (waypoints[index]) {
            waypoints[index].latLng = latlng;
          } else {
            waypoints[index] = L.Routing.waypoint(latlng);
          }
        //   L.marker(latlng).addTo(this.map);

          this.router.setWaypoints(waypoints);

          this.map.setView(latlng, this.zoom);
          //   this.map.touchZoom.disable();
          //   this.map.doubleClickZoom.disable();
          //   this.map.scrollWheelZoom.disable();
          //   this.map.boxZoom.disable();
          //   this.map.keyboard.disable();
          //   this.map.zoomControl.remove();
        } else {
          alert("Location not found: " + query);
        }
      });
    },
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
.leaflet-routing-alternatives-container {
  display: none;
}
</style>
