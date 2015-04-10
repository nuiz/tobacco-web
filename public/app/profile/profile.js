/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var profileapp = angular.module('profile', []);
profileapp.controller('ProfileListCtl', ['$scope', function ($scope) {
    $scope.homeClick = function(){
        window.location.href = "?view=home";
    }
}]);
