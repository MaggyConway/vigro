$(document).ready(function () {
    let myHash = location.hash; //получаем значение хеша
	location.hash = ''; //очищаем хеш
	if(myHash[1] != undefined) { //проверяем, есть ли в хеше какое-то значение

	if (myHash) {
		$('html, body').animate(
		{scrollTop: $(myHash).offset().top - 90}
		, 2000);
		location.hash = myHash; //возвращаем хеш
		};
	}

	//СКРОЛЛИНГ-МЕНЮ
	$(function(){
		$('a[href^="#"]').on('click', function(event) {  
			var src = $(this).attr("href"),
			sectionPosition = $(src).offset().top - 90;
			$('html, body').animate({scrollTop: sectionPosition}, 1000);
			$('.small_menu').removeClass('opened');
		});
	});
	// function smoothToBlock() {
	// 	var src = '#' + $(event.target).attr("href").split('#')[1];
	// 	console.log(src);
	// 	var sectionPos = $(src).offset().top;
	// 	$('html, body').animate({scrollTop: sectionPos}, 1000);
	// 	$('.small_menu').removeClass('opened');
	// }
});