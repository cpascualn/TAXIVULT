<template>
  <div class="login-page">
    <div class="login-container">
      <div class="login-content">
        <div class="image-column">
          <img
            src="/img/loginFoto.jpg"
            alt="Login page image"
            class="login-image"
          />
        </div>
        <div class="form-column">
          <div class="form-wrapper">
            <header class="logo-wrapper">
              <img
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/b15c9c15460a878efaa70989d161f75b407bf1e3e628374e2df3d2f62b99a1d3?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
                alt="Company logo"
                class="logo-image"
              />
            </header>
            <div class="form-content">
              <div class="form-card">
                <div class="form-header">
                  <h2 class="welcome-text">Bienvenido de nuevo</h2>
                </div>
                <form @submit="submitForm" class="login-form">
                  <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                      <input
                        v-model="mail"
                        type="text"
                        id="email"
                        class="form-input"
                        placeholder="Email"
                      />
                    </div>
                    <div
                      class="validFeedback"
                      :style="{ display: displayValidMail }"
                    >
                      Correcto
                    </div>
                    <div
                      class="invalidFeedback"
                      :style="{ display: displayInvalidMail }"
                    >
                      {{ invalidMailMessage }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                      <input
                        v-model="password"
                        :type="passw"
                        id="password"
                        class="form-input"
                        placeholder="Enter password"
                      />
                      <div @click="showPassword" class="password-toggle">
                        <img
                          src="https://cdn.builder.io/api/v1/image/assets/TEMP/09ca2b0c86ba8f95547f11d5cfe48f5ffbdb8cfd050e5d4a2809f41a8290b8c1?apiKey=601f2040cd0c43f79e782a307ce6d5d5&"
                          alt="Toggle password visibility"
                          class="toggle-icon"
                        />
                      </div>
                    </div>
                    <div
                      class="validFeedback"
                      :style="{ display: displayValidPass }"
                    >
                      Correcto
                    </div>
                    <div
                      class="invalidFeedback"
                      :style="{ display: displayInvalidPass }"
                    >
                      {{ invalidPassMessage }}
                    </div>
                  </div>
                  <div class="form-options">
                    <div class="remember-me">
                      <div class="checkbox-wrapper">
                        <input
                          type="checkbox"
                          id="rememberMe"
                          class="checkbox-input"
                        />
                        <label for="rememberMe" class="checkbox-label"></label>
                      </div>
                      <span class="remember-text">Remember me</span>
                    </div>
                  </div>
                  <button type="submit" class="login-button">Sign in</button>
                </form>
                <div class="form-divider"></div>
                <div class="signup-link">
                  <span class="no-account">Dont have an account?</span>

                  <RouterLink :to="{ name: 'register' }" class="signup-now"
                    >Sign up now</RouterLink
                  >
                </div>
              </div>
            </div>
            <footer class="footer">
              <RouterLink to="/" class="footer-content">TAXIVULT </RouterLink>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import authService from "@/services/auth.service";

const mail = ref("");
const password = ref("");
const passw = ref("password");
const invalidMailMessage = ref("El email no es correcto");
const invalidPassMessage = ref(
  "la contraseña debe tener al menos una letra, al menos un número y una longitud mínima de 8 caracteres."
);

const displayValidMail = ref("none");
const displayInvalidMail = ref("none");
const displayValidPass = ref("none");
const displayInvalidPass = ref("none");

const router = useRouter();

const showPassword = () => {
  passw.value = passw.value === "password" ? "text" : "password";
};

const submitForm = async (event) => {
  event.preventDefault();

  let mailCorrect = checkMail();
  let passCorrect = checkPass();
  if (!mailCorrect || !passCorrect) {
    event.preventDefault();
  } else {
    const user = {
      email: mail.value,
      password: password.value,
    };

    try {
      const data = await authService.login(user);
      if (!data.success) throw new Error(data.error);
      router.push("/");
    } catch (error) {
      console.error("Error en el login:", error);
    }
  }
};

const checkMail = () => {
  const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  if (regexCorreo.test(mail.value)) {
    displayValidMail.value = "block";
    displayInvalidMail.value = "none";
    return true;
  } else {
    displayValidMail.value = "none";
    displayInvalidMail.value = "block";
    return false;
  }
};

const checkPass = () => {
  const regexPassword = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;

  if (regexPassword.test(password.value)) {
    displayValidPass.value = "block";
    displayInvalidPass.value = "none";
    return true;
  } else {
    displayValidPass.value = "none";
    displayInvalidPass.value = "block";
    return false;
  }
};
</script>

<style scoped>
.login-page {
  background-color: var(--oscuro1, #0a151b);
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.login-container {
  background-color: var(--oscuro2, #162430);
  padding: 3rem 10vw;
  width: 100%;
}

@media (max-width: 991px) {
  .login-container {
    max-width: 100%;
    padding-right: 20px;
  }
}

.login-content {
  display: flex;
  gap: 20px;
}

@media (max-width: 991px) {
  .login-content {
    align-items: stretch;
    flex-direction: column;
    gap: 0;
  }
}

.image-column {
  line-height: normal;
  margin-left: 0;
  width: 50%;
  display: flex;
  max-height: 100%;
}

@media (max-width: 991px) {
  .image-column {
    width: 100%;
  }
}

.login-image {
  aspect-ratio: 1;
  object-fit: contain;
  width: 100%;
}

@media (max-width: 991px) {
  .login-image {
    margin-top: 40px;
    max-width: 100%;
  }
}

.form-column {
  line-height: normal;
  width: 50%;
  max-height: 100%;
}

@media (max-width: 991px) {
  .form-column {
    width: 100%;
  }
}

.form-wrapper {
  align-self: stretch;
  background-color: #0b151c;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  justify-content: space-between;
  padding: 4vw;
  width: 100%;
  height: 100%;
}

@media (max-width: 991px) {
  .form-wrapper {
    margin-top: 40px;
    max-width: 100%;
    padding: 0 20px;
  }
}

.logo-wrapper {
  align-items: center;
  display: flex;
  justify-content: center;
  max-width: 100%;
  width: 149px;
}

.logo-image {
  width: 100%;
}

.form-content {
  display: flex;
  flex-direction: column;
  margin-top: 48px;
}

@media (max-width: 991px) {
  .form-content {
    margin-top: 40px;
    max-width: 100%;
  }
}

.form-card {
  border-radius: 8px;
  box-shadow: 0 3px 24px rgba(26, 26, 26, 0.1);
  display: flex;
  flex-direction: column;
}

@media (max-width: 991px) {
  .form-card {
    max-width: 100%;
  }
}

.form-header {
  display: flex;
  flex-direction: column;
}

@media (max-width: 991px) {
  .form-header {
    max-width: 100%;
  }
}

.welcome-text {
  color: var(--blanco, #fff);
  font: 600 20px/140% Poppins, sans-serif;
}

@media (max-width: 991px) {
  .welcome-text {
    max-width: 100%;
  }
}

.login-form {
  display: flex;
  flex-direction: column;
  margin-top: 25px;
  gap: 25px;
}

@media (max-width: 991px) {
  .login-form {
    max-width: 100%;
  }
}

.form-group {
  display: flex;
  flex-direction: column;
  font-weight: 400;
  justify-content: center;
  gap: 20px;
}

@media (max-width: 991px) {
  .form-group {
    max-width: 100%;
  }
}

.form-label {
  color: var(--blanco, #fff);
  font: 16px/109% K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  justify-content: center;
  letter-spacing: 0.3px;
  white-space: nowrap;
}

@media (max-width: 991px) {
  .form-label {
    max-width: 100%;
    white-space: initial;
  }
}

.input-wrapper {
  background-color: var(--black-50-f-2-f-2-f-2, #f2f2f2);
  border: 1px solid rgba(229, 229, 229, 1);
  border-radius: 6px;
  color: var(--black-500808080, #808080);
  display: flex;
  font-size: 15px;
  justify-content: center;
  line-height: 133%;
  margin-top: 8px;
}

@media (max-width: 991px) {
  .input-wrapper {
    max-width: 100%;
  }
}

.form-input {
  align-items: start;
  border-radius: 6px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 1rem;
  width: 100%;
  background: transparent;
  border: none;
}

@media (max-width: 991px) {
  .form-input {
    max-width: 100%;
    padding-right: 20px;
  }
}

.form-input::placeholder {
  font-family: Roboto, sans-serif;
  justify-content: center;
}

.password-toggle {
  align-items: center;
  display: flex;
  justify-content: center;
  padding: 8px;
  cursor: pointer;
  background: transparent;
  border: none;
}

.toggle-icon {
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
  width: 16px;
}

.form-options {
  display: flex;
  gap: 16px;
  margin-top: 20px;
}

@media (max-width: 991px) {
  .form-options {
    flex-wrap: wrap;
  }
}

.remember-me {
  display: flex;
  flex: 1;
  gap: 8px;
}

.checkbox-wrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.checkbox-input {
  display: none;
}

.checkbox-label {
  background-color: var(--black-50-f-2-f-2-f-2, #ff0000);
  border: 1px solid rgba(229, 229, 229, 1);
  border-radius: 36.5px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  width: 2vw;
  height: 3vh;
}

.checkbox-label::before {
  background-color: var(--blanco, #fff);
  border-radius: 12px;
  box-shadow: 1px 1px 2px -1px rgba(51, 51, 51, 0.3);
  content: "";
  height: 16px;
  left: 2px;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  transition: transform 0.2s ease-in-out;
  width: 16px;
}

.checkbox-input:checked + .checkbox-label::before {
  transform: translate(16px, -50%);
}

.checkbox-input:checked + .checkbox-label {
  background-color: green;
}

.remember-text {
  color: var(--blanco, #fff);
  flex: 1;
  font: 400 12px/167% K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  letter-spacing: 0.3px;
}

.forgot-password {
  color: var(--primario, #ffc000);
  flex: 1;
  font: 400 12px/167% K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  letter-spacing: 0.3px;
  text-align: right;
}

.login-button {
  align-items: center;
  background-color: var(--primario, #ffc000);
  border-radius: 6px;
  color: var(--white-ffffff, var(--blanco, #fff));
  font: 700 15px/133% Roboto, sans-serif;
  justify-content: center;
  letter-spacing: 0.3px;
  margin-top: 32px;
  padding: 10px 24px;
  text-align: center;
}

@media (max-width: 991px) {
  .login-button {
    max-width: 100%;
    padding: 0 20px;
  }
}

.form-divider {
  background-color: var(--black-100-e-5-e-5-e-5, #e5e5e5);
  height: 1px;
  margin-top: 32px;
}

@media (max-width: 991px) {
  .form-divider {
    max-width: 100%;
  }
}

.signup-link {
  align-self: center;
  display: flex;
  font-size: 12px;
  font-weight: 400;
  gap: 8px;
  letter-spacing: 0.3px;
  line-height: 167%;
  margin-top: 24px;
}

.no-account {
  color: var(--blanco, #fff);
  font-family: K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
}

.signup-now {
  color: var(--primario, #ffc000);
  font-family: K2D, sans-serif;
  font-feature-settings: "clig" off, "liga" off;
  text-align: right;
}

.footer {
  color: white;
  text-align: center;
  margin-top: 20px;
}
.footer-content {
  color: white;
  text-decoration: none;
}

.validFeedback {
  color: green;
  display: block;
}

.invalidFeedback {
  color: red;
  display: block;
}
</style>
