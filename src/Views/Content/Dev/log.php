<?php
$Msgindex = 0;
$Logindex = 0;
if (!empty($_SESSION['MSGs']["undying"])) {
	foreach ($_SESSION['MSGs']["undying"] as $index => $Log_instance) {
		if (isset($Log_instance)) {
			echo "<div class='log'>";
			echo "<h2>";
			echo $Log_instance->get_Called_Action();
			echo "</h2>";

			$MsgBundle = $Log_instance->get_Msgs();
			if (!empty($MsgBundle)) { ?>
				<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#msg<?= $Msgindex ?>" aria-expanded="false" aria-controls="collapseExample">
					Liste des messages
				</button>
				<?php echo "<div class='collapse' id='msg$Msgindex' >";
				foreach ($MsgBundle as $index2 => $Msg) { ?>
					<div class="alert alert-<?= $Msg->getType() ?>" role="alert" id="alertMessage<?= $index2 ?>">
						<h3><?= $Msg->getTitle() ?></h3>

					<?php if ($Msg->getMessage() != null) {
						echo "<p>" . $Msg->getMessage() . "</p>";
					}
					echo '</div>';
				}
				echo "</div>";
				$Msgindex++;
			} else {
				echo "<p> Pas de message </p>";
			}

			$LogBundle = $Log_instance->get_Logs();
			if (!empty($LogBundle)) { ?>
					<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#log<?= $Logindex ?>" aria-expanded="false" aria-controls="collapseExample">
						Liste des logs
					</button>
	<?php echo "<div class='collapse' id='log$Logindex'>";
				foreach ($LogBundle as $log) {
					echo "<p class='log_line'>$log</p>";
				}
				echo "</div>";
				$Logindex++;
			} else {
				echo "<p> Pas de log </p>";
			}

			echo "<p>";
			echo $Log_instance->get_Redirection();
			echo "</p>";

			echo "</div>";
		}
	}
}
	?>
	<a href="?action=clear_log"> Effacer l'historique des messages</a>