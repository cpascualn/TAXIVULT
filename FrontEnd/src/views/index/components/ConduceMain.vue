<template>
  <main class="main-content">
    <section class="intro-section">
      <h2>¿Por qué conducir para Taxivult?</h2>
      <img
        loading="lazy"
        :src="taxiDriver"
        alt="Taxi driver illustration"
        class="intro-img"
      />

      <div class="features-section row">
        <div class="feature--item col-4">
          <img
            loading="lazy"
            :src="people"
            alt="Feature 1"
            class="feature-img"
          />
          <span class="feature-detail">La mayor red de usuarios del país.</span>
        </div>
        <div class="feature--item col-4">
          <img
            loading="lazy"
            :src="star"
            alt="Feature 2"
            class="feature-img"
          />
          <span class="feature-detail">Aplicacion mejor valorada.</span>
        </div>
        <div class="feature--item col-4">
          <img
            loading="lazy"
            :src="phone"
            alt="Feature 3"
            class="feature-img"
          />
          <span class="feature-detail">Sencillez en tu bolsillo.</span>
        </div>
      </div>
    </section>
    <section class="getting-started-section">
      <h2>Cómo empezar</h2>
      <div class="steps-container">
        <div class="step">
          <img
            loading="lazy"
            :src="write"
            alt="Step 1"
            class="step-img"
          />
          <p class="step-detail">
            <span class="highlight">Registro y seguro:</span><br />
            Registra tu vehículo en la plataforma y asegúrate de tener el seguro
            adecuado para protegerte a ti y a tus pasajeros.
          </p>
        </div>
        <div class="step">
          <img
            loading="lazy"
            :src="list"
            alt="Step 2"
            class="step-img"
          />
          <p class="step-detail">
            <span class="highlight">Licencia de conducir:</span><br />
            Debes tener una licencia de conducir válida y cumplir con los
            requisitos de edad y experiencia de manejo en tu área.
          </p>
        </div>
        <div class="step">
          <img
            loading="lazy"
            :src="check"
            alt="Step 3"
            class="step-img"
          />
          <p class="step-detail">
            <span class="highlight">Vehículo apto:</span><br />
            Tu vehículo debe cumplir con los estándares de seguridad y calidad
            de Taxivult. Consulta nuestras pautas para obtener más información.
          </p>
        </div>
      </div>
    </section>
  </main>
</template>
<script setup>
import taxiDriver from "@/assets/img/index/taxiDriver.png";
import people from "@/assets/img/index/people.svg";
import star from "@/assets/img/index/star.svg";
import phone from "@/assets/img/index/phone.svg";
import write from "@/assets/img/index/write.svg";
import list from "@/assets/img/index/list.svg";
import check from "@/assets/img/index/check.svg";
</script>

<style scoped>
@import url("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css");
.main-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  background: #162430;
}

.intro-section {
  text-align: center;
  margin-top: 100px;
}
@media (max-width: 991px) {
  .intro-section {
    margin-top: 40px;
  }
}

h2 {
  color: var(--blanco, #fff);
  font: 400 55px/1.1 K2D, sans-serif;
}
@media (max-width: 991px) {
  h2 {
    font-size: 40px;
  }
}

.intro-img {
  width: 720px;
  aspect-ratio: 1.82;
  object-fit: auto;
  object-position: center;
  margin-top: 93px;
  max-width: 100%;
}
@media (max-width: 991px) {
  .intro-img {
    margin-top: 40px;
  }
}

.feature--item {
  display: flex;
  flex-direction: column;
  align-items: center;
}

@media (max-width: 500px) {
  .feature--item {
    display: block;
  }
}

.features-section {
  margin-top: 66px;
  width: 100%;
  max-width: 896px;
  padding: 0 2px;
}

.features-images {
  display: flex;
  justify-content: space-around;
  gap: 20px;
}
@media (max-width: 991px) {
  .features-images {
    flex-wrap: wrap;
    margin-top: 40px;
  }
}

.feature-img {
  width: 80px;
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
}

.features-text {
  display: flex;
  justify-content: space-between;
  text-align: center;
  font-size: 24px;
  color: var(--blanco, #fff);
  font-weight: 600;
  line-height: 28px;
  margin-top: 32px;
  gap: 20px;
  padding: 0 2px;
}
@media (max-width: 991px) {
  .features-text {
    flex-wrap: wrap;
  }
}

.feature-detail {
  width: 242px;
  font-family: K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  text-align: center;
  font-size: 24px;
  color: var(--blanco, #fff);
  font-weight: 600;
}

.getting-started-section {
  text-align: center;
  margin-top: 100px;
  display: flex;
  flex-direction: column;
  gap: 50px;
  margin-bottom: 200px;
}

@media (max-width: 991px) {
  .getting-started-section {
    margin-top: 40px;
  }
}

.steps-container {
  display: flex;
  flex-direction: column;
  gap: 50px;
  max-width: 50vw;
}

.step {
  text-align: center;
  font-size: 24px;
  font-weight: 600;
  color: var(--blanco, #fff);
  line-height: 28px;
  display: flex;
  gap: 5%;
}

.step-img {
  width: 70px;
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
}

@media (max-width: 991px) {
  .step img + img {
    margin-top: 40px;
  }
}
@media (max-width: 780px) {
  .step {
    flex-direction: column;
    align-items: center;
  }

  .getting-started-section {
    align-items: center;
  }
  .steps-container {
    max-width: 70vw;
  }
}

.step-detail {
  font-family: K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  margin-top: 10px;
}

.step-detail + .step-detail {
  margin-top: 196px;
}

.step-detail + .step-detail + .step-detail {
  margin-top: 205px;
}
@media (max-width: 991px) {
  .step-detail {
    margin-top: 40px;
  }
  .step-detail + .step-detail {
    margin-top: 40px;
  }
}

.highlight {
  font-weight: 800;
  font-style: italic;
}
</style>
