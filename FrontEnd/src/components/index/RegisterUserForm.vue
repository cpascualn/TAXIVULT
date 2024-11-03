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
          <form class="form" @submit.prevent="next">
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.email"
                  autocomplete="usuario.email"
                  placeholder="Email"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidMail[1] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidMail[0] }"
                >
                  El mail debe tener formato usuario@dominio.**
                </div>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.nombre"
                  autocomplete="usuario.nombre"
                  placeholder="Nombre"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidNombre[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidNombre[1] }"
                >
                  Nombre incorrecto
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <input
                  type="tel"
                  v-model="usuario.telefono"
                  autocomplete="usuario.telefono"
                  placeholder="telefono"
                  minlength="9"
                  maxlength="10"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidTelefono[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidTelefono[1] }"
                >
                  El telefono no es valido
                </div>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.apellidos"
                  autocomplete="usuario.apellidos"
                  placeholder="Apellidos"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidApellido[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidApellido[1] }"
                >
                  El apellido no es valido
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <select
                  v-model="usuario.ciudad"
                  id="selectCiu"
                  autocomplete="usuario.ciudad"
                  placeholder="Ciudad"
                  required
                >
                  <option value="" disabled selected>Ciudad</option>
                  <option
                    v-for="ciudad in ciudades"
                    :key="ciudad.id"
                    :value="ciudad.id"
                  >
                    {{ ciudad.nombre }}
                  </option>
                </select>
                <div
                  class="validFeedback"
                  :style="{ display: displayValidCiudad[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidCiudad[1] }"
                >
                  Debes seleccionar una ciudad
                </div>
              </div>
              <div class="input-group">
                <input
                  type="password"
                  v-model="usuario.contrasena"
                  autocomplete="usuario.contrasena"
                  placeholder="Contrasena"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidContra[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidContra[1] }"
                >
                  la contraseña debe tener al menos una letra, al menos un
                  número y una longitud mínima de 8 caracteres.
                </div>
              </div>
            </div>
            <div
              class="cta"
              data-style="see-through"
              data-alignment="right"
              data-text-color="custom"
            >
                  <button class="submit-next-button" type="submit">
                    <img
                      src="/src/assets/img/flecha-correcta.png"
                      alt=""
                      class="icono-flecha"
                    />
                  </button>   
            </div>
          </form>
        </section>
      </transition>
      <transition name="slide-fade">
        <section v-show="step === 2">
          <form
            class="form"
            method="post"
            @submit.prevent="register"
          >
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.n_tarjeta"
                  autocomplete="usuario.n_tarjeta"
                  placeholder="numero tarjeta"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidTarjeta[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidTarjeta[1] }"
                >
                  la tarjeta no coincide (debe tener 16 numeros)
                </div>
              </div>

              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.titular_tarjeta"
                  autocomplete="usuario.titular_tarjeta"
                  placeholder="nombre"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidNombreTarjeta[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidNombreTarjeta[1] }"
                >
                  El nombre no es correcto
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.caducidad_tarjeta"
                  autocomplete="usuario.caducidad_tarjeta"
                  placeholder="fecha expiracion (mm/yy)"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidExpTarjeta[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidExpTarjeta[1] }"
                >
                  la caducidad debe tener formato mm/yy
                </div>
              </div>

              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.cvv_tarjeta"
                  autocomplete="usuario.cvv_tarjeta"
                  placeholder="CVC"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidCVC[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidCVC[1] }"
                >
                  el cvc debe tener formato de tres numeros
                </div>
              </div>
            </div>
            <div class="form-group cta-step">
              <div class="cta prev">
                <span class="link_wrap">
                  <button class="submit-next-button" @click.prevent="prev()">
                    <img
                      src="/src/assets/img/flecha-correcta.png"
                      alt=""
                      class="icono-flecha-atras"
                    />
                  </button>
                </span>
              </div>
              <div class="cta"></div>
              <div class="register-btn">
                <input type="submit" value="REGISTRATE" />
              </div>
            </div>
          </form>
        </section>
      </transition>
    </section>
    <section class="congrats register" v-if="hasSeenCongrats">
      <h2 class="congrats-title">Registro finalizado!</h2>
      <p class="congrats-subtitle">
        {{ finalMessage }}
      </p>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ciudadService from "@/services/ciudad.service";
import regFormCheck from "@/mixins/regFormCheck";
import authService from "@/services/auth.service";

const step = ref(1);
const titulos = ["PERSONAL", "TARJETA"];
const ciudades = ref(["Madrid"]);

// propiedades del css para mostrar los validadores, [0] para el correcto y [1] para el incorrecto
const displayValidMail = ref(["none", "none"]);
const displayValidNombre = ref(["none", "none"]);
const displayValidApellido = ref(["none", "none"]);
const displayValidContra = ref(["none", "none"]);
const displayValidTelefono = ref(["none", "none"]);
const displayValidCiudad = ref(["none", "none"]);

const displayValidTarjeta = ref(["none", "none"]);
const displayValidNombreTarjeta = ref(["none", "none"]);
const displayValidExpTarjeta = ref(["none", "none"]);
const displayValidCVC = ref(["none", "none"]);

