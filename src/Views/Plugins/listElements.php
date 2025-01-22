<?php

/**
 * NECESSAIRE : définir la variable elements avec une liste d'elements affichables
 */

echo '<ul>';
foreach ($elements as $ele) {
	echo "<li> $ele </li>";
}
echo '</ul>';
