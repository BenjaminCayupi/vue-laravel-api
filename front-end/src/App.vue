<template>
  <v-app style="background: #e8ecfa;">
    <Navbar></Navbar>
    <v-content class="mx-1 mx-sm-3 my-6">
      <transition name="router-ani" enter-active-class="animated slideInUp faster" mode="out-in">
        <router-view></router-view>
      </transition>
    </v-content>
  </v-app>
</template>

<script>
import Navbar from "./components/Navbar.vue";

export default {
  name: "App",
  components: { Navbar }
};
</script>

<style>
@import "https://cdn.jsdelivr.net/npm/animate.css@3.5.1";

.page {
  width: inherit;
}

.animated {
  animation-duration: 300ms;
}

</style>