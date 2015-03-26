/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var faqapp=angular.module('faq',[]);
faqapp.controller('FaqListCtl',['$scope', '$http' , function($scope, $http){
    $http.get('http://192.168.100.26/tobacco/faq').success(function(data) {
        console.log(data);
        $scope.faqs = data.data;
    });
    $scope.faqshow=function(index){
        $scope.displayAns=$scope.faqs[index].faq_answer;
    }
}]);

