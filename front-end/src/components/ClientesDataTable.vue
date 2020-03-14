<template>
  <div>
    <v-data-table :headers="headers" :items="clientes" class="elevation-0" no-data-text="Sin datos" :search="search" :loading="loading" loading-text="Cargando ... Por favor espera" >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title class="secondary--text">Lista de Clientes</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details class="mr-5" color="secondary" ></v-text-field>
          <!-- Modal formulario -->
          <v-dialog v-model="dialogForm" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn depressed color="btnbackground secondary--text" dark v-on="on">
                <v-icon color="secondary">mdi-plus</v-icon>Añadir
              </v-btn>
            </template>
            <v-card>
              <v-card-title class="headline background white--text" primary-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text class="pt-3 pb-1">
                
                    <v-col cols="12" sm="12" md="12">
                      <!-- Formulario para guardar y modificar clientes -->
                      <form id="formCliente" ref="formCliente">
                        <v-text-field v-model="editedItem['nombre']" :error-messages="nombreErrors" :counter="20" label="Nombre cliente" color="secondary" class="pt-0" @input="$v.editedItem['nombre'].$touch()" @blur="$v.editedItem['nombre'].$touch()" ></v-text-field>
                        <v-text-field v-model="editedItem['email']" :error-messages="emailErrors" label="E-mail" color="secondary" @input="$v.editedItem['email'].$touch()" @blur="$v.editedItem['email'].$touch()" ></v-text-field>
                        <v-text-field v-model="editedItem['telefono']" :error-messages="telefonoErrors" label="Telefono" color="secondary" :messages="['Ejemplo: 912345678']" @input="$v.editedItem['telefono'].$touch()" @blur="$v.editedItem['telefono'].$touch()" ></v-text-field>
                        <v-text-field v-model="editedItem['direccion']" :error-messages="direccionErrors" label="Direccion" color="secondary" @input="$v.editedItem['direccion'].$touch()" @blur="$v.editedItem['direccion'].$touch()" ></v-text-field>
                      </form>
                    </v-col>
                 
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="danger white--text" depressed @click="close">Cancelar</v-btn>
                <v-btn v-if="formTitle === 'Nuevo cliente'" color="success" depressed form="formCliente" @click="guardarCliente" >Guardar</v-btn>
                <v-btn v-if="formTitle === 'Editar Cliente'" color="success" depressed form="formCliente" @click="modificarCliente" >Modificar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <template v-slot:item.action="{ item }">
        <v-icon small color="secondary" class="ml-1" @click="modalEditar(item)">mdi-pencil</v-icon>
        <v-icon small color="danger" class="ml-2" @click="modalEliminar(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>

    <!-- Alerta para respuestas del api -->
    <v-snackbar v-model="snackbar" :color="color" :timeout="timeout" top right>
      <v-icon color="white" class="ml-1 mr-2">{{snackIcon}}</v-icon>
      {{txtnackbar}}
      <v-btn dark text @click="snackbar = false">CERRAR</v-btn>
    </v-snackbar>
    
     <!-- Modal confirmar eliminar -->
    <v-dialog v-model="dialogElim" max-width="310" >
      <v-card>
        <v-card-title class="headline danger white--text">Eliminar <v-icon class="ml-3" color="white">mdi-delete</v-icon></v-card-title>
        <v-card-text class="mt-2">Esta seguro de eliminar el Cliente #{{this.clienteId}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" text @click="dialogElim = false" > Cancelar </v-btn>
          <v-btn color="secondary" text @click="eliminarCliente" > Eliminar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
import Global from "../Global";
import { validationMixin } from "vuelidate";
import { required, maxLength, email, numeric } from "vuelidate/lib/validators";
import alertMixin from "../mixins/alertMixin";
import formValidationMixin from "../mixins/formValidationMixin";

export default {
  mixins: [validationMixin, alertMixin, formValidationMixin],
  validations: {
    editedItem: {
      nombre: { required, maxLength: maxLength(20) },
      email: { required, email },
      telefono: { required, numeric, maxLength: maxLength(9) },
      direccion: { required }
    }
  },
  data() {
    return {
      // Data
      url: Global.url,
      clientes: [],
      clienteId: "",
      // FrontEnd
      dialogForm: false,
      dialogElim: false,
      search: "",
      loading: false,

      //----Data table
      headers: [
        { text: "ID", sorteable: true, value: "id" },
        { text: "Nombre", sorteable: true, value: "nombre" },
        { text: "Email", sorteable: true, value: "email" },
        { text: "Telefono", sorteable: true, value: "telefono" },
        { text: "Direccion", sorteable: true, value: "direccion" },
        { text: "Acciones", sorteable: false, value: "action" }
      ],
      editedIndex: -1,
      editedItem: { nombre: "", email: "", telefono: "", direccion: "" },
      defaultItem: { nombre: "", email: "", telefono: "", direccion: "" }
    };
  },

  methods: {
  //Metodos del API
    listarClientes() {
      this.loading = true;
      axios.get(this.url + "cliente")
        .then(res => {
          if (res.data.status == "success") {
            this.clientes = res.data.cliente;
            this.loading = false;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
    },
    
    guardarCliente() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.alertServerError("Datos invalidos o incompletos");
      } else {
        axios.post(this.url + "cliente", this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.close();
            this.listarClientes();
            this.alertSuccess();
          }
          })
          .catch(err => {
            this.alertServerError("Por favor rellena los campos", err);
          });
      }
    },

    modificarCliente() {
      this.$v.$touch();
      if (this.$v.$invalid){
        this.alertServerError("Datos invalidos o incompletos")
      }else{
        axios.put(this.url + "cliente/" + this.clienteId, this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.listarClientes();
            this.alertUpdate();
            this.dialogForm = false;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
      }
    },

    eliminarCliente() {
      axios.delete(this.url + "cliente/" + this.clienteId)
      .then(res => {
        if (res.data.status == "success") {
          this.listarClientes();
          this.alertDanger();
          this.dialogElim = false
        }
        })
        .catch(err => {
          this.alertServerError(err);
        });
    },

    //Metodos del front-end
    modalEditar(item) {
      this.editedIndex = this.clientes.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogForm = true;
      this.clienteId = item.id;
    },
    modalEliminar(item) {
      this.clienteId = item.id;
      this.dialogElim = true;
    },

    close() {
      this.dialogForm = false;
      this.$v.$reset();
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    }
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo cliente" : "Editar Cliente";
    }
  },
  mounted() {
    this.listarClientes();
  }
};
</script>
