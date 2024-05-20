<template>
  <section class="div">
    <div class="container">
      <div class="col">
        <div class="content">
          <div class="headtxt">TRABAJA CON NOSOTROS</div>
          <div class="subtxt">
            Gana dinero usando tu propio coche transportando gente en tu ciudad.
          </div>
          <div class="element">
            <div class="element__icon">1</div>
            <div class="element__txt">
              Ayuda a la gente a llegar a su destino
            </div>
          </div>
          <div class="element">
            <div class="element__icon">2</div>
            <div class="element__txt">Horario flexible</div>
          </div>
          <div class="element">
            <div class="element__icon">3</div>
            <div class="element__txt">Ventajas exclusivas</div>
          </div>
          <router-link to="/conduce" class="button"
            >PRIMEROS PASOS</router-link
          >
        </div>
      </div>
      <div class="col-2">
        <img loading="lazy" srcSet="/img/taxicar.jpg" class="img" />
      </div>
    </div>
  </section>
</template>

<style scoped>
.div {
  background-color: var(--oscuro1, #0a151b);
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  padding: 0 60px;
}

@media (max-width: 991px) {
  .div {
    max-width: 100%;
    padding: 0 20px;
  }
}

.container {
  width: 1222px;
  max-width: 100%;
  gap: 20px;
  display: flex;
}

.col {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 56%;
  margin-left: 0px;
}

@media (max-width: 991px) {
  .column {
    width: 100%;
  }
}

.content {
  display: flex;
  margin-top: 113px;
  flex-direction: column;
  font-size: 28px;
  text-align: center;
  line-height: 179%;
}

@media (max-width: 991px) {
  .content {
    max-width: 100%;
    margin-top: 40px;
  }
}

.headtxt {
  color: var(--blanco, #fff);
  font: 400 55px/100% K2D, sans-serif;
}

@media (max-width: 991px) {
  .headtxt {
    max-width: 100%;
    font-size: 40px;
  }
}

.subtxt {
  color: var(--blanco, #fff);
  font-family: K2D, sans-serif;
  font-weight: 400;
  line-height: 50px;
  align-self: center;
  margin-top: 102px;
  margin-bottom: 25px;
}

@media (max-width: 991px) {
  .subtxt {
    max-width: 100%;
    margin-top: 40px;
  }
}

.element__icon {
  font-family: K2D, sans-serif;
  background-color: var(--primario, #ffc000);
  border-radius: 50%;
  align-items: center;
  color: var(--negro, #000);
  font-weight: 800;
  white-space: nowrap;
  justify-content: center;
  width: 70px;
  height: 70px;
  padding: 10px 25px;
}

@media (max-width: 991px) {
  .element__icon {
    white-space: initial;
    padding: 10px 25px;
  }
}

.element__txt {
  color: var(--blanco, #fff);
  font-family: K2D, sans-serif;
  font-weight: 400;
  flex-grow: 1;
  flex-basis: auto;
  margin: auto 0;
}

@media (max-width: 991px) {
  .element__txt {
    max-width: 100%;
  }
}

.element {
  display: flex;
  margin-top: 30px;
  gap: 20px;
}

@media (max-width: 991px) {
  .element {
    max-width: 100%;
    flex-wrap: wrap;
  }
}

.button {
  border-radius: 50px;
  box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25) inset;
  border-color: rgba(0, 0, 0, 1);
  border-style: solid;
  border-width: 3px;
  background-color: var(--primario, #ffc000);
  align-self: center;
  margin-top: 37px;
  width: 241px;
  max-width: 100%;
  color: var(--negro, #000);
  justify-content: center;
  padding: 20px 45px;
  font: italic 800 30px K2D, sans-serif;
  margin-bottom: 15px;
  text-decoration: none;
}

@media (max-width: 991px) {
  .button {
    padding: 0 20px;
  }
}

.col-2 {
  display: flex;
  flex-direction: column;
  line-height: normal;
  width: 44%;
  margin-left: 20px;
}

@media (max-width: 991px) {
  .col-2 {
    width: 100%;
  }
}

.img {
  aspect-ratio: 0.63;
  object-fit: cover;
  object-position: -123px;
  width: 100%;
  flex-grow: 1;
}

@media (max-width: 991px) {
  .img {
    max-width: 100%;
    margin-top: 21px;
  }
}
</style>
