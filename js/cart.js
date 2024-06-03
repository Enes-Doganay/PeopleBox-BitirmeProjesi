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

    function updateQuantity(productId, quantity) {
        $.post("cart.php", { productId: productId, quantity: quantity }, function(data) {
            location.reload();
        });
    }
});
