

    <script src="https://js.stripe.com/v3/"></script>

    <div class="new-subscription-overlay">
        <div class="new-subscription-form">
            <button class="stripe-checkout-button">Checkout</button>
        </div>
    </div>

    <script>

        $(document).ready(function(){

            priceId = 'price_1JDhPOGQfNpvdYMIYE3RaJm1';
            let stripe = Stripe('pk_live_vrZJxbj9ZAgOZfp1mCUlxEC500xLCa1RSL');

            $('.stripe-checkout-button').click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'stripe/new-checkout-session.php',
                    data: {priceId: priceId},
                    success: function(sessionId) {
                        stripe.redirectToCheckout({sessionId: sessionId}).then(handleResult);
                    }
                });
            });

        });

    </script>