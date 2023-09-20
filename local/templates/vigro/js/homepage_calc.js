$(document).ready(function () {
	// выделение чекбоксов на шаге "выбор цвета"
	$('.calc__overview .step--color ul li').on('click', function (e) {
		$(this).toggleClass('checked');
	});

	const progressBar = $('.calc__overview .calc__progress');
	const stepStyle = $('.calc__overview .step--style');
	const stepColor = $('.calc__overview .step--color');
	const stepProcess = $('.calc__overview .step--process');
	const stepResult = $('.calc__overview .step--result');
	const showMore = $('.calc__overview .step--result__readmore');
	const btnRestart = $('.calc__overview .btn.restart');

	const changeStepTime = 500;

	let checked_items = [];
	let checked_colors = [];

    let quantityIdeas = null;

	// временно отключила клики на ссылки в результатах
	$('.calc__overview a').on('click', function (e) {
		e.preventDefault();
	});

	// потом в аякс-запросе отправлять эти массивы на php-файл обработчик
	// далее эти данные там в файле принимать и по ним строить вывод компонента с фильтрацией

	$('.calc__overview .step--style > .btn').on('click', function (e) {
		e.preventDefault();
		$(this)
			.prev('ul')
			.find('input')
			.each(function (id, el) {
				if ($(el).prop('checked') == true) {
					checked_items.push($(el).attr('data-name'));
				}
			});

		// console.log(checked_items);
		progressBar.attr('progress', '33%');

		setTimeout(() => {
			stepStyle.removeClass('active');
			stepColor.addClass('active');
		}, changeStepTime);
	});

	$('.calc__overview .step--color > .btn').on('click', function (e) {
		e.preventDefault();
		$(this)
			.prev('ul')
			.find('li')
			.each(function (id, el) {
				if ($(el).hasClass('checked')) {
					checked_colors.push($(el).find('img').attr('data-code'));
				}
			});

		// console.log(checked_colors);

		progressBar.attr('progress', '66%');
		setTimeout(() => {
			stepColor.removeClass('active');
			stepProcess.addClass('active');
			progressBar.attr('progress', '100%');
		}, changeStepTime);

		// let props = [{'checked_items':checked_items}, {'checked_colors':checked_colors}];
		let props = [checked_items, checked_colors];

		// аякс запрос к ideas_calc.php
		$.post('/include/ideas_calc.php', { props: props }, function (response) {
			stepResult.html(' ');
			stepResult.append(response);
			console.log(response);

			setTimeout(() => {
                quantityIdeas = $('.step--result__grid > li').length;
				if (quantityIdeas > 2) {
					showMore.show();
                    showMore.on('click', function (e) {
                        // quantityIdeas -= 2;
                        // console.log(quantityIdeas);
                        $('.step--result__grid > li').show();
                        showMore.hide();
                    });
				}
				btnRestart.show();
				stepProcess.removeClass('active');
				stepResult.addClass('active');
				progressBar.removeClass('active').removeClass('searching');
				progressBar.hide();
				progressBar.attr('progress', '0');
			}, changeStepTime);
		});
	});

	// $('.calc__overview .step--process > .btn').on('click', function (e) {
	//     e.preventDefault();

	// setTimeout(() => {
	//     stepProcess.removeClass('active');
	//     stepResult.addClass('active');
	//     progressBar.removeClass('active').removeClass('searching');
	//     progressBar.hide();
	//     progressBar.attr('progress', '0');
	// }, 4500);
	// });

	// клик по кнопке "вдохновиться ещё раз"
	btnRestart.on('click', function (e) {
		e.preventDefault();
		stepResult.removeClass('active');

		checked_items = [];
		checked_colors = [];

		stepStyle.find('ul').find('input').prop('checked', false);
		stepColor.find('ul').find('li').removeClass('checked');

		showMore.hide();
		btnRestart.hide();
		stepStyle.addClass('active');
		$('.calc__overview .calc__progress').show();
		// $(window).scrollTop($('.calc'));

		$('html').animate(
			{
				scrollTop: $('.calc').offset().top - 100,
			},
			500
		);
	});
});
