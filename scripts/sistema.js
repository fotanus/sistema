// JavaScript Document
function showErrorMsg(msg, typ, rload){//showErrorMsg
	var tipo = ['fk-message-success', 'fk-message-error'];
	if(rload == undefined) rload = false;
	$('.fk-message').removeClass(tipo[0]).removeClass(tipo[1]);
	$('.fk-message').addClass(tipo[typ]);
	$('.fk-message-txt').html(msg);
	$('#showErrorMsg').slideDown(function(){
		setTimeout(function(){
			$('#showErrorMsg').slideUp();
			if(rload) location.reload();
			}, 3000);
		});
};