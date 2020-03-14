<template>
  <div>
    <v-data-table :headers="headers" :items="arriendo" no-data-text="Sin datos" class="elevation-0" :search="search" :loading="loading" loading-text="Cargando ..." >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title class="secondary--text">Lista de Arriendos</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details class="mr-5" color="secondary" ></v-text-field>

          <v-dialog max-width="500px" v-model="dialogForm">
            <template v-slot:activator="{ on }">
              <v-btn depressed color="btnbackground secondary--text" dark v-on="on">
                <v-icon color="secondary">mdi-plus</v-icon>Añadir
              </v-btn>
            </template>
            <v-card>
              <v-card-title class="headline background white--text" primary-title>
                <span class="headline">Crear Ticket Arriendo</span>
              </v-card-title>

              <v-card-text class="py-0">
                <v-container class="py-1">
                  <form id="formArriendo" ref="formArriendo">
                    <v-row class="py-3">
                      <v-col cols="12" sm="12" md="12" class="py-0">
                        <v-select v-model="editedItem['cliente_id']" label="Cliente" :items="clientes" item-text="nombre" item-value="id" color="secondary" item-color="secondary" :error-messages="clienteErrors" @change="$v.editedItem['cliente_id'].$touch()" @blur="$v.editedItem['cliente_id'].$touch()" ></v-select>
                      </v-col>

                      <v-col cols="12" sm="12" md="12" class="py-0">
                        <v-select v-model="editedItem['producto_id']" label="Producto" :items="productos" item-text="modelo" item-value="id" color="secondary" item-color="secondary" :error-messages="productoErrors" @change="$v.editedItem['producto_id'].$touch()" @blur="$v.editedItem['producto_id'].$touch()" ></v-select>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" class="py-0">
                        <v-menu v-model="fech1" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px" color="secondary" >
                          <template v-slot:activator="{ on }">
                            <v-text-field v-model="editedItem['fentrega']" label="Fecha inicio" readonly v-on="on" color="secondary" :error-messages="fechaInErrors" @change="$v.editedItem['fentrega'].$touch()" @blur="$v.editedItem['fentrega'].$touch()" ></v-text-field>
                          </template>
                          <v-date-picker v-model="editedItem['fentrega']" @input="fech1 = false" no-title :first-day-of-week="1" ></v-date-picker>
                        </v-menu>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" class="py-0">
                        <v-menu v-model="fech2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px" >
                          <template v-slot:activator="{ on }">
                            <v-text-field v-model="editedItem['ftermino']" label="Fecha termino" readonly v-on="on" color="secondary" :error-messages="fechaTmErrors" @change="$v.editedItem['ftermino'].$touch()" @blur="$v.editedItem['ftermino'].$touch()" ></v-text-field>
                          </template>
                          <v-date-picker v-model="editedItem['ftermino']" @input="fech2 = false" no-title :first-day-of-week="1" ></v-date-picker>
                        </v-menu>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" class="py-0">
                        <v-select v-model="editedItem['estado']" label="Estado" :items="estado" color="secondary" :error-messages="estadoErrors" @change="$v.editedItem['estado'].$touch()" @blur="$v.editedItem['estado'].$touch()" ></v-select>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" class="py-0">
                        <v-text-field v-model="editedItem['cantidad']" label="Cantidad" color="secondary" :error-messages="cantidadErrors" @input="$v.editedItem['cantidad'].$touch()" @blur="$v.editedItem['cantidad'].$touch()" ></v-text-field>
                      </v-col>
                    </v-row>
                  </form>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="danger white--text" depressed @click="close">Cancelar</v-btn>
                <v-btn v-if="formTitle === 'Nuevo Arriendo'" color="success" depressed form="formArriendo" @click="guardarArriendo" >Guardar</v-btn>
                <v-btn v-if="formTitle === 'Editar Arriendo'" color="success" depressed form="formArriendo" @click="modificarArriendo">Modificar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon small color="secondary" class="ml-1" @click="modalEditar(item)">mdi-pencil</v-icon>
        <v-icon small color="danger" class="ml-2" @click="modalEliminar(item)">mdi-delete</v-icon>
      </template>

      <!-- Vuelidate Ship para colorear el estado del arriendo en el data table -->
      <template v-slot:item.estado="{ item }">
        <v-chip :color="getColor(item.estado)" dark>{{ item.estado }}</v-chip>
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
        <v-card-text class="mt-2">Esta seguro de eliminar el Arriendo #{{this.arriendoId}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" text @click="dialogElim = false" > Cancelar </v-btn>
          <v-btn color="secondary" text @click="eliminarArriendo" > Eliminar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
