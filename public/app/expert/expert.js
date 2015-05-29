/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var expertapp = angular.module('expert', []);
expertapp.controller('ExpertListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.homeClick = function () {
        window.location.href = "?view=home";
    };

    $scope.gurus = [];
    $scope.cats = [];
    $http.get(window.config.api_url+"/guru/category").success(function(data){
        data.data = data.data.reverse();
        $scope.cats = data.data;
    });

    $scope.selectedGuru = null;
    $scope.clickGuru = function(item){
        $scope.selectedGuru = item;
        console.log(item);
    };

    $scope.catPage = 0;
    $scope.clickLever = function(){
        if($scope.catPage == 0)
            $scope.catPage = 1;
        else
            $scope.catPage = 0;
    };

    $scope.selectedCat = null;
    $scope.clickCat = function(index){
        $scope.selectedCat = index;
        $('.cat-icon').removeClass('selected');
        $('.cat-icon').eq(index).addClass('selected');

        var cat = $scope.cats[($scope.catPage*11)+index];

        $scope.gurus = [];
        $http.get(window.config.api_url+"/guru?guru_cat_id=" + cat.guru_cat_id).success(function(data){
            $scope.gurus = data.data;
        });
    };
}]);

expertapp.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});