<template>
  <div class="productos page">
    <h1 class="headline subtitle--text mx-3 font-weight-light">
      PRODUCTOS
      <v-icon color="subtitle" class="mb-1 ml-2">mdi-laptop</v-icon>
    </h1>
    <ProductosDataTable></ProductosDataTable>
    <v-container fluid class="pb-1">
    </v-container>
  </div>
</template>

<script>
import ProductosDataTable from '../components/ProductosDataTable'
export default {
  name: "Productos",
  components: { ProductosDataTable },
  data() {
    return {};
  }
};
</script>

<style>
</style>