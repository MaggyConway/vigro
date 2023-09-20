$(document).ready(function () {
	// кнопка "вверх"
	$().UItoTop({ easingType: 'easeOutQuart' });


	// табы на главной
	$('.catalog_sliders .tabs > li').on('click', function (e) {
		$('.catalog_sliders > div').removeClass('show');
		let type = $(this).attr('data-type');
		if (type == 'hit') {
			$('.catalog_sliders__hits').addClass('show').slick('setPosition');
		} else if (type == 'new') {
			$('.catalog_sliders__new').addClass('show').slick('setPosition');
		}
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});


	// аккордеон на главной
	$('.faq__accordeon__item.opened > .desc').slideDown();

	$('.faq__accordeon__item > h3').on('click', function (e) {
		$(this).parent().toggleClass('opened');
		$(this).next('.desc').slideToggle();
	});


	// sticky header
	$(window).on('scroll', function (e) {
		let sticky = $('.header > .row:nth-child(2)');
		if (
			$(this).scrollTop() > $('.header').height() &&
			!$('.header > .row:nth-child(2)').hasClass('sticky')
		) {
			sticky.addClass('sticky').addClass('container');

			if(location.pathname !== '/shop/') {
				sticky.find('#main_menu_trigger').on(
					'mouseenter',
					function (e) {
						$('#main_menu_panel').addClass('sticky_main_menu_panel');
					}
				);
			}
		} else if (
			$(this).scrollTop() <= $('.header').height() &&
			sticky.hasClass('sticky')
		) {
			sticky.removeClass('sticky').removeClass('container');
			$('#main_menu_panel').removeClass('sticky_main_menu_panel'); //!
			// нужно отследить, когда в какой момент не убирается класс - и убирать его
		}
	});


	// mobile filter
	if($(window).width() < 769) {
		let filterClone = $('.catalog_section .catalog_section__filter').clone();
		$('.mobile_filter_panel').append(filterClone);
		$('.catalog_section .catalog_section__filter').hide();
	}

	$('.mobile_filter_open_btn').on('click', function(e) {
		$('.mobile_filter_panel').addClass('show');
		$('body').addClass('panel_opened');

		$('.mobile_filter_panel.show .bx-filter-param-label').on('click', function (e) {
			let chbox = $(this).find('input[type="checkbox"]');
			chbox.prop('checked', !chbox.prop('checked'));
		});
	});

	$('.mobile_filter_panel--close').on('click', function(e) {
		$('.mobile_filter_panel').removeClass('show');
		$('body').removeClass('panel_opened');
	});

	
	// wishlist toggle hearts
	$("body").on('click', '.wish, .btn_wish', function (e) {
		// $(this).toggleClass('active');

		console.log($(this).attr("data-product-id"));
        let like = $(this);
        $.ajax({
            url: "/include/addToFavorites.php",
            data: "id=" + $(this).attr("data-product-id"),
            method: "POST",
            success: function (data) {
                // let count = parseInt($('span#wish_count').html());
                if(data == "true"){
                    // $('span#wish_count').html(++count);
                    $(like).addClass("active");
                }else{
                    // $('span#wish_count').html(--count);
                    $(like).removeClass("active");

                    if (location.pathname == '/wishlist/') {
                    	location.href = "/wishlist/";
                    }
                }
            },
            error: function (er) {
                console.log("er",er);
            }
        });
	});

});
