/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var expertapp = angular.module('expert', []);
expertapp.controller('ExpertListCtl', ['$scope', function ($scope) {
    $scope.homeClick = function () {
        window.location.href = "?view=home";
    }
}]);