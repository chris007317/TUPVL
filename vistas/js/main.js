var btnMenu = document.getElementById('btn-menu');
var nav = document.getElementById('menu');
var borde = document.getElementById('nav-content');
btnMenu.addEventListener('click', function(){
	nav.classList.toggle('mostrar-menu');
	borde.classList.toggle('sin-borde');
});
var btn1 = document.getElementById('menu-list');
btn1.addEventListener('click', function(){
	nav.classList.remove('mostrar-menu');
	borde.classList.remove('sin-borde');
});	

var divHeight;
var obj = document.getElementById('nav-content'); 
	if(obj.offsetHeight){
		divHeight=obj.offsetHeight;
 	}
  else if(obj.style.pixelHeight){
  	divHeight=obj.style.pixelHeight;
  }

$(window).on('scroll', function(){
	if($(window).scrollTop()>divHeight){
		$('.nav-content').addClass('header-mover');
	}
	else{
		$('.nav-content').removeClass('header-mover');	
	}

	if ($(window).scrollTop()>100) {
		$('.flecha-up').fadeIn('slow');
	}else{
		$('.flecha-up').fadeOut('slow');
	}
});


$(document).on('click', '.menu-link', function(e) {
	$('.activo').removeClass('activo');
	$(this).addClass('activo');
});