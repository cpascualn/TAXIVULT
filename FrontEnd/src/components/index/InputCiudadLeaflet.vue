<template>
  <div>
    <!-- Input para buscar ciudades -->
    <input
      type="text"
      placeholder="Escribe el nombre de una ciudad..."
      v-model="city"
      @keydown="searchCity"
    />

    <!-- Opciones sugeridas -->
    <ul v-if="suggestions.length">
      <li
        v-for="(suggestion, index) in suggestions"
        :key="index"
        @click="selectCity(suggestion)"
        class="opcion"
      >
        {{ suggestion.name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from "vue";
import L from "leaflet";
import "leaflet-control-geocoder";

// Estado del input y sugerencias
const city = ref(""); // Valor del input
const suggestions = ref([]); // Sugerencias de ciudades

// Geocodificación de ciudades
const geocoder = L.Control.Geocoder.nominatim({
  geocodingQueryParams: {
    countrycodes: "ES", // Limitar la búsqueda a España
  },
});

// Función para buscar ciudades
const searchCity = () => {
  if (city.value.trim() === "") {
    suggestions.value = [];
    return;
  }

  geocoder.geocode(city.value, (results) => {
    suggestions.value = results.map((result) => ({
      name: result.name,
      latlng: result.center, // Puedes usar esta información para lo que necesites
    }));
  });
};

// Función para seleccionar una ciudad
const selectCity = (suggestion) => {
  console.log("Ciudad seleccionada:", suggestion.name, suggestion.latlng);
  city.value = suggestion.name;
  emit("city-selected", suggestion);
  suggestions.value = []; // Limpia las sugerencias después de seleccionar
};
</script>

<style scoped>
ul {
  list-style: none;
  padding: 0;
}

li {
  cursor: pointer;
  padding: 5px;
  background-color: #f0f0f0;
  margin: 5px 0;
}
.opcion {
  background-color: #162430;
}
li:hover {
  background-color: #e0e0e0;
  color: black;
}
</style>
