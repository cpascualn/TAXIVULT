<template>
  <div>
    <Header></Header>
    <LoadingPage ref="loading"></LoadingPage>
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
import { ref } from "vue";

let entradas = ref();
let searchParams = ref({
  date: "",
  time: "",
  startLocation: "",
  endLocation: "",
  distance: "",
  duration: "",
});

const loading = ref(null);

const handleFromMap = (data) => {
  entradas.value = data;
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
};

const loadFinished = () => {
  if (loading.value) {
    loading.value.closeModal();
  }
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
</style>
