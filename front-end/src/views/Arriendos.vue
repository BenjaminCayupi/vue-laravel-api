<template>
  <div class="ordenes page">
        <h1 class="headline subtitle--text mx-3 font-weight-light">ARRIENDOS <v-icon  color="subtitle" class="mb-2 ml-2">mdi-format-list-bulleted</v-icon></h1> 

    <v-container fluid class="mb-1">
      <ArriendoDataTable></ArriendoDataTable>
    </v-container>
  </div>
</template>

<script>
import ArriendoDataTable from '../components/ArriendoDataTable'
export default {
  name:'Arriendos',
  components:{ArriendoDataTable}
};
</script>

<style>
</style>