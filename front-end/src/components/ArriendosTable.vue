<template>
  <v-row class="d-flex justify-start">
    <v-col cols="2">
      <div class="pl-5">
        <div class="caption grey--text d-none d-sm-flex">#Orden</div>
        <div class="caption grey--text d-flex d-sm-none">#</div>
        <h4
          class="font-weight-regular"
          v-if="dato.id || !dato.id===undefined"
        >{{dato.id}}</h4>
        <h4 class="font-weight-regular" v-else>Sin datos</h4>
      </div>
    </v-col>
    <v-col cols="1" class="d-flex justify-start">
      <div>
        <div class="caption grey--text">Cliente</div>
        <h4
          class="font-weight-regular"
          v-if="dato.cliente_id || !dato.cliente_id ===undefined"
        >{{dato.cliente_id}}</h4>
        <h4 class="font-weight-regular" v-else>Sin datos</h4>
      </div>
    </v-col>
    <v-col cols="3" class="d-flex justify-center">
      <div>
        <div class="caption grey--text">Entrega</div>
        <h4 class="font-weight-regular" v-if="dato.fentrega || !dato.fentrega===undefined">{{dato.fentrega}}</h4>
        <h4 class="font-weight-regular" v-else>Sin datos</h4>
      </div>
    </v-col>
    <v-col cols="3" class="d-flex justify-center">
      <div>
        <div class="caption grey--text">Termino</div>
        <h4 class="font-weight-regular" v-if="dato.ftermino || !dato.ftermino===undefined">{{dato.ftermino}}</h4>
        <h4 class="font-weight-regular" v-else>Sin datos</h4>
      </div>
    </v-col>
    
    <v-col cols="3" class="d-flex justify-center">
      <div>
        <div class="caption grey--text">Estado</div>
        <v-chip v-if="dato.estado == 'arrendado'" color="success" class="d-none d-sm-flex" >{{dato.estado}}</v-chip>
        <v-chip v-if="dato.estado == 'arrendado'" color="success" class="d-flex d-sm-none" small >{{dato.estado}}</v-chip>
        <v-chip v-if="dato.estado == 'entregado'" color="danger" class="white--text d-none d-sm-flex" >{{dato.estado}}</v-chip>
        <v-chip v-if="dato.estado == 'entregado'" color="danger" class="white--text d-flex d-sm-none" small >{{dato.estado}}</v-chip>

        
      </div>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "ArriendosTable",
  props: ["dato"]
};
</script>

<style>
</style>