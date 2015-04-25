/**
 * Created by Penders on 3/19/2015.
 */
(function(){

    var app = angular.module('veilingapp',[]);

    /*ARTIKEL CONTROLLER*/
    app.controller('ArtikelController',function($scope,$http){

        $http({url: 'artikels/get_list',
            method: "POST"
        }).success(function (data) {
            $scope.artikels = data;
        });

        $scope.inputnaam = undefined;

        $scope.submitForm = function() {
            console.log('posting data ....');

            $http({
                method: 'POST',
                url: 'artikels/insert_artikel',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({naam: $scope.inputnaam})
            }).success(function(data){
                console.log(data);
                console.log($scope);
                $scope.message=data;
                $scope.inputnaam = '';
                $scope.loadData();

            });
        }

        $scope.loadData = function () {
            $http.get('artikels/get_list').success(function(data) {
                $scope.artikels = data;
            });
        };

    });


    /*AANKOOP CONTROLLER*/
    app.controller('AankoopController',function($scope,$http){

        $http({url: 'aankopen/get_list',
            method: "POST"
        }).success(function (data) {
            $scope.aankopen = data;
        });


        $scope.submitForm = function() {
            console.log('posting data ....');
            console.log($scope);

            $http({
                method: 'POST',
                url: 'aankopen/insert_aankopen_temp',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    datum:$scope.aankoopdatum,
                    gekocht_voor: $scope.gekochtvoor,
                    artikel: $scope.artikel,
                    aantal: $scope.aantal,
                    eenheidsprijs: $scope.ehprijs,
                    totale_prijs: $scope.ehprijs * $scope.aantal,
                    aantal_container: $scope.container,
                    aantal_opzet: $scope.opzet,
                    aantal_tray: $scope.tray,
                    aantal_doos: $scope.doos})
            }).success(function(data){
                console.log(data);
                console.log($scope);
                $scope.message=data;

                $scope.loadData();

            });


        }


        $http({url: 'gebruikers/get_primary_user',
            method: "POST"
        }).success(function (data) {
            $scope.gekochtvoor = data;
        });

        $scope.aankoopdatum = new Date() ;


        $scope.loadData = function () {
            $http.get('aankopen/get_list').success(function(data) {
                $scope.aankopen = data;
            });
        };

    });

})();