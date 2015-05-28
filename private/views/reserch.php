<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/reserch/reserch.css"/>
<script src="public/app/reserch/reserchAPP.js"></script>
<div ng-app="reserch"
     ng-controller="ReserchListCtl">
    <div class="Tinews">
        <div class="CaptionNews">
            <div class="Pic_other" ng-repeat="item in contents | filterType:filterType | limitTo: 12" ng-click="contentClick(item)">
                <div ng-if="item.content_type=='video'" class="content-thumb"
                     ng-style="{'background-image': 'url('+item.videos[0].video_thumb_url+')'}">
                </div>
                <div ng-if="item.content_type=='book'" class="content-thumb"
                     ng-style="{'background-image': 'url('+item.book_cover_url+')'}">
                </div>
                <div>
                    <strong>{{item.content_name}}</strong>
                </div>
            </div>
        </div>
    </div>

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