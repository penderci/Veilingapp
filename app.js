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

        //$scope.sortorder = 'naam';

        //$scope.numLimit = 5;

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

       /* $scope.updateArtikel = function() {
            $http({
                method: 'POST',
                url: 'artikels/update',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({naam: $scope.inputnaam})
            }).success(function(data){
                console.log(data);
                console.log($scope);
                $scope.message=data;
                $scope.inputnaam = '';
                $scope.loadData();

            });
        }*/

    });


})();