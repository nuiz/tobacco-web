<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>

<link rel="stylesheet" href="public/app/video_page/video_page.css">
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/video_page/video_page.js"></script>

<div id="video-page" ng-app="video-page" ng-controller="VideoPageCtrl">
    <div class="blockleft">
        <div class="video">
            <video width="100%" height="100%" id="videoPlayer" controls=""></video>
        </div>
        <div class="block_admin">
            <a href="text" class="wood-bg-btn" href="?view=exam" style="float: right;">ทำแบบทดสอบ</a>
            <div class="txt_admin">{{content.content_name}} ({{videoShow.video_name}})</div>
            <div class="txt_report">{{content.content_description}}</div>
<!--            <div class="txt_grp">หมวดหมู่ ความรู้ทั่วไป <br> :</div>-->
<!--            <div class="txt_other">2 ก.พ. 58 ประเภท: บทความและคู่มือ รยส. รูปแบบ: วีดีโอ(High | Low)</div>-->
        </div>

    </div>

    <div class="blockright">
        <div class="list_video" ng-repeat="item in content.videos" ng-click="displayVideo(item)">
            <div class="thumb"><img src="{{item.video_thumb_url}}" width="100%" ></div>
            <div class="text">{{item.video_name}}</div>
        </div>
    </div>

</div>