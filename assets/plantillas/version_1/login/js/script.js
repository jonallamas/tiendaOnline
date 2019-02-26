var validator = new FormValidator('f_form', [{
	name: 'log_usuario',
	rules: 'required'
  },{
	name: 'log_contra',
	rules: 'required'
  }
], function(errors, event) {
      form_error_eliminar("#f_form"); 
      if(errors.length > 0) {
          //Creando todas las alertas
          for (var i=0; i<errors.length; i++) {
              var id = errors[i]["id"];
              var mensaje = errors[i]["message"];
              form_error(id, mensaje);
              if(i == 0){ $("#"+id).focus(); }
          }
      }
});