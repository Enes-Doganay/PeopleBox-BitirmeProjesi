$(document).ready(function() {
    $(".btn-increase").click(function() {
        var productId = $(this).data('id');
        var input = $("input[data-id='" + productId + "']");
        var newQuantity = parseInt(input.val()) + 1;
        updateQuantity(productId, newQuantity);
    });

    $(".btn-decrease").click(function() {
        var productId = $(this).data('id');
        var input = $("input[data-id='" + productId + "']");
        var newQuantity = parseInt(input.val()) - 1;
        if (newQuantity >= 1) {
            updateQuantity(productId, newQuantity);
        }
    });

    $(".btn-remove").click(function(event) {
        event.preventDefault();
        var productId = $(this).data('id');
        removeFromCart(productId);
    });

    function updateQuantity(productId, quantity) {
        $.post("cart.php", { productId: productId, quantity: quantity }, function() {
            location.reload();
        }).fail(function(xhr) {
            alert(xhr.status === 500 ? 'Sunucuda bir hata oluştu: ' + xhr.responseText : 'Geçersiz istek.');
        });
    }

    function removeFromCart(productId) {
        $.post("cart.php", { productId: productId, action: 'delete' }, function() {
            location.reload();
        }).fail(function(xhr) {
            alert(xhr.status === 500 ? 'Sunucuda bir hata oluştu: ' + xhr.responseText : 'Geçersiz istek.');
        });
    }
});
