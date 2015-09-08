<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/reserch/reserch.css"/>
<script src="public/app/reserch/reserchAPP.js"></script>
<div ng-app="reserch"
     ng-controller="ReserchListCtl">
    <div class="select">
        <div class="block_select">
            <div class="label_select"
                 ng-click="lv2Click(item)"
                 ng-style="{'margin-top': reserchs.length-$index}"
                 ng-class="{'active': item.category_id == lv2_category.category_id}"
                 ng-repeat="item in lv2_categories | startFrom:lv2_page*5 | limitTo: 5"> <!-- add class active -->

                {{item.category_name}}

            </div>
        </div>
        <div class="line">
           <!-- <div class="Textline" ng-click="clickMain()">หมวดหมู่ {{main_category.category_name}}</div>-->

            <div class="category-pagenum">
            	<ol class="breadcrumb">
        					<li><a href="?view=category">หมวดหมู่</a></li>
        					<li>
                    <a href="#" class="category_subname"
                    ng-class="{'active': lv2_category == null}"
                    ng-click="clickMain()">{{main_category.category_name}}</a>
                  </li>
        					<li ng-show="lv2_category != null">
                    <a href="#" class="category_subname"
                    ng-class="{'active': lv3_category == null}">{{lv2_category.category_name}}</a>
                  </li>
                  <li ng-show="lv3_category != null">
                    <a href="#" class="category_submenu"
                    ng-class="{'active': lv3_category != null}">{{lv3_category.category_name}}</a>
                  </li>
      				</ol>
            </div>

            <div style="float: right; margin: 10px 10px 0 0;">
                <button ng-click="clickFilter('video')" class="filter-btn" ng-class="{'active': filterType=='video'}">แสดงเฉพาะ video</button>
                <button ng-click="clickFilter('book')" class="filter-btn" ng-class="{'active': filterType=='book'}">แสดงเฉพาะ e-book</button>
                <button ng-click="clickFilter(false)" class="filter-btn" ng-class="{'active': filterType==false}">แสดงทั้งหมด</button>
            </div>
        </div>
<!--        <div class="buttonleft"></div>-->
<!--        <div class="buttonright"></div>-->
        <div class="categoryBack" ng-click="backClick()"></div>
        <div class="groups" ng-show="lv3_categories.length > 0">
<!--            <div class="on"></div>-->
            <div class="grps">หมวดหมู่ย่อย {{lv2_category.category_name}}</div>
            <!-- add class avtive -->
            <div class="sub-menu">
                <div class="subtype"
                     ng-click="lv3Click(item)"
                     ng-repeat="item in lv3_categories | limitTo: 10"
                     ng-class="{'active': item.category_id == lv3_category.category_id}">
                    <table style="height: 100%; width: 100%;">
                        <tr>
                            <td style="vertical-align: middle; text-align: center; word-break: break-word;">{{item.category_name}}</td>
                        </tr>
                    </table>
                </div>
           </div><!-- submenu -->
<!--            <div class="down"></div>-->
        </div>
    </div>
    <div class="content-prev-btn" ng-hide="pagingContent <= 0" ng-click="pagingContent=pagingContent-1"></div>
    <div class="content-next-btn" ng-hide="(pagingContent+1)*10 >= getFilterContentLength()" ng-click="pagingContent=pagingContent+1"></div>
    <div class="Tinews">
        <div class="CaptionNews">
            <div class="Pic_other" ng-repeat="item in contents | filterType: filterType | startFrom: pagingContent*10 | limitTo: 10" ng-click="contentClick(item)">
                <div ng-if="item.content_type=='video'" class="content-thumb"
                     ng-style="{'background-image': 'url('+item.videos[0].video_thumb_url+')'}">
                     	<!-- start display video -->
                        <div class="display-video">
                        	<i class="icon-video"></i>  <!--display ebook-->
                            	<div class="add-new-item add-hot-item">
                            		<i class="new" ng-show="(item.created_at - 259200)*1000 > now.getTime()"></i> <!-- add new item -->
                            		<i class="hot" ng-show="false"></i> <!-- item so hot -->
                                </div>
                        </div><!-- end icon video-->
                </div>
                <div ng-if="item.content_type=='book'" class="content-thumb"
                     ng-style="{'background-image': 'url('+item.book_cover_url+')'}">
                     	<!-- start display e-book -->
                     	<div class="display-ebook">
                        	<i class="icon-ebook"></i> <!--display ebook-->
                            	<div class="add-new-item add-hot-item">
                            		<i class="new" ng-show="(item.created_at - 259200)*1000 > now.getTime()"></i> <!-- add new item -->
                            		<i class="hot" ng-show="false"></i> <!-- item so hot -->
                                </div>
                       </div><!-- end icon video-->
                </div>
                <div style="line-height: 17px; margin-top: 10px;">
                    <strong>{{item.content_name.length>50? item.content_name.substring(0, 36)+"...": item.content_name}}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
