<template>
  <div class="card bg-transparent shadow-xl">
    <div
      class="overflow-hidden position-relative border-radius-xl"
      :style="{ backgroundImage: `url(${curvedImage})` }"
    >
      <span class="mask" :class="`bg-gradient-${card.background}`"></span>
      <div class="card-body position-relative z-index-1 p-3">
        <i class="fas fa-wifi text-white p-2" aria-hidden="true"></i>
        <h5 class="text-white mt-4 mb-5 pb-2">
          {{ card.number }}
        </h5>
        <div class="d-flex">
          <div class="d-flex">
            <div class="me-4">
              <p class="text-white text-sm opacity-8 mb-0">Titular</p>
              <h6 class="text-white mb-0">{{ card.holderName }}</h6>
            </div>
            <div class="me-4">
              <p class="text-white text-sm opacity-8 mb-0">Caduca</p>
              <h6 class="text-white mb-0">{{ card.expiryDate }}</h6>
            </div>
            <div class="me-4">
              <p class="text-white text-sm opacity-8 mb-0">CVV</p>
              <h6 class="text-white mb-0">{{ card.cvv }}</h6>
            </div>
          </div>
          <div class="w-20 d-flex align-items-end justify-content-end ms-auto">
            <material-avatar class="w-60 mt-2" :img="img1" alt="logo" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialAvatar from "@/components/dashboard/MaterialAvatar.vue";
import img1 from "@/assets/img/logos/mastercard.png";
import curvedImage from "@/assets/img/curved14.jpg";

export default {
  name: "MasterCard",
  components: {
    MaterialAvatar,
  },
  props: {
    card: {
      type: Object,
      number: String,
      holderName: String,
      expiryDate: String,
      cvv: String,
      background: String,
      default: () => ({}),
    },
  },
  data() {
    return {
      img1,
      curvedImage,
    };
  },
  computed: {},
};
</script>

<style scoped>
.dark-version .bg-gradient-dark {
  background-image: linear-gradient(195deg, #323a5459, #1a20358a);
}
</style>
