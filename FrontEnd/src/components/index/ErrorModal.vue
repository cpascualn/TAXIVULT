<template>
  <div>
    <div :class="modalClass" id="exampleModalToggle">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="errormodal">
              {{ errorTitle }}
            </h1>
            <button
              type="button"
              class="btn-close"
              @click="closeModal"
            ></button>
          </div>
          <div class="modal-body">{{ errorMessage }}</div>
          <div class="modal-footer">
            <button class="btn btn-danger" @click="closeModal">ACEPTAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const modalClass = ref("modal fade");
const errorMessage = ref("LOGIN INCORRECTO");
const errorTitle = ref("ERROR DE INICIO DE SESION");

const openModal = (title = "", message = "") => {
  modalClass.value = "modal fade show";
  if (title != "") errorTitle.value = title;
  if (message != "") errorMessage.value = message;
};

const closeModal = () => {
  modalClass.value = "modal fade";
};

defineExpose({
  openModal, // Exponer el método para que pueda ser llamado desde el padre
});
</script>

<style scoped>

.modal-content {
  background-color: #0b151c;
  color: white;
  border: none;
}

.modal-body {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.btn {
  background-color: #ffc000;
  color: #0b151c;
}

.modal-content {
  background-color: #0b151c;
  color: white;
}
.btn {
  background-color: #ffc000;
  color: #0b151c;
}

.show {
  display: block;
}
</style>
