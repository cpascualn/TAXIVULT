<template>
  <div class="regForm">
    <section class="register" v-if="!hasSeenCongrats">
      <h3 class="title">REGISTRESE COMO PASAJERO</h3>
      <div class="register-stepper">
        <div
          class="step"
          :class="{ 'step-active': step === 1, 'step-done': step > 1 }"
        >
          <span class="step-number">1</span>
        </div>
        <div
          class="step"
          :class="{ 'step-active': step === 2, 'step-done': step > 2 }"
        >
          <span class="step-number">2</span>
        </div>
      </div>

      <h2 class="register-title">{{ titulos[step - 1] }}</h2>

      <transition name="slide-fade">
        <section v-show="step === 1">
          <form class="form" method="post" @submit.prevent="next">
            <div class="form-group">
              <input
                type="text"
                v-model="usuario.email"
                autocomplete="usuario.email"
                placeholder="Email"
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                required
              />
              <input
                type="text"
                v-model="usuario.nombre"
                autocomplete="usuario.nombre"
                placeholder="Nombre"
                required
              />
            </div>

            <div class="form-group">
              <input
                type="tel"
                v-model="usuario.telefono"
                autocomplete="usuario.telefono"
                placeholder="telefono"
                minlength="9"
                maxlength="10"
                pattern="^\+?[0-9\s\-().]{7,15}$"
                required
              />
              <input
                type="text"
                v-model="usuario.apellidos"
                autocomplete="usuario.apellidos"
                placeholder="Apellidos"
                required
              />
            </div>

            <div class="form-group">
              <input
                type="text"
                v-model="usuario.ciudad"
                autocomplete="usuario.ciudad"
                placeholder="Ciudad"
                required
              />

              <input
                type="password"
                v-model="usuario.password"
                autocomplete="usuario.password"
                placeholder="Contrasena"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                required
              />
            </div>

            <div class="form-group">
              <input
                type="date"
                v-model="usuario.fechaNac"
                placeholder="Birthday ('day'/'month'/'year')"
                required
              />
            </div>

            <div
              class="cta"
              data-style="see-through"
              data-alignment="right"
              data-text-color="custom"
            >
              <p class="cta-color">
                <span class="link_wrap">
                  <input type="submit" value="" class="link_text" />
                  <span class="arrow-next"></span>
                </span>
              </p>
            </div>
          </form>
        </section>
      </transition>
      <transition name="slide-fade">
        <section v-show="step === 2">
          <form
            class="form"
            method="post"
            action="#"
            @submit.prevent="register"
          >
            <div class="form-group">
              <input
                type="text"
                v-model="usuario.cardNumber"
                autocomplete="usuario.cardNumber"
                placeholder="numero tarjeta"
                pattern="^\d{4}(?:\s?\d{4}){3}$"
                required
              />
              <input
                type="text"
                v-model="usuario.cardName"
                autocomplete="usuario.cardName"
                placeholder="nombre"
                required
              />
            </div>

            <div class="form-group">
              <input
                type="text"
                v-model="usuario.cardExpiration"
                autocomplete="usuario.cardExpiration"
                placeholder="fecha expiracion (mm/yy)"
                pattern="\d{2}/\d{2}"
                required
              />
              <input
                type="text"
                v-model="usuario.cardCVC"
                autocomplete="usuario.cardCVC"
                placeholder="CVC"
                pattern="^\d{3,4}$"
                required
              />
            </div>

            <div class="form-group cta-step">
              <div class="cta prev">
                <p class="cta-color">
                  <span class="link_wrap">
                    <a class="link_text" href="#" @click.prevent="prev()"
                      ><span class="arrow-prev"></span>
                    </a>
                  </span>
                </p>
              </div>
              <div class="cta">
                <p class="cta-color">
                  <span class="text"></span>
                  <span class="link_wrap">
                    <input type="submit" value="" class="link_text" />
                  </span>
                </p>
              </div>
              <div class="register-btn">
                <input type="submit" value="REGISTRATE" />
              </div>
            </div>
          </form>
        </section>
      </transition>
    </section>
    <section class="congrats register" v-if="hasSeenCongrats">
      <h2 class="congrats-title">Thank you !</h2>
      <p class="congrats-subtitle">
        You have successfully created your account and joined the<br />
        <strong>VueJS<br />multiple steps form</strong>
      </p>
    </section>
  </div>
