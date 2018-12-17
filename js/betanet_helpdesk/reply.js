jQuery(document).ready(function () {
    jQuery('#reply_submit').on('click', function () {

        jQuery.ajax(jQuery('#reply_submit_url').val(), {
            method: 'post',
            data: {
                'form_key': window.FORM_KEY,
                'message': jQuery('#reply_message').val(),
                'status_id': jQuery('#reply_status_id').val(),
                'user_id': jQuery('#reply_user_id').val(),
                'customer_id': jQuery('#reply_customer_id').val(),
                'ticket_id': jQuery('#reply_ticket_id').val()
            },
            beforeSend: function () {
                jQuery('#loading-mask').show();
            },
            success: function(response) {
                if (response.hasOwnProperty('payload')) {
                    var reply = jQuery('<div class="reply" style="margin-bottom: 10px">' +
                        '<blockquote class="reply-blockquote-right"></blockquote>' +
                        '<p class="reply-blockquote-author"></p>' +
                        '</div>');
                    var status = jQuery('<span class="status_id-'+response.payload.status.id+'"></span>').text(response.payload.status.title);
                    reply.find('.reply-blockquote-right').text(response.payload.message);
                    reply.find('.reply-blockquote-author').text(response.payload.author.fullname+' | '+response.payload.date+' | ').append(status);
                    jQuery('#replies-conversation').append(reply);
                    jQuery('#reply_message').val('');
                }
            },
            complete: function () {
                jQuery('#loading-mask').hide();
            }
        });

        return false;
    });
});