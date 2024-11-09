<template>
  <div class="regForm">
    <section class="register" v-if="!hasSeenCongrats">
      <h3 class="title">REGISTRESE COMO CONDUCTOR</h3>
      <div class="register-stepper">
        <div
          class="stepp"
          :class="{ 'stepp-active': step === 1, 'stepp-done': step > 1 }"
        >
          <span class="stepp-number">1</span>
        </div>
        <div
          class="stepp"
          :class="{ 'stepp-active': step === 2, 'stepp-done': step > 2 }"
        >
          <span class="stepp-number">2</span>
        </div>
        <div
          class="stepp"
          :class="{ 'stepp-active': step === 3, 'stepp-done': step > 3 }"
        >
          <span class="stepp-number">3</span>
        </div>
        <div
          class="stepp"
          :class="{ 'stepp-active': step === 4, 'stepp-done': step > 4 }"
        >
          <span class="stepp-number">4</span>
        </div>
      </div>

      <h2 class="register-title">{{ titulos[step - 1] }}</h2>

      <transition name="slide-fade">
        <section v-show="step === 1">
          <form novalidate class="form" @submit.prevent="next">
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
          <form novalidate class="form" method="post" @submit.prevent="next">
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.n_tarjeta"
                  autocomplete="usuario.n_tarjeta"
                  placeholder="numero iban "
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
                  El iban no es correcto (debe ser ESXX XXXX XXXX XXXX XXXX
                  XXXX)
                </div>
              </div>

              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.titular_tarjeta"
                  autocomplete="usuario.titular_tarjeta"
                  placeholder="Titular de la cuenta"
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
                  El titular no es correcto
                </div>
              </div>
            </div>

            <div class="form-group cta-step">
              <div class="cta prev">
                <button class="submit-next-button" @click.prevent="prev()">
                  <img
                    src="/src/assets/img/flecha-correcta.png"
                    alt=""
                    class="icono-flecha-atras"
                  />
                </button>
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
            </div>
          </form>
        </section>
      </transition>

      <transition name="slide-fade">
        <section v-show="step === 3">
          <form novalidate class="form" method="post" @submit.prevent="next">
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.dni"
                  autocomplete="usuario.dni"
                  placeholder="dni"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidDNI[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidDNI[1] }"
                >
                  El DNI debe tener 8 numeros y 1 LETRA
                </div>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.licenciaVTC"
                  autocomplete="usuario.licenciaVTC"
                  placeholder="licencia VTC (VTC-123456)"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidVTC[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidVTC[1] }"
                >
                  La licencia vtc debe tener 3 letras y 6 numeros
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <select name="horario" v-model="usuario.horario" required>
                  <option disabled selected value="">Horario</option>
                  <option
                    v-for="item in horarios"
                    :key="item.id"
                    :value="item.id"
                  >
                    {{ item.name }}
                  </option>
                </select>

                <div
                  class="validFeedback"
                  :style="{ display: displayValidHorario[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidHorario[1] }"
                >
                  Selecciona un Horario
                </div>
              </div>

              <div class="buscador">
                <input
                  type="text"
                  id="cityInput"
                  v-model="cityName"
                  placeholder="Barrio habitual"
                  @input="searchLocations"
                />
                <p v-if="errorMessage" style="color: red">{{ errorMessage }}</p>
                <p v-if="!errorMessage && cityName != ''" style="color: green">
                  Correcto
                </p>
                <ul v-if="locations.length > 0" class="desplegable">
                  <li
                    v-for="location in locations"
                    :key="location.place_id"
                    @click="selectLocation(location)"
                  >
                    {{ location.display_name }}
                  </li>
                </ul>
              </div>
            </div>

            <div class="form-group cta-step">
              <div class="cta prev">
                <button class="submit-next-button" @click.prevent="prev()">
                  <img
                    src="/src/assets/img/flecha-correcta.png"
                    alt=""
                    class="icono-flecha-atras"
                  />
                </button>
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
            </div>
          </form>
        </section>
      </transition>

      <transition name="slide-fade">
        <section v-show="step === 4">
          <form novalidate class="form" @submit.prevent="register">
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.matricula"
                  autocomplete="usuario.matricula"
                  placeholder="matricula"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidMatricula[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidMatricula[1] }"
                >
                  La Matricula debe tener 4 numeros y 3 letras
                </div>
              </div>

              <div class="input-group">
                <input
                  type="number"
                  v-model="usuario.capacidad"
                  autocomplete="usuario.capacidad"
                  placeholder="capacidad"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidCapacidad[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidCapacidad[1] }"
                >
                  La capacidad minima es de 5 plazas(turismo comun)
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.fabricante"
                  autocomplete="usuario.fabricante"
                  placeholder="fabricante"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidFabricante[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidFabricante[1] }"
                >
                  El fabricante es incorrecto
                </div>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  v-model="usuario.modelo"
                  autocomplete="usuario.modelo"
                  placeholder="modelo"
                />
                <div
                  class="validFeedback"
                  :style="{ display: displayValidModelo[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidModelo[1] }"
                >
                  el modelo es incorrecto
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <select name="tipo" v-model="usuario.tipo" required>
                  <option disabled selected value="">tipo</option>
                  <option v-for="item in tiposVehi" :key="item" :value="item">
                    {{ item }}
                  </option>
                </select>

                <div
                  class="validFeedback"
                  :style="{ display: displayValidTipoCoche[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidTipoCoche[1] }"
                >
                  Seleccione un tipo de vehiculo
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label for="image">Imagen del Vehiculo (opcional)</label>
                <input
                  type="file"
                  id="image"
                  accept="image/*"
                  @change="onImageChange"
                />

                <div
                  class="validFeedback"
                  :style="{ display: displayValidImagen[0] }"
                >
                  Correcto
                </div>
                <div
                  class="invalidFeedback"
                  :style="{ display: displayValidImagen[1] }"
                >
                  la imagen no contiene un vehiculo valido
                </div>
              </div>
            </div>
            <div class="form-group cta-step">
              <div class="cta prev">
                <button class="submit-next-button" @click.prevent="prev()">
                  <img
                    src="/src/assets/img/flecha-correcta.png"
                    alt=""
                    class="icono-flecha-atras"
                  />
                </button>
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
import encodeImageToBase64 from "@/assets/utils/imageEncoder";

