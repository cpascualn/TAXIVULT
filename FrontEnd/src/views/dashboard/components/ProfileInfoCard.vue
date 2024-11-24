<template>
  <div class="h-100">
    <div class="p-3 pb-0 card-header">
      <div class="row">
        <div class="col-md-8 d-flex align-items-center">
          <h6 class="mb-0">{{ title }}</h6>
        </div>
      </div>
    </div>
    <div class="p-3 card-body">
      <hr class="my-1 horizontal gray-light" />
      <ul class="list-group">
        <li class="pt-0 text-sm border-0 list-group-item ps-0">
          <strong class="text-white">Nombre Completo:</strong> &nbsp;
          {{ info.fullName }}
        </li>
        <li class="text-sm border-0 list-group-item ps-0">
          <strong class="text-white">Teléfono:</strong> &nbsp; {{ info.mobile }}
        </li>
        <li class="text-sm border-0 list-group-item ps-0">
          <strong class="text-white">Email:</strong> &nbsp; {{ info.email }}
        </li>
        <li class="text-sm border-0 list-group-item ps-0">
          <strong class="text-white">Ciudad:</strong> &nbsp;
          {{ info.location }}
        </li>
        <li class="text-sm border-0 list-group-item ps-0">
          <strong class="text-white">En Taxivult Desde:</strong> &nbsp;
          {{ info.desde }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfileInfoCard",
  props: {
    title: {
      type: String,
      default: "",
    },
    info: {
      type: Object,
      fullName: String,
      mobile: String,
      email: String,
      location: String,
      desde: String,
      default: () => {},
    },
  },
};
</script>
