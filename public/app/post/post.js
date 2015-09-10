/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";

window.userlogin = null;
var app = angular.module('post-app', []);
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

app.controller('PostCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.item = null;
    onUserReady(function(){
        $http.get(window.config.api_url+"/blog/"+getParameterByName("post_id")+"?"+ $.param({auth_token: window.userlogin.auth_token}))
            .success(function(data){
                $scope.item = data;
            });
        $scope.userlogin = window.userlogin;
    });

    $scope.comments = [];
    $http.get(window.config.api_url+"/blog/post/comment/"+getParameterByName("post_id"))
        .success(function(data){
            $scope.comments = data.data;
        });

    $scope.addForm = {};
    $scope.addForm.comment_text = "";

    var commentAjaxReq = false;
    $scope.addComment = function(){
        if(commentAjaxReq) return;

        var url = window.config.api_url+"/blog/post/comment/"+getParameterByName("post_id")+"?auth_token="+userlogin.auth_token;
        commentAjaxReq = true;
        $.post(url, $scope.addForm, function(data){
            window.location.reload();
        }, 'json');
    };

    $scope.like = function(item){
        var url = window.config.api_url+"/blog/post/like/"+item.post_id+"?auth_token="+window.userlogin.auth_token;
        $http.post(url).success(function(data){
            item.like_count=data.like_count;
            item.liked = data.liked;
        });
    };

    $scope.unlike = function(item){
        var url = window.config.api_url+"/blog/post/unlike/"+item.post_id+"?auth_token="+window.userlogin.auth_token;
        $http.post(url).success(function(data){
            item.like_count=data.like_count;
            item.liked = data.liked;
        });
    };

    $scope.delete = function(item){
        if(!confirm('คุณแน่ใจหรือไม่?')) {
          return;
        }
        var url = window.config.api_url+"/blog/post/delete/"+item.post_id+"?auth_token="+window.userlogin.auth_token;
        $http.get(url).success(function(data){
          window.history.back();
        });
    };

    $scope.deleteComment = function(item){
        if(!confirm('คุณแน่ใจหรือไม่?')) {
          return;
        }
        var url = window.config.api_url+"/blog/post/comment/delete/"+item.comment_id+"?auth_token="+window.userlogin.auth_token;
        $http.get(url).success(function(data){
          window.location.reload();
        });
    };

    (function($scope) {
        var thMonth = [
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

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        $scope.dateThai = function (dateInput) {
            var dateObject = new Date(dateInput.replace(" ", "T"));
            var date = "วันที่ " + dateObject.getDate() + " " + thMonth[dateObject.getMonth()] + " " + (dateObject.getFullYear() + 543);
            var time = checkTime(dateObject.getHours()) + ":" + checkTime(dateObject.getMinutes()) + " น.";

            return date + " เวลา " + time;
        };
    })($scope);
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
