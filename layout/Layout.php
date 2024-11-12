<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Visualisation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        Header
    </header>

    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <p class="changing"> liste retractable de météothèques </p>
        </div>

        <div style="flex-grow: 1; position: relative;">
            <?php echo $main; ?>
        </div>
    </main>

    <footer>
        Footer
    </footer>
</body>
</html>
