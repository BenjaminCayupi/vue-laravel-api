<template>
  <nav>
    <v-app-bar app flat  color="white">
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="text-uppercase">
        <span class="font-weight-light subtitle--text">SISTEMA </span>
        <span class="subtitle--text">Arriendo Productos</span>
      </v-toolbar-title>

    </v-app-bar>

    <v-navigation-drawer app dark color="background" v-model="drawer">
      <v-app-bar flat color="background">
        <v-toolbar-title>
          <v-avatar>
            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
          </v-avatar>
          <span class="white--text ml-3">Usuario</span>
        </v-toolbar-title>
      </v-app-bar>

      <v-list class="pt-2" flat>
        <v-subheader>Acciones</v-subheader>
        <v-list-item-group>
          <v-list-item
            v-for="link in links"
            :key="link.text"
            link
            dark
            color="danger"
            router
            :to="link.route"
          >
            <v-list-item-icon>
              <v-icon>{{ link.icon}}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{link.text}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      
    </v-navigation-drawer>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      drawer: true,
      links: [
        { icon: "mdi-view-dashboard", text: "Dashboard", route: "/" },
        {
          icon: "mdi-format-list-bulleted",
          text: "Arriendos",
          route: "/arriendos"
        },
        {
          icon: "mdi-account-card-details",
          text: "Clientes",
          route: "/clientes"
        },
        { icon: "mdi-cart", text: "Productos", route: "/productos" }
      ]
    };
  }
};
</script>

<style>
</style>