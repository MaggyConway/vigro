// $(document).ready(function () {
// 	// open / close select panel

//     if(location.pathname == '/') {

//         $('.pseudo_select .active_label').on('click', function (e) {
//             e.preventDefault();
//             let panel = $(this).next('.pseudo_select__panel');
//             if (panel.css('display') !== 'block') {
//                 $('.hero__filter .pseudo_select__panel').hide();
//                 $('.hero__filter .pseudo_select .active_label').removeClass('opened');
//             }
//             panel.toggle();
//             $(this).toggleClass('opened');
//         });
    
//         $('.pseudo_select__item').on('click', function (e) {
//             e.preventDefault();
//             let prop = $(this).attr('data-val');
//             let select = $(this).parent().parent().parent().find('select');
//             let panel = $(this).parent();
//             let label = $(this).parent().parent().find('.active_label');
//             let txt = $(this).text();
    
//             label.text(txt);
//             label.removeClass('opened');
//             select.val(prop);
//             panel.hide();
//         });
        
//     }
// });
