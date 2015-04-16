/**
 * Created by NUIZ on 3/4/2558.
 */

"use strict";
var app = angular.module('news-subtype', []);
app.controller('NewsController', ['$scope', '$http', '$location', function ($scope, $http, $location) {
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var id = $location.search().id;
    var url = 'http://localhost/tobacco/news/'+getParameterByName('id');

    $scope.news = {};
    $http.get(url).success(function (data) {
        $scope.news = data;
    });
}]);

app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});