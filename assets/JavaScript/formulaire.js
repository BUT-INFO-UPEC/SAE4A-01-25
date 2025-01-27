var app = angular.module('myApp', []);

app.controller('myCtrl', function ($scope) {
	let idCounter = 1; // Compteur d'ID

	$scope.tabs = [{
		id: idCounter++, // Générer un ID unique
		name: 'Onglet 1',
		content: 'onglet.html',
		active: true
	},
	];

	$scope.selectTab = function (index) {
		$scope.tabs.forEach(function (tab) {
			tab.active = false;
		});
		$scope.tabs[index].active = true;
	};

	$scope.removeTab = function (index) {
		$scope.tabs.splice(index, 1);
		if ($scope.tabs.length > 0 && !$scope.tabs.some(tab => tab.active)) {
			$scope.tabs[Math.max(0, index - 1)].active = true;
		}
	};

	$scope.addTab = function () {
		var newTab = {
			id: idCounter++, // Générer un nouvel ID unique
			name: 'Nouvel onglet',
			content: 'onglet.html',
			active: true
		};
		$scope.tabs.push(newTab);
		$scope.selectTab($scope.tabs.length - 1);
	};

	count_id = idCounter;
});
