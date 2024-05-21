<template>
  <div class="container">
    <div class="head__wrapper">
      <router-link to="/" class="button-2"> INICIO</router-link>
      <div class="opciones" v-if="$route.path === '/register'">
        <router-link to="/register/user" class="button"
          >Registrarse Como pasajero</router-link
        >
        <router-link to="/register/driver" class="button"
          >Registrarse Como conductor</router-link
        >
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script setup></script>

<style scoped>
html,
body {
  height: 100%;
  margin: 0;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  flex-direction: column;
  background: #162430;
}

.button {
  font-family: K2D, sans-serif;
  justify-content: center;
  border-radius: 8px;
  box-shadow: 999px 999px 0px 0px rgba(0, 0, 0, 0.08) inset;
  border-color: rgba(0, 0, 0, 1);
  border-style: solid;
  border-width: 1px;
  background-color: #ffc000;
  color: var(--Content-contentPrimary, var(--negro, #000));
  white-space: nowrap;
  padding: 6px 12px;
  font-weight: 600;
  text-decoration: none;
}

.button-2 {
  font-family: K2D, sans-serif;
  justify-content: center;
  border-radius: 8px;
  box-shadow: 999px 999px 0px 0px rgba(255, 255, 255, 0) inset;
  border-color: rgba(255, 192, 0, 1);
  border-style: solid;
  border-width: 1px;
  color: var(--Inverse-Content-contentInversePrimary, var(--blanco, #fff));
  padding: 6px 7px;
  font-weight: 500;
  text-decoration: none;
}

.opciones {
  display: flex;
  gap: 1rem;
  padding: 2rem;
}

.head__wrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>
