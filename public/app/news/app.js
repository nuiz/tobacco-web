/**
 * Created by NUIZ on 3/4/2558.
 */

"use strict";
var app = angular.module('news-app', ['ionic']);
app.controller('NewsController', ['$scope', '$http', function ($scope, $http) {
    $scope.currentNews = 0;
    $scope.news = [];
    $http.get('http://localhost/tobacco/news').success(function (data) {
        $scope.news = data.data;

            $scope.initSuccess = true;
            $scope.fetchDisplay();
            $scope.$apply();
    });

    $scope.prev = function(){
        $scope.currentNews--;
        if($scope.currentNews < 0){
            $scope.currentNews = $scope.news.length-1;
        }

        $scope.fetchDisplay();
    };

    $scope.next = function(){
        $scope.currentNews++;
        if($scope.currentNews >= $scope.news.length){
            $scope.currentNews = 0;
        }

        $scope.fetchDisplay();
    };

    $scope.fetchDisplay = function(){
        $scope.newsPrev = $scope.news[$scope.currentNews-1] || $scope.news[$scope.news.length-1];
        $scope.newsCur = $scope.news[$scope.currentNews];
        $scope.newsNext = $scope.news[$scope.currentNews+1] || $scope.news[0];
    };
}]);

app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});