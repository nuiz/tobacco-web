<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/km_center/km_center.css"/>
<script src="public/app/km_center/km_centerAPP.js"></script>

<div class="bgcenter"></div>
<div ng-app="center" ng-controller="CenterListCtl">
    <div class="LabelKM">
        <div class="txtLabel" ng-hide="itemshow">
            <!-- <div class="clickcenter">คลิกเพื่อส่งจดหมายหาศูนย์การเรียนรู้ KM</div> -->
            <div class="blockpic">
                <a class="kmPic" ng-click="centershow(center)"
                   ng-repeat="center in centers | startFrom:currentPage*pageSize | limitTo: 4" href="#">
                    <!-- <div class="kmMsg">
                    </div> -->
                    <div class="left-leaf"></div>
                    <div class="right-leaf"></div>
                    <div class="kmText">
                        {{center.kmcenter_name}}
                    </div>
                </a>

                <div class="line"></div>
                <button class="buttonleft" ng-disabled="currentPage == 0" ng-hide="currentPage == 0" ng-click="currentPage=currentPage-1"></button>
                <button class="buttonright" ng-disabled="currentPage >= (centers.length/pageSize) - 1" ng-hide="currentPage >= (centers.length/pageSize) - 1"
                        ng-click="currentPage=currentPage+1"></button>
            </div>
        </div>
        <div class="location" ng-show="itemshow">
            <div class="map" style="background-size: cover;" ng-style="{'background-image': 'url('+itemshow.kmcenter_map_pic_url+')'}"></div>
            <div class="detail">
                ชื่อ : {{itemshow.kmcenter_name}}<br />
                ที่ตั้ง : {{itemshow.kmcenter_location}}<br />
                เบอร์โทรศัพท์ : {{itemshow.kmcenter_phone}}<br />
                รายละเอียด : {{itemshow.kmcenter_description}}
            </div>
            <div class="back" ng-click="itemshow = false">< Back</div>
        </div>
    </div>
    <div class="backHM" ng-click="homeClick()"></div>
</div>

<div class="centerKM"></div>
