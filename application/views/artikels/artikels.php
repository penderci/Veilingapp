
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

    <table>
        <tr ng-repeat="artikel in artikels | filter: q as results">
            <td>{{artikel.naam}}</td>
            <td>
                <a href="artikels/edit/{{artikel.id}}" class="btn-sm glyphicon glyphicon-pencil"></a>
                <a href="artikels/delete/{{artikel.id}}" class="btn-sm glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    </table>
</div>
</form>