<template>
  <v-card :class="dato.color" dark outlined>
    <v-list-item three-line>
      <v-list-item-content>
        <div class="overline">{{dato.overline}}</div>
        <v-list-item-title class="display-1 d-flex justify-space-between">
          <span v-if="dato.title || !dato.title===undefined">{{dato.title}}</span>
          <span v-else :class="dato.color">Sin datos</span>
          <v-icon x-large>{{dato.icon}}</v-icon>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    </v-card>
    
  
</template>

<script>

export default {
  name: "CardInfo",
  props:['dato']
  
};
</script>

<style>
</style>