<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Visualisation</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <?php include "Header.php"; ?>
    </header>

    <main class="flex">
        <div class="sidebar" style="display: block; width: 6cm;">
            <?php include "SideBar.php"; ?>
        </div>

        <div style="flex-grow: 1; position: relative;">
            <?php echo $main; ?>
        </div>
    </main>

    <footer>
        <?php include "Footer.php"; ?>
    </footer>
</body>
</html>
