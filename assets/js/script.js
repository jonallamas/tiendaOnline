// Validaciones logueo
$('#modalbtnIngresar').on('click', function(e){
    e.preventDefault();

    let modal_login_correo = $('#modal_login_correo').val();
    let modal_login_pass = $('#modal_login_pass').val();

    $('#modal_alerta_login').fadeOut('fast');

    // ----------------------
    // 
    // Optimizar validaciones
    // 
    // ----------------------
    if(modal_login_correo == ''){
        $('#modal_alerta_login').fadeIn('fast', function(){
            $('#modal_alerta_login').html('<p><b>Atención:</b> Debe rellenar el correo</p>');
            $('#modal_login_correo').focus();
        });
        return false;
    }

    if(validarCorreo(modal_login_correo) == false){
        $("#modal_alerta_login").fadeIn('fast', function(){
            $('#modal_alerta_login').html("<p><b>Atención:</b> La dirección de email es incorrecta</p>");
            $("#modal_login_correo").focus();
        });
        return false;
    }
    if(modal_login_pass == ''){
        $("#modal_alerta_login").fadeIn('fast', function(){
            $('#modal_alerta_login').html('<p><b>Atención:</b> Campo incompleto</p>');
            $('#modal_login_pass').focus();
        });
         return false;
    }

    $.ajax({
        type: 'POST',
        data: {
            'f_login_correo': modal_login_correo,
            'f_login_pass'  : modal_login_pass
        },
        url: base_url+'panel/ingreso',
        success: function(data){
        var data = jQuery.parseJSON(data);
        if(data.conectado == 1){
            if(data.usuario_tipo == 1){
                $("#modal_alerta_login").fadeOut('fast');
                window.location.replace(base_url+'panel');
            }else{
                $("#modal_alerta_login").fadeOut('fast');
                window.location.replace(base_url);
            }
        }
        else{
            if(data.error){
                if(data.error_tipo == 1){
                    $("#modal_alerta_login").fadeIn('fast');
                    $('#modal_alerta_login').html('<p><b>Atención:</b> '+data.error_text+'</p>');
                };
            }
        }
      }
    });
});

function validarCorreo(valor) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(reg.test(valor)) { return true; }else{ return false; }
}

$('#btnRegistro').on('click', function(e){
    e.preventDefault();
    $('.login-body').fadeOut('fast', function(){
        $('.registro-body').fadeIn('fast');
    });
    $('#modal-id').modal('show');
});

$('#btnIngreso').on('click', function(e){
    e.preventDefault();
    $('.registro-body').fadeOut('fast', function(){
        $('.login-body').fadeIn('fast');
    });
});

// Validaciones para registro
$('#modalbtnRegistrarme').on('click', function(e){
    e.preventDefault();

    let modal_registro_apellido = $('#f_registro_apellido').val();
    let modal_registro_nombre = $('#f_registro_nombre').val();
    let modal_registro_correo = $('#f_registro_correo').val();
    let modal_registro_pass = $('#f_registro_pass').val();
    let modal_registro_pass_verificar = $('#f_registro_pass_verificar').val();

    $('#modal_alerta_login').fadeOut('fast');

    // ----------------------
    // 
    // Optimizar validaciones
    // 
    // ----------------------
    if(modal_registro_apellido == ''){
        $("#modal_alerta_registro").fadeIn('fast', function(){
            $('#modal_alerta_registro').html('<p><b>Atención:</b> Campo incompleto</p>');
            $('#f_registro_apellido').focus();
        });
         return false;
    }
    if(modal_registro_nombre == ''){
        $("#modal_alerta_registro").fadeIn('fast', function(){
            $('#modal_alerta_registro').html('<p><b>Atención:</b> Campo incompleto</p>');
            $('#f_registro_nombre').focus();
        });
         return false;
    }
    if(modal_registro_correo == ''){
        $('#modal_alerta_registro_correo').fadeIn('fast', function(){
            $('#modal_alerta_registro_correo').html('<p><b>Atención:</b> Debe rellenar el correo</p>');
            $('#f_registro_correo').focus();
        });
        return false;
    }
    if(validarCorreo(modal_registro_correo) == false){
        $("#modal_alerta_registro_correo").fadeIn('fast', function(){
            $('#modal_alerta_registro_correo').html("<p><b>Atención:</b> La dirección de email es incorrecta</p>");
            $("#f_registro_correo").focus();
        });
        return false;
    }
    if(modal_registro_pass == ''){
        $("#modal_alerta_registro").fadeIn('fast', function(){
            $('#modal_alerta_registro').html('<p><b>Atención:</b> Campo incompleto</p>');
            $('#f_registro_pass').focus();
        });
         return false;
    }
    if(modal_registro_pass_verificar == ''){
        $("#modal_alerta_registro").fadeIn('fast', function(){
            $('#modal_alerta_registro').html('<p><b>Atención:</b> Campo incompleto</p>');
            $('#f_registro_pass_verificar').focus();
        });
         return false;
    }

    if(validar_pass() == false){
        return false;
    }

    $.ajax({
        type: 'POST',
        data: {
            'f_registro_apellido': modal_registro_apellido,
            'f_registro_nombre'  : modal_registro_nombre,
            'f_registro_correo'  : modal_registro_correo,
            'f_registro_pass'  : modal_registro_pass
        },
        url: base_url+'panel/registro',
        success: function(data){
        var data = jQuery.parseJSON(data);
        if(data.conectado == 1){
            $("#modal_alerta_registro").fadeOut('fast');
            window.location.replace(base_url+'tienda/carrito');
        }
        else{
            if(data.error){
                if(data.error_tipo == 1){
                    $("#modal_alerta_registro").fadeIn('fast');
                    $('#modal_alerta_registro').html('<p><b>Atención:</b> '+data.error_text+'</p>');
                };
            }
        }
      }
    });
});

