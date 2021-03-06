<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/e-book/e-book.css"/>
<script src="public/app/e-book/ebook.js"></script>
<div class="body">
    <div ng-app="ebook" ng-controller="EbookListCtl">
        <div class="back_home" ng-click="backhome()"></div>
        <div class="book" ng-click="bookClick(category_show[0].category_id)">
            <div class="type-title">{{category_show[0].category_name}}</div>
            <div class="booksClick"> > </div>
            <div ng-class="'mag'+($index+1)"
                 ng-style="{'background-image': 'url('+item.book_cover_url+')'}"
                 ng-repeat="item in books_group[0]">

                <!-- <div class="add-new add-recom"></div>  icon เวลาที่แอดหนังสือใหม่ หรือ เป็นหนังสือแนะนำ -->

                 </div>
        </div>
        <div class="book_2" ng-click="bookClick(category_show[1].category_id)">
            <div class="type-title">{{category_show[1].category_name}}</div>
            <div class="booksClick"> < </div>
            <div ng-class="'book'+($index+1)"
                ng-style="{'background-image': 'url('+item.book_cover_url+')'}"
                ng-repeat="item in books_group[1]">

            <!-- <div class="add-new add-recom"></div>  icon เวลาที่แอดหนังสือใหม่ หรือ เป็นหนังสือแนะนำ -->

            </div>
<!--            <div class="book1"></div>-->
        </div>
        <button class="buttonleft" ng-click="backCat()"></button>
        <button class="buttonright" ng-click="nextCat()"></button>
        <div class="b_shf">
            <div class="shelf_smalls">
            	<i class="tag"><p>ใหม่ล่าสุด</p></i>
            </div>
            <div class="shelf_book"></div>
            <div class="shelf_small">
            	<i class="tag"><p>หนังสือแนะนำ</p></i>
            </div>
                <div class="centerbook-wrap">
                    <a
                        ng-repeat="b in showpageBooks | limitTo : 2"
                        href="?view=book-reader&tp=tp-none&content_id={{b.content_id}}#book5/page1">
                        <div class="magshf"
                             ng-style="{'background-image': 'url('+b.book_cover_url+')'}">
                             <div class="new-book"><i class="tag-name"></i></div>
                             <div class="recommend"><i class="tag-name-recom"></i></div>
                       </div>
                    </a>
                </div>
        </div>
        <div class="label_book"></div>
        <div class="search">
            <form action="index.php">
                <input type="hidden" name="view" value="subpage">
                <input type="text" name="keyword" class="search-input" required style="border:none;">
            </form>
        </div>

        <div class="lb_category">
            <a class="type" href="#"></a>
        </div>
        <div class="Ebooktype" style="display: none">
            <div class="exit">x
                <a class="exit1" href="#"></a>
            </div>
            <div class="booktype" ng-click="bookClick(cat.category_id)" ng-repeat="cat in category">
                {{cat.category_name}}
            </div>
        </div>

        <div class="bg_black">
            <a
                ng-repeat="b in showpageBooks  | limitTo : 5"
                ng-if="$index > 1"
                href="?view=book-reader&tp=tp-none&content_id={{b.content_id}}#book5/page1">
            <div class="mag" ng-style="{'background-image': 'url('+b.book_cover_url+')'}">
             	<div class="most-view">
                	<i class="icon-most1"></i>
                    <i class="icon-most2"></i>
                    <i class="icon-most3"></i>
                </div><!-- เวลาคนเข้ามาดูมากที่สุดให้แสดง เป็นลำดับ 1 2 3 -->
            </div>
            </a>
        </div>

    </div>
</div>
<script>
    $(function () {
        var type = $('.type');
        var typeEbook = $('.Ebooktype');
        var exit1 = $('.exit1');
        type.click(function (e) {
            e.preventDefault();
            typeEbook.show()
        });
        exit1.click(function (e) {
            e.preventDefault();
            typeEbook.hide()
        });
    });
</script>
