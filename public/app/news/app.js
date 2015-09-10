/**
 * Created by NUIZ on 3/4/2558.
 */

"use strict";
var app = angular.module('news-app', []);
app.controller('NewsController', ['$scope', '$http', function ($scope, $http) {
    $scope.date = new Date();
    $scope.dateNow = new Date();
    $scope.setMonth = function(month){
        var now = new Date();
        if($scope.date.getFullYear() == now.getFullYear()){
            if(month > now.getMonth()) return;
        }
        $scope.date.setMonth(month);
        $scope.getNews();
    };
    $scope.prevYear = function(){
        var year = parseInt($scope.date.getFullYear()) - 1;
        $scope.date.setYear(year);

        $scope.getNews();
        $scope.getList2();
    };
    $scope.nextYear = function(){
        var year = parseInt($scope.date.getFullYear()) + 1;
        $scope.date.setYear(year);

        $scope.getNews();
        $scope.getList2();
    };

    $scope.pagingLimit = 1; // set size of page limit

    $scope.currentNews = 0;
    $scope.pagingStart = 0;
    $scope.news = [];

    $scope.getNews = function(){
        var url = window.config.api_url+'/news?';
        var date = $scope.date.getFullYear();
        date += '-';
        date += $scope.date.getMonth()+1 < 10 ? '0'+($scope.date.getMonth()+1): ($scope.date.getMonth()+1);
        date += '-';
        //date += $scope.date.getDate() < 10 ? '0'+$scope.date.getDate(): $scope.date.getDate();
        date += '01';

        url += $.param({
            "date": date
        });

        $http.get(url).success(function (data) {
            $scope.pagingStart = 0;
            $scope.currentNews = 0;
            $scope.news = data.data;

            $scope.initSuccess = true;
            $scope.fetchDisplay();
        });
    };
    $scope.getNews();

    $scope.prev = function () {
        $scope.currentNews--;
        if ($scope.currentNews < 0) {
            $scope.currentNews = $scope.news.length - 1;
        }

        $scope.fetchDisplay();
    };

    $scope.next = function () {
        $scope.currentNews++;
        if ($scope.currentNews >= $scope.news.length) {
            $scope.currentNews = 0;
        }

        $scope.fetchDisplay();
    };

    setInterval(function(){
        $scope.next();
        $scope.$apply();
    }, 15000);

    $scope.fetchDisplay = function () {
        $scope.newsPrev = $scope.news[$scope.currentNews - 1] || $scope.news[$scope.news.length - 1];
        $scope.newsCur = $scope.news[$scope.currentNews];
        $scope.newsNext = $scope.news[$scope.currentNews + 1] || $scope.news[0];
    };

    $scope.setcurrentNews = function (currentNews) {
        $scope.currentNews = currentNews;
        $scope.fetchDisplay();
    };

    $scope.readmoreClick = function (id) {
        window.location.href = "?view=news-subtype&id="+id;
    };
    $scope.backClick = function () {
        window.location.href = "?view=home";
    };

    $scope.pagingStart = 0;
    $scope.pagingNext = function(){
        $scope.pagingStart += $scope.pagingLimit;
    };

    $scope.pagingPrev = function(){
        $scope.pagingStart -= $scope.pagingLimit;
    };

    $scope.list2 = [];
    $scope.getList2 = function(){
        var url = window.config.api_url+'/news/by_year?';
        var date = $scope.date.getFullYear();
        date += '-';
        date += $scope.date.getMonth()+1 < 10 ? '0'+($scope.date.getMonth()+1): ($scope.date.getMonth()+1);
        date += '-';
        //date += $scope.date.getDate() < 10 ? '0'+$scope.date.getDate(): $scope.date.getDate();
        date += '01';

        url += $.param({
            "year": date
        });

        $http.get(url).success(function (data) {
            data.data.reverse();
            $scope.list2 = data;
        });
    };
    $scope.getList2();

    $scope.thMonth = [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤจิกายน",
        "ธันวาคม"
    ];
}]);

app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});
