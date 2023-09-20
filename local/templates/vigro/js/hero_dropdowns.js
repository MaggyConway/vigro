$(document).ready(function () {
    if(location.pathname == '/') {

        $('.pseudo_select .active_label').on('click', function (e) {
            e.preventDefault();
            let panel = $(this).next('.pseudo_select__panel');
            if (panel.css('display') !== 'block') {
                $('.hero__filter .pseudo_select__panel').hide();
                $('.hero__filter .pseudo_select .active_label').removeClass('opened');
            }
            panel.toggle();
            $(this).toggleClass('opened');
        });
    
        $('.pseudo_select__item').on('click', function (e) {
            e.preventDefault();
            let prop = $(this).attr('data-val');
            // console.log('prop = ', prop);
            let select = $(this).parent().parent().parent().find('select');
            let panel = $(this).parent();
            let label = $(this).parent().parent().find('.active_label');
            let txt = $(this).text();
            let url = $(this).attr('data-url');
    
            label.text(txt);
            label.removeClass('opened');
            select.val(prop);
            panel.hide();

            if (prop == 'faucet') {
                $('.hero__filter > .col.type').find('.active_label').text('———')
                $('.hero__filter > .col.type').addClass('disable');
            } else if (prop == 'washing') {
                $('.hero__filter > .col.type').removeClass('disable');
                $('.hero__filter > .col.type').find('.active_label').text('Круглая');
            }

            $('.hero__filter .btn').attr('href', url);
        });
        
    }
});