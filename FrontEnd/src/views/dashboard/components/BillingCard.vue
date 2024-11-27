<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h6 class="mb-0">Información Bancaria</h6>
    </div>
    <div class="card-body pt-1 p-3">
      <ul class="list-group">
        <li
          class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg"
        >
          <div class="d-flex flex-column">
            <h6 class="mb-3 text-sm">{{ card.titular }}</h6>
            <span class="mb-2 text-xs">
              IBAN:
              <span class="text-dark font-weight-bold ms-sm-2"
                >{{ card.iban }}</span
              >
            </span>
            <span class="mb-2 text-xs">
              TITULAR:
              <span class="text-dark ms-sm-2 font-weight-bold"
                >{{ card.titular }}</span
              >
            </span>
            <span class="text-xs">
              LICENCIA VTC
              <span class="text-dark ms-sm-2 font-weight-bold">{{ card.licencia }}</span>
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "billing-card",
  props: {
    card: {
      type: Object,
      iban: String,
      titular: String,
      licencia: String,
      default: () => ({}),
    },
  },
};
</script>
