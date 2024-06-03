<?php 
include "views/_header.php";
include "views/_navbar.php";
include "libs/functions.php";
?>
<form action="charge.php" method="post" id="payment-form">
        <div class="form-row">
            <label for="card-element">Kredi Kartı</label>
            <div id="card-element">
                

            </div>
            <div id="card-errors" role="alert"></div>
        </div>
        <script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1PNGHXIzrk4FBfXJS2BjI2ua"
  publishable-key="pk_test_51PNEIYIzrk4FBfXJSML24U8dG1IFImd42b0710Y0D3ElQqldEDtAqwn1wrPlN1FybqWW3mObw2VUVaZaL8Gw0Ytm00LkN6YuKS"
>
</stripe-buy-button>
    </form>

    <script>
        var stripe = Stripe('pk_test_51PNEIYIzrk4FBfXJSML24U8dG1IFImd42b0710Y0D3ElQqldEDtAqwn1wrPlN1FybqWW3mObw2VUVaZaL8Gw0Ytm00LkN6YuKS');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>

    <?php include 'views/_footer.php'; ?>