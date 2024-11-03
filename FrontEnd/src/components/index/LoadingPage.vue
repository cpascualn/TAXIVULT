<template>
  <div>
    <div :class="modalClass" id="exampleModalToggle">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="loading-spinner mb-2"></div>
            <div>Loading</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const modalClass = ref("modal fade show");

const closeModal = () => {
  modalClass.value = "modal fade";
};

defineExpose({
  closeModal, // Exponer el método para que pueda ser llamado desde el padre
});
</script>

<style scoped>
.modal-content {
  background-color: #0b151c;
  color: white;
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

.show {
  display: block;
  background-color: #0b151c;
}

.loading-spinner {
  width: 8rem;
  height: 8rem;
  border: 1rem solid #ffc000;
  border-radius: 50%;
  border-top-color: #0001;
  display: inline-block;
  animation: loadingspinner 0.7s linear infinite;
}
@keyframes loadingspinner {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
