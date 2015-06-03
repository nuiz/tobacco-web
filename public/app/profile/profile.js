/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";

window.userlogin = null;
var profileapp = angular.module('profile', []);
profileapp.config(['$sceDelegateProvider', function ($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist([
        'self',
        window.config.api_url+'/**'
    ]);
}]);

profileapp.controller('ProfileCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.homeClick = function(){
        window.location.href = "?view=home";
    };

    $scope.user = {};
    $http.get("auth.php?action=get").success(function(data){
        window.userlogin = $scope.user = data;
    });
}]);

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

profileapp.controller('FeedListCtl', ['$scope', '$http', function ($scope, $http) {
    //$("#content-1").mCustomScrollbar({});

    $scope.limit = 15;
    $scope.currentPage = 1;

    $scope.posts = [];

    $scope.total = 0;
    $scope.pageLength = 0;
    $scope.paging = [];
    function refreshPage(){
        var paramStr = $.param({page: $scope.currentPage, limit: $scope.limit, auth_token: window.userlogin.auth_token});
        $http.get(window.config.api_url+"/blog/feed?"+ paramStr)
            .success(function(data){
                $scope.posts = data.data;
                $scope.total = data.total;
                $scope.pageLength = parseInt($scope.total/$scope.limit);
                if($scope.total%$scope.limit != 0) $scope.pageLength++;

                $scope.paging = [];
                for(var i = 0; i < $scope.pageLength; i++){
                    $scope.paging.push({page: i+1, current: $scope.currentPage==i+1});
                }
                console.log($scope.paging, $scope.total);
            });
    }
    onUserReady(refreshPage);

    $scope.setCurrentPage = function(cur){
        $scope.currentPage = cur;
        refreshPage();
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

    $scope.form = {};
    function PostForm(){}
    PostForm.prototype.formshow = false;
    PostForm.prototype.ajaxReq = false;
    PostForm.prototype.setFormshow = function(formshow){
        this.formshow = formshow;
    };
    PostForm.prototype.formText = {post_type: "text", "post_text": ""};
    PostForm.prototype.formImage = {post_type: "image", "post_text": ""};
    PostForm.prototype.formVideo = {post_type: "video", "post_text": ""};
    PostForm.prototype.textSubmit = function(){
        if(this.ajaxReq) return;

        if(this.formText.post_text.length == 0){
            alert("กรุณาใส่ข้อความที่จะโพส");
            return;
        }

        this.ajaxReq = true;
        $.post(window.config.api_url+"/blog/post?auth_token="+window.userlogin.auth_token, this.formText, function(data){
                window.location.reload();
            }, 'json');
    };
    PostForm.prototype.images = [];
    PostForm.prototype.browseImage = function(images){
        var that = this;
        $.each(images, function(index, img){
            that.images.push(img);
        });
    };
    PostForm.prototype.deleteImage = function(index){
        this.images.splice(index, 1);
    };
    PostForm.prototype.imageSubmit = function(){
        if(this.ajaxReq) return;

        if(this.images.length == 0){
            alert("กรุณาเลือกรูปภาพก่อน");
            return;
        }

        var fd = new FormData();
        fd.append("post_type", this.formImage.post_type);
        fd.append("post_text", this.formImage.post_text);

        $.each(this.images, function(index, img){
            fd.append("post_image["+index+"]", img.file, img.file.name);
        });

        this.ajaxReq = true;
        $.ajax({
            url: window.config.api_url+"/blog/post?auth_token="+window.userlogin.auth_token,
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                window.location.reload();
            }
        });
    };
    PostForm.prototype.videoInput = null;
    PostForm.prototype.setVideoInput = function(el){
        this.videoInput = el[0];
    };
    PostForm.prototype.videoSubmit = function(){
        if(this.ajaxReq) return;

        if(this.videoInput.files.length == 0){
            alert("กรุณาเลือก video ก่อน");
            return;
        }

        var file = this.videoInput.files[0];
        var fd = new FormData();
        fd.append("post_type", this.formVideo.post_type);
        fd.append("post_text", this.formVideo.post_text);
        fd.append("post_video", file, file.name);

        this.ajaxReq = true;
        $.ajax({
            url: window.config.api_url+"/blog/post?auth_token="+window.userlogin.auth_token,
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                window.location.reload();
            }
        });
    };

    $scope.form.vm = new PostForm();
}]);

var videojs_id = 0;
profileapp.directive('myPlayer', function () {
    var linker = function (scope, element, attrs){
        videojs_id++;
        var id = "videojs_" + videojs_id;
        //element.attr("id", id);
        //setTimeout(function(){
        //    videojs(id, {}, function(){});
        //}, 1);
        //element[0].oncanplay = function() {
        //    videojs(element[0], {}, function(){});
        //};
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