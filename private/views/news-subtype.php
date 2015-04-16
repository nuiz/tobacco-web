<link rel="stylesheet" href="public/app/news-subtype/news-subtype.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/news-subtype/app.js"></script>
<div class="blcType-bg"></div>
<div class="blcType" style="color: white;" ng-app="news-subtype" ng-controller="NewsController">

    <div style="text-align: center; padding: 20px;">
        <a href="?view=news" style="line-height: 30px;">กลับหน้าหลัก</a><br>
        <img src="{{news.news_image_url}}" height="200" style="margin: 40px;">
    </div>
    <div class="capnews">{{news.news_name}}</div>
    <div class="txtType">
        {{news.news_description}}
    </div>
</div>