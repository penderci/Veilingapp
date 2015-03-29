<!--<script type="text/javascript">
    function artikelController($scope,$http) {
        $scope.artikels = [];
        $http.get('<?php /*echo site_url('artikels/get_list'); */?>').success(function($data){ $scope.artikels=$data; });
    }
    </script>-->

<div class="container" ng-controller="ArtikelController">
    <ul>
        <li ng-repeat="artikel in artikels">
            {{artikel.id}} - {{artikel.naam}}
        </li>
    </ul>
</div>
<script>
    function ArtikelController($scope){
        $scope.artikels=[{id:'1',naam:'roos'},{id:'2',naam:'tulp'}];
    }
</script>