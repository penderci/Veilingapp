
<form ng-controller="ArtikelController" ng-submit="submitForm()">
    <div class="container">
        Nieuw artikel :
        <p>
            <input type="text" ng-model="inputnaam"/>
            <button type="submit" class="btn-sm btn-default">Toevoegen</button>
        </p>
        <p>

            Zoek een artikel :
            <input type="search" ng-model="q" placeholder="artikel" />
        </p>


        <div class="col-sm-3" style="position: absolute;left: 13%;top: 30%">
            <div style="height: 450px; overflow: auto;">
                <table class="table table-striped table-hover" style="font-size: 12px;">

<!--        <table>-->
            <tr ng-repeat="artikel in artikels | filter: q as results">
                <td>{{artikel.naam}}</td>
                <td>
                    <a href="artikels/edit/{{artikel.id}}" class="btn-sm glyphicon glyphicon-pencil"></a>
                    </td><td>
                    <a href="#" ng-click="launch_dialog(artikel.id)" class="btn-sm glyphicon glyphicon-trash"></a>
                    <!--ng-click="launch_dialog()"                 artikels/delete/{{artikel.id}}-->
                </td>
            </tr>
        </table>
                </div>
            </div>
    </div>
</form>
