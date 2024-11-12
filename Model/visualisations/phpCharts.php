<?php

function uniqueValue($data) {
    return $data["value"];
}


function generateTextRepresentation($data) {
    return "<p>" . htmlspecialchars($data) . "</p>";
}
?>