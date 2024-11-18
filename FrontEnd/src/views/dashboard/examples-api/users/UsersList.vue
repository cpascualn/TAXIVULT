<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 user">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-bottom">
            <div class="user d-flex align-items-center">
              <div class="col-6">
                <h5 class="mb-0 ms-0">Users</h5>
              </div>
              <div class="col-6 text-end">
                <material-button
                  class="float-right btn btm-sm"
                  @click="addUser()"
                >
                  <i class="fas fa-user-plus me-2"></i>
                  Add User
                </material-button>
              </div>
            </div>
          </div>

          <!-- Card body -->
          <div class="px-0 pb-0 card-body">
            <div class="row">
              <material-input
                id="buscar"
                :value="searchQuery"
                type="text"
                label="Buscar..."
                class="col-9"
                @update:value="upval"
              />

              <material-button
                class="float-right btn btm-sm col-2"
                @click="resetFilter()"
              >
                <i class="fa fa-undo" aria-hidden="true"></i>
                Resetear filtros
              </material-button>
              <material-button
                class="float-right btn btm-sm col-1 ml-3"
                @click="reloadUsers()"
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
                    v-for="(valor, key) in valores"
                    :key="key"
                    @click="ordenar(valor)"
                  >
                    {{ valor }} <i class="fa fa-sort" aria-hidden="true"></i>
                  </th>

                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <user-item-list
                  v-for="user in paginatedData"
                  :id="user.id"
                  :email="user.email"
                  :nombre="user.nombre"
                  :apellidos="user.apellidos"
                  :telefono="user.telefono"
                  :ciudad="user.ciudad"
                  :creado="user.fecha_creacion"
                  :rol="user.rol"
                ></user-item-list>
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
import UserItemList from "./UserItemList.vue";
import showSwal from "@/mixins/showSwal";
import MaterialPagination from "@/components/dashboard/MaterialPagination.vue";
import MaterialPaginationItem from "@/components/dashboard/MaterialPaginationItem.vue";
import MaterialInput from "@/components/dashboard/MaterialInput.vue";
import userService from "@/services/user.service";
import authService from "@/services/auth.service";
export default {
  name: "UsersList",
  components: {
    MaterialButton,
    UserItemList,
    MaterialPagination,
    MaterialPaginationItem,
    MaterialInput,
  },
  data() {
    return {
      usuariosPorPagina: 5,
      paginaActual: 1,
      sortField: null,
      sortOrder: null, // Orden actual (asc o desc)
      searchQuery: "",
      valores: [
        "Email",
        "Nombre",
        "Apellidos",
        "Telefono",
        "Ciudad",
        "Fecha_creacion",
        "Rol",
      ],
      users: [],
    };
  },
  async mounted() {
    const users = await this.getUsers();
    this.users = users.usuarios;
    await this.$store.dispatch("profile/getProfile");
  },
  computed: {
    // Filtra los datos según la búsqueda
    filteredItems() {
      const query = this.searchQuery.toLowerCase();
      return this.users.filter((item) =>
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
      return Math.ceil(this.filteredItems.length / this.usuariosPorPagina); // Total de páginas
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
    async addUser() {
      const datos = await showSwal.methods.showAddUser();
      if (!datos) return;
      console.log(datos);
      const data = await authService.register(datos);
      if (!data.success) {
        let finalMessage = data.error ? `ERROR: ${data.error}` : "ERROR";
        showSwal.methods.showSwal({
          type: "error",
          message: finalMessage,
          width: 500,
        });
      } else {
        showSwal.methods.showSwal({
          type: "success",
          message: "Usuario creado",
          width: 500,
        });
      }
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
    async getUsers() {
      return await userService.getUsuarios();
    },
    upval(e) {
      this.searchQuery = e;
    },
    async reloadUsers(){
      const users = await this.getUsers();
      this.users = users.usuarios;
      this.resetFilter();
    }
  },
};

// para filtrar y ordenar modificar el array q se pone dentro de data return
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
</style>
