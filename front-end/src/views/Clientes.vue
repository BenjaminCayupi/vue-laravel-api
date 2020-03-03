<template>
  <div class="clientes page">
    <h1 class="headline subtitle--text mx-3 font-weight-light">CLIENTES <v-icon  color="subtitle" class="mb-2 ml-2">mdi-account-group</v-icon></h1> 
    <v-container fluid class="pb-1">
      <ClientesDataTable></ClientesDataTable>
    </v-container>
  </div>
</template>

<script>
// import ClientesDataTable from '../components/ClientesDataTable'
import ClientesDataTable from '../components/ClientesDataTable'
export default {
  name:'Clientes',
  components:{ ClientesDataTable}
};
</script>

<style>
</style>