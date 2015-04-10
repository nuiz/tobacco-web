/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var faqapp=angular.module('faq',[]);
faqapp.controller('FaqListCtl',['$scope', '$http' , function($scope, $http){
    $http.get('http://localhost/tobacco/faq').success(function(data) {
        $scope.faqs = data.data;
    });
    $scope.backhomeClick = function(){
        window.location.href = "?view=home";
    };
    $scope.faqshow=function(index){
        $scope.displayAns=$scope.faqs[index].faq_answer;
    }
}]);