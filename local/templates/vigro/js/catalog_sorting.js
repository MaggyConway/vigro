$(document).ready(function () {
	// open / close select panel
	$('.catalog_sort .pseudo_select .active_label').on('click', function (e) {
		let panel = $(this).next('.pseudo_select__panel');
		panel.toggle();
		$(this).toggleClass('opened');
	});
});
