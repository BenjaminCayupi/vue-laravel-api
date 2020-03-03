<template>
  <div class="dashboard page">
    <h1 class="headline subtitle--text mx-3 font-weight-light">
      DASHBOARD
      <v-icon color="subtitle" class="mb-2 ml-2">mdi-view-dashboard</v-icon>
    </h1>
    <v-container fluid class="my-1">
      <v-row class="d-flex justify-space-between">
        <!-- Tarjetas de informacion component: cardinfo -->
        <v-col cols="12" sm="12" md="4" lg="4" v-for="card in cards" :key="card.overline">
          <CardInfo v-bind:dato="card"></CardInfo>
        </v-col>
      </v-row>
      <!-- Tabla ultimas ordenes  -->
      <v-row class="mt-2 d-flex justify-space-around">
        <v-col cols="12">
          <v-card class="elevation-0">
            <v-card-title class="pb-1 title-1 subtitle--text">Ultimos Arriendos</v-card-title>

            <div v-for="orden in ordenes" :key="orden.numero" class="pb-0" elevation="0">
              <ArriendosTable v-bind:dato="orden"></ArriendosTable>
              <v-divider></v-divider>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import CardInfo from "../components/CardInfo.vue";
import ArriendosTable from "../components/ArriendosTable.vue";
import axios from "axios";
import Global from "../Global";
export default {
  components: { CardInfo, ArriendosTable },
  data() {
    return {
      title1:'a',
      title2:'b',
      title3:'c',
      url: Global.url,
      cards: [
        {
          color: "secondary",
          overline: "Ordenes ultimos 15 dias",
          title: '',
          icon: "mdi-format-list-bulleted"
        },
        {
          color: "danger",
          overline: "Ordenes del mes anterior",
          title: '',
          icon: "mdi-calendar-month"
        },
        {
          color: "success",
          overline: "Cliente favorito",
          title: '',
          icon: "mdi-account-heart"
        }
      ],
      
      ordenes: null,
    };
  },
  methods:{
    listarDatos(){
      axios.get(this.url + "dashboard")
      .then(res =>{
        if(res.data.status == 'success'){
          this.cards[0].title = res.data.last_15
          this.cards[1].title = res.data.last_month
          this.cards[2].title = res.data.fav_client[0].nombre
          this.ordenes= res.data.ult_arriendos

        }
      })
    }
  },
  mounted(){
    this.listarDatos();
  }
  
};
</script>

<style>
</style>
