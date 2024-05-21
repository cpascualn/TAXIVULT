<template>
  <div>
    <Header></Header>
    <section class="trip-booking">
      <div class="trip-booking__container">
        <div class="trip-booking__content">
          <SearchTrip></SearchTrip>
          <LeafMap></LeafMap>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import Header from "@/components/Header.vue";
import SearchTrip from "@/components/SearchTrip.vue";
import LeafMap from "@/components/LeafMap.vue";
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
