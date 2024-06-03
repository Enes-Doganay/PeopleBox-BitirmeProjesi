// Stripe API'sini başlat ve elemanları oluştur
var stripe = Stripe('pk_test_51PNEIYIzrk4FBfXJSML24U8dG1IFImd42b0710Y0D3ElQqldEDtAqwn1wrPlN1FybqWW3mObw2VUVaZaL8Gw0Ytm00LkN6YuKS');
var elements = stripe.elements();

// Elemanlar için stil seçeneklerini belirle
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Kart elemanını oluştur ve sayfada bir DOM elemanına bağla
var card = elements.create('card', {style: style});
card.mount('#card-element');

// Kart bilgileri değiştiğinde hata mesajlarını güncelle
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Form gönderildiğinde token oluşturup sunucuya gönder
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

// Token'ı form ile birlikte sunucuya gönder
function stripeTokenHandler(token) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    form.submit();
}
