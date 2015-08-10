<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>

<link rel="stylesheet" href="public/app/video_page/video_page.css">
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/video_page/video_page.js"></script>

<style type="text/css">
    #video-page{
        background: url(public/app/video_page/images/bg-video-page.png) no-repeat;
        background-size: 100%;
    }
    .blockleft{
        width: 680px;
    }
    .video{
        background: url(public/app/video_page/images/border-video.png) no-repeat #000;
        height: 350px;
        width: 640px;
        margin: 0 20px;
        padding: 8px 0;   
    }
    .list_video{
        background: url(public/app/video_page/images/border-sub-video.png) no-repeat #fff;
        height: 355px;
        padding: 5px;
    }
    .thumb{
        margin: 10px 0px 10px 5px;
    }
    .text{
        width: 135px;
        padding-top: 10px;
    }
    .video-info{
        background: url(public/app/video_page/images/bg-info.png) no-repeat;
        margin: 0 20px;
        width: 640px;
        color: #fff;
        height: 130px;
    }
    .txt_admin{
        color: #fff;
        font-size: 28px;
        padding: 5px 0 0 0;
    }
    .txt_other,
    .txt_report{
        color: #e8bb74;
        margin-top: 5px;
        padding-right: 10px;
        font-size: 16px;
    }
    .txt_report{
        font-size: 20px;
    }
    .test{
        margin: 0 20px;
        width: 630px;
        border:#61321a 3px solid; 
        position: relative;
        top: 40px;

    }
    a.wood-bg-btn{
        background: url(public/app/video_page/images/bg-test.png) no-repeat ;
        position: relative;
        top: -20px;
        right: -5px;
        font-size: 20px;
        padding-top: 9px;
    }
    .list_video .text{
        font-size: 20px;
    }
</style>

<div id="video-page" ng-app="video-page" ng-controller="VideoPageCtrl">
    <div class="blockleft">
        <div class="video">
            <video width="100%" height="100%" id="videoPlayer" controls=""></video>
        </div>
        <div class="block_admin">
            <div class="video-info">
                <div class="txt_admin">{{content.content_name}} ({{videoShow.video_name}})</div>
    <!--            <div class="txt_grp">หมวดหมู่ ความรู้ทั่วไป</div>-->
                <div class="txt_other">2 ก.พ. 58</div>
                <div class="txt_report">{{content.content_description}}</div>
            </div>
            <div class="test"ng-show="content.question_count!=0" >
                <a ng-show="content.question_count!=0" class="wood-bg-btn" href="?view=exam&content_id=<?php echo $_GET['content_id'];?>" style="float: right;">ทำแบบทดสอบ</a>
            </div>
        </div>

    </div>

    <div class="blockright">
        <div class="list_video" ng-repeat="item in content.videos" ng-click="displayVideo(item)">
            <div class="thumb"><img src="{{item.video_thumb_url}}" width="100%" ></div>
            <div class="text">{{item.video_name}}</div>
        </div>
    </div>

</div>