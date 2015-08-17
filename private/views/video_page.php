<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>

<link rel="stylesheet" href="public/app/video_page/video_page.css">
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/video_page/video_page.js"></script>

<style type="text/css">
    #video-page{
        background: #f1f1f1;
        background-size: 100%;
    }
    .blockleft{
        width: 680px;
    }
    .video{
        height: 350px;
        width: 640px;
        margin: 0 20px;
        padding: 8px 0;
        background:#000;
    }
    .list_video{
        background:#fff;
        height: 355px;
        padding: 5px;
    }

    .text{
        width: 135px;
        padding-top: 10px;
    }
    .video-info{
        background: #fff;
        margin: 0 20px;
        width: 640px;
        color: #000;
        min-height: 180px;
    }
    .txt_admin{
        color: #000;
        font-size: 28px;
        padding: 5px 0 10px 0;
        border-bottom: 1px solid #e2e2e2;
        margin-right: 10px;
    }
    .txt_other,
    .txt_report{
        color: dimgray;
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
        position: relative;
        top: 40px;
    }
    .hr{
        border-bottom: 2px solid darkred;
        position: relative;
        top: 0px;
        width: 525px;
    }
    a.wood-bg-btn{
        background: darkred;
        position: relative;
        top: -20px;
        right: -5px;
        font-size: 20px;
        padding-top: 9px;
    }
    a.wood-bg-btn:hover{
        opacity: 0.8;
    }
    .list_video .text{
        font-size: 20px;
    }
    .list{
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 5px;
        height: 75px;
        margin: 10px 0px 15px 5px;
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

</div>