const step = ref(1);
const titulos = [
  "PERSONAL",
  "INFORMACIÓN BANCARIA",
  "CONDUCTOR",
  "INFO VEHICULO",
];
const tiposVehi = ["comun", "van"];
const ciudades = ref(["Madrid"]);

const cityName = ref("");
const latitude = ref(null);
const longitude = ref(null);
const errorMessage = ref("");
const locations = ref([]);
const imageFile = ref(null);

// propiedades del css para mostrar los validadores, [0] para el correcto y [1] para el incorrecto
const displayValidMail = ref(["none", "none"]);
const displayValidNombre = ref(["none", "none"]);
const displayValidApellido = ref(["none", "none"]);
const displayValidContra = ref(["none", "none"]);
const displayValidTelefono = ref(["none", "none"]);
const displayValidCiudad = ref(["none", "none"]);

const displayValidTarjeta = ref(["none", "none"]);
const displayValidNombreTarjeta = ref(["none", "none"]);

const displayValidDNI = ref(["none", "none"]);
const displayValidVTC = ref(["none", "none"]);
const displayValidHorario = ref(["none", "none"]);

const displayValidMatricula = ref(["none", "none"]);
const displayValidCapacidad = ref(["none", "none"]);
const displayValidFabricante = ref(["none", "none"]);
const displayValidModelo = ref(["none", "none"]);
const displayValidTipoCoche = ref(["none", "none"]);
const displayValidImagen = ref(["none", "none"]);
// se reemplazaran por la llamada a la api
const horarios = [
  { id: 1, name: "diurno" },
  { id: 2, name: "nocturno" },
];
const usuario = ref({
  //step 1
  email: "",
  nombre: "",
  apellidos: "",
  telefono: "",
  ciudad: "",
  contrasena: "",
  rol: 2,
  //step 2
  n_tarjeta: "",
  titular_tarjeta: "",
  //step 3
  dni: "",
  licenciaVTC: "",
  latEspera: "",
  lonEspera: "",
  horario: "", // desplegable con los valores que llegen del servidor
  //step 4
  matricula: "",
  capacidad: "",
  fabricante: "",
  modelo: "",
  tipo: "",
  imagen: "", // desplegable con los valores que llegen del servidor
});

