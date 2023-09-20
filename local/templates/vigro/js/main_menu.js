$(document).ready(function () {
	if(location.pathname !== '/shop/') {
		if ($(window).width() > 1023) {
			$('#main_menu_trigger, #mobile_menu_trigger').on(
				'mouseenter',
				function (e) {
					$('#main_menu_panel').fadeIn('fast');
					$('#main_menu_panel').css('top', 128 + $('#bx-panel').height() + 'px');
					$('#main_menu_trigger, #mobile_menu_trigger').addClass('active');
				}
			);
	
			$('#main_menu_panel').on('mouseleave', function (e) {
				$('#main_menu_panel').fadeOut('fast');
				$('#main_menu_trigger, #mobile_menu_trigger').removeClass('active');
				$('#main_menu_panel').removeClass('sticky_main_menu_panel'); //!
				// нужно отследить, когда в какой момент не убирается класс - и убирать его
			});
		}
		if ($(window).width() > 767 && $(window).width() < 1024) {
			$('#main_menu_trigger, #mobile_menu_trigger').on(
				'click',
				function (e) {
					$('#main_menu_panel').fadeToggle('fast');
					$('#main_menu_trigger, #mobile_menu_trigger').toggleClass(
						'active'
					);
				}
			);
		}
	}

	if ($(window).width() < 768) {
		$('#mobile_menu_trigger').on('click', function (e) {
			$('.header').toggleClass('mobile_menu_opened');
			$('body').toggleClass('panel_opened');

			$('#mobile_menu_panel').fadeToggle('fast');
			$('#mobile_menu_trigger').toggleClass('active');
		});

		$('.mobile_menu > li:first').on('click', function (e) {
			$(this).toggleClass('opened');
		});
	}
});
