<link rel="stylesheet" href="public/app/expert/expert.css"/>
<div class="body">
    <div class="bg_expert"></div>
    <div class="label_ep"></div>
    <div class="back_home"></div>

    <div class="circle">
        <a class="toggle" href="#"></a>
    </div>
    <div class="circle2" style="display: none">
        <a class="toggle2" href="#"></a>
    </div>
</div>
<script>
    $(function () {
        var circle = $('.circle');
        var circle2 = $('.circle2');
        var toggle = $('.toggle');
        var toggle2 = $('.toggle2');

        toggle.click(function (e) {
            e.preventDefault();
            circle.hide();
            circle2.show()
        });
        toggle2.click(function (e) {
            e.preventDefault();
            circle2.hide();
            circle.show()
        });
    });
</script>