async function searchLocations() {
  try {
    const ciudad = ciudades.value.find(
      (ciudad) => ciudad.id === usuario.value.ciudad
    );
    const url = `https://nominatim.openstreetmap.org/search.php?street=${cityName.value}&city=${ciudad.nombre}&countrycodes=ES&format=jsonv2`;

    const response = await fetch(url);
    const data = await response.json();

    locations.value = data;
    errorMessage.value = "";
  } catch (error) {
    console.error("Error al buscar ubicaciones:", error);
    errorMessage.value = "Hubo un error al buscar las ubicaciones.";
  }
}

function selectLocation(location) {
  cityName.value = location.display_name;
  latitude.value = location.lat;
  longitude.value = location.lon;
  locations.value = [];

  // limitar la cadena a 12 digitos
  usuario.value.latEspera =
    location.lat.length > 12 ? location.lat.slice(0, 12) : location.lat;
  usuario.value.lonEspera =
    location.lon.length > 12 ? location.lon.slice(0, 12) : location.lon;
}

async function onImageChange(event) {
  const file = event.target.files[0];
  if (file && file.type.startsWith("image/")) {
    const result = await regFormCheck.checkImagenCoche(file);
    if (result) {
      imageFile.value = file;
      usuario.value.imagen = await encodeImageToBase64(file);
      displayValidImagen.value[0] = "block";
      displayValidImagen.value[1] = "none";
    } else {
      imageFile.value = null;
      usuario.value.imagen = null;
      displayValidImagen.value[0] = "none";
      displayValidImagen.value[1] = "block";
    }
  } else {
    imageFile.value = null;
    usuario.value.imagen = null;
    displayValidImagen.value[0] = "none";
    displayValidImagen.value[1] = "block";
    alert("Por favor, selecciona un archivo de imagen válido.");
  }
}

const hasSeenCongrats = ref(false);
const finalMessage = ref(
  "TU CUENTA SE HA CREADO CON EXITO, YA PUEDES INICIAR SESION. "
);

onMounted(async () => {
  ciudades.value = await fetchCiudades();
});

const validarStep1 = () => {
  let valid = true;
  if (regFormCheck.checkMail(usuario.value.email)) {
    displayValidMail.value[0] = "none";
    displayValidMail.value[1] = "block";
  } else {
    displayValidMail.value[0] = "block";
    displayValidMail.value[1] = "none";
    valid = false;
  }

  if (regFormCheck.checkNombre(usuario.value.nombre)) {
    displayValidNombre.value[0] = "block";
    displayValidNombre.value[1] = "none";
  } else {
    displayValidNombre.value[0] = "none";
    displayValidNombre.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkTelefono(usuario.value.telefono)) {
    displayValidTelefono.value[0] = "block";
    displayValidTelefono.value[1] = "none";
  } else {
    displayValidTelefono.value[0] = "none";
    displayValidTelefono.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkNombre(usuario.value.apellidos)) {
    displayValidApellido.value[0] = "block";
    displayValidApellido.value[1] = "none";
  } else {
    displayValidApellido.value[0] = "none";
    displayValidApellido.value[1] = "block";
    valid = false;
  }

  if (usuario.value.ciudad && usuario.value.ciudad != "") {
    displayValidCiudad.value[0] = "block";
    displayValidCiudad.value[1] = "none";
  } else {
    displayValidCiudad.value[0] = "none";
    displayValidCiudad.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkContrasena(usuario.value.contrasena)) {
    displayValidContra.value[0] = "block";
    displayValidContra.value[1] = "none";
  } else {
    displayValidContra.value[0] = "none";
    displayValidContra.value[1] = "block";
    valid = false;
  }

  return valid;
};
const validarStep2 = () => {
  let valid = true;
  if (regFormCheck.checkIban(usuario.value.n_tarjeta)) {
    displayValidTarjeta.value[0] = "block";
    displayValidTarjeta.value[1] = "none";
  } else {
    displayValidTarjeta.value[0] = "none";
    displayValidTarjeta.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkNombre(usuario.value.titular_tarjeta)) {
    displayValidNombreTarjeta.value[0] = "block";
    displayValidNombreTarjeta.value[1] = "none";
  } else {
    displayValidNombreTarjeta.value[0] = "none";
    displayValidNombreTarjeta.value[1] = "block";
    valid = false;
  }

  return valid;
};
const validarStep3 = () => {
  let valid = true;
  if (regFormCheck.checkDNI(usuario.value.dni)) {
    displayValidDNI.value[0] = "block";
    displayValidDNI.value[1] = "none";
  } else {
    displayValidDNI.value[0] = "none";
    displayValidDNI.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkVTC(usuario.value.licenciaVTC)) {
    displayValidVTC.value[0] = "block";
    displayValidVTC.value[1] = "none";
  } else {
    displayValidVTC.value[0] = "none";
    displayValidVTC.value[1] = "block";
    valid = false;
  }

  if (usuario.value.horario && usuario.value.horario != "") {
    displayValidHorario.value[0] = "block";
    displayValidHorario.value[1] = "none";
  } else {
    displayValidHorario.value[0] = "none";
    displayValidHorario.value[1] = "block";
    valid = false;
  }

  if (cityName.value == "") {
    errorMessage.value = "seleccione su barrio";
    valid = false;
  } else {
    errorMessage.value = "";
  }

  return valid;
};
const validarStep4 = () => {
  let valid = true;
  if (regFormCheck.checkMatricula(usuario.value.matricula)) {
    displayValidMatricula.value[0] = "block";
    displayValidMatricula.value[1] = "none";
  } else {
    displayValidMatricula.value[0] = "none";
    displayValidMatricula.value[1] = "block";
    valid = false;
  }

  if (usuario.value.capacidad >= 5) {
    displayValidCapacidad.value[0] = "block";
    displayValidCapacidad.value[1] = "none";
  } else {
    displayValidCapacidad.value[0] = "none";
    displayValidCapacidad.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkNomCoche(usuario.value.fabricante)) {
    displayValidFabricante.value[0] = "block";
    displayValidFabricante.value[1] = "none";
  } else {
    displayValidFabricante.value[0] = "none";
    displayValidFabricante.value[1] = "block";
    valid = false;
  }

  if (regFormCheck.checkNomCoche(usuario.value.modelo)) {
    displayValidModelo.value[0] = "block";
    displayValidModelo.value[1] = "none";
  } else {
    displayValidModelo.value[0] = "none";
    displayValidModelo.value[1] = "block";
    valid = false;
  }

  if (usuario.value.tipo && usuario.value.tipo != "") {
    displayValidTipoCoche.value[0] = "block";
    displayValidTipoCoche.value[1] = "none";
  } else {
    displayValidTipoCoche.value[0] = "none";
    displayValidTipoCoche.value[1] = "block";
    valid = false;
  }

  return valid;
};

