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
            <material-input
              type="search"
              label="Buscar..."
              name="search"
              v-model="searchQuery"
            />
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
              mostrando {{ paginatedData.length }} de {{ users.length }}
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
                :label="page"
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
      users: [
        {
          id: 1,
          email: "admin@taxivult.app",
          telefono: "123456789",
          nombre: "admin",
          apellidos: "admin",
          contrasena:
            "$2y$10$3G/s1ebD.NJoIYYihmGqHOXxZWC7PvDsEVODU4/Zo5.24bbteoHGm",
          ciudad: 1,
          creado: "2024-10-29",
          rol: 1,
        },
        {
          id: 4,
          email: "usuariooo@example.com",
          telefono: "1234567890",
          nombre: "Juan",
          apellidos: "Pérez",
          contrasena: "$2y$10$nr.Kbe.MVOqEgw2Ln8vSYO/",
          ciudad: 1,
          creado: "2024-06-30",
          rol: 3,
        },
      ],
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
      return Math.ceil(this.users.length / this.usuariosPorPagina); // Total de páginas
    },
    paginatedData() {
      const start = (this.paginaActual - 1) * this.usuariosPorPagina;
      const end = start + parseInt(this.usuariosPorPagina, 10);
      console.log(this.sortedItems);

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
    addUser() {
      showSwal.methods.showSwal({
        type: "success",
        message: "Usuario creado",
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
    async getUsers() {
      return await userService.getUsuarios();
    },
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
</style>
