<?php
function antiinjection($data) {
    $filtered_data = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
    return $filtered_data;
}
?>
