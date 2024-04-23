<script setup>

</script>

<template>
    <div class="div">
        <div class="div-2">
            <div class="div-3">
                <img loading="lazy" srcSet="/img/logo.jpg" class="img" />
                <div class="div-4">
                    <div class="div-5">INICIO</div>
                    <div class="div-6">VIAJA</div>
                    <div class="div-7">CONDUCE</div>
                </div>
                <div class="div-8">
                    <div class="div-9">Iniciar Sesión</div>
                    <div class="div-10">Registrarse</div>
                </div>
            </div>
        </div>

    </div>
</template>



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

.div-2 {
    position: relative;
    background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
    display: flex;
    width: 100%;
    align-items: center;
    font-weight: 700;
    justify-content: center;
    padding: 14px 60px;
}

@media (max-width: 991px) {
    .div-2 {
        max-width: 100%;
        padding: 0 20px;
    }
}

.div-3 {
    display: flex;
    width: 1190px;
    max-width: 100%;
    align-items: center;
    gap: 20px;
    justify-content: space-between;
    padding: 0 2px;
}

@media (max-width: 991px) {
    .div-3 {
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

.div-4 {
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
    .div-4 {
        white-space: initial;
    }
}

.div-5 {
    color: var(--primario, #ffc000);
    -webkit-text-stroke-width: 1;
    -webkit-text-stroke-color: var(--negro, #000);
    font-family: K2D, sans-serif;

}

.div-6 {
    -webkit-text-stroke-width: 1;
    -webkit-text-stroke-color: var(--negro, #000);
    font-family: K2D, sans-serif;

}

.div-7 {
    -webkit-text-stroke-width: 1;
    -webkit-text-stroke-color: var(--negro, #000);
    font-family: K2D, sans-serif;

}

.div-8 {
    align-self: stretch;
    display: flex;
    gap: 20px;
    font-size: 15px;
    line-height: 133%;
    justify-content: space-between;
    margin: auto 0;
}

.div-9 {
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
}

.div-10 {
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
}

@media (max-width: 991px) {
    .div-10 {
        white-space: initial;
    }
}
</style>