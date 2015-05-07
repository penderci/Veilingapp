/**
 * Created by Penders on 3/19/2015.
 */
(function () {

    var app = angular.module('veilingapp', ['LocalStorageModule','ui.date']);

    /*FACTORY voor het ophalen van de primaire gebruiker waarvoor gekocht wordt. Deze selectie is op meerdere plaatsen nodig*/
    app.factory('primaryUserFactory',function($http){
        var factory={};

        factory.primaryUser = function() {
            return $http({
                url: 'gebruikers/get_primary_user',
                method: "POST"
            })
        }

        return factory;

        });

    /*config voor localstorage*/
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

    }); //einde ARTIKEL CONTROLLER


    /*AANKOOP CONTROLLER*/
    app.controller('AankoopController', function ($scope, $http, primaryUserFactory) {

        var aankoop = {};

        $scope.aankopen = JSON.parse(localStorage.getItem("aankopen"));

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        $scope.aankoopdatum = new Date().toLocaleDateString();

        primaryUserFactory.primaryUser()
            .success(function (data) {
                $scope.gekochtvoor = data;
            })
            .error(function(err){
                alert('Er is een fout opgetreden');
            });

        $scope.submitForm = function () {
            if (localStorage.getItem("aankopen")) {
                console.log('bekend');
                var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            } else {
                console.log('niet bekend');
                var aankopen = [];}

            var datum = new Date($scope.aankoopdatum);
            //console.log('datum' + $scope.aankoopdatum);
            //console.log(datum);

            var aankoop = {'datum': datum, //$scope.aankoopdatum,
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

            localStorage.setItem("aankopen",JSON.stringify(aankopen));

            $scope.artikel = '';
            $scope.aantal = '';
            $scope.ehprijs = '';
            $scope.container = '';
            $scope.opzet = '';
            $scope.tray = '';
            $scope.doos = '';

            $scope.loadData();
        } //end submitForm


        /*$http({
            url: 'gebruikers/get_primary_user',
            method: "POST"
        }).success(function (data) {
            $scope.gekochtvoor = data;
            console.log($scope.gekochtvoor)
        });*/

        $scope.loadData = function () {
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

        $scope.synchronize = function($event) {
            var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            var aankopen2 = localStorage.getItem("aankopen")

            $event.preventDefault();
            console.log(aankopen);
            console.log(aankopen2);

            $http({
                url: 'aankopen/synchronize',
                method: "POST",
                data: aankopen2
            }).success(function (data) {
                console.log('sync gedaan');
                alert('De gegevens werden succesvol opgeslaan in de databank');
                localStorage.removeItem('aankopen');
                $scope.loadData();
            }).error(function(xhr, textStatus, error){
                alert('Er is een fout opgetreden bij het syncen. Probeer nogmaals');
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            });

        }

    }); //einde AANKOOP CONTROLLER

    /*OVERZICHT CONTROLLER*/
    app.controller('OverzichtController', function ($scope, $http,primaryUserFactory) {
        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        var datum = new Date();
        var year = datum.getFullYear();

        $scope.totdatum = datum.toLocaleDateString();
        $scope.vandatum = new Date('01/01/' + year);

        primaryUserFactory.primaryUser()
            .success(function (data) {
                $scope.partner = data;
            })
            .error(function(err){
                alert('Er is een fout opgetreden');
            });

    }); //einde OVERZICHT CONTROLLER

})();

