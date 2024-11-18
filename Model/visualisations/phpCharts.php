<?php

// -----
// DONEE TEXTUELLE
// -----
function unique_value($data, $unite) {
    // var_dump($data);
    return array_values($data[0])[0].$unite;
}

function generate_text_representation($data) {
    return "<p>" . htmlspecialchars($data) . "</p>";
}

?>