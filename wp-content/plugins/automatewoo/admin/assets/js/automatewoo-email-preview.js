jQuery(function($) {

    /**
     * Init
     */
    function init() {

        set_iframe_height();

        $(window).resize(function(){
            set_iframe_height();
        });

    }


    function set_iframe_height() {
        $('.email-iframe').height( $(window).height() - $('.email-preview-header').outerHeight() );
    }



    $('form.email-preview-send-test-form').submit(function(e){
        e.preventDefault();

        var $form = $(this);

        $form.addClass('loading');
        $form.find('button').blur();

        $.ajax({
                method: 'POST',
                url: ajaxurl,
                data: {
                    action: 'aw_send_test_email',
                    type: $form.find('[name="type"]').val(),
                    to_emails: $form.find('[name="to_emails"]').val(),
                    args: $.parseJSON( $form.find('[name="args"]').val() )
                }
            })
            .done(function(response){
                alert( response.data.message );
                $form.removeClass('loading');
            })

            .fail(function(response){
                console.log( response );
            })
        ;

        return false;

    });


    init();

});