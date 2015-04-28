<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/reserch/reserch.css"/>
<script src="public/app/reserch/reserchAPP.js"></script>
<div ng-app="reserch"
     ng-controller="ReserchListCtl">
    <div class="Tinews">
<!--        <div class="sum">-->
<!--            <div class="material">รวมเนื้อหา</div>-->
<!--            <div class="video">รวมวีดีโอ</div>-->
<!--        </div>-->
<!--        <div class="Caption">หัวข้อ-->
<!--            <a href="images/G_reserch/42585048.jpg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--                <div class="Pic">-->
<!--                    <div class="TextPic">รักษาการ</div>-->
<!--                </div>-->
<!--            </a>-->
<!---->
<!--            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--                <div class="PicII">-->
<!--                    <div class="TextPicII">รักษาการ</div>-->
<!--                </div>-->
<!--            </a>-->
<!--            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--                <div class="Pix">-->
<!--                    <div class="TextPix">รักษาการ</div>-->
<!--                </div>-->
<!--                <div class="PixII">-->
<!--                    <div class="TextPixII">รักษาการ</div>-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->

<!--        <div class="CaptionII">หัวข้อ-->
<!--            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--                <div class="Picture">-->
<!--                    <div class="TextPicture">รักษาการ</div>-->
<!--                </div>-->
<!--            </a>-->
<!--            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--                <div class="PictureII">-->
<!--                    <div class="TextPicture">รักษาการ</div>-->
<!--                </div>-->
<!--            </a>-->
<!--            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"-->
<!--               title="Google.com opened at 100%">-->
<!--            </a>-->
<!--        </div>-->
        <div class="CaptionNews">
<!--            <div class="other">-->
<!--                <div class="Pic_other" ng-repeat="other in others | limitTo: 4"></div>-->
<!--            </div>-->

            <div class="Pic_other" ng-repeat="item in contents | filterType:filterType | limitTo: 12" ng-click="contentClick(item)">
                <div ng-if="item.content_type=='video'" style="width: width: 136px; height: 136px; background-size: cover;"
                     ng-style="{'background-image': 'url('+item.videos[0].video_thumb_url+')'}">
                </div>
                <div ng-if="item.content_type=='book'" style="width: width: 136px; height: 136px; background-size: cover;"
                     ng-style="{'background-image': 'url('+item.book_cover_url+')'}">
                </div>
                <div>
                    <strong>{{item.content_name}}</strong>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="buttonleft_small"></div>-->
<!--    <div class="buttonright_small"></div>-->

    <style>
        button.active {
            background: gray;
        }
    </style>
    <div class="select">
        <div class="block_select">
            <div class="label_select"
                 ng-click="lv2Click(item)"
                 ng-style="{'margin-top': reserchs.length-$index}"
                 ng-repeat="item in lv2_categories | startFrom:lv2_page*5 | limitTo: 5">
                {{item.category_name}}
            </div>
        </div>
        <div class="line">
            <div class="Textline" ng-click="clickMain()">หมวดหมู่ {{main_category.category_name}}</div>
            <div style="float: right; margin: 10px 10px 0 0;">
                <button ng-click="clickFilter('video')" ng-class="{'active': filterType=='video'}">แสดงเฉพาะ video</button>
                <button ng-click="clickFilter('book')" ng-class="{'active': filterType=='book'}">แสดงเฉพาะ e-book</button>
                <button ng-click="clickFilter(false)" ng-class="{'active': filterType==false}">แสดงทั้งหมด</button>
            </div>
        </div>
<!--        <div class="buttonleft"></div>-->
<!--        <div class="buttonright"></div>-->
        <div class="categoryBack" ng-click="backClick()"></div>
        <div class="groups" ng-show="lv3_categories.length > 0">
<!--            <div class="on"></div>-->
            <div class="grps">หมวดหมู่ย่อย {{lv2_category.category_name}}</div>
            <div class="subtype"
                 ng-click="lv3Click(item)"
                 ng-repeat="item in lv3_categories | limitTo: 10">
                <table style="height: 100%; width: 100%;">
                    <tr>
                        <td style="vertical-align: middle; text-align: center;">{{item.category_name}}</td>
                    </tr>
                </table>
            </div>
<!--            <div class="down"></div>-->
        </div>
    </div>
    <div ng-app="reserch"
         ng-controller="ReserchListCtl">
    </div>
</div>