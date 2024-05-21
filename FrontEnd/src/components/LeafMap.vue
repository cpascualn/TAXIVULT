<template>
  <div class="trip-booking__map">
    <div class="trip-booking__map-container">
      <div></div>
      <div class="leafMap">
        <l-map ref="map" :zoom="zoom" :center="center" @ready="onMapReady()">
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
      this.initializeRouter();

      // You can also use the ready event
      // this.router.geocoder.on("ready", () => {
      //   console.log("Geocoder is ready");
      // });

      let entradas = document.getElementsByClassName(
        "leaflet-routing-geocoder"
      );
      this.$emit("send-data", entradas);
    },
    hideOptions() {
      const options = document.getElementsByClassName(
        "leaflet-routing-geocoder-result"
      );
      console.log(options);
      // Iterar sobre los elementos y cambiar las clases
      for (const option of options) {
        if (option.classList.contains("leaflet-routing-geocoder-result-none")) {
          option.classList.remove("leaflet-routing-geocoder-result-none");
        }
        option.classList.add("leaflet-routing-geocoder-result-none");
      }
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

        geocoder: L.Control.Geocoder.nominatim(),
      }).addTo(this.map);

      this.router.on("routesfound", (event) => {
        const route = event.routes[0];
        this.distance = route.summary.totalDistance;
        this.time = route.summary.totalTime;
      });

      this.router.on("routeselected", function (event) {
        console.log("Ruta seleccionada:", event.route);
      });

      this.router.on("waypointschanged", (event) => {
        this.hideOptions(); // Oculta la div solo si el segundo punto de ruta no ha sido cambiado antes
        secondWaypointChanged = true; // Marca el segundo punto de ruta como cambiado
      });

      this.router.on("geocodestatechange", function (event) {
        // Manejar el evento de cambio de estado del geocodificador
        console.log("Estado del geocodificador cambiado:", event);
      });
    },

    addWaypoint(query, index) {
      L.Control.Geocoder.nominatim().geocode(query, (results) => {
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
/* .leaflet-routing-alternatives-container {
  display: none;
} */

.leaflet-routing-geocoders {
  display: block;
}
.leaflet-routing-geocoder-result {
  display: flex;
  flex-direction: column;
  gap: 1px;
  list-style: none;
  max-height: 100px;
  padding: 0;
  position: absolute;
  background-color: white;
  color: black;
  min-width: 160px;
  max-height: 200px; /* Altura máxima del desplegable */
  overflow-y: auto; /* Habilitar desplazamiento vertical */
  border: 1px solid #ccc;
  z-index: 1;
}

.leaflet-routing-geocoder-result-none {
  display: none;
}

.leaflet-routing-geocoder-result tr:hover {
  background: #ffc000;
}

.leaflet-routing-alternatives-container {
  display: none;
}

.leaflet-routing-add-waypoint {
  display: none;
}
</style>
