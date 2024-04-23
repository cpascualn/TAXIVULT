<template>
    <div class="div">
        <div class="div-2">
            <div class="div-3">
                <div class="column">
                    <div class="div-4">
                        <div class="div-5">TRABAJA CON NOSOTROS</div>
                        <div class="div-6">
                            Gana dinero usando tu propio coche transportando gente en tu
                            ciudad.
                        </div>
                        <div class="div-7">
                            <div class="div-8">1</div>
                            <div class="div-9">Ayuda a la gente a llegar a su destino</div>
                        </div>
                        <div class="div-10">
                            <div class="div-11">2</div>
                            <div class="div-12">Horario flexible</div>
                        </div>
                        <div class="div-13">
                            <div class="div-14">3</div>
                            <div class="div-15">Ventajas exclusivas</div>
                        </div>
                        <div class="div-16">PRIMEROS PASOS</div>
                    </div>
                </div>
                <div class="column-2">
                    <img loading="lazy" srcSet="/img/taxicar.jpg" class="img" />
                </div>
            </div>
        </div>
    </div>
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

.div-2 {
    width: 1222px;
    max-width: 100%;
}

.div-3 {
    gap: 20px;
    display: flex;
}

@media (max-width: 991px) {
    .div-3 {
        flex-direction: column;
        align-items: stretch;
        gap: 0px;
    }
}

.column {
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

.div-4 {
    display: flex;
    margin-top: 113px;
    flex-direction: column;
    font-size: 28px;
    text-align: center;
    line-height: 179%;
}

@media (max-width: 991px) {
    .div-4 {
        max-width: 100%;
        margin-top: 40px;
    }
}

.div-5 {
    color: var(--blanco, #fff);
    font: 400 55px/100% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-5 {
        max-width: 100%;
        font-size: 40px;
    }
}

.div-6 {
    color: var(--blanco, #fff);
    font-family: K2D, sans-serif;
    font-weight: 400;
    line-height: 50px;
    align-self: center;
    margin-top: 102px;
}

@media (max-width: 991px) {
    .div-6 {
        max-width: 100%;
        margin-top: 40px;
    }
}

.div-7 {
    display: flex;
    margin-top: 54px;
    gap: 20px;
}

@media (max-width: 991px) {
    .div-7 {
        max-width: 100%;
        flex-wrap: wrap;
        margin-top: 40px;
    }
}

.div-8 {
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
    .div-8 {
        white-space: initial;
        padding: 10px 25px;
    }
}

.div-9 {
    color: var(--blanco, #fff);
    font-family: K2D, sans-serif;
    font-weight: 400;
    flex-grow: 1;
    flex-basis: auto;
    margin: auto 0;
}

@media (max-width: 991px) {
    .div-9 {
        max-width: 100%;
    }
}

.div-10 {
    display: flex;
    margin-top: 30px;
    gap: 20px;
}

@media (max-width: 991px) {
    .div-10 {
        max-width: 100%;
        flex-wrap: wrap;
    }
}

.div-11 {
    font-family: K2D, sans-serif;
    background-color: var(--primario, #ffc000);
    border-radius: 50%;
    align-items: center;
    color: var(--negro, #000);
    font-weight: 800;
    white-space: nowrap;
    width: 70px;
    justify-content: center;
    height: 70px;
    padding: 10px 25px;
}

@media (max-width: 991px) {
    .div-11 {
        white-space: initial;
        padding: 10px 25px;
    }
}

.div-12 {
    color: var(--blanco, #fff);
    font-family: K2D, sans-serif;
    font-weight: 400;
    flex-grow: 1;
    flex-basis: auto;
    margin: auto 0;
}

.div-13 {
    display: flex;
    margin-top: 30px;
    gap: 20px;
}

@media (max-width: 991px) {
    .div-13 {
        max-width: 100%;
        flex-wrap: wrap;
    }
}

.div-14 {
    font-family: K2D, sans-serif;
    background-color: var(--primario, #ffc000);
    border-radius: 50%;
    align-items: center;
    color: var(--negro, #000);
    font-weight: 800;
    white-space: nowrap;
    width: 70px;
    justify-content: center;
    height: 70px;
    padding: 10px 25px;
}

@media (max-width: 991px) {
    .div-14 {
        white-space: initial;
        padding: 0 20px;
    }
}

.div-15 {
    color: var(--blanco, #fff);
    font-family: K2D, sans-serif;
    font-weight: 400;
    flex-grow: 1;
    flex-basis: auto;
    margin: auto 0;
}

@media (max-width: 991px) {
    .div-15 {
        max-width: 100%;
    }
}

.div-16 {
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
    margin-bottom: 15px
}

@media (max-width: 991px) {
    .div-16 {
        padding: 0 20px;
    }
}

.column-2 {
    display: flex;
    flex-direction: column;
    line-height: normal;
    width: 44%;
    margin-left: 20px;
}

@media (max-width: 991px) {
    .column-2 {
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