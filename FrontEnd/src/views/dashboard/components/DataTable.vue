<template>
  <div class="card">
    <DataTable
      :value="products"
      paginator
      :rows="5"
      :rowsPerPageOptions="[5, 10, 20, 50]"
      showGridlines
      tableStyle="min-width: 50rem"
      paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
      currentPageReportTemplate="{first} to {last} of {totalRecords}"
    >
      <template #paginatorstart>
        <Button type="button" icon="pi pi-refresh" text />
      </template>
      <template #paginatorend>
        <Button type="button" icon="pi pi-download" text />
      </template>
      <Column field="code" header="Code" sortable></Column>
      <Column field="name" header="Name" sortable></Column>
      <Column field="category" header="Category" sortable></Column>
      <Column field="quantity" header="Quantity" sortable></Column>
    </DataTable>
  </div>
</template>

<script setup>
import DataTable from "primevue/datatable";
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import Column from "primevue/column";
import { ref, onMounted } from "vue";
import { ProductService } from "@/services/ProductService";

//  los filtros a medias


onMounted(() => {
  ProductService.getProducts().then((data) => (products.value = data));
});

const products = ref();
</script>
