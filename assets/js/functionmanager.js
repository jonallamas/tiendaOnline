
	function validarCorreo(valor) {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(valor)) { return true; }else{ return false; }
	}
