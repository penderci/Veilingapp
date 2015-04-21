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

    app.controller('AankoopController',function($scope,$http){
        console.log($scope);

       // $scope.gekochtvoor = 'Marco';

/*        $http({url: 'gebruikers/get_user_list',
            method: "POST"
        }).success(function (data) {
            $scope.gebruikers = data;
        });*/

        /*$scope.gebruikers = function () {
            $http.get('gebruikers/get_user_list').success(function(data) {
                $scope.gebruikers = data;
            });
        };*/

        $http({url: 'gebruikers/get_primary_user',
            method: "POST"
        }).success(function (data) {
            $scope.gekochtvoor = data;
        });

        $scope.aankoopdatum = new Date() ;
        /*$http({url: 'gebruikers/get_gebruikers_list',
            method: "POST"
        }).success(function (data) {
            $scope.gebruikers = data;
            console.log($scope.gebruikers);
        });*/
    });

})();