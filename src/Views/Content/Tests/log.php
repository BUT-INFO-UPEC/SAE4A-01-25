<?php
if (!empty($_SESSION['MSGs']["undying"])) {
	foreach ($_SESSION['MSGs']["undying"] as $index => $MsgBundle) {
		if (!empty($MsgBundle)) {
			echo "<div>";
			if (!empty($MsgBundle[0])) {
				foreach ($MsgBundle[0] as $index => $Msg) { ?>
					<div class="alert alert-<?= $Msg->getType() ?>" role="alert" id="alertMessage<?= $index ?>">
						<h3><?= $Msg->getTitle() ?></h3>

	<?php if ($Msg->getMessage() != null) {
						echo "<p>" . $Msg->getMessage() . "</p>";
					}
					echo '</div>';
				}
			} else {
				echo "<p> Pas de message </p>";
			}
			echo "<p> $MsgBundle[1] </p>";

			echo "</div>";
		}
	}
}
	?>
	<a href="?action=clear_log"> Effacer l'historique des messages</a>