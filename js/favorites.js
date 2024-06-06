$(document).ready(function() {
    $(".favorite-btn").click(function(event) {
        event.preventDefault();
        var userId = $(this).data('user-id');
        var bookId = $(this).data('book-id');
        var action = $(this).data('action');
        manageFavorite(userId, bookId, action, $(this));
    });

    $(".favorite-btn").hover(function() {
        // Mouse üzerine geldiğinde
        var icon = $(this).find('i');
        if ($(this).data('action') === 'add') {
            icon.addClass('fa-solid').removeClass('fa-regular');
        } else if ($(this).data('action') === 'remove') {
            icon.addClass('fa-regular').removeClass('fa-solid');
        }
    }, function() {
        // Mouse üzerinden ayrıldığında
        var icon = $(this).find('i');
        if ($(this).data('action') === 'add') {
            icon.removeClass('fa-solid').addClass('fa-regular');
        } else if ($(this).data('action') === 'remove') {
            icon.removeClass('fa-regular').addClass('fa-solid');
        }
    });

    function manageFavorite(userId, bookId, action, button) {
        $.ajax({
            url: 'favorite-handler.php',
            method: 'POST',
            data: { userId: userId, bookId: bookId, action: action },
            dataType: 'json',
            success: function(response) {
                console.log("Response from server: ", response);
                if (response.status === 'success') {
                    var icon = button.find('i');
                    if (action === 'add') {
                        // Favori butonunu güncelle
                        icon.removeClass('fa-regular').addClass('fa-solid');
                        button.data('action', 'remove');
                    } else if (action === 'remove') {
                        // Favori butonunu güncelle
                        icon.removeClass('fa-solid').addClass('fa-regular');
                        button.data('action', 'add');
                    }
                } else {
                    console.log(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error response: ", xhr.responseText);
            }
        });
    }
});