<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/faq/faq.css"/>
<script src="public/app/faq/faqAPP.js"></script>

<div class="bg_faq"></div>
<div class="LBfaq"></div>
<div class="backH"></div>
<div ng-app="faq" ng-controller="FaqListCtl">
    <div class="logo_leafFAQ" ng-show="!displayAns"></div>
    <div class="glassFAQ" ng-show="!displayAns"></div>
    <div class="blockAns">
        <div class="Ans">
            <!--<div class="Ans_prs">โปรดเลือกคำถาม</div>-->
            <div class="txtAns">
                <div>{{displayAns}}</div>
            </div>
        </div>
    </div>
    <div class="blkQ">
        <div class="LabelQ"
             ng-style="{'margin-top': $index==0? 0: '', 'z-index': faqs.length-$index}"
             ng-repeat="faq in faqs | limitTo: 3"
             ng-click="faqshow($index)">
            <div class="Qus">Q:{{faq.faq_question}}</div>
        </div>
    </div>
</div>
