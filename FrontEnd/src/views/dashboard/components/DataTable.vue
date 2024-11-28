<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 user">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-bottom">
            <div class="user d-flex align-items-center">
              <div class="col-6">
                <h5 class="mb-0 ms-0">{{ itemType }}</h5>
              </div>
              <div class="col-6 text-end">
                <material-button
                  class="float-right btn btm-sm"
                  v-if="onAdd"
                  @click="onAdd()"
                >
                  <i class="fa fa-plus-circle me-2"></i>
                  Añadir {{ itemType }}
                </material-button>
              </div>
            </div>
          </div>

          <!-- Card body -->
          <div class="px-0 pb-0 card-body">
            <!-- Options -->
            <div class="row">
              <material-input
                id="buscar"
                :value="searchQuery"
                type="text"
                label="Buscar..."
                class="col-lg-9 col-sm-12"
                @update:value="upval"
              />

              <material-button
                class="float-right btn btm-sm col-lg-2 col-sm-12"
                @click="resetFilter()"
              >
                <i class="fa fa-undo" aria-hidden="true"></i>
                Resetear filtros
              </material-button>
              <material-button
                class="float-right btn btm-sm col-lg-1 col-sm-12 ml-3"
                @click="reload()"
                color="info"
              >
                <i class="fa fa-undo" aria-hidden="true"></i>
                Recargar
              </material-button>
            </div>
            <!-- Table -->
            <table class="table table-flush mt-3">
              <thead class="thead-light">
                <tr>
                  <th
                    v-for="(valor, key) in columns"
                    :key="key"
                    @click="ordenar(valor)"
                  >
                    {{ valor }} <i class="fa fa-sort" aria-hidden="true"></i>
                  </th>

                  <th class="text-end" v-if="onEdit || onDelete">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <DataTableItemList
                  v-for="item in paginatedData"
                  :item="item"
                  :columns="columns"
                  v-on:edit="this.onEdit"
                  v-on:delete="this.onDelete"
                ></DataTableItemList>
              </tbody>
            </table>
          </div>
          <!-- Card Footer -->
          <div
            class="card-footer d-flex justify-content-evenly align-items-center"
          >
            <div>
              mostrando {{ paginatedData.length }} de {{ filteredItems.length }}
            </div>

            <material-pagination>
              <material-pagination-item
                prev
                @click="cambiarPagina(paginaActual - 1)"
              />
              <material-pagination-item
                v-for="page in totalPages"
                :key="page"
                :active="page === paginaActual"
                :label="page.toString()"
                @click="cambiarPagina(page)"
              />
              <material-pagination-item
                next
                @click="cambiarPagina(paginaActual + 1)"
              />
            </material-pagination>

            <select v-model="usuariosPorPagina">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="25">25</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialButton from "@/components/dashboard/MaterialButton.vue";
import DataTableItemList from "./DataTableItemList.vue";
import showSwal from "@/mixins/showSwal";
import MaterialPagination from "@/components/dashboard/MaterialPagination.vue";
import MaterialPaginationItem from "@/components/dashboard/MaterialPaginationItem.vue";
import MaterialInput from "@/components/dashboard/MaterialInput.vue";

export default {
  name: "DataTable",
  components: {
    MaterialButton,
    DataTableItemList,
    MaterialPagination,
    MaterialPaginationItem,
    MaterialInput,
  },
  props: {
    itemType: String,
    items: Array,
    columns: Array,
    onAdd: Function,
    onEdit: Function,
    onDelete: Function,
    onReload: Function,
  },
  data() {
    return {
      usuariosPorPagina: 5,
      paginaActual: 1,
      sortField: null,
      sortOrder: null, // Orden actual (asc o desc)
      searchQuery: "",
    };
  },
  computed: {
    // Filtra los datos según la búsqueda
    filteredItems() {
      const query = this.searchQuery.toLowerCase();
      return this.items.filter((item) =>
        Object.values(item).some((val) =>
          String(val).toLowerCase().includes(query)
        )
      );
    },

    // Ordena los datos según el campo y el orden actual
    sortedItems() {
      if (!this.sortField) return this.filteredItems;

      return [...this.filteredItems].sort((a, b) => {
        const fieldA = a[this.sortField];
        const fieldB = b[this.sortField];

        if (fieldA < fieldB) return this.sortOrder === "asc" ? -1 : 1;
        if (fieldA > fieldB) return this.sortOrder === "asc" ? 1 : -1;
        return 0;
      });
    },
    totalPages() {
      const totalP = Math.ceil(
        this.filteredItems.length / this.usuariosPorPagina
      );
      if (this.paginaActual > totalP) this.paginaActual = 1;
      return totalP;
    },
    paginatedData() {
      const start = (this.paginaActual - 1) * this.usuariosPorPagina;
      const end = start + parseInt(this.usuariosPorPagina, 10);

      return this.sortedItems.slice(start, end); // Datos de la página actual
    },
  },
  methods: {
    showErrorMessage() {
      showSwal.methods.showSwal({
        type: "error",
        message: "Error.",
        width: 500,
      });
    },
    ordenar(campo) {
      if (this.sortField === campo.toLowerCase()) {
        this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
      } else {
        this.sortField = campo.toLowerCase();
        this.sortOrder = "asc";
      }
    },
    cambiarPagina(pagina) {
      if (pagina >= 1 && pagina <= this.totalPages) {
        this.paginaActual = pagina;
      }
    },
    resetFilter() {
      this.searchQuery = "";
      this.sortField = null;
      this.sortDirection = "asc";
      this.currentPage = 1;
    },
    upval(e) {
      this.searchQuery = e;
    },
    async reload() {
      await this.onReload();
      this.resetFilter();
    },
  },
};
</script>

<style scoped>
table thead tr th {
  padding-left: 1.5 rem !important;
}
th {
  cursor: pointer;
}
select {
  background-color: #162430;
  color: white;
}

.col-9 {
  width: 70% !important;
}
@media (max-width: 1400px) {
  .card-body {
    overflow: auto;
  }
}
.card .card-footer {
  overflow: auto;
}
.row {
  margin: 0 !important;
  gap: 0.5rem;
}
.row > * {
  padding-right: 0
}
</style>
