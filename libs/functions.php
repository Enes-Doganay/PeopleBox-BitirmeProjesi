<?php
function control_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>