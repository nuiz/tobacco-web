<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>

<link rel="stylesheet" href="public/app/video_page/video_page.css">
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/video_page/video_page.js"></script>

<div id="video-page" ng-app="video-page" ng-controller="VideoPageCtrl">
<div class="buttonleft"><a href="{{backHref}}" style="color: inherit; text-decoration: none;"><img src="public/app/video_page/images/icongrp.png"> กลับไปหมวดหมู่</a></div>
    <div class="blockleft">
        <div class="video">
            <video width="100%" height="100%" id="videoPlayer" controls></video>
        </div>
        <div class="block_admin">
            <div class="video-info">
                <div class="txt_admin">{{content.content_name}} ({{videoShow.video_name}})</div>
    <!--            <div class="txt_grp">หมวดหมู่ ความรู้ทั่วไป</div>-->
                <div class="txt_other">

                </div>
                <div class="txt_other">
                  {{dateThai(content.created_at)}} (การเข้าชม {{content.view_count}} ครั้ง)
                  <a href="{{videoShow.video_url}}" download style="color: inherit; text-descoration: none;">Download Video</a>
                </div>
                <div class="txt_other">
                <a href="{{item.file_url}}" class="attach-file" ng-repeat="item in content.attach_files">{{item.file_name}}</a>
                </div>
                <div class="txt_report">{{content.content_description}}</div>
            </div>
            <div class="test"ng-show="content.question_count!=0" >
                <div class="hr"></div>
                <a ng-show="content.question_count!=0" class="wood-bg-btn" href="?view=exam&content_id=<?php echo $_GET['content_id'];?>" style="float: right;">ทำแบบทดสอบ</a>
            </div>
        </div>

    </div>

    <div class="blockright">
        <div class="list_video" ng-repeat="item in content.videos" ng-click="displayVideo(item)">
            <div class="list">
                <div class="thumb"><img src="{{item.video_thumb_url}}" width="100%" ></div>
                <div class="text">{{item.video_name}}</div>
            </div>
        </div>
    </div>

    <div class="categoryBack"></div>
</div>
