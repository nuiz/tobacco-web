<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/km_center/km_center.css"/>
<script src="public/app/km_center/km_centerAPP.js"></script>

<div class="bgcenter"></div>
<div ng-app="center" ng-controller="CenterListCtl">
    <div class="LabelKM">
        <div class="txtLabel">
            <div class="clickcenter">คลิกเพื่อส่งจดหมายหาศูนย์การเรียนรู้ KM</div>
            <div class="blockpic">
                <a class="kmPic" ng-click="centershow(center)"
                   ng-repeat="center in centers | startFrom:currentPage*pageSize | limitTo: 4" href="#">
                    <div class="kmMsg">
                    </div>
                    <div class="kmText">
                        {{center.kmcenter_name}}
                    </div>
                </a>

                <div class="line"></div>
                <button class="buttonleft" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1"></button>
                <button class="buttonright" ng-disabled="currentPage >= (centers.length/pageSize) - 1"
                        ng-click="currentPage=currentPage+1"></button>
            </div>
        </div>
        <div class="location" style="display: none">
            <div class="map"><img src="{{itemshow.kmcenter_map_pic_url}}" style="width: 325px; height: 435px;"></div>
            <div class="data">
                <input type="text" name="txtRec" ; style="height: 350px;
                width: 425px;
                margin-top: 195px;
                margin-left: 420px;
                font-size: 14px;"></div>
        </div>
    </div>
</div>

<div class="backHM"></div>
<div class="centerKM"></div>
