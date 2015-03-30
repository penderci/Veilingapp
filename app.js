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
                $scope.message=data;

            });
        }
        /*$scope.submitForm = function() {
            formData = $scope.form;
            console.log(formData);

            $http({url : 'artikels/insert_artikel',
                method: "POST",
                data: JSON.stringify(formData)
            }).success(function(){});

            //$http.post('artikels/insert_artikel', JSON.stringify(formData)).success(function(){*//*success callback*//*});
        };

        console.log($scope);*/
    });


})();