<link rel="stylesheet" href="public/app/news-subtype/news-subtype.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>

<link rel="stylesheet" href="public/assert/prettyPhoto/css/prettyPhoto.css">
<script src="public/assert/prettyPhoto/js/jquery.prettyPhoto-news.js"></script>

<script src="public/app/news-subtype/app.js"></script>

<div class="blcType-bg"></div>
<div class="close-btn" onclick="window.location.href='?view=news'"></div>
<div class="blcType" ng-app="news-subtype" ng-controller="NewsController">
    <div style="text-align: center; padding: 20px;">
        <div style="font-size: 26px; font-weight: bold;">{{news.news_name}}</div>
<!--        <a href="?view=news" style="line-height: 30px;">กลับหน้าหลัก</a><br>-->
        <img src="{{news.news_cover_url}}" height="300" width="520" style="margin: 20px 0 0 0; object-fit: cover;">
    </div>
    <div class="txtType">
        <div><a ng-repeat="item in news.news_images" href="{{item.image_url}}" ng-show="$index==0" rel="prettyPhoto[pp_gal]" title="">คลิกเพื่อดูรูปภาพเพิ่มเติม</a></div>
        {{news.news_description}}
    </div>
</div>
<style>
    .pp_gallery {
        display: none;
        left: 50%;
        margin-top: 0px;
        position: absolute;
        z-index: 10000;
    }
    div.pp_default .pp_content_container .pp_details {
        margin-top: 30px;
    }

    .pp_gallery {
        display: block;
        left: 50%;
        margin-top: 0px;
        position: absolute;
        z-index: 10000;
    }
</style>