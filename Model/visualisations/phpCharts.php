<?php

// -----
// DONEE TEXTUELLE
// -----
function unique_value($data) {
    return $data["value"];
}

function generate_text_tepresentation($data) {
    return "<p>" . htmlspecialchars($data) . "</p>";
}

?>