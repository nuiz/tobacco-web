/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var subpageapp = angular.module('subpage', []);
subpageapp.controller('SubpageListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get(window.config.api_url+'/book_type').success(function (data) {
        $scope.booktypes = data.data;
    });
    $scope.subpageClick = function(){
        window.location.href = "?view=e-book";
    };

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.books = [];
    var url = window.config.api_url+"/ebook?book_type_id="+getParameterByName('book_type_id');
    $http.get(url).success(function (data) {
        $scope.books = data.data;
    });
}]);
