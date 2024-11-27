<template>
  <tr>
    <td
      v-for="(value, key) in this.filteredItems"
      :key="key"
      class="text-sm font-weight-normal"
      v-html="renderColumn(value, key)"
    ></td>
    <td class="text-sm font-weight-normal">
      <div class="text-end">
        <material-button
          class="m-1 btn-circle"
          title="edit"
          size="sm"
          v-if="onEdit"
          @click="onEdit(this.item)"
        >
          <i class="fas fa-pen"></i>
        </material-button>
        <material-button
          id="delBut"
          class="m-1 btn-circle"
          size="sm"
          color="danger"
          title="delete"
          v-if="onDelete"
          @click="onDelete(this.item)"
        >
          <i class="fas fa-trash"></i>
        </material-button>
      </div>
    </td>
  </tr>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";

export default {
  name: "UserItemList",
  components: {
    MaterialButton,
  },
  props: {
    item: [Array, Object],
    columns: Array,
    onEdit: Function,
    onDelete: Function,
  },
  computed: {
    filteredItems() {
      return Object.fromEntries(
        Object.entries(this.item).filter(([key]) =>
          this.columns
            .map((col) => col.toLowerCase())
            .includes(key.toLowerCase())
        )
      );
    },
  },
  methods: {
    renderColumn(value, key) {
      const colores = {
        "libre": "success",
        "fuera de servicio": "secondary",
        "ocupado": "danger",
      };

      if (key === "estado") {
        return `<span class="badge badge-sm bg-gradient-${colores[value]}">${value}</span>`;
      }

      if (key === "imagen") {
        return `<div style="display: flex; align-items: center; justify-content: center;">
            <img style="max-height: 12vh; border-radius: 5px; width: 10rem; object-fit: cover;" 
            src="${value ? value : "/img/taxiIcon.jpg"}" alt="" />
          </div>`;
      }
      return value;
    },
  },
};
</script>

<style scoped>
.image__div {
  -webkit-box-align: center;
  align-items: center;
  display: flex;
  flex-shrink: 0;
  -webkit-box-pack: center;
}
img {
  border: 1px solid black;
  height: 12vh;
  border-radius: 5px;
  width: 10rem;
  object-fit: contain;
}

.btn-circle.btn-sm {
  width: 30px;
  height: 30px;
  padding: 6px 0px;
  border-radius: 15px;
  font-size: 8px;
  text-align: center;
}

table tbody tr td {
  padding-left: 1.5rem !important;
}

.table td,
.table th {
  white-space: break-spaces;
}
</style>
