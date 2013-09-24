<?php
$this->pageTitle = Yii::app()->name . ' - ولوج';
$this->breadcrumbs = array('ولوج');
?>

<div class="form view" style=' height: 250px; position: relative; '>
  <h2 class='' >ولوج - للتمكن من إضافة مدخلات و التعليق وتسجيل الإعجاب و استلام الرسالة الإخبارية.</h2>
<p class='uthman fontxlarge'>
لا يتطلب موقعنا ملء نموذج للتسجيل، يمكنك الولوج مباشرة بواسطة إحدى الشبكات الاجتماعية التالية :</p>


<p>
يُرجى اختيار الشبكة التي تُفَضّلها و من ثم اعطاء الصلاحية للولوج.
</p>
</div><!-- form -->


<div class=row >
  <div class= >
    <form name="frmFacebookLogin" action="/site/login">
      <input type="hidden" value="facebook" name="via" />
      <input type="image" style="max-width: 200px; float: right;padding: 15px;" type="submit" src="/images/btn_facebook_button.png"></input>
    </form>
  </span>
  <div class=offset1 >
    <form name="frmTwitterLogin" action="/site/login">
      <input type="hidden" value="twitter" name="via" />
      <input type="image" style="max-width: 200px; float: right;padding: 15px;" type="submit" src="/images/btn_twitter_button.png"></input>
    </form>
  </div>
  <div class=offset2 >
    <form name="frmTwitterLogin" action="/site/login">
      <input type="hidden" value="google" name="via" />
      <input type="image" style="max-width: 200px; float: right;padding: 15px;" type="submit" src="/images/btn_google_button.png"></input>
    </form>
  </div>
</div>
<br/>
</div>