const validaciones = [
  null,
  validarStep1,
  validarStep2,
  validarStep3,
  validarStep4,
];

const register = async () => {
  console.log(usuario.value);

  if (validarStep4()) {
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

const prev = () => {
  step.value--;
};

const next = () => {
  // Verifica si existe una función de validación para el paso actual y si pasa la validación
  if (validaciones[step.value] && validaciones[step.value]()) {
    step.value++;
  }
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

.register-stepper .stepp {
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

.register-stepper .stepp-active {
  color: black;
  background-color: #ffc000;
}

.register-stepper .stepp-done {
  color: black;
  background-color: #ffc000;
}

.register-stepper .stepp::before {
  z-index: 0;
  content: "";
  display: block;
  position: absolute;
  height: 4px;
  top: calc(50% - 1px);
  background: white;
  width: calc(30% - 50px);
  margin-left: 130px;
}

.register-stepper .stepp-done::before {
  z-index: 0;
  content: "";
  display: block;
  position: absolute;
  height: 4px;
  top: calc(50% - 1px);
  background: #ffc000;
  width: calc(30% - 50px);
  margin-left: 130px;
}

.register-stepper .stepp:last-child:before {
  display: none;
}

.register-stepper .stepp-number {
  font-family: "K2D", sans-serif;
  font-weight: 800;
  line-height: 1;
  vertical-align: middle;
}
.form {
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
.cta {
  display: flex;
  flex-direction: row;
  justify-content: center;
}
.register .form-group.cta-step {
  color: #fff;
  justify-content: center;
  align-items: center;
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
input[type="file"]::-webkit-file-upload-button {
  visibility: hidden; /* Ocultar texto */
}

input[type="file"] {
  cursor: pointer;
  border-radius: 5 rem;
  background-color: #ffc000;
  color: black; /* Ocultar texto */
  width: 100%;
  max-width: 100%;
  text-align: center;
}

input[type="file"]:hover {
  background-color: #ffcb2d;
  transform: scale(1.1);
  box-shadow: 0 18px 25px #162430;
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
