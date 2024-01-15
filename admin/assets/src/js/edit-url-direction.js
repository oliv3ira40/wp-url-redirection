jQuery(function($) {
    const equal_fields = $('.equal-fields');
    const url_origin = $('.url_origin');
    var input_url_origin = url_origin.find('input');
    const url_destiny = $('.url_destiny');
    var input_url_destiny = url_destiny.find('input');
    var label_url_destiny = url_destiny.find('label');

    input_url_origin.on('input', function() {
        console.log(input_url_origin.val());
        check_equal_fields()
    });

    input_url_destiny.on('input', function() {
        console.log(input_url_destiny.val());
        check_equal_fields()
    });

    function check_equal_fields() {
        if (input_url_origin.val() == input_url_destiny.val()) {
            equal_fields.addClass('text-danger');
            label_url_destiny.append('<span class="text-danger"> (não pode ser igual a url de origem)<span>');
        } else {
            equal_fields.removeClass('text-danger');
            label_url_destiny.find('span').remove();
        }
    }
})
