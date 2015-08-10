<link rel="stylesheet" href="public/app/search/search.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/search/search.js"></script>

<div ng-app="search-app" ng-controller="SearchController">
    <div class="search-wrap">
        <div class="search-static">
            ค้นหาจาก <strong>"{{keyword}}"</strong> พบ {{data.length}} รายการ
        </div>
        <div class="search-list">
            <div ng-repeat="item in data" class="search-list-item">
                <a href="{{viewObjectUrl(item)}}">
                    <i ng-class="{'icon-news': item.object_type=='news', 'icon-video': item.object_type=='video', 'icon-ebook': item.object_type=='book'}"></i>
                    {{item.keyword}}
                </a>
            </div>
        </div>
    </div>
</div>