const usuario = ref({
  //step 1
  email: "",
  nombre: "",
  apellidos: "",
  telefono: "",
  ciudad: "",
  contrasena: "",
  rol: 3,
  //step 2
  n_tarjeta: "",
  titular_tarjeta: "",
  caducidad_tarjeta: "",
  cvv_tarjeta: "",
});

const hasSeenCongrats = ref(false);
const finalMessage = ref(
  "TU CUENTA SE HA CREADO CON EXITO, YA PUEDES INICIAR SESION. "
);

onMounted(async () => {
  ciudades.value = await fetchCiudades();
});

const prev = () => {
  step.value--;
};

const next = () => {
  if (validarStep1()) step.value++;
};

const validarStep1 = () => {
  if (regFormCheck.checkMail(usuario.value.email)) {
    displayValidMail.value[0] = "none";
    displayValidMail.value[1] = "block";
  } else {
    displayValidMail.value[0] = "block";
    displayValidMail.value[1] = "none";
    return false;
  }

  if (regFormCheck.checkNombre(usuario.value.nombre)) {
    displayValidNombre.value[0] = "block";
    displayValidNombre.value[1] = "none";
  } else {
    displayValidNombre.value[0] = "none";
    displayValidNombre.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkTelefono(usuario.value.telefono)) {
    displayValidTelefono.value[0] = "block";
    displayValidTelefono.value[1] = "none";
  } else {
    displayValidTelefono.value[0] = "none";
    displayValidTelefono.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkNombre(usuario.value.apellidos)) {
    displayValidApellido.value[0] = "block";
    displayValidApellido.value[1] = "none";
  } else {
    displayValidApellido.value[0] = "none";
    displayValidApellido.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkContrasena(usuario.value.contrasena)) {
    displayValidContra.value[0] = "block";
    displayValidContra.value[1] = "none";
  } else {
    displayValidContra.value[0] = "none";
    displayValidContra.value[1] = "block";
    return false;
  }

  return true;
};
const validarStep2 = () => {
  if (regFormCheck.checkTarjeta(usuario.value.n_tarjeta)) {
    displayValidTarjeta.value[0] = "block";
    displayValidTarjeta.value[1] = "none";
  } else {
    displayValidTarjeta.value[0] = "none";
    displayValidTarjeta.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkNombre(usuario.value.titular_tarjeta)) {
    displayValidNombreTarjeta.value[0] = "block";
    displayValidNombreTarjeta.value[1] = "none";
  } else {
    displayValidNombreTarjeta.value[0] = "none";
    displayValidNombreTarjeta.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkExpTarjeta(usuario.value.caducidad_tarjeta)) {
    displayValidExpTarjeta.value[0] = "block";
    displayValidExpTarjeta.value[1] = "none";
  } else {
    displayValidExpTarjeta.value[0] = "none";
    displayValidExpTarjeta.value[1] = "block";
    return false;
  }

  if (regFormCheck.checkCvcTarjeta(usuario.value.cvv_tarjeta)) {
    displayValidCVC.value[0] = "block";
    displayValidCVC.value[1] = "none";
  } else {
    displayValidCVC.value[0] = "none";
    displayValidCVC.value[1] = "block";
    return false;
  }
  return true;
};

const register = async () => {
  if (validarStep2()) {
    hasSeenCongrats.value = true;
    const data = await authService.register(usuario.value);
    if (!data.success)
      finalMessage.value = data.error ? `ERROR: ${data.error}` : "ERROR";
  }
};

async function fetchCiudades() {
  const response = await ciudadService.getCiudades();
  let cius = [];
  if (response.success) {
    response.ciudades.forEach((ciudad) => {
      cius.push({ id: ciudad.id, nombre: ciudad.nombre });
    });
  }
  return cius;
}
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

.validFeedback {
  color: green;
  display: block;
  text-align: center;
  width: 100%;
  max-width: 12rem;
  margin: 0.5rem;
  overflow-wrap: break-word;
}

.invalidFeedback {
  color: red;
  display: block;
  text-align: center;
  width: 100%;
  max-width: 12rem;
  margin: 0.5rem;
  overflow-wrap: break-word;
}

.input-group {
  position: relative;
  display: flex;
  flex-direction: column;
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

.form{
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.register .form-group {
  display: flex;
  flex-flow: row;
  justify-content: flex-start;
  align-items: baseline;
  gap: 1.5rem;
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
.cta{
  display: flex;
  justify-content: center;
}

.register .form-group.new-password {
  margin-top: 2rem;
}

.register .cta-color,
.register .cta-color input,
.register .cta-color .link_text {
  color: #ffc000;
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

.submit-next-button {
  background-color: #ffc000; /* Color de fondo */
  color: white; /* Color del texto */
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px; /* Espacio entre texto e imagen */
}
.submit-next-button:hover {
  background-color: #ffcb2d; 
    transform: scale(1.1); 
    box-shadow: 0 18px 25px #162430; 
}

.icono-flecha {
  width: 32px;
  height: 32px;
}

.icono-flecha-atras {
  width: 32px;
  height: 32px;
  transform: rotate(180deg);
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
