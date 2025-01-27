<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div ng-app="myApp" ng-controller="myCtrl">
	<ul class="nav nav-tabs">
		<li ng-repeat="tab in tabs" ng-class="{'active': tab.active}">
			<a href="#" ng-click="selectTab($index)">{{tab.name}}</a>
			<span ng-click="removeTab($index)" class="glyphicon glyphicon-remove" style="cursor: pointer;"></span>
		</li>
		<li>
			<a href="#" ng-click="addTab()">Ajouter un onglet</a>
		</li>
	</ul>
	<div ng-repeat="tab in tabs" ng-show="tab.active">
		<div ng-include="tab.content"></div>
		<input type="text" ng-model="tab.name" placeholder="Nom de l'onglet">
		<div class="">
			<p><strong>ID :</strong> {{ tab.id }}</p>
			<!-- met ce que tu veut -->
		</div>
	</div>
</div>

<script>
	var app = angular.module('myApp', []);

	app.controller('myCtrl', function($scope) {
		let idCounter = 1; // Compteur d'ID

		$scope.tabs = [{
				id: idCounter++, // Générer un ID unique
				name: 'Onglet 1',
				content: 'onglet.html',
				active: true
			},
			{
				id: idCounter++,
				name: 'Onglet 2',
				content: 'onglet.html',
				active: false
			}
		];

		$scope.selectTab = function(index) {
			$scope.tabs.forEach(function(tab) {
				tab.active = false;
			});
			$scope.tabs[index].active = true;
		};

		$scope.removeTab = function(index) {
			$scope.tabs.splice(index, 1);
			if ($scope.tabs.length > 0 && !$scope.tabs.some(tab => tab.active)) {
				$scope.tabs[Math.max(0, index - 1)].active = true;
			}
		};

		$scope.addTab = function() {
			var newTab = {
				id: idCounter++, // Générer un nouvel ID unique
				name: 'Nouvel onglet',
				content: 'onglet.html',
				active: true
			};
			$scope.tabs.push(newTab);
			$scope.selectTab($scope.tabs.length - 1);
		};
	});
</script>

<style>
	.nav-tabs li {
		display: inline-block;
	}

	.nav-tabs li a {
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 5px 5px 0 0;
		text-decoration: none;
		color: #000;
	}

	.nav-tabs li.active a {
		background-color: #337ab7;
		color: #fff;
	}

	.nav-tabs li a:hover {
		background-color: #337ab7;
		color: #fff;
	}

	.glyphicon-remove {
		padding: 5px;
		margin-left: 5px;
		color: red;
		cursor: pointer;
	}
</style>