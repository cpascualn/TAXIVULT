<script setup></script>
<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-top">
        <div class="footer-top-content">
          <div class="footer-logo-container">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/e406f87081855b9eb1baf0a7b08a27074762d19cfa96755e12dd822c8d24d88c?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
              alt="Company logo"
              class="footer-logo"
            />
          </div>
          <div class="footer-links-container">
            <div class="footer-links-wrapper">
              <div class="footer-links-column">
                <div class="footer-links">
                  <div class="footer-link-title">Empresa</div>
                  <div class="footer-link">Sobre Nosotros</div>
                  <div class="footer-link">Soluciones</div>
                  <div class="footer-link">Insights</div>
                </div>
              </div>
              <div class="footer-links-column">
                <div class="footer-links">
                  <div class="footer-link-title">Categorías</div>
                  <div class="footer-link">Contratar Talento</div>
                  <div class="footer-link">Desarrollar Talento</div>
                  <div class="footer-link">Herramientas de Gamificación</div>
                </div>
              </div>
              <div class="footer-links-column">
                <div class="footer-links">
                  <div class="footer-link-title">Competencias Digitales</div>
                  <div class="footer-link">Competencias Comerciales</div>
                  <div class="footer-link">Liderazgo</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-divider"></div>
      <div class="footer-bottom">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/TEMP/dc47f7097b8d90af98224282559e9b24cff7e34859c27111968dbe50bd3f030f?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
          alt="Company logo"
          class="footer-bottom-logo"
        />
        <div class="footer-bottom-links">
          <div class="footer-bottom-link">Política de Privacidad</div>
          <div class="footer-bottom-link">Términos y Condiciones</div>
          <div class="footer-bottom-link">Código de Conducta</div>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  background-color: var(--oscuro1, #0a151b);
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  padding: 55px 60px;
}

.footer-container {
  display: flex;
  width: 1222px;
  max-width: 100%;
  flex-direction: column;
}

@media (max-width: 991px) {
  .footer-top {
    max-width: 100%;
    padding-right: 20px;
  }
}

.footer-top-content {
  gap: 20px;
  display: flex;
}

@media (max-width: 991px) {
  .footer-top-content {
    flex-direction: column;
    align-items: stretch;
    gap: 0px;
  }
}

.footer-logo-container {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 29%;
  margin-left: 0px;
}

@media (max-width: 991px) {
  .footer-logo-container {
    width: 100%;
  }
}

.footer-logo {
  aspect-ratio: 1.08;
  object-fit: auto;
  object-position: center;
  width: 136px;
  max-width: 100%;
}

@media (max-width: 991px) {
  .footer-logo {
    margin-top: 40px;
  }
}

.footer-links-container {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 71%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .footer-links-container {
    width: 100%;
  }
}

.footer-links-wrapper {
  flex-grow: 1;
}

@media (max-width: 991px) {
  .footer-links-wrapper {
    max-width: 100%;
    margin-top: 40px;
  }
}

.footer-links-wrapper {
  gap: 20px;
  display: flex;
}

@media (max-width: 991px) {
  .footer-links-wrapper {
    flex-direction: column;
    align-items: stretch;
    gap: 0px;
  }
}

.footer-links-column {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 27%;
  margin-left: 0px;
}

@media (max-width: 991px) {
  .footer-links-column {
    width: 100%;
  }
}

.footer-links {
  display: flex;
  margin-top: 12px;
  flex-grow: 1;
  flex-direction: column;
  font-size: 14px;
  color: var(--White, var(--blanco, #fff));
  font-weight: 400;
  line-height: 150%;
}

@media (max-width: 991px) {
  .footer-links {
    margin-top: 40px;
  }
}

.footer-link-title {
  font: 16px K2D, sans-serif;
}

.footer-link {
  font-family: K2D, sans-serif;
  margin-top: 49px;
}

@media (max-width: 991px) {
  .footer-link {
    margin-top: 40px;
  }
}

.footer-links-column:nth-child(2) {
  width: 39%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .footer-links-column:nth-child(2) {
    width: 100%;
  }
}

.footer-links-column:nth-child(3) {
  width: 34%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .footer-links-column:nth-child(3) {
    width: 100%;
  }
}

.footer-links:nth-child(3) {
  margin-top: 63px;
}

@media (max-width: 991px) {
  .footer-links:nth-child(3) {
    margin-top: 40px;
  }
}

.footer-divider {
  background-color: var(--blanco, #fff);
  margin-top: 72px;
  height: 1px;
}

@media (max-width: 991px) {
  .footer-divider {
    max-width: 100%;
    margin-top: 40px;
  }
}

.footer-bottom {
  display: flex;
  margin-top: 20px;
  width: 100%;
  gap: 20px;
  font-size: 14px;
  color: var(--White, var(--blanco, #fff));
  font-weight: 400;
  line-height: 150%;
  justify-content: space-between;
}

@media (max-width: 991px) {
  .footer-bottom {
    max-width: 100%;
    flex-wrap: wrap;
  }
}

.footer-bottom-logo {
  aspect-ratio: 5;
  object-fit: auto;
  object-position: center;
  width: 100px;
  align-self: start;
  max-width: 100%;
}

.footer-bottom-links {
  display: flex;
  gap: 20px;
  justify-content: space-between;
}

@media (max-width: 991px) {
  .footer-bottom-links {
    flex-wrap: wrap;
  }
}

.footer-bottom-link {
  font-family: K2D, sans-serif;
}
</style>
