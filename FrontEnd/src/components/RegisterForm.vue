<template>
  <div class="regForm">
    <section class="register" v-if="!hasSeenCongrats">
      <h2 class="register-title">{{ titulos[step - 1] }}</h2>

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
        <div
          class="step"
          :class="{ 'step-active': step === 3, 'step-done': step > 3 }"
        >
          <span class="step-number">3</span>
        </div>
        <div
          class="step"
          :class="{ 'step-active': step === 4, 'step-done': step > 4 }"
        >
          <span class="step-number">4</span>
        </div>
      </div>

      <transition name="slide-fade">
        <section v-show="step === 1">
          <form class="form" method="post" action="#" @submit.prevent="next">
            <div class="form-group">
              <input
                id="loyaltyCivilityMr"
                type="radio"
                value="1"
                v-model="customer.gender"
              />
              <label class="input-label" for="loyaltyCivilityMr">Mr.</label>

              <input
                id="loyaltyCivilityMrs"
                type="radio"
                value="2"
                v-model="customer.gender"
              />
              <label class="input-label" for="loyaltyCivilityMrs">Mrs.</label>
            </div>

            <div class="form-group">
              <input
                type="text"
                v-model="customer.firstName"
                autocomplete="customer.firstName"
                placeholder="First name"
                required
              />
              <input
                type="text"
                v-model="customer.lastName"
                autocomplete="customer.lastName"
                placeholder="Last name"
                required
              />
            </div>

            <div class="form-group">
              <input
                type="tel"
                v-model="customer.phoneNumber"
                autocomplete="customer.phoneNumber"
                placeholder="Phone number"
                minlength="9"
                maxlength="10"
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
                  <input type="submit" value="Next" class="link_text" />
                  <span class="arrow-next"></span>
                </span>
              </p>
            </div>
          </form>
        </section>
      </transition>
      <transition name="slide-fade">
        <section v-show="step === 2">
          <form class="form" method="post" action="#" @submit.prevent="next">
            <div class="form-group">
              <input
                type="text"
                v-model="customer.address"
                autocomplete="customer.address"
                placeholder="Address"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="text"
                v-model="customer.zipCode"
                autocomplete="customer.zipCode"
                placeholder="Zip Code"
                minlength="5"
                maxlength="5"
                required
              />
              <input
                type="text"
                v-model="customer.city"
                autocomplete="customer.city"
                placeholder="City"
                required
              />
            </div>

            <div class="form-group cta-step">
              <div class="cta prev">
                <p class="cta-color">
                  <span class="link_wrap">
                    <a class="link_text" href="#" @click.prevent="prev()"
                      ><span class="arrow-prev"></span>Previous
                    </a>
                  </span>
                </p>
              </div>
              <div class="cta">
                <p class="cta-color">
                  <span class="text"></span>
                  <span class="link_wrap">
                    <input type="submit" value="Next" class="link_text" />
                    <span class="arrow-next"></span>
                  </span>
                </p>
              </div>
            </div>
          </form>
        </section>
      </transition>
      <transition name="slide-fade">
        <section v-show="step === 3">
          <form class="form" action="#" @submit.prevent="customerRegister">
            <div class="form-group">
              <input
                type="email"
                v-model="customer.eMail"
                autocomplete="customer.eMail"
                placeholder="Email"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="date"
                v-model="customer.birthDay"
                placeholder="Birthday ('day'/'month'/'year')"
                required
              />
            </div>

            <div class="form-group cta-step">
              <div class="cta prev">
                <p class="cta-color">
                  <span class="link_wrap">
                    <a class="link_text" href="#" @click.prevent="prev()"
                      ><span class="arrow-prev"></span>Previous
                    </a>
                  </span>
                </p>
              </div>
            </div>
            <div class="register-btn">
              <input type="submit" value="Créer mon compte" />
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

const steps = ref({});
const step = ref(1);
const titulos = ["PERSONAL", "TARJETA", "CONDUCTOR", "INFO VEHICULO"];

const customer = ref({
  gender: "1",
  firstName: "",
  lastName: "",
  phoneNumber: "",
  address: "",
  zipCode: "",
  city: "",
  birthDay: "",
  termOfService: "",
  pinCode: "",
  eMail: "",
});

const hasSeenCongrats = ref(false);

const tempCustomer = ref({
  gender: "",
  firstName: "",
  lastName: "",
  phoneNumber: "",
  address: "",
  zipCode: "",
  city: "",
  birthDay: "",
  termOfService: "",
  pinCode: "",
  eMail: "",
});

// Métodos del componente
const prev = () => {
  step.value--;
};

const next = () => {
  step.value++;
};

const customerRegister = () => {
  hasSeenCongrats.value = true;
};
</script>

<style>
body {
  background-color: var(--oscuro1, #162430);
  /* font: italic 800 30px K2D, sans-serif; */
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
  font-family: "Montserrat", sans-serif;
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

.register-title {
  font-weight: 400;
  font-size: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 0.2rem;
  text-align: center;
  color: #fff;
  padding: 0 2rem;
  margin-top: 2rem;
  margin-bottom: 3rem;
}

.register-stepper {
  display: flex;
  justify-content: space-between;
  width: 100%;
  position: relative;
  margin: 0 auto 1.5em;
}

.register-stepper::before {
  z-index: 0;
  content: "";
  display: block;
  position: absolute;
  height: 2px;
  top: calc(50% - 1px);
  background: #cecece;
  width: calc(100% - 20px);
}

.register-stepper .step {
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2;
  border: 2px solid #cecece;
  color: #cecece;
  background-color: #fff;
  border-radius: 50%;
  min-width: 25px;
  min-height: 25px;
  line-height: 20px;
  font-size: 16px;
}

.register-stepper .step-active {
  color: #00c4b5;
  background-color: #fff;
  border-color: #00c4b5;
}

.register-stepper .step-done {
  color: #a7e4b5;
  border-color: #a7e4b5;
}

.register-stepper .step-number {
  font-family: "Montserrat", sans-serif;
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
  justify-content: space-between;
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
  font-family: "Montserrat", sans-serif;
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
  content: "<";
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
  content: ">";
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

input[type="submit"],
input[type="text"],
input[type="tel"],
input[type="email"],
input[type="date"] {
  -webkit-appearance: none;
  border: 0;
  border-radius: 5px;
  padding: 1.3rem 1rem;
  width: 100%;
  margin: 0.5rem;
}

input[type="submit"] {
  cursor: pointer;
  position: relative;
  padding-right: 36px;
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

.register-btn input {
  color: #fff;
  font-size: 1.2rem;
  font-family: "Montserrat", sans-serif;
  font-weight: 800;
  line-height: 1;
  width: fit-content;
  background: linear-gradient(145deg, #1b3c05, #173205);
  box-shadow: 20px 20px 60px #142c04, -20px -20px 60px #1f4406;
}

.register-btn input:hover {
  background: linear-gradient(145deg, #173205, #1b3c05);
  box-shadow: 20px 20px 60px #142c04, -20px -20px 60px #1f4406;
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
