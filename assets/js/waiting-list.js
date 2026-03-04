$(document).ready(function () {

    $('#waitingListForm').on('submit', function (event) {
        event.preventDefault();

        var $form   = $(this);
        var $btn    = $('#submitBtn');
        var $response = $('#response');

        // Disable button and show sending state
        $btn.prop('disabled', true).text('Sending...');
        $response.removeClass('d-none').html('');

        // Request reCAPTCHA token then submit
        grecaptcha.ready(function () {
            grecaptcha.execute('6LeRdqkkAAAAAHn11l-i3DDK9vgpi10iULGTpMHT', {
                action: 'submit'
            }).then(function (token) {

                var formData = new FormData($form.get(0));
                formData.append('token', token);

                $.ajax({
                    type: 'POST',
                    url: '/scripts/waiting-list-script.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.success) {
                            // Hide the form, show success message
                            $form.hide();
                            $response
                                .removeClass('d-none error')
                                .addClass('form-response')
                                .html('<p>' + data.message + '</p>')
                                .slideDown(400);
                        } else {
                            // Show inline error, re-enable button
                            $response
                                .removeClass('d-none')
                                .addClass('form-response error')
                                .html('<p>' + data.message + '</p>')
                                .slideDown(400);
                            $btn.prop('disabled', false).text('Join Waiting List');
                        }
                    },
                    error: function () {
                        $response
                            .removeClass('d-none')
                            .addClass('form-response error')
                            .html('<p>Something went wrong. Please try again or call us on <a href="tel:01406258382">01406 258382</a>.</p>')
                            .slideDown(400);
                        $btn.prop('disabled', false).text('Join Waiting List');
                    }
                });
            });
        });
    });

});
