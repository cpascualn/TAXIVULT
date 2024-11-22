<template>
  <nav class="div">
    <div :class="$route.path === '/viaja' ? 'background--viaja' : 'background'">
      <div class="header">
        <router-link :to="{ name: 'homeComp' }" class="nav__link--active">
          <img loading="lazy" srcSet="/img/logo.jpg" class="img" />
        </router-link>

        <div class="nav">
          <router-link
            :to="{ name: 'home' }"
            :class="{ 'nav__link active': $route.path === '/' }"
            class="nav__link"
          >
            INICIO</router-link
          >
          <router-link
            :to="{ name: 'viaja' }"
            :class="{ 'nav__link active': $route.path === '/viaja' }"
            class="nav__link"
            >VIAJA</router-link
          >
          <router-link
            :to="{ name: 'conduce' }"
            :class="{ 'nav__link active': $route.path === '/conduce' }"
            class="nav__link"
            >CONDUCE</router-link
          >
        </div>

        <div class="buttons" v-if="token">
          <div class="viajes" @click="redirigirViajes">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/7d78f584f4528b1b3fa093f16102020cbac643872414eba8da81aab8620f1319?"
              class="img--viaje"
            />
            <p class="viaje--txt">Mis viajes</p>
          </div>

          <div @click="redirigirDash" class="usuario">
            <img
              loading="lazy"
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/18070c5c704d2146192df4332b603c7d0418703aec817cbd2c1fb32679b39bf4?"
              class="acc--img"
            />
          </div>
        </div>
        <div class="buttons" v-else>
          <router-link :to="{ name: 'login' }" class="logIn"
            >Iniciar Sesión</router-link
          >
          <router-link :to="{ name: 'register' }" class="Sign"
            >Registrarse</router-link
          >
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
const token = localStorage.getItem("authToken");
const redirigirDash = () => {
  window.location.href = "/dashboard/profile";
};
const redirigirViajes = () => {
  window.location.href = "/dashboard/viajes";
};
</script>

<style scoped>
.div {
  display: flex;
  flex-direction: column;
  overflow: hidden;
  position: relative;
  width: 100%;
  text-align: center;
  z-index: 100;
}

@media (max-width: 991px) {
  .div {
    max-width: 100%;
  }
}

.background {
  position: relative;
  background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
  display: flex;
  width: 100%;
  align-items: center;
  font-weight: 700;
  justify-content: center;
  padding: 14px 60px;
}

.background--viaja {
  position: relative;
  background-color: var(--oscuro-header, rgba(10, 21, 27, 1));
  display: flex;
  width: 100%;
  align-items: center;
  font-weight: 700;
  justify-content: center;
  padding: 14px 60px;
}

@media (max-width: 991px) {
  .background {
    max-width: 100%;
    padding: 0 20px;
  }
}

.header {
  display: flex;
  width: 1190px;
  max-width: 100%;
  align-items: center;
  gap: 20px;
  justify-content: space-between;
  padding: 0 2px;
}

@media (max-width: 991px) {
  .header {
    flex-wrap: wrap;
  }
}

.img {
  aspect-ratio: 1.85;
  object-fit: cover;
  object-position: center;
  width: 172px;
  align-self: stretch;
  max-width: 100%;
}

.nav {
  align-self: stretch;
  display: flex;
  gap: 1.5rem;
  font-size: 20px;
  color: var(--blanco, #fff);
  white-space: nowrap;
  line-height: 80%;
  margin: auto 0;
}

@media (max-width: 991px) {
  .nav {
    white-space: initial;
  }
}

.nav__link {
  color: var(--blanco, #fff);
  -webkit-text-stroke-width: 1;
  -webkit-text-stroke-color: var(--negro, #000);
  font-family: K2D, sans-serif;
  text-decoration: none;
}

.nav__link.active {
  color: var(--primario, #ffc000);
}

.buttons {
  align-self: stretch;
  display: flex;
  gap: 20px;
  font-size: 15px;
  line-height: 133%;
  justify-content: space-between;
  margin: auto 0;
  /* flex-direction: column; */
}

.logIn {
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

.Sign {
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

@media (max-width: 991px) {
  .Sign {
    white-space: initial;
  }
}

.viajes {
  justify-content: center;
  display: flex;
  gap: 10px;
  margin: auto 0;
  padding: 0 0.1rem;
  text-decoration: none;
}

.viajes:hover {
  cursor: pointer;
}

.usuario:hover {
  cursor: pointer;
}
@media (max-width: 991px) {
  .viajes {
    padding: 0 20px;
  }
}
.img--viaje {
  aspect-ratio: 0.5;
  object-fit: auto;
  object-position: center;
  width: 20px;
}
.viaje--txt {
  font-family: K2D, sans-serif;
  margin: auto 0;
  color: white;
}

.acc--img {
  aspect-ratio: 1;
  object-fit: auto;
  object-position: center;
  width: 70px;
}
</style>
