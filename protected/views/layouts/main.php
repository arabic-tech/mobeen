<!DOCTYPE html>
<html lang="ar">
<head>
    <script src="/js/masonry.js"></script>
    <script src="/js/jquery.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="/css/animation.css" /> -->
    <link rel="stylesheet" type="text/css" href="/less/mobeen.css" />
    <meta charset="utf-8" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="/css/ourstyle.css">

<script>
  $(document).ready( function(){
    $('.logo').hover( function(){
    $('.description').show();
    
  } );

  $('.logo').mouseleave( function(){
    $('.description').hide();
  } ); } ) ;
  
  
  </script>
</head>

<body onload=" refresh();"  >
  <div class="main-container">
    <div class="header-container">
      <a href="/" > <img src="/images/logo.png" alt="Mobeen logo" class="right logo" /> </a>

      <div class="header-menu right">
        <ul>
          <li>
            <a href="/about">عن مبين</a>
          </li>

          <li>
            <a  href="/articles" >مواضيع</a>
          </li>

          <li>
            <a href="/questions" > استفسارات</a>
          </li>
        </ul>
      </div>

      <div class="social left">
        <ul>
          <li> <a href="index.php" > <img alt="جوجل+" src="/images/g+.png" /> </a> </li>
          <li> <a href="" > <img alt="تويتر" src="/images/twitter.png" /> </a> </li>
          <li> <a href="" > <img alt="فايسبوك" src="/images/fb.png" /> </a> </li>
          <li> <a href="" > <img alt="البريد الإلكتروني" src="/images/email.png" /> </a> </li>
        </ul>
        <p>  الحقونا </p>
      </div>

      <div class="search left">
        <form action="/site/search">
          <img alt="بحث" src="/images/search.png" />
          <input type="text" name="term" placeholder="ابحث عن ... " />
        </form>
      </div>

      <div class="clear"></div>
    <a href="/site/contact" class="version-label">نسخة تجريبية، اعطنا رأيك</a>
    </div>

    <div class="description">
      <p>موقع عربي متخصص في مشاركة المواضيع وطرح الاستفسارات في حقول التقنية المختلفة، ويعتمد إثراء محتوى الموقع وبشكل مفتوح على مجتمع التقنية العربي.</p>
    </div>

    <div class="body-container">
      <div class="left-panel">
        <div class="title">
          آخر أنشطة
        </div>

        <ul>
          <?php $this->widget('ShortPost'); ?>
        </ul>

        <div class="title">
          أسئلة لم يرد عليها
        </div>

        <ul>
          <?php $this->widget('ShortPost'); ?>
        </ul>

      </div>

      <div class="right-panel">
        
<?php if(Yii::app()->user->isGuest) {  ?>
        <div class="login">
          <p> يمكنك الولوج باستخدام الشبكات الاجتماعية التالية </p>
          <ul>
            <li><a href=/site/login/via/facebook > <img alt="ولوج باستخدام الفايسبوك" src="/images/fb-login.png" /> </a> </li>
            <li><a href=/site/login/via/twitter > <img alt="ولوج باستخدام تويتر" src="/images/twitter-login.png" /> </a> </li>
            <li><a href=/site/login/via/google > <img alt="ولوج باستخدام جوجل بلص" src="/images/googleplus-login.png" /> </a> </li>

          </ul>
        </div>
<?php } else  { ?>
<div class="user-area">
  <img src="<?php echo User::model()->findByPk( Yii::app()->user->id)->picture ?>" alt="<?php echo User::model()->findByPk( Yii::app()->user->id)->prettyname ?>" />
  <ul>
    <li class="name"> <?php echo '<a href="/profile" > '.Yii::app()->user->name . '</a>' ; ?></li>
    <li> <a href="/site/logout" > تسجيل الخروج</a> </li>
    <hr />
    <li>إشعارات (0)</li>
    <li> <a href="/post/list" > ادارة  </a> </li>
    <li> <a href="/post/create" > ادخال مقالة  </a> </li>
    
  </ul>
</div>

<?php } ?>
        <div class="title">
          الموضوعات الشائعة
        </div>

        <ul>
          <?php 
            $m = Post::model()->findAll();
            $i  = 0 ;
            foreach ($m as $key => $value) {
                $i++;
                echo '<li><a href="'. $this->createUrl("post/view" , array('id' =>  $value->id) ) .'"> '  .  $value->title  . '</a></li>';
                if($i > 15 ) break ;
            }
        ?>
        </ul>
      </div>

      <div   id="container" class="middle center " >
        <?php   echo $content ; ?>

      </div>

      <div class="clear"></div>

    </div>
  </div>

</body>

</html>
