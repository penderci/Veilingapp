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

    /*FACTORY voor het ophalen van alle partners waarvoor de ingelogde gebruiker kan kopen*/
    app.factory('partnersFactory',function($http){
        var factory={};

        factory.partners = function() {
            return $http({
                url: 'gebruikers/get_gebruikers_list',
                method: "POST"
            })
        }

        return factory;
    });



    /*FACTORY voor het ophalen van de uitgevoerde betalingen, nodig in aankopenscherm voor totaal betalingen en voor scherm overdracht*/
    app.factory('betalingenFactory',function($http){
        var factory={};

        factory.betalingen = function() {
            return $http({
                url: 'overdrachten/get_betalingen',
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

    /*app.directive('jqdatepicker', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, element, attrs, ctrl) {
                $(element).datepicker({
                    dateFormat: 'dd/mm/yy',
                    onSelect: function(date) {
                        ctrl.$setViewValue(date);
                        ctrl.$render();
                        scope.$apply();
                    }
                });
            }
        };
    });*/

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
               // console.log('bekend');
                var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            } else {
              //  console.log('niet bekend');
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
            //var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            var aankopen2 = localStorage.getItem("aankopen")

            $event.preventDefault();

           // console.log(aankopen);
           // console.log(aankopen2);

            $http({
                url: 'aankopen/synchronize',
                method: "POST",
                data: aankopen2
            }).success(function (data) {
               // console.log('sync gedaan');
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
        primaryUserFactory.primaryUser()
            .success(function (data) {
                $scope.partner = data;
            })
            .error(function(err){
                alert('Er is een fout opgetreden');
            });

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        var datum = new Date();
        var day = datum.getDate();
        var month = datum.getMonth();
        var month = month + 1;
        var year = datum.getFullYear();

        $scope.totdatum = new Date(day + '/' + month + '/' + year); //new Date().toISOString();;
        $scope.vandatum = new Date('01/01/' + year);

        //Haal enkel data op als alle 3 de velden ingevuld zijn
        $scope.$watch('vandatum', function() {
            if ($scope.partner && $scope.totdatum && $scope.vandatum){
                $scope.aankopen_gedaan();
                $scope.aankopen_ontvangen();
            }
        });

        $scope.$watch('totdatum', function() {
            if ($scope.partner && $scope.totdatum && $scope.vandatum){
                   $scope.aankopen_gedaan();
                   $scope.aankopen_ontvangen();
            }
        });

        $scope.$watch('partner', function() {
            if ($scope.partner && $scope.totdatum && $scope.vandatum){
                console.log('watch partner');
                $scope.aankopen_gedaan();
                $scope.aankopen_ontvangen();
            }
        });

        $scope.aankopen_gedaan = function(){
            $http({
                url: 'aankopen/aankopen_gedaan',
                method: "POST",
                data: JSON.stringify({partner: $scope.partner, vandatum: $scope.vandatum,
                                        totdatum: $scope.totdatum
                                        })
            }).success(function (data) {
                $scope.ak_gedaan = data;
                console.log('aankopen gedaan');
                console.log($scope);
            }).error(function(xhr, textStatus, error){
                alert('Er is een fout opgetreden bij ophalen van de aankopen');
                //console.log(xhr.statusText);
                //console.log(textStatus);
                //console.log(error);
            });
        }

        $scope.getTotalPriceAk = function () {
            var total = 0;

            angular.forEach($scope.ak_gedaan, function (aankoop, index) {
                if (aankoop.aantal != null && aankoop.eenheidsprijs) {
                    total += parseFloat(aankoop.aantal * aankoop.eenheidsprijs);
                }
            });

            return total.toFixed(3);

        };

        $scope.getTotalContainerAk = function () {
            var total = 0;

            angular.forEach($scope.ak_gedaan, function (aankoop, index) {
                if (aankoop.aantal_container != null) {
                    total += parseInt(aankoop.aantal_container);
                }
            });

            return total;
        };

        $scope.getTotalOpzetAk = function () {
            var total = 0;

            angular.forEach($scope.ak_gedaan, function (aankoop, index) {
                if (aankoop.aantal_opzet != null) {
                    total += parseInt(aankoop.aantal_opzet);
                }

            });
            return total;
        };

        $scope.getTotalTrayAk = function () {
            var total = 0;

            angular.forEach($scope.ak_gedaan, function (aankoop, index) {
                if (aankoop.aantal_tray != null) {
                    total += parseInt(aankoop.aantal_tray);
                }
            });
            return total;
        };

        $scope.getTotalDoosAk = function () {
            var total = 0;

            angular.forEach($scope.ak_gedaan, function (aankoop, index) {
                if (aankoop.aantal_doos != null) {
                    total += parseInt(aankoop.aantal_doos);
                }
            });
            return total;
        };

        $scope.aankopen_ontvangen = function(){
            $http({
                url: 'aankopen/aankopen_ontvangen',
                method: "POST",
                data: JSON.stringify({partner: $scope.partner, vandatum: $scope.vandatum,
                    totdatum: $scope.totdatum
                })
            }).success(function (data) {
                $scope.ak_ontvangen = data;
            }).error(function(xhr, textStatus, error){
                alert('Er is een fout opgetreden bij het ophalen van de aankopen');
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            });
        }

        $scope.getTotalPriceOntv = function () {
            var total = 0;

            angular.forEach($scope.ak_ontvangen, function (aankoop, index) {
                if (aankoop.aantal != null && aankoop.eenheidsprijs) {
                    total += parseFloat(aankoop.aantal * aankoop.eenheidsprijs);
                }
            });

            return total.toFixed(3);

        };

        $scope.getTotalContainerOntv = function () {
            var total = 0;

            angular.forEach($scope.ak_ontvangen, function (aankoop, index) {
                if (aankoop.aantal_container != null) {
                    total += parseInt(aankoop.aantal_container);
                }
            });

            return total;
        };

        $scope.getTotalOpzetOntv = function () {
            var total = 0;

            angular.forEach($scope.ak_ontvangen, function (aankoop, index) {
                if (aankoop.aantal_opzet != null) {
                    total += parseInt(aankoop.aantal_opzet);
                }

            });
            return total;
        };

        $scope.getTotalTrayOntv = function () {
            var total = 0;

            angular.forEach($scope.ak_ontvangen, function (aankoop, index) {
                if (aankoop.aantal_tray != null) {
                    total += parseInt(aankoop.aantal_tray);
                }
            });
            return total;
        };

        $scope.getTotalDoosOntv = function () {
            var total = 0;

            angular.forEach($scope.ak_ontvangen, function (aankoop, index) {
                if (aankoop.aantal_doos != null) {
                    total += parseInt(aankoop.aantal_doos);
                }
            });
            return total;
        };


    }); //einde OVERZICHT CONTROLLER

    /*OVERDRACHT CONTROLLER*/
    app.controller('OverdrachtController', function ($scope, $http,partnersFactory,primaryUserFactory){
        partnersFactory.partners()
            .success(function (data) {
                $scope.partners = jQuery.makeArray(data);
                console.log($scope);
            })
            .error(function(err){
                alert('Er is een fout opgetreden bij het ophalen van de partners');
            });

        primaryUserFactory.primaryUser()
            .success(function (data) {
                $scope.primaryPartner = data;
                console.log($scope);
            })
            .error(function(err){
                alert('Er is een fout opgetreden');
            });

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

       /* $scope.betaaldAan = $scope.primaryPartner;
        console.log($scope);*/


        $scope.betaaldatum = new Date().toLocaleDateString();


    }); //einde OVERDRACHT CONTROLLER
})();

