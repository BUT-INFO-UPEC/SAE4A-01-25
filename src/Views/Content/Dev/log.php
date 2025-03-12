<?php
$Msgindex = 0;
$Logindex = 0;
if (!empty($_SESSION['MSGs']["undying"])) {
	foreach ($_SESSION['MSGs']["undying"] as $index => $Log_instance) {
		if (isset($Log_instance)) {
			echo "<div class='log'>";
			echo "<div class='flex'>";
			echo "<h2>";
			echo $Log_instance->get_Called_Action();
			echo "</h2>"; ?>
			<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#log_container<?= $index ?>" aria-expanded="false">
				>
			</button>
			</div>
			<?php echo "<div class='collapse' id='log_container$index'>";

			$MsgBundle = $Log_instance->get_Msgs();
			if (!empty($MsgBundle)) { ?>
				<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#msg<?= $Msgindex ?>" aria-expanded="false">
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
					<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#log<?= $Logindex ?>" aria-expanded="false">
						Liste des logs
					</button>
	<?php echo "<div class='collapse' id='log$Logindex'>";
				foreach ($LogBundle as $log_and_color) {
					$color = $log_and_color[0];
					$log = $log_and_color[1];
					echo "<p class='log_line $color'>$log</p>";
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
			echo "</div>";
		}
	}
}
	?>
	<a href="?action=clear_log"> Effacer l'historique des messages</a>