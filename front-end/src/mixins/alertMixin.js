export default{
  data(){
    return{
      //----snackbar
      snackbar: false,
      color: "",
      txtnackbar: "",
      timeout: 3200,
      snackIcon: "",
    }
  },
  methods:{
    alertSuccess() {
        this.snackbar = true;
        this.color = "success";
        this.txtnackbar = "Almacenado con exito";
        this.snackIcon = "mdi-checkbox-marked-circle";
      },
      alertDanger() {
        this.snackbar = true;
        this.color = "danger";
        this.txtnackbar = "Eliminado con exito";
        this.snackIcon = "mdi-delete-circle";
      },
      alertUpdate() {
        this.snackbar = true;
        this.color = "accent";
        this.txtnackbar = "Actualizado con exito";
        this.snackIcon = "mdi-information";
      },
      alertServerError(err) {
        this.snackbar = true;
        this.color = "warning";
        this.txtnackbar = err;
        this.snackIcon = "mdi-information";
      },
  }    
}