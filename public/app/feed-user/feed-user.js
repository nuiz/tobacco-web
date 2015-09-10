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

profileapp.controller('FeedListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.limit = 15;
    $scope.currentPage = 1;

    $scope.posts = [];

    $scope.total = 0;
    $scope.pageLength = 0;
    $scope.paging = [];
    function refreshPage(){
        var paramStr = $.param({page: $scope.currentPage, limit: $scope.limit, auth_token: window.userlogin.auth_token});
        $http.get(window.config.api_url+"/blog/user/"+getParameterByName("account_id")+"?"+ paramStr)
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

    $http.get(window.config.api_url+'/account/'+getParameterByName('account_id')).success(function(data){
        $scope.userProfile = data;
    });

    onUserReady(function() {
      refreshPage();
    });

    var $inputUploadPicture = $('#inputUploadPicture');
    $scope.uploadPictureAjax = false;
    $scope.clickInputPicture = function()
    {
      $inputUploadPicture.val('');
      $inputUploadPicture.click();
    };

    $inputUploadPicture.change(function(e){
      if(this.files.length == 0) return;
      var file = this.files[0];
      var fd = new FormData();
      fd.append('picture', file, file.name);

      $scope.uploadPictureAjax = true;
      $.ajax({
          url: window.config.api_url+"/account/"+$scope.userProfile.account_id+"/picture?auth_token="+window.userlogin.auth_token,
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          type: 'POST',
          success: function(data){
            $scope.uploadPictureAjax = false;
            $.post('auth.php?action=update', {
              user: {
                picture: data.picture
              }
            }, function(data) {
              window.location.reload();
            }, 'json');
            $scope.$apply();
          }
      });
      $scope.$apply();
    });

    $scope.editMode = false;
    $scope.toggleEditmode = function()
    {
      $scope.editMode = !$scope.editMode;
    };

    $scope.saveProfileEdit = function()
    {
      $.post(window.config.api_url+"/account/edit/"+$scope.userProfile.account_id, {
        email: $scope.userProfile.email,
        phone: $scope.userProfile.phone
      }, function(data){
        $.post('auth.php?action=update', {
          user: {
            email: data.email,
            phone: data.phone
          }
        }, function(data) {
          // do noting
        }, 'json');
        $scope.toggleEditmode();
        $scope.$apply();
      }, 'json');
    };

    $scope.backText = "หลัก";
    // $scope.backHref = '?view=feed';
    if(/(view=expert)/.test(document.referrer)) {
      $scope.backText = "ผู้เชี่ยวชาญ";
      // $scope.backHref = document.referrer;
    }

    $scope.backClick = function()
    {
      if(/(view=expert)/.test(document.referrer)) {
        window.history.back();
      }
      else {
        window.href = '?view=feed';
      }
    };

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

    $scope.delete = function(item){
        if(!confirm('คุณแน่ใจหรือไม่?')) {
          return;
        }
        var url = window.config.api_url+"/blog/post/delete/"+item.post_id+"?auth_token="+window.userlogin.auth_token;
        $http.get(url).success(function(data){
          refreshPage();
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

    (function($scope){
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

        $scope.dateThai = function(dateInput){
            var dateObject = new Date(dateInput.replace(" ", "T"));
            var date = "วันที่ "+dateObject.getDate()+" "+thMonth[dateObject.getMonth()]+" "+(dateObject.getFullYear()+543);
            var time = checkTime(dateObject.getHours())+":"+checkTime(dateObject.getMinutes())+" น.";

            return date + " เวลา " + time;
        };
    })($scope);
}]);

var videojs_id = 0;
profileapp.directive('videojs', function () {
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
