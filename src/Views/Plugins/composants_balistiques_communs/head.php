<?php
// Get the absolute path of the current script
$phpSelfPath = $_SERVER['PHP_SELF'];

// Split the path into segments
$pathSegments = explode('/', $phpSelfPath);

// Calculate the number of levels to go up (subtract 2 to adjust for current directory and target structure)
$numberOfLevelsToGoUp = count($pathSegments) - 2;

// Build the prefix using str_repeat
$prefixe = str_repeat('../', $numberOfLevelsToGoUp) . 'Views/';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo isset($titre) ? htmlspecialchars($titre) : "Titre"; // Prevent XSS
        ?>
    </title>
    <link rel="stylesheet" href="<?php echo $prefixe . 'css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo $prefixe . 'css/style_layout.css'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
