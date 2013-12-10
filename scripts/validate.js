/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	//global vars
	
	var form = $(document).find('form');// $("#un");
	//console.log($(form));
	var name = $("#Nombre");
	var nameInfo = $("#snombre");
	var email = $("#Correo");
	var emailInfo = $("#scorreo");
	var pass1 = $("#Password");
	var pass1Info = $("#spassword");
	var pass2 = $("#CPassword");
	var pass2Info = $("#scpassword");
	//var message = $("#message");
	var tyc = $('#tyc');
	var ap = $('#ap')
	
	var telefono = $("#Telefono");
	var stelefono = $("#stelefono");
	
	var comment = $("#Comment");
	var scomment = $("#scomment");
	
	//On blur
	name.blur(validateName);
	email.blur(validateEmail);
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
	telefono.blur(validateTelefono);
	comment.blur(validateComments);
	//On key press
	name.keyup(validateName);
	pass1.keyup(validatePass1);
	pass2.keyup(validatePass2);
	telefono.keyup(validateTelefono);
	comment.keyup(validateComments);
	//message.keyup(validateMessage);
	//On Submitting
	form.submit(function(){
		if(form.attr('name') == 'un'){
			if(validateName() & validateEmail() & validatePass1() & validatePass2())
				return true;
			else
				return false;
		}
		if(form.attr('name') == 'fc'){
			if(validateName() & validateEmail() & validateTelefono() & validateComments())
				return true;
			else
				return false;
		}
		if(form.attr('name') == 'nmisip'){
			if(validateName() & validateEmail() & validatePass1() & validatePass2() & validatecheckbox())
				return true;
			else
				return false;
		}
	});
	
	function validatecheckbox(){
		console.log($('#tyc').prop('checked'));
		if($('#tyc').prop('checked') == false || $('#ap').prop('checked') == false){
			if($('#tyc').prop('checked') == false){
				$('#lbtyc').text(' Se debe aceptar los terminos y condiciones');
			}
			if($('#ap').prop('checked') == false){
				$('#lbap').text(' Se debe aceptar el aviso de privacidad');
			}
			return false;
		} else {
			if($('#tyc').prop('checked') == true){
				$('#lbtyc').text(' Se acepto los terminos y condiciones');
			}
			if($('#ap').prop('checked') == true){
				$('#lbap').text(' Se acepto el aviso de privacidad');
			}
			return true;
		}
	}
	
	function validateComments(){
		if(comment.val().length < 20){
			comment.addClass("error");
			scomment.text("Por favor incluya sus comentarios");
			scomment.addClass("error");
			return false;
		} else {
			comment.removeClass("error");
			scomment.text("Agrege sus comentarios");
			scomment.removeClass("error");
			return true;
		}
	}
	
	function validateTelefono(){
		if(telefono.val().length < 10){
			telefono.addClass("error");
			stelefono.text("El número de teléfono es muy corto");
			stelefono.addClass("error");
			return false;
		}
		else{
			telefono.removeClass("error");
			stelefono.text("Ingresa tu número de teléfono!");
			stelefono.removeClass("error");
			return true;
		}
	}
	//validation functions
	function validateEmail(){
		//testing regular expression
		var a = $("#Correo").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email.removeClass("error");
			emailInfo.text("¿Cual es tu correo?");
			emailInfo.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			email.addClass("error");
			emailInfo.text("Ingresa una dirección de correo valida.");
			emailInfo.addClass("error");
			return false;
		}
	}
	function validateName(){
		//if it's NOT valid
		if(name.val().length < 4){
			name.addClass("error");
			nameInfo.text("Ingresa un nombre valido!");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("¿Cual es tu nombre?");
			nameInfo.removeClass("error");
			return true;
		}
	}
	function validatePass1(){
		var a = $("#Password");
		var b = $("#CPassword");

		//it's NOT valid
		if(pass1.val().length < 5){
			pass1.addClass("error");
			pass1Info.text("Minimo 5 caracteres: letras, numeros y '_'");
			pass1Info.addClass("error");
			return false;
		}
		//it's valid
		else{
			pass1.removeClass("error");
			pass1Info.text("Escriba su contraseña");
			pass1Info.removeClass("error");
			validatePass2();
			return true;
		}
	}
	function validatePass2(){
		var a = $("#Password");
		var b = $("#CPassword");
		//are NOT valid
		if( pass1.val() != pass2.val() ){
			pass2.addClass("error");
			pass2Info.text("La contraseña no es igual!");
			pass2Info.addClass("error");
			return false;
		}
		//are valid
		else{
			pass2.removeClass("error");
			pass2Info.text("Confirme su contraseña");
			pass2Info.removeClass("error");
			return true;
		}
	}
});