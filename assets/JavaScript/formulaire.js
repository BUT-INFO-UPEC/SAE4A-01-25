var app = angular.module('myApp', []);

app.controller('myCtrl', function ($scope) {
	let idCounter = 1; // Compteur pour les IDs uniques des onglets

	$scope.tabs = [{
		id: idCounter++, // Générer un ID unique
		name: 'Onglet 1',
		content: 'onglet.html',
		active: true
	}];

	// Initialiser count_id avec le nombre total d'onglets
	$scope.count_id = $scope.tabs.length;

	// Fonction pour sélectionner un onglet
	$scope.selectTab = function (index) {
		$scope.tabs.forEach(function (tab) {
			tab.active = false;
		});
		$scope.tabs[index].active = true;
	};

	// Fonction pour supprimer un onglet
	$scope.removeTab = function (index) {
		$scope.tabs.splice(index, 1);

		// Si aucun onglet actif, activer un onglet par défaut
		if ($scope.tabs.length > 0 && !$scope.tabs.some(tab => tab.active)) {
			$scope.tabs[Math.max(0, index - 1)].active = true;
		}

		// Mettre à jour le nombre total d'onglets
		$scope.count_id = $scope.tabs.length;
	};

	// Fonction pour ajouter un nouvel onglet
	$scope.addTab = function () {
		var newTab = {
			id: idCounter++, // Générer un nouvel ID unique
			name: 'Nouvel onglet',
			content: 'onglet.html',
			active: true
		};

		$scope.tabs.push(newTab);
		$scope.selectTab($scope.tabs.length - 1);

		// Mettre à jour le nombre total d'onglets
		$scope.count_id = $scope.tabs.length;
	};
});
