/**
 * Created by Penders on 3/19/2015.
 */
(function(){

    var app = angular.module('veilingapp',[]);

    app.controller('ArtikelController',function($scope,$http){

        $http({url: 'artikels/get_list',
            method: "POST"
            }).success(function (data) {
                $scope.artikels = data;
            });
    });


})();