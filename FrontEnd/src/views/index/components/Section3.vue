<template>
  <section class="section">
    <div class="div">
      <h1 class="headtxt">NUESTROS DATOS</h1>
      <div class="container">
        <div class="column">
          <div class="element">
            <img loading="lazy" :src="speedmeter" class="img" />
            <div class="element__h1">10000</div>
            <div class="element__subtxt">KM CONDUCIDOS</div>
          </div>
        </div>
        <div class="column">
          <div class="element">
            <img loading="lazy" :src="people2" class="img" />
            <div class="element__h1">100</div>
            <div class="element__subtxt">PASAJEROS</div>
          </div>
        </div>
        <div class="column">
          <div class="element">
            <img loading="lazy" :src="carfill" class="img" />
            <div class="element__h1">100</div>
            <div class="element__subtxt">CONDUCTORES</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import speedmeter from "@/assets/img/index/speedmeter.svg";
import people2 from "@/assets/img/index/people2.svg";
import carfill from "@/assets/img/index/carfill.svg";
</script>

<style scoped>
.section {
  background-color: var(--oscuro2, #162430);
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  padding: 80px 60px;
}

@media (max-width: 991px) {
  .section {
    max-width: 100%;
    padding: 0 20px;
  }
}

.div {
  display: flex;
  width: 1222px;
  max-width: 100%;
  flex-direction: column;
  margin: 40px 0 23px;
}

.headtxt {
  color: var(--blanco, #fff);
  text-align: center;
  align-self: center;
  font: 400 55px/41% K2D, sans-serif;
  line-height: 1;
}

@media (max-width: 991px) {
  .headtxt {
    max-width: 100%;
    font-size: 40px;
  }
}

.container {
  justify-content: space-between;
  margin-top: 101px;
  gap: 5%;
  display: flex;
}

@media (max-width: 991px) {
  .container {
    max-width: 100%;
    margin-top: 40px;
    flex-direction: column;
    align-items: stretch;
    gap: 0px;
  }
}

.column {
  width: 33%;
}

@media (max-width: 991px) {
  .column {
    width: 100%;
  }
}

.element {
  display: flex;
  flex-grow: 1;
  flex-direction: column;
  color: var(--primario, #ffc000);
  font-weight: 400;
  text-align: center;
  justify-content: center;

  border-radius: 20px;
  background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
  padding: 50px 0px;
}

@media (max-width: 991px) {
  .element {
    margin-top: 40px;
  }
}

.img {
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
  width: 80px;
  align-self: center;
}

.element__h1 {
  margin-top: 49px;
  font: 55px/41% K2D, sans-serif;
}

@media (max-width: 991px) {
  .element__h1 {
    margin-top: 40px;
    font-size: 40px;
  }
}

.element__subtxt {
  margin-top: 42px;
  font: 20px/112% K2D, sans-serif;
}

@media (max-width: 991px) {
  .element__subtxt {
    margin-top: 40px;
  }
}

@media (max-width: 991px) {
  .column-2 {
    width: 100%;
  }
}

@media (max-width: 991px) {
  .element__wrapper {
    padding: 0 20px;
  }
}
</style>
