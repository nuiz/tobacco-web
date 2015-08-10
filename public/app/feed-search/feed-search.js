/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";

window.userlogin = null;
var app = angular.module('feed-search-app', []);
app.config(['$sceDelegateProvider', function ($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist([
        'self',
        window.config.api_url+'/**'
    ]);
}]);

app.controller('ProfileCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.homeClick = function(){
        window.location.href = "?view=home";
    };

    $scope.user = {};
    $http.get("auth.php?action=get").success(function(data){
        window.userlogin = $scope.user = data;
    });
}]);

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function onUserReady(cb){
    if(window.userlogin == null){
        setTimeout(function(){
            onUserReady(cb);
        }, 100);
    }
    else {
        cb();
    }
};

app.controller('SearchUserCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.item = null;
    onUserReady(function(){
        $http.get(window.config.api_url+"/blog/"+getParameterByName("post_id")+"?"+ $.param({auth_token: window.userlogin.auth_token}))
            .success(function(data){
                $scope.item = data;
            });
        $scope.userlogin = window.userlogin;
    });

    $scope.search_users = [];
    $http.get(window.config.api_url+"/usersearch?keyword="+getParameterByName("keyword"))
        .success(function(data){
            $scope.search_users = data;
        });
}]);

var videojs_id = 0;
app.directive('videojs', function () {
    var linker = function (scope, element, attrs){
        videojs_id++;
        var id = "videojs_" + videojs_id;
        element.attr("id", id);
        setTimeout(function(){
            videojs(id, {}, function(){}) ;
        }, 100);
    };
    return {
        restrict : 'A',
        link : linker
    };
})

.directive("formImageBrowse", [function () {
    var URL = window.URL || window.webkitURL;
    return {
        restrict : 'A',
        link: function (scope, element, attributes) {
            element.bind("change", function (e) {
                var imgs = [];
                $.each(e.target.files, function(index, file){
                    var ext = file.name.split(".").pop().toLowerCase();
                    if(ext != "jpg" && ext != "jpeg" && ext != "png"){
                        return;
                    }
                    var fileURL = URL.createObjectURL(file);
                    var obj = {
                        fileURL: fileURL,
                        file: file
                    };
                    imgs.push(obj);
                });

                scope.$apply(function(){
                    scope.form.vm.browseImage(imgs);
                });

                element.val('');
            });
        }
    }
}])

.directive("formVideoBrowse", [function () {
    var URL = window.URL || window.webkitURL;
    return {
        restrict : 'A',
        link: function (scope, element, attributes) {
            scope.form.vm.setVideoInput(element);
        }
    }
}]);