/**
 * Created by NUIZ on 21/4/2558.
 */

function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex ;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

var app = angular.module("exam-page", []);
app.controller("ExamCtrl", ['$scope', '$http', function($scope, $http){
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.finish = false;
    $scope.content = {};
    $scope.choice = undefined;
    var questions = $scope.questions = [];
    var index = 0;

    $http.get(window.config.api_url+'/content/' + getParameterByName('content_id')).success(function (data) {
        $scope.content = data;
    });

    $http.get(window.config.api_url+'/content/exam/' + getParameterByName('content_id')).success(function (data) {
        questions = $scope.questions = data;
        $scope.q = $scope.questions[index];
        $scope.q.choices = shuffle($scope.q.choices);
    });

    $scope.submitQuestion = function(){
        if(typeof $scope.choice=="undefined"){
            notifyText("คุณยังไม่ได้เลือกคำตอบ", "red", true);
            return;
        }
        if($scope.choice==1){
            notifyText("คำตอบถูกต้อง", "green", true);
            $scope.questions.splice(index, 1);
            index--;
        }
        else {
            notifyText("คำตอบผิด", "red", true);
        }
        index++;

        if($scope.questions.length==0){
            $scope.finish = true;
        }
        if($scope.questions.length <= index){
            index = 0;
        }

        $scope.q = $scope.questions[index];
        $scope.q.choices = shuffle($scope.q.choices);

        $scope.i = undefined;
        $scope.choice = undefined;
    };

    $scope.setAnswer = function(c, i){
        $scope.choice = c.is_answer;
        $scope.i = i;
    };

    var $notifyText = $('#notifyText');
    function notifyText(text, color, fadeOut){
        if(!fadeOut)
            fadeOut = false;

        if(!color)
            color = "inherit";

        $notifyText.text(text);
        $notifyText.css({color: color});

        if(fadeOut) {
            clearTimeout($notifyText.data('timeout'));
            $notifyText.stop().clearQueue();
            $notifyText.show();
            $notifyText.data('timeout', setTimeout(function(){
                $notifyText.fadeOut();
            }, 1000));
        }
    }
}]);