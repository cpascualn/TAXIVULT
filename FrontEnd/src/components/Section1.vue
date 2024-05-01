<script></script>

<template>
  <div class="div">
    <div class="container1">
      <div class="separador--flex">
        <div class="container2">
          <div class="icon">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/554cfde192841d9d5f734ba5189bb7325ab2213f1570b23445c98ce63170c350?"
              class="img"
            />
          </div>
          <div class="separador"></div>
          <div class="icon">
            <img loading="lazy" src="/img/ubipng.png" class="img" />
          </div>
          <div class="separador"></div>
          <div class="icon">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/7be12cd8dd522dbe0061016e023c0515ddc3858ffff693bcd4109a7dabd2a7ca?"
              class="img"
            />
          </div>
        </div>
      </div>

      <div class="texts">
        <div class="container">
          <div class="main--txt">EN 2 CLICKS</div>
          <div class="second--txt">CONTACTE CON SU CONDUCTOR EN SEGUNDOS</div>
        </div>

        <div class="container">
          <div class="main--txt">SELECCIONE UBICACION</div>
          <div class="second--txt">
            ELIJA LA UBICACION DE SALIDA Y LLEGADA EN CUALQUIER ZONA
          </div>
        </div>
        <div class="container">
          <div class="main--txt">RAPIDEZ</div>
          <div class="second--txt">
            CUMPLIMOS CON LOS PLAZOS DE PUNTUALIDAD CON SERIEDAD
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.div {
  background-color: var(--oscuro2, #162430);
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  padding: 80px 60px;
}

@media (max-width: 991px) {
  .div {
    max-width: 100%;
    padding: 0 20px;
  }
}

.container1 {
  display: flex;
  width: 1257px;
  max-width: 100%;
  flex-direction: column;
  margin: 41px 0 14px;
  gap: 40px;
}

@media (max-width: 991px) {
  .container1 {
    margin-top: 40px;
  }
}

.separador--flex {
  display: flex;
  gap: 0px;
  margin: 0 auto;
}

@media (max-width: 991px) {
  .separador--flex {
    margin-right: 10px;
    flex-wrap: wrap;
  }
}

@media (max-width: 991px) {
  .div-4 {
    flex-wrap: wrap;
  }
}

.icon {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: var(--primario, #ffc000);
  border-radius: 50%;
  width: 170px;
  height: 170px;
}

.container2 {
  justify-content: space-between;
  align-self: start;
  z-index: 10;
  display: flex;
  margin-top: 21px;
  flex-wrap: wrap;
}

@media (max-width: 991px) {
  .container2 {
    flex-wrap: wrap;
  }
}

.img {
  max-width: 100%;
  margin: 0 auto;
}

.separador {
  border-color: rgba(255, 255, 255, 1);
  border-style: solid;
  border-width: 5px;
  background-color: #fff;
  width: 351px;
  max-width: 100%;
  height: 5px;
  margin: auto 0;
}

.texts {
  display: flex;
  gap: 25%;
  color: var(--blanco, #fff);
}

@media (max-width: 991px) {
  .texts {
    max-width: 100%;
    flex-wrap: wrap;
  }
}

.container {
  align-self: start;
  display: flex;
  flex-direction: column;
  text-align: center;
  flex: 1;
}

.main--txt {
  align-self: center;
  font: 700 25px/89.6% K2D, sans-serif;
}

.second--txt {
  text-align: center;
  margin-top: 40px;
  font: 400 20px/22px K2D, sans-serif;
}
</style>
