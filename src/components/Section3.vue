<template>
    <div class="div">
        <div class="div-2">
            <div class="div-3">NUESTROS DATOS</div>
            <div class="div-4">
                <div class="div-5">
                    <div class="column">
                        <div class="div-6">
                            <div class="div-7">
                                <img loading="lazy"
                                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/1c2fab37cb5f79e1eb3b9d5a848963d622b9ca8502f4f4589f7c738c222a104b?"
                                    class="img" />
                                <div class="div-8">10000</div>
                                <div class="div-9">KM CONDUCIDOS</div>
                            </div>
                        </div>
                    </div>
                    <div class="column-2">
                        <div class="div-10">
                            <div class="div-11">
                                <img loading="lazy"
                                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/3aaf3a5335ec9f85d94d71d880da9f25ddf7b065d118a368c4dc1fdbfc0adb2a?"
                                    class="img-2" />
                                <div class="div-12">100</div>
                                <div class="div-13">PASAJEROS</div>
                            </div>
                        </div>
                    </div>
                    <div class="column-3">
                        <div class="div-14">
                            <div class="div-15">
                                <img loading="lazy"
                                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/46ff6f3f4694f98e5c124cc57526aa43e5a025a301c49f4307b93959f5235895?"
                                    class="img-3" />
                                <div class="div-16">100</div>
                                <div class="div-17">CONDUCTORES</div>
                            </div>
                        </div>
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

.div-2 {
    display: flex;
    width: 1156px;
    max-width: 100%;
    flex-direction: column;
    margin: 40px 0 23px;
}

.div-3 {
    color: var(--blanco, #fff);
    text-align: center;
    align-self: center;
    font: 400 55px/41% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-3 {
        max-width: 100%;
        font-size: 40px;
    }
}

.div-4 {
    justify-content: space-between;
    margin-top: 101px;
}

@media (max-width: 991px) {
    .div-4 {
        max-width: 100%;
        margin-top: 40px;
    }
}

.div-5 {
    gap: 5%;
    display: flex;
}

@media (max-width: 991px) {
    .div-5 {
        flex-direction: column;
        align-items: stretch;
        gap: 0px;
    }
}

.column {
    display: flex;
    flex-direction: column;
    line-height: normal;
    width: 33%;
    margin-left: 0px;
}

@media (max-width: 991px) {
    .column {
        width: 100%;
    }
}

.div-6 {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    color: var(--primario, #ffc000);
    font-weight: 400;
    text-align: center;
    justify-content: center;
}

@media (max-width: 991px) {
    .div-6 {
        margin-top: 40px;
    }
}

.div-7 {
    border-radius: 20px;
    background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
    display: flex;
    flex-direction: column;
    padding: 51px 69px;
}

@media (max-width: 991px) {
    .div-7 {
        padding: 0 20px;
    }
}

.img {
    aspect-ratio: 1;
    object-fit: auto;
    object-position: center;
    width: 80px;
    align-self: center;
}

.div-8 {
    margin-top: 49px;
    font: 55px/41% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-8 {
        margin-top: 40px;
        font-size: 40px;
    }
}

.div-9 {
    margin-top: 42px;
    font: 20px/112% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-9 {
        margin-top: 40px;
    }
}

.column-2 {
    display: flex;
    flex-direction: column;
    line-height: normal;
    width: 33%;

}

@media (max-width: 991px) {
    .column-2 {
        width: 100%;
    }
}

.div-10 {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    color: var(--primario, #ffc000);
    font-weight: 400;
    text-align: center;
    justify-content: center;
}

@media (max-width: 991px) {
    .div-10 {
        margin-top: 40px;
    }
}

.div-11 {
    border-radius: 20px;
    background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 57px 80px;
}

@media (max-width: 991px) {
    .div-11 {
        padding: 0 20px;
    }
}

.img-2 {
    aspect-ratio: 1.32;
    object-fit: auto;
    object-position: center;
    width: 80px;
}

.div-12 {
    margin-top: 56px;
    font: 55px/41% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-12 {
        margin-top: 40px;
        font-size: 40px;
    }
}

.div-13 {
    margin-top: 42px;
    font: 20px/112% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-13 {
        margin-top: 40px;
    }
}

.column-3 {
    display: flex;
    flex-direction: column;
    line-height: normal;
    width: 33%;

}

@media (max-width: 991px) {
    .column-3 {
        width: 100%;
    }
}

.div-14 {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
    color: var(--primario, #ffc000);
    font-weight: 400;
    white-space: nowrap;
    text-align: center;
    justify-content: center;
}

@media (max-width: 991px) {
    .div-14 {
        margin-top: 40px;
        white-space: initial;
    }
}

.div-15 {
    border-radius: 20px;
    background-color: var(--oscuro-header, rgba(10, 21, 27, 0.95));
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 51px 79px;
}

@media (max-width: 991px) {
    .div-15 {
        white-space: initial;
        padding: 0 20px;
    }
}

.img-3 {
    aspect-ratio: 1;
    object-fit: auto;
    object-position: center;
    width: 80px;
}

.div-16 {
    margin-top: 49px;
    font: 55px/41% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-16 {
        margin-top: 40px;
        font-size: 40px;
    }
}

.div-17 {
    align-self: stretch;
    margin-top: 42px;
    font: 20px/112% K2D, sans-serif;
}

@media (max-width: 991px) {
    .div-17 {
        margin-top: 40px;
    }
}
</style>