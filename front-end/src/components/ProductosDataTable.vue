<template>
  <div>
    <v-data-table :headers="headers" :items="productos" no-data-text="Sin datos" class="elevation-0" :search="search" :loading="loading" loading-text="Cargando ..." >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title class="secondary--text">Lista de Productos</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details class="mr-5" color="secondary" ></v-text-field>
          <v-dialog max-width="500px" v-model="dialogForm">
            <template v-slot:activator="{ on }">
              <v-btn depressed color="btnbackground secondary--text" dark v-on="on">
                <v-icon color="secondary">mdi-plus</v-icon>Añadir
              </v-btn>
            </template>
            <v-card>
              <v-card-title class="headline background white--text" primary-title> <span class="headline">Crear Producto</span> </v-card-title>
              <v-card-text class="py-0">
                <v-col cols="12" sm="12" md="12">
                  <form id="formProducto" ref="formProducto">
                    <v-text-field
                      v-model="editedItem['modelo']"
                      label="Modelo"
                      color="secondary"
                      :error-messages="modeloErrors"
                      @input="$v.editedItem['modelo'].$touch()"
                      @blur="$v.editedItem['modelo'].$touch()"
                    ></v-text-field>
                    <v-text-field
                      v-model="editedItem['marca']"
                      label="Marca"
                      color="secondary"
                      :error-messages="marcaErrors"
                      @input="$v.editedItem['marca'].$touch()"
                      @blur="$v.editedItem['marca'].$touch()"
                    ></v-text-field>
                    <v-select
                      v-model="select"
                      label="Categoria"
                      color="secondary"
                      item-color="secondary"
                      :items="categoria"
                      :error-messages="categErrors"
                      @input="$v.select.$touch()"
                      @blur="$v.select.$touch()"
                    ></v-select>
                    <v-text-field
                      v-model="editedItem['nserie']"
                      :error-messages="nserieErrors"
                      @input="$v.editedItem['nserie'].$touch()"
                      @blur="$v.editedItem['nserie'].$touch()"
                      label="Numero de Serie"
                      color="secondary"
                    ></v-text-field>
                  </form>
                </v-col>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="danger white--text" depressed @click="close">Cancelar</v-btn>
                <v-btn v-if="formTitle === 'Nuevo producto'" color="success" depressed form="formProducto" @click="guardarProducto" >Guardar</v-btn>
                <v-btn v-if="formTitle === 'Editar producto'" color="success" depressed form="formProducto" @click="modificarProducto" >Modificar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon small color="secondary" class="ml-1" @click="modalEditar(item)">mdi-pencil</v-icon>
        <v-icon small color="danger" class="ml-2" @click.stop="modalEliminar(item)">mdi-delete</v-icon>
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
        <v-card-text class="mt-2">Esta seguro de eliminar el Producto #{{this.productoId}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" text @click="dialogElim = false" > Cancelar </v-btn>
          <v-btn color="secondary" text @click="eliminarProducto" > Eliminar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    
  </div>
</template>


<script>
import axios from "axios";
import Global from "../Global";
import { required } from "vuelidate/lib/validators";
import { validationMixin } from "vuelidate";
import alertMixin from "../mixins/alertMixin";
import formValidationMixin from "../mixins/formValidationMixin";

export default {
  mixins: [validationMixin, formValidationMixin, alertMixin],
  validations: {
    editedItem: { marca: { required }, modelo: { required }, nserie: { required } },
    select: { required }
  },
  data() {
    return {
      // Data
      url: Global.url,
      categoria: [ "Notebook", "Pc escritorio", "Celular", "Impresora", "Monitor" ],
      productos: [],
      productoId: '',
      //FrontEnd
      dialogForm: false,
      dialogElim:false,
      loading: false,
      search: "",
      select: null,
      headers: [
        { text: "Id", align: "left", value: "id" },
        { text: "Modelo", value: "modelo" },
        { text: "Marca", value: "marca" },
        { text: "Categoria", value: "categoria" },
        { text: "Numero de serie", value: "nserie" },
        { text: "Acciones", value: "action", sortable: false }
      ],
      editedIndex: -1,
      editedItem: { modelo: "", marca: "", categoria: "", nserie: "" },
      defaultItem: { modelo: "", marca: "", categoria: "", nserie: "" }
    };
  },
  methods: {
    //Metodos del API
    listarProductos() {
      this.loading = true;
      axios.get(this.url + "producto")
      .then(res => {
        if (res.data.status == "success") {
          this.productos = res.data.producto;
          this.loading = false;
        }
      })
      .catch(err => {
        this.alertServerError(err);
      });
    },

    guardarProducto() {
      this.editedItem["categoria"] = this.select;
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.alertServerError("Datos invalidos o incompletos");
      } else {
        axios.post(this.url + "producto", this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.close();
            this.listarProductos();
            this.alertSuccess();
          }
        })
        .catch(err => {
          this.alertServerError("Por favor rellena los campos", err);
        });
      }
    },
    modificarProducto() {
      this.editedItem["categoria"] = this.select; //Asigna el valor del select al modelo categoria
      this.$v.$touch();
      if (this.$v.$invalid){
        this.alertServerError("Datos invalidos o incompletos")
      }else{
        axios.put(this.url + "producto/" + this.productoId, this.editedItem)
        .then(res => {
          if (res.data.status == "success") {
            this.listarProductos();
            this.alertUpdate();
            this.dialogForm = false;
          }
        })
        .catch(err => {
          this.alertServerError(err);
        });
      }
    },
    eliminarProducto() {
      axios.delete(this.url + "producto/" + this.productoId)
      .then(res => {
        if (res.data.status == "success") {
          this.listarProductos();
          this.alertDanger();
          this.dialogElim = false
        }
        })
        .catch(err => {
          this.alertServerError("Primero debe eliminar los arriendos de este producto",err);
          this.dialogElim = false
        });
    },

    //Metodos del frontend
    modalEditar(item) {
      this.editedIndex = this.productos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.select = item.categoria //saca el valor del select categoria para mostrarlo en edicion
      this.productoId = item.id;
      this.dialogForm = true;
    },
    modalEliminar(item) {
      this.productoId = item.id;
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

  mounted() {
    this.listarProductos();
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo producto" : "Editar producto";
    }
  }
};
</script>