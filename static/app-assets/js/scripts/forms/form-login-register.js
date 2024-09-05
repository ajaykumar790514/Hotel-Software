$(document).ready(function(){
	'use strict';
	//Login Register Validation
	if($("form.form-horizontal").attr("novalidate")!=undefined){
		$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
	}

	// For change default year in copyright
	var $year = new Date().getFullYear();
	$(".year").text($year);


	$('#login').submit(function(){
		$.post($(this).attr('action'),$(this).serialize())
		.done(function(data){
			data = JSON.parse(data);
			$('.'+data.res).html(data.msg);
			if (data.res=='success') {
				setTimeout(function() {
					window.open(data.redirect_url,'_self');
				}, 500);
			}
		})

		return false;
	})

	$('#login2').submit(function(){
		$.post($(this).attr('action'),$(this).serialize())
		.done(function(data){
			data = JSON.parse(data);
			$('.'+data.res).html(data.msg);
			if (data.res=='success') {
				setTimeout(function() {
					window.open(data.redirect_url,'_self');
				}, 500);
			}
		})

		return false;
	})
});
