/**
 * Created by Penders on 3/19/2015.
 */
(function () {

    var app = angular.module('veilingapp', ['LocalStorageModule']);


    app.config(function (localStorageServiceProvider) {
        localStorageServiceProvider
            .setPrefix('veilingapp');
    });

    /*ARTIKEL CONTROLLER*/
    app.controller('ArtikelController', function ($scope, $http) {

        $http({
            url: 'artikels/get_list',
            method: "POST"
        }).success(function (data) {
            $scope.artikels = data;
        });

        $scope.inputnaam = undefined;

        $scope.submitForm = function () {
            console.log('posting data ....');

            $http({
                method: 'POST',
                url: 'artikels/insert_artikel',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({naam: $scope.inputnaam})
            }).success(function (data) {
                //console.log(data);
                //console.log($scope);
                $scope.message = data;
                $scope.inputnaam = '';
                $scope.loadData();

            });
        }

        $scope.loadData = function () {
            $http.get('artikels/get_list').success(function (data) {
                $scope.artikels = data;
            });
        };

    });


    /*AANKOOP CONTROLLER*/
    app.controller('AankoopController', function ($scope, $http) {

        var aankoop = {};

        /*$http({
            url: 'aankopen/get_list',
            method: "POST"
        }).success(function (data) {
            $scope.aankopen = data;
        });*/

        $scope.aankopen = JSON.parse(localStorage.getItem("aankopen"));


        $scope.submitForm = function () {
            //console.log('posting data ....');
            //console.log($scope);

            if (localStorage.getItem("aankopen")) {
                console.log('bekend');
                var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            } else {
                console.log('niet bekend');
                var aankopen = [];}

            var aankoop = {'datum': $scope.aankoopdatum,
                'gekocht_voor': $scope.gekochtvoor,
                'artikel': $scope.artikel,
                'aantal': $scope.aantal,
                'eenheidsprijs': $scope.ehprijs,
                'totale_prijs': $scope.ehprijs * $scope.aantal,
                'aantal_container': $scope.container,
                'aantal_opzet': $scope.opzet,
                'aantal_tray': $scope.tray,
                'aantal_doos': $scope.doos};

            aankopen.push(aankoop);

            console.log('aankopen');
            console.log(aankopen);

            //if (localStorage.getItem("aankopen") === null) {
                localStorage.setItem("aankopen",JSON.stringify(aankopen));
            //} else {

            //}
            //$scope.message = data;
            $scope.artikel = '';
            $scope.aantal = '';
            $scope.ehprijs = '';
            $scope.container = '';
            $scope.opzet = '';
            $scope.tray = '';
            $scope.doos = '';

            $scope.loadData();



             /*lengte = aankopenJson.length;
             console.log('lengte');
             console.log(lengte);*/


            /*$http({
                method: 'POST',
                url: 'aankopen/insert_aankopen_temp',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    datum: $scope.aankoopdatum,
                    gekocht_voor: $scope.gekochtvoor,
                    artikel: $scope.artikel,
                    aantal: $scope.aantal,
                    eenheidsprijs: $scope.ehprijs,
                    totale_prijs: $scope.ehprijs * $scope.aantal,
                    aantal_container: $scope.container,
                    aantal_opzet: $scope.opzet,
                    aantal_tray: $scope.tray,
                    aantal_doos: $scope.doos
                })
            }).success(function (data) {
                //console.log(data);
                // console.log($scope);
                $scope.message = data;
                $scope.artikel = '';
                $scope.aantal = '';
                $scope.ehprijs = '';
                $scope.container = '';
                $scope.opzet = '';
                $scope.tray = '';
                $scope.doos = '';

                $scope.loadData();

            });*/
        } //end submitForm


        $http({
            url: 'gebruikers/get_primary_user',
            method: "POST"
        }).success(function (data) {
            $scope.gekochtvoor = data;
            console.log($scope.gekochtvoor)
        });

        $scope.aankoopdatum = new Date();


        $scope.loadData = function () {
            //$http.get('aankopen/get_list').success(function (data) {
                //$scope.aankopen = data;
           // });
            $scope.aankopen = JSON.parse(localStorage.getItem("aankopen"));
        };

        $scope.getTotalPrice = function () {
            var total = 0;

            angular.forEach($scope.aankopen, function (aankoop, index) {
                if (aankoop.totale_prijs != null) {
                    total += parseFloat(aankoop.totale_prijs);
                }
            });

            return total.toFixed(3);

            /*for (var i = 0; i < $scope.aankopen.length; i++) {

             var aankoop = aankopen.$scope[i];

             if (aankoop.totale_prijs != null) {
             total += parseFloat(aankoop.totale_prijs);
             }

             }
             return total.toFixed(3);*/
        };

        $scope.getTotalContainer = function () {
            var total = 0;

            angular.forEach($scope.aankopen, function (aankoop, index) {
                if (aankoop.aantal_container != null) {
                    total += parseInt(aankoop.aantal_container);
                }

            });

            return total;
        };

        $scope.getTotalOpzet = function () {
            var total = 0;

            angular.forEach($scope.aankopen, function (aankoop, index) {
                if (aankoop.aantal_opzet != null) {
                    total += parseInt(aankoop.aantal_opzet);
                }

            });
            return total;
        };

        $scope.getTotalTray = function () {
            var total = 0;

            angular.forEach($scope.aankopen, function (aankoop, index) {
                if (aankoop.aantal_tray != null) {
                    total += parseInt(aankoop.aantal_tray);
                }

            });
            return total;
        };

        $scope.getTotalDoos = function () {
            var total = 0;

            angular.forEach($scope.aankopen, function (aankoop, index) {
                if (aankoop.aantal_doos != null) {
                    total += parseInt(aankoop.aantal_doos);
                }

            });
            return total;
        };

    });
})();

