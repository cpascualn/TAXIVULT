<template>
  <div>
    <Hero imagen="/img/heroConducir.jpg" :botones="false"></Hero>
    <main class="main-content">
      <section class="intro-section">
        <h2>¿Por qué conducir para Taxivult?</h2>
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/7675903299062473866a29b00494627ae190965f82f9566c7cd958fd73d71b49?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
          alt="Taxi driver illustration"
          class="intro-img"
        />

        <div class="features-section">
          <div class="features-images">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/9b8b590558ca8abc0140196c58e5008d7ae27744a98abcefad209dd6954032fe?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Feature 1"
              class="feature-img"
            />
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/f6064d2850c81bfc201ed72bdead8ce0fafad464c4c5111380a10ce7a1d1379e?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Feature 2"
              class="feature-img"
            />
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/8594bc73a4b68972b8d233194e5498581e0538426b93fd500186ae8f3bc4f9ee?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Feature 3"
              class="feature-img"
            />
          </div>
          <div class="features-text">
            <p class="feature-detail">La mayor red de usuarios del país.</p>
            <p class="feature-detail">La mayor red de usuarios del país.</p>
            <p class="feature-detail">La mayor red de usuarios del país.</p>
          </div>
        </div>
      </section>
      <section class="getting-started-section">
        <h2>Cómo empezar</h2>
        <div class="steps-container">
          <div class="step">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/0601826f5a827ef1c70a7fd8a13f89ab6fd11efd1d79d4ca9dcc8fa6dbd4f987?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Step 1"
              class="step-img"
            />
            <p class="step-detail">
              <span class="highlight">Registro y seguro:</span> Registra tu
              vehículo en la plataforma y asegúrate de tener el seguro adecuado
              para protegerte a ti y a tus pasajeros.
            </p>
          </div>
          <div class="step">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/9c10a79b35f146a950a633badd554723288cfb4e57f3b49ead0c75750283b5c1?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Step 2"
              class="step-img"
            />
            <p class="step-detail">
              <span class="highlight">Licencia de conducir:</span> Debes tener
              una licencia de conducir válida y cumplir con los requisitos de
              edad y experiencia de manejo en tu área.
            </p>
          </div>
          <div class="step">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/b9cacf55cd1b964bd09fc15b0d8015b97e064b39115f3e511ad01a784ba0456a?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Step 3"
              class="step-img"
            />
            <p class="step-detail">
              <span class="highlight">Vehículo apto:</span> Tu vehículo debe
              cumplir con los estándares de seguridad y calidad de Uber.
              Consulta nuestras pautas para obtener más información.
            </p>
          </div>
        </div>
      </section>
    </main>
    <Footer></Footer>

  </div>
</template>

<script setup>
import Hero from "./components/Hero.vue";
import Footer from "./components/Footer.vue";
</script>

<style scoped>

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
