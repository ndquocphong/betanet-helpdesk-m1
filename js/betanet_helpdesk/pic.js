jQuery(document).ready(function () {
    jQuery('input[type="checkbox"][name="is_pic"]').on('change', function () {
        var userId = jQuery(this).val(),
            action = '';
        if (jQuery(this).prop('checked')) {
            action = 'insert';
        } else {
            action = 'remove';
        }

        jQuery.ajax(window.BASE_URL + 'helpdesk_pic/update', {
            method: 'post',
            data: {
                'form_key': window.FORM_KEY,
                'user_id': userId,
                'action': action
            },
            beforeSend: function () {
                jQuery('#loading-mask').show();
            },
            complete: function () {
                jQuery('#loading-mask').hide();
            }
        });
    });
});