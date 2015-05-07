/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var expertapp = angular.module('expert', []);
expertapp.controller('ExpertListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.homeClick = function () {
        window.location.href = "?view=home";
    };

    $scope.cats = [];
    $http.get("http://localhost/tobacco/guru/category").success(function(data){
        $scope.cats = data.data;
    });

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
    };
}]);