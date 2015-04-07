<link rel="stylesheet" href="public/app/category/category.css"/>
<div class="all"></div>
<div class="backHm"></div>
<div class="icon">
    <div class="bottom">
        <a class="bottomClick" href="#"></a>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/1.png">

        <div>กฎหมาย</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/2.png">

        <div>จัดซื้อ/จัดจ้าง</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/3.png">

        <div>เทคโนโลยี</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/4.png">

        <div>การพิมพ์</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/5.png">

        <div>การผลิต</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/7.png">

        <div>การวิจัย</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/7.png">

        <div>ใบยา</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/8.png">

        <div>ความปลอดภัยและสิ่งแวดล้อม</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/10.png">

        <div>บุคคล/บริหาร</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/10.png">

        <div>งานช่าง</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/11.png">

        <div>โครงการย้ายโรงงานใหม่</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/12.png">

        <div>กำกับตรวจสอบ</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/13.png">

        <div>บัญชี การเงิน งบประมาณ</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/14.png">

        <div>ผลิตภัณฑ์</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/15.png">

        <div>การแพทย์อาหาร/สุขภาพ</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/16.png">

        <div>ความรู้ทั่วไป</div>
    </div>
</div>
<div class="icon2" style="display: none">
    <div class="icon1">
        <img src="public/app/category/images/1.png">

        <div>กฎหมาย</div>
    </div>
    <div class="icon1">
        <img src="public/app/category/images/1.png">

        <div>กฎหมาย</div>
    </div>
    <div class="bottomBack">
        <a class="bottomBack2" href="#"></a>
    </div>
</div>
</div>
<script>
    $(function () {
        var icon = $('.icon');
        var bottomClick = $('.bottomClick');
        var icon2 = $('.icon2');
        var bottomBack2 = $('.bottomBack2');
        bottomClick.click(function (e) {
            e.preventDefault();
            icon.hide();
            icon2.show()
        });
        bottomBack2.click(function (e) {
            e.preventDefault();
            icon2.hide();
            icon.show()
        });
    });
</script>


