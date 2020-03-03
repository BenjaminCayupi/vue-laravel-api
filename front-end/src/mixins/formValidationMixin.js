export default {

  computed: {

    //***----- CLIENTES -----****
    nombreErrors() {
      const errors = [];
      if (!this.$v.editedItem["nombre"].$dirty) return errors;
      !this.$v.editedItem["nombre"].maxLength &&
        errors.push("El nombre puede tener un maximo de 20 caracteres");
      !this.$v.editedItem["nombre"].required &&
        errors.push("El nombre es requerido");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.editedItem["email"].$dirty) return errors;
      !this.$v.editedItem["email"].email && errors.push("Debe ser un e-mail");
      !this.$v.editedItem["email"].required &&
        errors.push("El correo es requerido");
      return errors;
    },
    telefonoErrors() {
      const errors = [];
      if (!this.$v.editedItem["telefono"].$dirty) return errors;
      !this.$v.editedItem["telefono"].numeric &&
        errors.push("Debe ser un numero");
      !this.$v.editedItem["telefono"].maxLength &&
        errors.push("El celular debe tener 9 digitos");
      !this.$v.editedItem["telefono"].required &&
        errors.push("El telefono es requerido");
      return errors;
    },
    direccionErrors() {
      const errors = [];
      if (!this.$v.editedItem["direccion"].$dirty) return errors;
      !this.$v.editedItem["direccion"].required &&
        errors.push("La direccion es requerido");
      return errors;
    },

    //***----- PRODUCTOS-----***
    modeloErrors() {
      const errors = [];
      if (!this.$v.editedItem["modelo"].$dirty) return errors;
      !this.$v.editedItem["modelo"].required && errors.push("El modelo es requerido");
      return errors;
    },
    marcaErrors() {
      const errors = [];
      if (!this.$v.editedItem["marca"].$dirty) return errors;
      !this.$v.editedItem["marca"].required && errors.push("La marca es requerido");
      return errors;
    },

    nserieErrors() {
      const errors = [];
      if (!this.$v.editedItem['nserie'].$dirty) return errors;
      !this.$v.editedItem['nserie'].required &&
        errors.push("El numero de serie es requerido");
      return errors;
    },
    categErrors() {
      const errors = [];
      if (!this.$v.select.$dirty) return errors;
      !this.$v.select.required && errors.push("La categoria es requerida");
      return errors;
    },

    //***----- ARRIENDOS -----***
    clienteErrors() {
      const errors = [];
      if (!this.$v.editedItem['cliente_id'].$dirty) return errors;
      !this.$v.editedItem['cliente_id'].required && errors.push("El producto es obligatorio");
      return errors;
    },
    productoErrors() {
      const errors = [];
      if (!this.$v.editedItem['producto_id'].$dirty) return errors;
      !this.$v.editedItem['producto_id'].required && errors.push("El producto es obligatorio");
      return errors;
    },
    cantidadErrors() {
      const errors = [];
      if (!this.$v.editedItem['cantidad'].$dirty) return errors;
      !this.$v.editedItem['cantidad'].required && errors.push("La cantidad es obligatoria");
      !this.$v.editedItem['cantidad'].numeric &&
        errors.push("solo se pueden ingresar numeros");
      return errors;
    },
    fechaInErrors() {
      const errors = [];
      if (!this.$v.editedItem['fentrega'].$dirty) return errors;
      !this.$v.editedItem['fentrega'].required && errors.push("La fecha es obligatoria");
      return errors;
    },
    fechaTmErrors() {
      const errors = [];
      if (!this.$v.editedItem['ftermino'].$dirty) return errors;
      !this.$v.editedItem['ftermino'].required && errors.push("La fecha es obligatoria");
      return errors;
    },
    estadoErrors(){
      const errors= [];
      if(!this.$v.editedItem['estado'].$dirty) return errors;
      !this.$v.editedItem['estado'].required && errors.push('El estado es obligatorio');
      return errors
    },
    
  }
}