import Global from "../Global";
import { validationMixin } from "vuelidate";
import { required, numeric } from "vuelidate/lib/validators";
import alertMixin from "../mixins/alertMixin";
import formValidationMixin from "../mixins/formValidationMixin";

export default {
  mixins: [validationMixin, alertMixin, formValidationMixin],
  validations: {
    editedItem: {
      cliente_id: { required },
      producto_id: { required },
      fentrega: { required },
      ftermino: { required },
      estado: { required },
      cantidad: { required, numeric }
    }
  },
  data() {
    return {
      // Data
      arriendo: [],
      clientes: [],
      productos: [],
      url: Global.url,
      editedItem: { producto_id: "", cliente_id: "", fentrega: "", ftermino: "", cantidad: "", estado: "" },
      estado: ["arrendado", "entregado"],
      arriendoId: "",

      //Frontend
      dialogForm: false,
      dialogElim: false,
      fech1: false,
      fech2: false,
      loading: false,
      search: "",
      headers: [
        { text: "N# Orden", align: "left", value: "id" },
        { text: "ID Producto", value: "producto_id" },
        { text: "ID Cliente", value: "cliente_id" },
        { text: "Fecha inicio", value: "fentrega" },
        { text: "Fecha termino", value: "ftermino" },
        { text: "Cantidad", align: "left", value: "cantidad" },
        { text: "Estado", value: "estado" },
        { text: "Acciones", value: "action", sortable: false }
      ],
      editedIndex: -1,
      defaultItem: { producto_id: "", cliente_id: "", fentrega: "", ftermino: "", cantidad: "", estado: "" }
    };
  },

  methods: {
    //Metodos del api
    listarArriendos() {
      axios.get(this.url + "arriendo")
      .then(res => {
        if (res.data.status == "success") {
          this.arriendo = res.data.arriendo;
        }
      })
      .catch(err => {
        this.alertServerError(err);
      });
    },
    guardarArriendo() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.alertServerError("Datos invalidos o incompletos");
      } else {
        axios.post(this.url + "arriendo", this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.close();
            this.listarArriendos();
            this.alertSuccess();
          }
        })
        .catch(err => {
          this.alertServerError("Por favor rellena los campos", err);
        });
      }
    },
    modificarArriendo() {
      this.$v.$touch();
      if (this.$v.$invalid){
        this.alertServerError("Datos invalidos o incompletos")
      }else{
        axios.put(this.url + "arriendo/" + this.arriendoId, this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.listarArriendos();
            this.alertUpdate();
            this.dialogForm = false;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
      }
    },
    eliminarArriendo() {
      axios.delete(this.url + "arriendo/" + this.arriendoId)
      .then(res => {
        if (res.data.status == "success") {
          this.listarArriendos();
          this.alertDanger();
          this.dialogElim = false
        }
        })
        .catch(err => {
          this.alertServerError(err);
        });
    },

    //Obtner los datos de los select
    listarClientes() {
      axios
        .get(this.url + "cliente")
        .then(res => {
          if (res.data.status == "success") {
            this.clientes = res.data.cliente;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
    },
    listarProductos() {
      axios
        .get(this.url + "producto")
        .then(res => {
          if (res.data.status == "success") {
            this.productos = res.data.producto;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
    },

    //Metodos del frontend
    getColor(estado) {
      if (estado === "arrendado") return "success";
      else if (estado === "entregado") return "danger";
    },

    close() {
      this.dialogForm = false;
      this.$v.$reset();
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    
    modalEditar(item) {
      this.editedIndex = this.arriendo.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogForm = true;
      this.arriendoId = item.id;
    },
    modalEliminar(item) {
      this.arriendoId = item.id;
      this.dialogElim = true;
    },
  },

  mounted() {
    this.listarArriendos();
    this.listarClientes();
    this.listarProductos();
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Arriendo" : "Editar Arriendo";
    }
  }
};
</script>
