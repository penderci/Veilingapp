<!--<script type="text/javascript">
    function artikelController($scope,$http) {
        $scope.artikels = [];
        $http.get('<?php /*echo site_url('artikels/get_list'); */?>').success(function($data){ $scope.artikels=$data; });
    }
    </script>-->
<form ng-controller="ArtikelController" ng-submit="submitForm()">
<div class="container">
    Nieuw artikel :
    <p>
        <input type="text" ng-model="inputnaam"/>
        <button ng-click="voegArtikelToe">Toevoegen</button>
    </p>
    <ul>
        <li ng-repeat="artikel in artikels">
            {{artikel.id}} - {{artikel.naam}}
        </li>
    </ul>

</div>
</form>