<template>
  <div class="card mt-3">
    <div class="card-header pb-0 p-3">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Editar Información Bancaria</h6>
        </div>
      </div>
    </div>
    <div class="card-body p-3">
      <div class="row">
        <div class="col-md-12">
          <div
            class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row cursor-pointer"
            @click="onEdit"
          >
            <img
              class="w-5 me-3 mb-0"
              src="@/assets/img/logos/visa.png"
              alt="logo"
            />
            <h6 class="mb-0">
              ****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****
            </h6>
            <i
              class="fas fa-pencil-alt ms-auto text-dark cursor-pointer"
              data-bs-placement="top"
              title
              aria-hidden="true"
              data-bs-original-title="Edit Card"
              aria-label="Edit Card"
            ></i>
            <span class="sr-only">Edit Card</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";
import img1 from "@/assets/img/logos/mastercard.png";
import img2 from "@/assets/img/logos/visa.png";

export default {
  name: "payment-card",
  components: {
    MaterialButton,
  },
  props: {
    onEdit: Function,
  },
  data() {
    return {
      img1,
      img2,
    };
  },
};
</script>
