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
        <button type="submit" class="btn-sm btn-default">Toevoegen</button>
<!--        <button ng-click="voegArtikelToe">Toevoegen</button>-->
    </p>
    <p>
<!--        Sorteer op:
        <select ng-model="orderBy">
            <option value="naamaz">A-Z</option>
            <option value="naamza">Z-A</option>
        </select>-->
        Zoek een artikel :
        <input type="search" ng-model="q" placeholder="artikel" />
    </p>
    <ul>
        <li ng-repeat="artikel in artikels | filter: q as results ">
            {{artikel.id}} - {{artikel.naam}}
        </li>
    </ul>

</div>
</form>