$('#f_registro_correo').on('change', function(){
    let correo = $(this).val();
    $('#modal_alerta_registro_correo').fadeOut('fast', function(){
        $('#modal_alerta_registro_correo').html('');
    });
    if(validarCorreo(correo) == false){
        $('#modal_alerta_registro_correo').fadeIn('fast', function(){
            $('#modal_alerta_registro_correo').html('Correo incorrecto');
            $('#f_registro_correo').focus();
        });
        return false;
    }
    $.ajax({
        type: 'POST',
        data: {
            'f_correo': correo
        },
        url: base_url+'panel/validar_correo',
        success: function(data){
            data = JSON.parse(data);
            if(data.error == 1){
                $('#modal_alerta_registro_correo').fadeIn('fast', function(){
                    $('#modal_alerta_registro_correo').html(data.error_texto);
                });
            }else{
                $('#modal_alerta_registro_correo').fadeOut('fast', function(){
                    $('#modal_alerta_registro_correo').html('');
                });
            }
        }
    });
});

function validar_pass(){
    let pass        = $('#f_registro_pass').val();
    let pass_verif  = $('#f_registro_pass_verificar').val();

    if(pass != pass_verif){
        $('#modal_alerta_registro').fadeIn('fast', function(){
            $('#modal_alerta_registro').html('Contraseña no coinciden');
        });
        return false;
    }else{
        $('#modal_alerta_registro').fadeOut('fast', function(){
            $('#modal_alerta_registro').html('');
        });
        return true;
    }
}


// Funciones para el carrito de compra
function carrito_producto_agregar(id, precio, nombre)
{
    cantidad_producto = $("#producto_cantidad_"+id).val();
    $.ajax({
        type: 'POST',
        data: {
            'producto_id'       : id,
            'producto_cantidad' : cantidad_producto,
            'producto_precio'   : precio,
            'producto_nombre'   : nombre
        },
        url: base_url+'tienda/producto_agregar',
        success: function(data){
            data = JSON.parse(data);
            $('.carrito_cantidad').html(data.carrito_cant);
            // $("#producto_cantidad_"+id).val('').html('');
            console.log('Se agregó la cantidad de '+data.producto_cantidad+' '+data.producto_nombre);
        }
    });
}

function carrito_recalcular(){
    var carrito_total_productos = 0;
    var carrito_total = 0;
    $('.carrito_producto_item').each(function(){
        var producto_catidad    = $(this).val();
        var producto_precio     = $(this).data('precio');
        var producto_id         = $(this).data('productoid');
        carrito_total_productos = carrito_total_productos + parseInt(producto_catidad);
        var producto_total      = producto_precio * producto_catidad;
        carrito_total           = carrito_total + producto_total;
        producto_total          =  producto_total.toFixed(2);
        $("#carrito_producto_"+producto_id+"_precio").html(producto_total);
    });
    $('.carrito_cantidad').html(carrito_total_productos);
    carrito_total = carrito_total.toFixed(2);
    $("#carrito_total").html(carrito_total);
}

function carrito_producto_eliminar(rowid){
    $.ajax({
        type: 'POST',
        data: {
            'row_id': rowid
        },
        url: base_url+'tienda/producto_eliminar',
        success: function(data){
            data = JSON.parse(data);
            if(data){
                if(data.carrito_cant > 0){
                    $('#carrito_producto_lista_'+data.producto_id).remove();
                    console.log('Se eliminó el producto '+data.producto_nombre);
                    carrito_recalcular();
                }else{
                    window.location.replace(base_url);
                }
            }
        }
    });
}