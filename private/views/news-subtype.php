<link rel="stylesheet" href="public/app/news-subtype/news-subtype.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>

<script type="text/javascript" src="public/assert/Jssor.Slider.FullPack/js/jssor.js"></script>
<script type="text/javascript" src="public/assert/Jssor.Slider.FullPack/js/jssor.slider.js"></script>

<link rel="stylesheet" href="public/assert/prettyPhoto/css/prettyPhoto.css">
<script src="public/assert/prettyPhoto/js/jquery.prettyPhoto-news.js"></script>

<script src="public/app/news-subtype/app.js"></script>

<div class="blcType-bg"></div>
<div ng-app="news-subtype" ng-controller="NewsController">
    <div ng-show="news.news_images.length == 0">
        <div class="close-btn" onclick="window.location.href='?view=news'"></div>
        <div class="blcType">
            <div style="text-align: center; padding: 20px;">
                <div style="font-size: 20px; font-weight: bold;">{{news.news_name}}</div>
        <!--        <a href="?view=news" style="line-height: 30px;">กลับหน้าหลัก</a><br>-->
                <img src="{{news.news_cover_url}}" height="auto" width="520" style="margin: 20px 0 0 0; object-fit: cover;">
            </div>
            <div class="txtType">
                <div><a ng-repeat="item in news.news_images" href="{{item.image_url}}" ng-show="$index==0" rel="prettyPhoto[pp_gal]" title="">คลิกเพื่อดูรูปภาพเพิ่มเติม</a></div>
                <div style="text-indent: 20px;">{{news.news_description}}</div>
            </div>
        </div>
    </div>
    <div ng-show="news.news_images.length > 0" style="position: absolute; top: 89px; left: 74px; width: 850px; height: 536px;">
        <div class="close-btn" onclick="window.location.href='?view=news'" style="top: -16px;
  left: 835px;"></div>
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.75); z-index: 1;   padding: 10px;
  color: white; box-sizing: border-box;">
            <h4 style="font-size: 22px; margin-bottom: 8px;">{{news.news_name}}</h4>
            <p>{{news.news_description}}</p>
        </div>

        <div jssor id="slider1_container" style="position: relative;
      top: 0;
      left: 0;
      width: 850px;
      height: 536px;
      overflow: hidden;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(public/assert/Jssor.Slider.FullPack/img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; 
          width: 850px;
          height: 536px;
          overflow: hidden;">
            <div ng-repeat="item in news.news_images" class="slide-item-img">
                <img u="image" src="{{item.image_url}}" />
            </div>
        </div>
        
        <!--#region Bullet Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
        <style>
            /* jssor slider bullet navigator skin 05 css */
            /*
            .jssorb05 div           (normal)
            .jssorb05 div:hover     (normal mouseover)
            .jssorb05 .av           (active)
            .jssorb05 .av:hover     (active mouseover)
            .jssorb05 .dn           (mousedown)
            */
            .jssorb05 {
                position: absolute;
                /*bottom: auto !important;
                top: 16px;*/
            }
            .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
                position: absolute;
                /* size of bullet elment */
                width: 16px;
                height: 16px;
                background: url(public/assert/Jssor.Slider.FullPack/img/b05.png) no-repeat;
                overflow: hidden;
                cursor: pointer;
            }
            .jssorb05 div { background-position: -37px -7px; }
            .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
            .jssorb05 .av { background-position: -67px -7px; }
            .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb05" style="bottom: 16px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->
        
        <!--#region Arrow Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
        <style>
            /* jssor slider arrow navigator skin 12 css */
            /*
            .jssora12l                  (normal)
            .jssora12r                  (normal)
            .jssora12l:hover            (normal mouseover)
            .jssora12r:hover            (normal mouseover)
            .jssora12l.jssora12ldn      (mousedown)
            .jssora12r.jssora12rdn      (mousedown)
            */
            .jssora12l, .jssora12r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 30px;
                height: 46px;
                cursor: pointer;
                background: url(public/assert/Jssor.Slider.FullPack/img/a12.png) no-repeat;
                overflow: hidden;
            }
            .jssora12l { background-position: -16px -37px; }
            .jssora12r { background-position: -75px -37px; }
            .jssora12l:hover { background-position: -136px -37px; }
            .jssora12r:hover { background-position: -195px -37px; }
            .jssora12l.jssora12ldn { background-position: -256px -37px; }
            .jssora12r.jssora12rdn { background-position: -315px -37px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora12l" style="top: 244px; left: 0px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora12r" style="top: 244px; right: 0px;">
        </span>
        <!--#endregion Arrow Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
    </div>
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
<style>
.jssorb05 {
    top: 16px;
    bottom: auto !important;
}
</style>