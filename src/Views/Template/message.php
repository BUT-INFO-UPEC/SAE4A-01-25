<?php
// var_dump($_SESSION['MSGs']);
if (!empty($_SESSION['MSGs']["list_messages"])) {
	foreach ($_SESSION['MSGs']["list_messages"] as $index => $Msg) { ?>
		<div class="alert alert-<?= $Msg->getType() ?> alert-dismissible fade show" role="alert" id="alertMessage<?= $index ?>">
			<h3><?= $Msg->getError() ?></h3>

	<?php if ($Msg->getMessage() != null) {
			echo "<p>" . $Msg->getMessage() . "</p>";
		}
		echo '</div>';
	}
	unset($_SESSION['MSGs']["list_messages"]);
}
	?>
	<!-- <script>
		document.addEventListener('DOMContentLoaded', function() {
			const alertMessages = document.querySelectorAll('[id^="alertMessage"]');

			alertMessages.forEach((msg) => {
				setTimeout(() => {
					msg.classList.add('fade'); // Ajoute la transition de disparition
					setTimeout(() => msg.remove(), 500); // Supprime complètement après 0.5s
				}, 5000); // Attendre 5 secondes avant de commencer
			});
		});
	</script> -->