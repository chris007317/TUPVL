$(document).on('click', 'body', function(e) {
	$('.input-grupo-login').css('border-color', '#BDB9BA');
});

$(document).on('click', '.input-grupo-login input', function(e) {
	const elemento = $(this).parent();
	$('.input-grupo-login').css('border-color', '#BDB9BA');
	elemento.css('border','1px solid #FF2D4D');
	e.stopPropagation();
});

