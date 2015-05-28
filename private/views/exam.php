<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>

<link rel="stylesheet" href="public/app/exam/exam.css">
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/exam/exam.js"></script>

<div id="exam-page" ng-app="exam-page" ng-controller="ExamCtrl">
    <div id="exam-page-wrap">
        <div style="text-align: center;">
            <div class="test-title wood-bg-btn">แบบทดสอบ {{content.content_name}}</div>
        </div>
        <div class="test-question-wrap">
            <div class="test-question">
                <div class="question">{{q.question}}</div>
                <div class="choice-list">
                    <div class="choice" ng-repeat="c in q.choices" ng-click="setAnswer(c, $index)">
                        <input type="radio" ng-model="$parent.i" name="choice" ng-value="$index"> {{c.choice}}
                    </div>
                </div>
                <div class="submit-btn-wrap">
                    <div ng-hide="finish">
                        <button class="wood-bg-btn" ng-click="submitQuestion()">ตกลง</button>
                        <div id="notifyText"></div>
                    </div>
                    <div ng-show="finish">
                        ทำแบบทดสอบเสร็จเรียบร้อยแล้ว<br />
                        <a class="wood-bg-btn" href="?view=video_page&content_id=<?php echo $_GET["content_id"];?>">
                            กลับหน้าวิดีโอ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>