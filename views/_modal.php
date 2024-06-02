<?php
function renderSuccessModal($message = "")
{
?>
    <!-- Başarılı İşlem Modalı -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Başarılı İşlem</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="showSuccessModal()">Tamam</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#successModal').modal('show');
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 2000); // 2 saniye bekle
        });
    </script>
<?php
}
?>