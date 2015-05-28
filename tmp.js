/**
 * Created by Penders on 5/27/2015.
 */
angular.module('modalTest',['ui.bootstrap','dialogs'])
    .controller('dialogServiceTest',function($scope,$rootScope,$timeout,$dialogs){




        $scope.launch = function(which){
            var dlg = null;

                    dlg = $dialogs.confirm('Please Confirm','Is this awesome or what?');
                    dlg.result.then(function(btn){
                        $scope.confirmed = 'You thought this quite awesome!';
                    },function(btn){
                        $scope.confirmed = 'Shame on you for not thinking this is awesome!';
                    });


        }; // end launch




    }) // end dialogsServiceTest
