$(document).ready(function () {
	$('.advantages__slider').slick({
		infinite: true,
		arrows: true,
		dots: true,
		autoplay: false,
		speed: 1200,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
				},
			},
		],
	});

	$('.find_couple__slider').slick({
		infinite: true,
		variableWidth: true,
		arrows: true,
		dots: false,
		autoplay: false,
		speed: 700,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					dots: true,
				},
			},
			{
				breakpoint: 576,
				settings: {
					variableWidth: false,
					arrows: false,
					dots: true,
				},
			}
		],
	});

	$('.catalog_sliders__hits, .catalog_sliders__new, .catalog_slider').slick({
		infinite: true,
		arrows: true,
		dots: true,
		autoplay: false,
		speed: 1200,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2
				},
			},
			{
				breakpoint: 576,
				settings: {
					arrows: false,
					slidesToShow: 1
				},
			}
		]
	});

	$('.news__slider').slick({
		infinite: true,
		arrows: true,
		dots: true,
		autoplay: false,
		speed: 1200,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			// {
			// 	breakpoint: 992,
			// 	settings: {
			// 		slidesToShow: 3
			// 	},
			// },
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2
				},
			},
			{
				breakpoint: 576,
				settings: {
					arrows: false,
					slidesToShow: 1
				},
			}
		],
	});
});
