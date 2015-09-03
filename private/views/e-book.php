<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/e-book/e-book.css"/>
<script src="public/app/e-book/ebook.js"></script>
<div class="body">
    <div ng-app="ebook" ng-controller="EbookListCtl">
        <div class="back_home" ng-click="backhome()"></div>
        <div class="book" ng-click="bookClick(2)">
            <div class="type-title">หนังสือ</div>
            <div class="booksClick"> > </div>
            <div ng-class="'mag'+($index+1)"
                 ng-style="{'background-image': 'url('+item.book_cover_url+')'}"
                 ng-repeat="item in books_group[0]"></div>
        </div>
        <div class="book_2" ng-click="bookClick(1)">
            <div class="type-title">นิตยสาร</div>
            <div class="booksClick"> < </div>
            <div ng-class="'book'+($index+1)" ng-style="{'background-image': 'url('+item.book_cover_url+')'}" ng-repeat="item in books_group[1]"></div>
<!--            <div class="book1"></div>-->
        </div>
        <button class="buttonleft" ng-disabled="currentPage == 0" ng-hide="currentPage == 0" ng-click="currentPage=currentPage-1"></button>
        <button class="buttonright" ng-disabled="currentPage >= (centers.length/pageSize) - 1" ng-hide="currentPage >= (centers.length/pageSize) - 1" ng-click="currentPage=currentPage+1"></button>
        <div class="b_shf">
            <div class="shelf_smalls">
            	<div class="tag"><i class="tag-name"></i></div>
            </div>
            <div class="shelf_book"></div>
            <div class="shelf_small">
            	<div class="tag"><i class="tag-name-recom"></i></div>
            </div>
                <div class="centerbook-wrap">
                    <a
                        ng-repeat="b in randomBooks | limitTo : 2"
                        href="?view=book-reader&tp=tp-none&content_id={{b.content_id}}#book5/page1">
                        <div class="magshf"
                             ng-style="{'background-image': 'url('+b.book_cover_url+')'}"></div>
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
            <div class="booktype" ng-click="bookClick(booktype.book_type_id)" ng-repeat="booktype in booktypes">
                {{booktype.book_type_name}}
            </div>
        </div>

        <div class="bg_black">
            <a
                ng-repeat="b in randomBooks  | limitTo : 5"
                ng-if="$index > 1"
                href="?view=book-reader&tp=tp-none&content_id={{b.content_id}}#book5/page1">
            <div class="mag" ng-style="{'background-image': 'url('+b.book_cover_url+')'}">
             	<div class="ribbon">
                	<i class="icon-recom"></i>
                </div>
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
