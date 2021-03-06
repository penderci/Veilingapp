/**
 * Created by Penders on 3/19/2015.
 */
(function () {

    var app = angular.module('veilingapp', ['LocalStorageModule', 'ui.date', 'ui.bootstrap', 'dialogs.main']); //,'ui.bootstrap' ,'ui.bootstrap','dialogs' ,'ui.bootstrap','dialogs.main','ngSanitize'

    app.filter('offset', function () {
        return function (input, start) {
            start = parseInt(start, 10);
            return input.slice(start);
        };
    });

    //*DIRECTIVES*//
    app.directive('pwCheck', [function () {
        return {
            require: 'ngModel',
            link: function (scope, elem, attrs, ctrl) {
                var firstPassword = '#' + attrs.pwCheck;
                elem.add(firstPassword).on('keyup', function () {
                    scope.$apply(function () {
                        var v = elem.val() === $(firstPassword).val();
                        ctrl.$setValidity('pwmatch', v);
                    });
                });
            }
        }
    }]);

    /*Deze directive was nodig omdat Safari de HTML step en min en max niet kent bij het number field, dit zorgde voor problemen */
    /*Voor gehele getallen*/
    app.directive('validNumber0', function() {
        return {
            require: '?ngModel',
            link: function(scope, element, attrs, ngModelCtrl) {
                if(!ngModelCtrl) {
                    return;
                }

                ngModelCtrl.$parsers.push(function(val) {
                    if (angular.isUndefined(val)) {
                        var val = '';
                    }
                    var clean = val.replace( /[^0-9]+/g, '');
                    if (val !== clean) {
                        ngModelCtrl.$setViewValue(clean);
                        ngModelCtrl.$render();
                    }
                    return clean;
                });

                element.bind('keypress', function(event) {
                    if(event.keyCode === 32) {
                        event.preventDefault();
                    }
                });
            }
        };
    });

    //*Voor getallen met 2 decimalen*/
    app.directive('validNumber', function() {
        return {
            require: '?ngModel',
            link: function(scope, element, attrs, ngModelCtrl) {
                if(!ngModelCtrl) {
                    return;
                }

                ngModelCtrl.$parsers.push(function(val) {
                    if (angular.isUndefined(val)) {
                        var val = '';
                    }
                    var clean = val.replace(/[^0-9\.]/g, '');
                    var decimalCheck = clean.split('.');

                    if(!angular.isUndefined(decimalCheck[1])) {
                        decimalCheck[1] = decimalCheck[1].slice(0,3);
                        clean =decimalCheck[0] + '.' + decimalCheck[1];
                    }

                    if (val !== clean) {
                        ngModelCtrl.$setViewValue(clean);
                        ngModelCtrl.$render();
                    }
                    return clean;
                });

                element.bind('keypress', function(event) {
                    if(event.keyCode === 32) {
                        event.preventDefault();
                    }
                });
            }
        };
    });


    /*FACTORY voor het ophalen van alle partners waarvoor de ingelogde gebruiker kan kopen*/
    app.factory('partnersFactory', function ($http) {
        var factory = {};

        factory.partners = function () {
            return $http({
                url: 'gebruikers/get_gebruikers_list',
                method: "POST"
            })
        }

        return factory;
    });

    /*FACTORY voor het ophalen van de uitgevoerde betalingen, nodig in aankopenscherm voor totaal betalingen en voor scherm overdracht*/
    app.factory('betalingenFactory', function ($http) {
        var factory = {};

        factory.betalingen = function () {
            return $http({
                url: 'overdrachten/get_betalingen',
                method: "POST"
            })
        }

        return factory;

    });

    /*FACTORY voor het ophalen van de gebruikersrollen*/
    app.factory('rollenFactory', function ($http) {
        var factory = {};

        factory.rollen = function () {
            return $http({
                url: 'rollen/get_rollen',
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
    app.controller('ArtikelController', function ($scope, $http, dialogs) {
        $scope.launch_dialog = function ($id, $naam) {
            var dlg = null;

            dlg = dialogs.confirm('Weet je zeker dat je het artikel ' + $naam + ', en alle gerelateerde aankopen wil verwijderen?');
            dlg.result.then(function (btn) {
                $scope.confirmed = $id + ' wordt verwijderd';

                $http({method: 'GET', url: 'artikels/delete/' + $id}).
                    success(function (data, status, headers, config) {
                        $scope.loadData();
                    }).
                    error(function (err, status) {
                        alert('Er is een fout opgetreden bij het verwijderen van het artikel of gelinkte gegevens');
                        console.log(err);
                        console.log(status);
                    });

                $scope.loadData();
            }, function (btn) {
                $scope.confirmed = 'Ok, actie wordt geannuleerd';
            });
        };


        $scope.loadData = function () {
            $http({
                url: 'artikels/get_list',
                method: "POST"
            }).success(function (data) {
                $scope.artikels = data;
            });
        }

        $scope.inputnaam = undefined;

        $scope.loadData();

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
    app.controller('AankoopController', function ($scope, $http, partnersFactory) {

        var aankoop = {};

        $scope.aankopen = JSON.parse(localStorage.getItem("aankopen"));

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        $scope.aankoopdatum = new Date().toLocaleDateString();

        partnersFactory.partners()
            .success(function (data) {
                $scope.partners = jQuery.makeArray(data);
                $scope.gekochtvoor = $scope.partners[0];
                //$scope.selectPrimary();
            })
            .error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de partners');
                console.log(err);
                console.log(status);
            });


        $scope.submitForm = function () {
            /*controleer of het object aankopen al bestaat in de localstorage*/
            if (localStorage.getItem("aankopen")) {
                var aankopen = JSON.parse(localStorage.getItem("aankopen"));
            } else {
                var aankopen = [];
            }

            var datum = new Date($scope.aankoopdatum);

            var aankoop = {
                'datum': datum,
                'gekocht_voor': $scope.gekochtvoor.naam,
                'artikel': $scope.artikel,
                'aantal': $scope.aantal,
                'eenheidsprijs': $scope.ehprijs,
                'totale_prijs': $scope.ehprijs * $scope.aantal,
                'aantal_container': $scope.container,
                'aantal_opzet': $scope.opzet,
                'aantal_tray': $scope.tray,
                'aantal_doos': $scope.doos
            };

            aankopen.push(aankoop);

            localStorage.setItem("aankopen", JSON.stringify(aankopen));

            $scope.artikel = '';
            $scope.aantal = '';
            $scope.ehprijs = '';
            $scope.container = '';
            $scope.opzet = '';
            $scope.tray = '';
            $scope.doos = '';

            $scope.loadData();
        } //end submitForm

        $scope.loadData = function () {
            $scope.aankopen = JSON.parse(localStorage.getItem("aankopen"));
        };

        /*Bereken totalen voor kolommen in tabel*/
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

        $scope.synchronize = function ($event) {
            var aankopen2 = localStorage.getItem("aankopen")

            $event.preventDefault();

            $http({
                url: 'aankopen/synchronize',
                method: "POST",
                data: aankopen2
            }).success(function (data) {
                alert('De gegevens werden succesvol opgeslaan in de databank');
                localStorage.removeItem('aankopen');
                $scope.loadData();
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het syncen. Probeer nogmaals');
                console.log(err);
                console.log(status);
            });

        }

        $scope.delete = function ($index) {
            var json = JSON.parse(localStorage["aankopen"]);
            $.each(json, function (index, obj) {
                if (index == $index) {
                    json.splice(index, 1);
                    localStorage["aankopen"] = JSON.stringify(json);
                }
            });
            $scope.loadData();
        }

        $scope.showmefn = function ($bool, $aankoop, $actie, $index) {
            $scope.showme = $bool;
            $scope.update_ak = $aankoop;

            if ($bool == true) {
                $scope.upd_index = $index;
                $scope.upd_artikel = $scope.update_ak.artikel;
                $scope.upd_aantal = parseInt($scope.update_ak.aantal);
                $scope.upd_ehprijs = parseFloat($scope.update_ak.eenheidsprijs);
                $scope.upd_container = parseInt($scope.update_ak.aantal_container);
                $scope.upd_opzet = parseInt($scope.update_ak.aantal_opzet);
                $scope.upd_tray = parseInt($scope.update_ak.aantal_tray);
                $scope.upd_doos = parseInt($scope.update_ak.aantal_doos);

            } else {
                if ($actie == 'update') {
                    var json = JSON.parse(localStorage["aankopen"]);
                    $.each(json, function (index, obj) {
                        console.log('index = ' + $scope.upd_index);
                        console.log(index);
                        if (index == $scope.upd_index) {
                            obj.artikel = $scope.upd_artikel;
                            obj.aantal = $scope.upd_aantal;
                            obj.eenheidsprijs = $scope.upd_ehprijs;
                            obj.totale_prijs = $scope.upd_aantal * $scope.upd_ehprijs;
                            obj.aantal_container = $scope.upd_container;
                            obj.aantal_opzet = $scope.upd_opzet;
                            obj.aantal_tray = $scope.upd_tray;
                            obj.aantal_doos = $scope.upd_doos;
                        }
                    });
                    localStorage["aankopen"] = JSON.stringify(json);
                    $scope.loadData();
                }
            }
        }

    }); //einde AANKOOP CONTROLLER

    /*OVERZICHT CONTROLLER*/
    app.controller('OverzichtController', function ($scope, $timeout, $http, partnersFactory) {
        $scope.showme = false;

        $scope.showmefn = function ($bool, $aankoop, $actie) {
            $scope.showme = $bool;
            $scope.update_ak = $aankoop;

            if ($bool == true) {
                $scope.upd_id = $scope.update_ak.id;
                $scope.upd_datum = $scope.update_ak.datum;
                $scope.upd_artikel = $scope.update_ak.naam;
                $scope.upd_aantal = parseInt($scope.update_ak.aantal);
                $scope.upd_ehprijs = parseFloat($scope.update_ak.eenheidsprijs);
                $scope.upd_container = parseInt($scope.update_ak.aantal_container);
                $scope.upd_opzet = parseInt($scope.update_ak.aantal_opzet);
                $scope.upd_tray = parseInt($scope.update_ak.aantal_tray);
                $scope.upd_doos = parseInt($scope.update_ak.aantal_doos);
            } else {
                if ($actie == 'update') {
                    $http({
                        url: 'aankopen/update_aankoop',
                        method: "POST",
                        data: JSON.stringify({
                            id: $scope.upd_id,
                            artikel: $scope.upd_artikel,
                            aantal: $scope.upd_aantal,
                            ehprijs: $scope.upd_ehprijs,
                            container: $scope.upd_container,
                            opzet: $scope.upd_opzet,
                            tray: $scope.upd_tray,
                            doos: $scope.upd_doos
                        })
                    }).success(function (data) {
                        $scope.aankopen_gedaan();
                        $scope.delta_aankopen_fn();
                        $timeout(diff_delta_fn, 1000);
                    }).error(function (err, status) {
                        alert('Er is een fout opgetreden bij het updaten van de aankooplijn.');
                        console.log(err);
                        console.log(status);
                    });
                }
            }
        }

        partnersFactory.partners()
            .success(function (data) {
                $scope.partners = jQuery.makeArray(data);
                $scope.partner = $scope.partners[0];
                //$scope.selectPrimary();
            })
            .error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de partners');
                console.log(err);
                console.log(status);
            });

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        var datum = new Date();
        var day = datum.getDate();
        var month = datum.getMonth();
        var month = month + 1;
        var year = datum.getFullYear();

        $scope.totdatum = new Date();
        $scope.vandatum = '01/01/' + new Date().getFullYear();

        //Haal enkel data op als alle 3 de velden ingevuld zijn
        $scope.$watch('vandatum', function () {
            if ($scope.partner && $scope.totdatum && $scope.vandatum) {
                $scope.aankopen_gedaan();
                $scope.aankopen_ontvangen();
            }
        });

        $scope.$watch('totdatum', function () {
            if ($scope.partner && $scope.totdatum && $scope.vandatum) {
                $scope.aankopen_gedaan();
                $scope.aankopen_ontvangen();
            }
        });

        $scope.$watch('partner', function () {
            if ($scope.partner && $scope.totdatum && $scope.vandatum) {
                console.log('watch partner');
                $scope.aankopen_gedaan();
                $scope.aankopen_ontvangen();
                $scope.delta_aankopen_fn();
                $scope.delta_ontvangen_fn();
                $timeout(diff_delta_fn, 1000);
            }
        });

        //voer deze functie 1 sec na het laden van de pagina uit. Deze maakt gebruik van dom velden. Zonder timeout zijn de variabelen nog niet gekend.
        $timeout(diff_delta_fn, 1000);

        //haal de aankopen op van de persoon die ingelogd is, en die hij deed voor de gekozen partner
        $scope.aankopen_gedaan = function () {
            $http({
                url: 'aankopen/aankopen_gedaan',
                method: "POST",
                data: JSON.stringify({
                    partner: $scope.partner.naam, vandatum: new Date($scope.vandatum),
                    totdatum: new Date($scope.totdatum)
                })
            }).success(function (data) {
                $scope.ak_gedaan = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij ophalen van de gedane aankopen');
                console.log(err);
                console.log(status);
            });
        }

        /*Bereken de totalen van de gedane aankopen in de tabel*/
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

        //haal de aankopen op die de gekozen partner deed voor de persoon die ingelogd is
        $scope.aankopen_ontvangen = function () {
            $http({
                url: 'aankopen/aankopen_ontvangen',
                method: "POST",
                data: JSON.stringify({
                    partner: $scope.partner.naam, vandatum: new Date($scope.vandatum),
                    totdatum: new Date($scope.totdatum)
                })
            }).success(function (data) {
                $scope.ak_ontvangen = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de ontvangen aankopen');
                console.log(err);
                console.log(status);
            });
        }

        /*Bereken de de totalen voor de tabel met de ontvangen aankopen*/
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

        $scope.delta_aankopen_fn = function () {
            $http({
                url: 'aankopen/totaal_delta_ak_gedaan',
                method: "POST",
                data: JSON.stringify({partner: $scope.partner.naam})
            }).success(function (data) {
                $scope.delta_aankopen = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de totalen van de gedane aankopen');
                console.log(err);
                console.log(status);
            });
        }

        $scope.delta_ontvangen_fn = function () {
            $http({
                url: 'aankopen/totaal_delta_ak_ontvangen',
                method: "POST",
                data: JSON.stringify({partner: $scope.partner.naam})
            }).success(function (data) {
                $scope.delta_ontvangen = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de totalen van de ontvangen aankopen');
                console.log(err);
                console.log(status);
            });
        }

        function diff_delta_fn() {
            var da_totaal_delta = 0;
            var da_container_delta = 0;
            var da_opzet_delta = 0;
            var da_tray_delta = 0;
            var da_doos_delta = 0;

            var do_totaal_delta = 0;
            var do_container_delta = 0;
            var do_opzet_delta = 0;
            var do_tray_delta = 0;
            var do_doos_delta = 0;

            /*geeft 1 record terug*/
            angular.forEach($scope.delta_aankopen, function (da, index) {
                da_totaal_delta = da.totaal_delta;
                da_container_delta = da.container_delta;
                da_opzet_delta = da.opzet_delta;
                da_tray_delta = da.tray_delta;
                da_doos_delta = da.doos_delta;
            });

            /*geeft 1 record terug*/
            angular.forEach($scope.delta_ontvangen, function (dontv, index) {
                do_totaal_delta = dontv.totaal_delta;
                do_container_delta = dontv.container_delta;
                do_opzet_delta = dontv.opzet_delta;
                do_tray_delta = dontv.tray_delta;
                do_doos_delta = dontv.doos_delta;
            });

            $scope.diff_totaal_delta = da_totaal_delta - do_totaal_delta;
            $scope.diff_container_delta = da_container_delta - do_container_delta;
            $scope.diff_opzet_delta = da_opzet_delta - do_opzet_delta;
            $scope.diff_tray_delta = da_tray_delta - do_tray_delta;
            $scope.diff_doos_delta = da_doos_delta - do_doos_delta;

        };

        $scope.delete_aankoop = function ($id) {

            $http({method: 'GET', url: 'aankopen/delete/' + $id}).
                success(function (data, status, headers, config) {
                    $scope.aankopen_gedaan();
                    $scope.aankopen_ontvangen();
                    $scope.delta_aankopen_fn();
                    $scope.delta_ontvangen_fn();
                    $timeout(diff_delta_fn, 1000);
                }).
                error(function (err, status) {
                    alert('Er is een fout opgetreden bij het verwijderen van de aankoop');
                    console.log(err);
                    console.log(status);
                });
        };
    }); //einde OVERZICHT CONTROLLER

    /*OVERDRACHT CONTROLLER*/
    app.controller('OverdrachtController', function ($scope, $http, $timeout, partnersFactory) {
        $scope.showme = false;

        $scope.showmefn = function ($bool, $overdracht, $actie) {
            $scope.showme = $bool;
            $scope.update_overdracht = $overdracht;

            if ($bool == true) {
                $scope.upd_id = $scope.update_overdracht.id;
                $scope.upd_betaaldatum = new Date($scope.update_overdracht.datum).toLocaleDateString();
                $scope.upd_bedrag = parseInt($scope.update_overdracht.bedrag);
                $scope.upd_container = parseInt($scope.update_overdracht.aantal_container);
                $scope.upd_opzet = parseInt($scope.update_overdracht.aantal_opzet);
                $scope.upd_tray = parseInt($scope.update_overdracht.aantal_tray);
                $scope.upd_doos = parseInt($scope.update_overdracht.aantal_doos);
            } else {
                if ($actie == 'update') {
                    $http({
                        url: 'overdrachten/update_overdracht',
                        method: "POST",
                        data: JSON.stringify({
                            id: $scope.upd_id,
                            datum: new Date($scope.upd_betaaldatum),
                            bedrag: $scope.upd_bedrag,
                            container: $scope.upd_container,
                            opzet: $scope.upd_opzet,
                            tray: $scope.upd_tray,
                            doos: $scope.upd_doos
                        })
                    }).success(function (data) {
                        $scope.loadData();
                    }).error(function (err, status) {
                        alert('Er is een fout opgetreden bij het updaten van de overdracht');
                        console.log(err);
                        console.log(status);
                    });
                }
            }
        }

        partnersFactory.partners()
            .success(function (data) {
                $scope.partners = jQuery.makeArray(data);
                console.log($scope.partners);
                $scope.betaaldAan = $scope.partners[0];
               // $scope.selectPrimary();
            })
            .error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de partners');
                console.log(err);
                console.log(status);
            });

        $scope.dateOptions = {
            dateFormat: 'dd/mm/yy'
        };

        $scope.betaaldatum = new Date().toLocaleDateString();

        $scope.loadData = function () {
            if ($scope.betaaldAan != null) {
                $http({
                    url: 'overdrachten/get_betalingen',
                    method: "POST",
                    data: JSON.stringify({betaaldAan: $scope.betaaldAan.naam})
                }).success(function (data) {

                    $scope.betalingen = data;
                    $timeout(delta_aankopen_fn, 500);
                    $timeout(delta_ontvangen_fn, 500);
                    $timeout(diff_delta_fn, 1000);

                }).error(function (err, status) {
                    alert('Er is een fout opgetreden bij ophalen van de betalingen');
                    console.log(err);
                    console.log(status);
                });
            }
        };

        $scope.$watch('betaaldAan', function () {
            $scope.loadData();
        });


        $scope.submitForm = function () {
            $http({
                url: 'overdrachten/insert_overdracht',
                method: "POST",
                data: JSON.stringify({
                    partner: $scope.betaaldAan.naam,
                    bedrag: $scope.bedrag,
                    aantal_container: $scope.container,
                    aantal_opzet: $scope.opzet,
                    aantal_tray: $scope.tray,
                    aantal_doos: $scope.doos,
                    datum: new Date($scope.betaaldatum)
                })
            }).success(function (data) {
                $scope.bedrag = '';
                $scope.container = '';
                $scope.opzet = '';
                $scope.tray = '';
                $scope.doos = '';

                $scope.loadData();
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het wegschrijven van de overdracht. Probeer nogmaals');
                console.log(err);
                console.log(status);
            });
        }

        /*Bereken de totalen*/
        $scope.getTotalBetaald = function () {
            var total = 0;

            angular.forEach($scope.betalingen, function (betaling, index) {
                if (betaling.bedrag != null) {
                    total += parseInt(betaling.bedrag);
                }
            });

            return total;

        };

        $scope.getTotalContainer = function () {
            var total = 0;

            angular.forEach($scope.betalingen, function (betaling, index) {
                if (betaling.aantal_container != null) {
                    total += parseInt(betaling.aantal_container);
                }
            });

            return total;
        };

        $scope.getTotalOpzet = function () {
            var total = 0;

            angular.forEach($scope.betalingen, function (betaling, index) {
                if (betaling.aantal_opzet != null) {
                    total += parseInt(betaling.aantal_opzet);
                }
            });
            return total;
        };

        $scope.getTotalTray = function () {
            var total = 0;

            angular.forEach($scope.betalingen, function (betaling, index) {
                if (betaling.aantal_tray != null) {
                    total += parseInt(betaling.aantal_tray);
                }
            });
            return total;
        };

        $scope.getTotalDoos = function () {
            var total = 0;

            angular.forEach($scope.betalingen, function (betaling, index) {
                if (betaling.aantal_doos != null) {
                    total += parseInt(betaling.aantal_doos);
                }
            });
            return total;
        };

        function delta_aankopen_fn() {
            $http({
                url: 'aankopen/totaal_delta_ak_gedaan',
                method: "POST",
                data: JSON.stringify({partner: $scope.betaaldAan.naam})
            }).success(function (data) {
                $scope.delta_aankopen = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de aankopen');
                console.log(err);
                console.log(status);
            });
        }

        function delta_ontvangen_fn() {
            $http({
                url: 'aankopen/totaal_delta_ak_ontvangen',
                method: "POST",
                data: JSON.stringify({partner: $scope.betaaldAan.naam})
            }).success(function (data) {
                $scope.delta_ontvangen = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de aankopen');
                console.log(err);
                console.log(status);
            });
        }

        function diff_delta_fn() {
            /*geeft 1 record terug*/
            angular.forEach($scope.delta_aankopen, function (da, index) {
                console.log('in for each ak');
                da_totaal_delta = da.totaal_delta;
                da_container_delta = da.container_delta;
                da_opzet_delta = da.opzet_delta;
                da_tray_delta = da.tray_delta;
                da_doos_delta = da.doos_delta;

            });

            /*geeft 1 record terug*/
            angular.forEach($scope.delta_ontvangen, function (dontv, index) {
                console.log('in for each ontv');
                do_totaal_delta = dontv.totaal_delta;
                do_container_delta = dontv.container_delta;
                do_opzet_delta = dontv.opzet_delta;
                do_tray_delta = dontv.tray_delta;
                do_doos_delta = dontv.doos_delta;

            });

            $scope.diff_totaal_delta = da_totaal_delta - do_totaal_delta;
            $scope.diff_container_delta = da_container_delta - do_container_delta;
            $scope.diff_opzet_delta = da_opzet_delta - do_opzet_delta;
            $scope.diff_tray_delta = da_tray_delta - do_tray_delta;
            $scope.diff_doos_delta = da_doos_delta - do_doos_delta;

        };

        $scope.delete_overdracht = function ($id) {
            $http({method: 'GET', url: 'overdrachten/delete/' + $id}).
                success(function (data, status, headers, config) {
                    $scope.loadData();
                }).error(function (err, status) {
                    alert('Er is een fout opgetreden bij het verwijderen van de overdracht');
                    console.log(err);
                    console.log(status);
                });

        };


    }); //einde OVERDRACHT CONTROLLER

    /*RESETPWD CONTROLLER*/
    app.controller('ResetPwdController', function ($scope, $http) {
        $scope.submitForm = function () {
            $http({
                method: 'POST',
                url: 'save_nieuw_paswoord',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({oud_pwd: $scope.oudpwd, nieuw_pwd: $scope.pw1})
            }).success(function (data) {
                if (data == 'ok') {
                    alert('De wijziging van het paswoord is opgeslagen');
                    $scope.oudpwd = '';
                    $scope.pw1 = '';
                    $scope.pw2 = '';
                } else {
                    alert('Het oude paswoord is niet correct. Probeer nog eens.');
                }
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het aanpassen van het wachtwoord. Probeer opnieuw.');
                console.log(err);
                console.log(status);
            });
        }
    });
    //einde RESETPWD CONTROLLER

    /*ADMINRESETPWD CONTROLLER*/
    app.controller('AdminResetPwdController', function ($scope, $http, $location) {
        $scope.submitForm = function (id) {
            $http({
                method: 'POST',
                url: 'admin_save_nieuw_paswoord',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({id: id, nieuw_pwd: $scope.pw1})
            }).success(function (data) {
                if (data == 'ok') {
                    alert('De wijziging van het paswoord is opgeslagen');
                    $scope.pw1 = '';
                    $scope.pw2 = '';
                } else {
                    alert('De gebruiker werd niet gevonden. Probeer nog eens.');
                }
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij het aanpassen van het wachtwoord. Probeer opnieuw.');
                console.log(err);
                console.log(status);
            });
        }

        $scope.naar_gebruikers = function ($event) {
            $event.preventDefault();

            $http({
                url: 'gebruikers',
                method: "POST"
            });
        }


    });
    //einde ADMINRESETPWD CONTROLLER

    /*GERUIKERSCONTROLLER*/
    app.controller('GebruikersController', function ($scope, $http, rollenFactory, dialogs) {
        rollenFactory.rollen()
            .success(function (data) {
                $scope.rollen = jQuery.makeArray(data);
                $scope.type = $scope.rollen[0].id;
            })
            .error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de rollen');
                console.log(err);
                console.log(status);
            });

        $scope.submitForm = function () {
            $http({
                method: 'POST',
                url: 'gebruikers/insert_gebruiker',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    naam: $scope.naam,
                    voornaam: $scope.voornaam,
                    email: $scope.email,
                    paswoord: $scope.paswoord,
                    rol: $scope.type
                })
            }).success(function (data) {
                $scope.message = data;
                $scope.naam = '';
                $scope.voornaam = '';
                $scope.email = '';
                $scope.paswoord = '';

                $scope.loadData();
            });
        }

        $scope.loadData = function () {
            $http({
                url: 'gebruikers/get_alle_gebruikers',
                method: "POST"
            }).success(function (data) {
                $scope.gebruikers = data;
            }).error(function (err, status) {
                alert('Er is een fout opgetreden bij ophalen van de gebruikers');
                console.log(err);
                console.log(status);
            });
        };

        $scope.launch_dialog = function ($id, $voornaam, $naam) {
            var dlg = null;

            dlg = dialogs.confirm('Weet je zeker dat je de gebruiker ' + $voornaam + ' ' + $naam + ', en alle gerelateerde aankopen wil verwijderen?');
            dlg.result.then(function (btn) {
                $scope.confirmed = $id + ' wordt verwijderd';

                $http({method: 'GET', url: 'gebruikers/delete_gebruiker/' + $id}).
                    success(function (data, status, headers, config) {
                        $scope.loadData();
                    }).
                    error(function (err, status) {
                        alert('Er is een fout opgetreden bij het verwijderen van de gebruiker of gelinkte gegevens');
                        console.log(err);
                        console.log(status);
                    });

                $scope.loadData();
            }, function (btn) {
                $scope.confirmed = 'Ok, ik doe niks';
            });
        };

        $scope.loadData();
    });
    //einde GERUIKERSCONTROLLER

    /*EDITGERUIKERSCONTROLLER*/
    app.controller('EditGebruikerController', function ($scope, $http, rollenFactory) {
        rollenFactory.rollen()
            .success(function (data) {
                $scope.rollen = jQuery.makeArray(data);
                $scope.type = $('#var_rol_id').val();
            })
            .error(function (err, status) {
                alert('Er is een fout opgetreden bij het ophalen van de rollen');
                console.log(err);
                console.log(status);
            });


    });
    //einde EDITGERUIKERSCONTROLLER

    /*KOPPELINGCONTROLLER*/
    app.controller('KoppelingController', function ($scope, $http, dialogs) {

        $scope.id = $('#id').val();

        $scope.loadData = function () {
            $http({
                url: 'gebruikers/get_alle_niet_gekoppelde_gebruikers',
                method: "POST",
                data: JSON.stringify({id: $scope.id})
            }).success(function (data) {
                $scope.gebruikers = data;
            });

            $http({
                url: 'gebruikers/get_alle_gekoppelde_gebruikers',
                method: "POST",
                data: JSON.stringify({id: $scope.id})
            }).success(function (data) {
                $scope.gekoppelde_gebruikers = data;
            });
        }

        $scope.loadData();

        $scope.submitForm = function () {
            $http({
                method: 'POST',
                url: 'gebruikers/koppel_gebruikers',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({id1: $scope.gebruiker, id2: $scope.id})
            }).success(function (data) {
                $scope.message = data;

                $scope.loadData();
            });
        }

        $scope.updateSelection = function (position, gekoppelde_gebruikers, id) {
            $http({
                method: 'POST',
                url: 'gebruikers/update_primair',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({id: id, gebruiker_id: $scope.id})
            }).success(function (data) {

                $scope.loadData();
            });

        }

        $scope.launch_dialog = function ($id, $id2, $naam) {
            var dlg = null;

            dlg = dialogs.confirm('Weet je zeker dat je de koppeling met  ' + $naam + ', en alle gerelateerde aankopen wil verwijderen?');
            dlg.result.then(function (btn) {
                $scope.confirmed = $id + ' wordt verwijderd';

                $http({method: 'GET', url: 'gebruikers/delete_koppeling/' + $id + '/' + $id2}).
                    success(function (data) {
                        $scope.loadData();
                    }).
                    error(function (err, status) {
                        alert('Er is een fout opgetreden bij het verwijderen van de koppeling of gelinkte gegevens');
                        console.log(err);
                        console.log(status);
                    });

                $scope.loadData();
            }, function (btn) {
                $scope.confirmed = 'Ok, de actie wordt geannuleerd';


            });
        };

    });
    //einde KOPPELINGCONTROLLER


})();

