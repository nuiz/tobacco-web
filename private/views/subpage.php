<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/subpage/subpage.css"/>
<script src="public/app/subpage/subpage.js"></script>

<div ng-app="subpage" ng-controller="SubpageListCtl">
<div>
    <div class="bgSubPage"></div>
    <div class="label_book"></div>
    <!--<div class="search"></div>-->
    <div class="back_home" ng-click="subpageClick()"></div>
        <div class="category">
            <a class="type2" href="#"></a>
        </div>
        <div class="Subpagetype" style="display: none">
            <div class="exit2">x
                <a class="exits2" href="#"></a>
            </div>
            <div class="booktype" ng-repeat="booktype in booktypes">
                {{booktype.book_type_name}}
            </div>
        </div>
    </div>
    <div class="block_book">
        <a
           ng-repeat="item in books"
           ng-class="'magazine'+($index+1)"
           ng-style="{'background-image': 'url('+item.book_cover_url+')'}"
           href="?view=book-reader&tp=tp-none&content_id={{item.content_id}}"
           title="">
            <div class="magazine"></div>
        </a>
    </div>
</div>
<script>
    $(function () {
        var type2 = $('.type2');
        var Subpagetype = $('.Subpagetype');
        var exits2 = $('.exits2');
        type2.click(function (e) {
            e.preventDefault();
            Subpagetype.show()
        });
        exits2.click(function (e) {
            e.preventDefault();
            Subpagetype.hide()
        });
    });
</script>