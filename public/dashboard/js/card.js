$(function(){

    $(document).on('click', '#choose_address', function(){

        let customer = $(this).val();

        if ($(this).is(':checked')) {
            $('#address_slug').removeAttr('disabled');
            let status = 'user';
            $.post('/distributor/load-customer-address', {customer: customer, status: status, address_type: 'billing'}, function(data){

                populateForm(data);
            })
            $.post('/distributor/load-customer-address', {customer: customer, status: status, address_type: 'shipping'}, function(data){
                populateForm(data);
            })
        }else{
            $("#checkoutForm")[0].reset();
            $(".form-control").removeClass('in-active');
            $('#address_slug').attr('disabled', 'disabled');
        }
    })

    

    function populateForm(data){

        var frm = $("#checkoutForm");
        var i;

        for (i in data) {
             if (frm.is('select')) //special form types
             {
                $('option', frm).each(function(index, value) {

                    if (this.value == value)
                        this.selected = true;
                    // this.selected.trigger('change');

                })

            } else{

                frm.find('[name="' + i + '"]').val(data[i]).addClass('in-active');
            }
        }

        $('.select2').trigger('change');
        // $('#billing_country').trigger('change');
        // $('#shipping_country').trigger('change');
    }


    // Stripe
    var elements = stripe.elements();
    const cardButton = document.getElementById('checkout_submit');
    const checkoutForm = document.getElementById('checkoutForm');

    var cardElement = elements.create('card', {

        hidePostalCode: false
    });

    cardElement.mount('#card-element');
    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });


    const clientSecret = cardButton.dataset.secret;

    checkoutForm.addEventListener('submit', async (e) => {

        e.preventDefault();

        $('#checkout_submit').html('<i class="fas fa-spinner fa-spin"></i> Submiting').attr('disabled', 'disabled');
        // cardButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submiting';
        // cardButton.disabled = true;


        if ($('#bankTransfer').is(':checked')) {

            document.getElementById('checkoutForm').submit();

        }else{

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                  card: cardElement,
                  billing_details: {
                    // billing_details: { name: cardHolderName.value }
                },
            },
        }).then(function(result) {
            // Handle result.error or result.paymentIntent
            if (result.error) {
                // Display "error.message" to the user...
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                cardButton.innerHTML = 'Place Order';
                cardButton.disabled = false;
            } else {
                // The card has been verified successfully, send to server

                stripePaymentMethodHandler(result.paymentIntent.payment_method);
            }
        });

    }

});

    function stripePaymentMethodHandler(paymentMethod) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('checkoutForm');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'paymentMethod');
      hiddenInput.setAttribute('value', paymentMethod);
      form.appendChild(hiddenInput);
      // disable onbeforeunload
      window.onbeforeunload = null;
      // Submit the form
      form.submit();
  }



  $(document).on('click', '.paymentMethod', function () {
    if ($('#bankTransfer').is(':checked')) {
        $('#payWithStripe').hide();
    }else{
        $('#payWithStripe').show();
    }
})

  $(document).on('click', '#showNewShippingForm', function () {
    if ($(this).is(':checked')) {
        $('#deliverToDifferentAddress').show();
    }else{
        $('#deliverToDifferentAddress').hide();
    }
})
    // $('#thankyouModal').modal('show');

    var checkoutTotalCard = $('.checkoutTotalCard').offset();
    var $window = $(window);

    $window.scroll(function() {
        if ( $window.scrollTop() >= checkoutTotalCard.top) {
            $(".checkoutTotalCard").addClass("sticky");
        }else{
            $(".checkoutTotalCard").removeClass("sticky");
        }
    });


})


