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
            <tbody>
            <tr ng-repeat="artikel in artikels | offset: currentPage*itemsPerPage | limitTo: itemsPerPage | filter: q as results"> <!--filter: q as results | -->
                <td>{{artikel.naam}}</td>
                <td>
                    <a href="artikels/edit/{{artikel.id}}" class="btn-sm glyphicon glyphicon-pencil"></a>
                </td><td>
                    <a href="artikels/delete/{{artikel.id}}" class="btn-sm glyphicon glyphicon-trash"></a>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <td colspan="3">
                <div class="pagination">
                    <ul>
                        <li ng-class="prevPageDisabled()">
                            <a href ng-click="prevPage()">« Prev</a>
                        </li>
                        <li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                            <a href="#">{{n+1}}</a>
                        </li>
                        <li ng-class="nextPageDisabled()">
                            <a href ng-click="nextPage()">Next »</a>
                        </li>
                    </ul>
                </div>
            </td>
            </tfoot>
        </table>

    </div>
</form>