</template>

<script setup>
import { ref } from "vue";

const step = ref(1);
const titulos = ["PERSONAL", "TARJETA(opcional)"];

// se reemplazaran por la llamada a la api
const horarios = ["diurno", "nocturno"];
const usuario = ref({
  //step 1
  email: "",
  nombre: "",
  apellidos: "",
  telefono: "",
  ciudad: "",
  password: "",
  fechaNac: "",
  //step 2
  cardNumber: "",
  cardName: "",
  cardExpiration: "",
  cardCVC: "",
});

const hasSeenCongrats = ref(false);

const prev = () => {
  step.value--;
};

const next = () => {
  console.log(usuario.value);
  step.value++;
};

const register = () => {
  console.log(usuario.value);
  hasSeenCongrats.value = true;
};
</script>

<style>
body {
  background-color: var(--oscuro1, #162430);
  font-family: "K2D", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  width: 100%;
  height: 100vh;
  margin: 0;
}

.pen-description {
  display: flex;
  flex-flow: column;
  align-items: center;
  font-family: "K2D", sans-serif;
}

.pen-description h1 {
  text-align: center;
  margin-top: 2rem;
  color: #fff;
}

.pen-description p {
  margin: 0;
  line-height: 1;
}

.pen-description .pen-copyright img {
  border-radius: 25px;
  padding: 5px;
  margin: 5px;
  transition: box-shadow 0.5s ease-in-out;
}

.pen-description .pen-copyright:hover img {
  box-shadow: 0 10px 20px #0e2101;
}

.register {
  display: block;
  color: #fff;
  max-width: 840px;
  margin: 2rem auto;
  padding: 2rem;
  border-radius: 4rem;
  background: #0a151b;
}

.register-icon {
  display: flex;
  background: #fff;
  border-radius: 2rem;
  width: 50px;
  height: 50px;
  padding: 1rem;
  margin: -50px auto 20px;
}

.register-icon-item {
  width: 100%;
}
.title {
  text-align: center;
}

.register-title {
  font-weight: 400;
  font-size: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 0.2rem;
  text-align: center;
  color: #fff;
  padding: 0 2rem;

  margin-bottom: 2rem;
}

.register-stepper {
  display: flex;
  justify-content: space-between;
  width: 100%;
  position: relative;
  margin: 0 auto 1.5em;
  margin-top: 2rem;
}

.register-stepper .step {
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2;
  color: black;
  background-color: #fff;
  border-radius: 50%;
  min-width: 30px;
  min-height: 30px;
  line-height: 20px;
  font-size: 16px;
}

.register-stepper .step-active {
  color: black;
  background-color: #ffc000;
}

.register-stepper .step-done {
  color: black;
  background-color: #ffc000;
}

.register-stepper .step::before {
  z-index: 0;
  content: "";
  display: block;
  position: absolute;
  height: 4px;
  top: calc(50% - 1px);
  background: white;
  width: calc(80% - 30px);
  margin-left: 390px;
}

.register-stepper .step-done::before {
  z-index: 0;
  content: "";
  display: block;
  position: absolute;
  height: 4px;
  top: calc(50% - 1px);
  background: #ffc000;
  width: calc(80% - 30px);
  margin-left: 390px;
}

.register-stepper .step:last-child:before {
  display: none;
}

.register-stepper .step-number {
  font-family: "K2D", sans-serif;
  font-weight: 800;
  line-height: 1;
  vertical-align: middle;
}

.register .form-group {
  display: flex;
  flex-flow: row;
  justify-content: flex-start;
  align-items: baseline;
}

.register .form-group label {
  text-align: left;
  font-size: 1.1rem;
  line-height: 1.1;
  padding-bottom: 0.5rem;
}

.register .form-group.cta-step {
  color: #fff;
  justify-content: center;
  align-items: center;
}

.register .form-group.cta-step .cta.prev {
  padding: 10px 30px;
}

.register .form-group.new-password {
  margin-top: 2rem;
}

.register .cta-color,
.register .cta-color input,
.register .cta-color .link_text {
  color: #fff;
  font-family: "K2D", sans-serif;
  font-size: 1.1rem;
  text-decoration: none;
}

.register .cta-color .link_wrap {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.register .cta-color .link_wrap .arrow-prev {
  position: relative;
  display: inline-block;
  transform: translate(0);
  transition: transform 0.3s ease-in-out;
}

.register .cta-color .link_wrap .arrow-prev::before {
  color: #ffc000;
  content: "<-";
  position: absolute;

  top: -17px;
  left: -25px;
}

.register .cta-color .link_wrap .arrow-next {
  position: relative;
  display: inline-block;
  transform: translate(0);
  transition: transform 0.3s ease-in-out;
}

.register .cta-color .link_wrap .arrow-next::before {
  color: #ffc000;
  content: "->";
  position: absolute;
  top: -10px;
  left: -25px;
}

.register .cta-color .link_wrap:hover .arrow-prev {
  transform: translate(-5px);
}

.register .cta-color .link_wrap:hover .arrow-next {
  transform: translate(5px);
}

.buscador {
  border: 0;
  padding: 0;
  width: 100%;
  margin: 0;
}

.desplegable {
  display: flex;
  flex-direction: column;
  gap: 1px;
  list-style: none;
  max-height: 100px;
  padding: 0;
  position: absolute;
  background-color: #d4d4d4;
  min-width: 160px;
  max-height: 200px; /* Altura máxima del desplegable */
  overflow-y: auto; /* Habilitar desplazamiento vertical */
  border: 1px solid #ccc;
  z-index: 1;
}
.desplegable li {
  color: black;
  background: white;
  border: 0;
  border-radius: 5px;
  padding: 0.4rem;
  width: 200px;
  margin: 0.2rem 0.5rem;
}
.desplegable li:hover {
  background: #ffc000;
}

select,
input[type="submit"],
input[type="number"],
input[type="text"],
input[type="tel"],
input[type="email"],
input[type="password"],
input[type="date"] {
  border: 0;
  border-radius: 5px;
  padding: 1.3rem 1rem;
  width: 100%;
  margin: 0.5rem;
  max-width: 12rem;
}

input[type="submit"] {
  cursor: pointer;
  position: relative;
  background: none;
  width: fit-content;
}

input[type="submit"]:hover,
input[type="submit"]:focus {
  box-shadow: unset;
  transform: none;
}

input[type="submit"]::after {
  content: "";
  display: block;
  position: absolute;
  right: 0;
  top: 50%;
  border-radius: 50px;
  border: 1px solid #00c4b5;
  height: 25px;
  width: 25px;
  margin-top: -14px;
  pointer-events: none;
  transition: all 0.33s cubic-bezier(0.12, 0.75, 0.4, 1);
}

.register-btn {
  display: flex;
  justify-content: center;
}

.register-btn input {
  color: #fff;
  font-size: 1.2rem;
  font-family: "K2D", sans-serif;
  font-weight: 800;
  line-height: 1;
  width: fit-content;
  background: #ffc000;
}

/* Transition SLIDE FADE */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}

.slide-fade-leave-active {
  display: none;
  transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}

.congrats {
  background: #fff;
  color: #00c4b5;
  padding: 4rem;
  text-align: center;
}

.congrats-subtitle {
  line-height: 1.3;
}

.congrats-subtitle strong {
  font-size: 2rem;
}
</style>
