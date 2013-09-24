<div class="detailed-tile">

          <div class="detailed-content right">

            <div class="detailed-side left">

            <div class="user-area">
              <img src="<?php echo User::model()->findByPk( $model->user_id)->picture ?>" class=right >

              <ul>
                <li class="name">الاسم الكامل</li>
                <li>الأسئلة</li>
                <li>الأجوبة</li>
              </ul>

            </div>

            <div class="detailed-tags">
              <ul><li>
                <?php echo implode('</i>,<li> ', $model->tagLinks); ?>
              </li></ul>
            </div>
          </div>

            <p class="question"><?php echo $model->title ; ?> </p>

            <p class="answer"><?php echo $model->content ; ?>  </p>

            <div class="detailed-actions">
              <div class="actions right">
                <ul>

                <li><a class="detailed-share"></a></li>
                <li><a class="detailed-like"></a></li>
                <li><a class="detailed-dislike"></a></li>
                <li><a class="detailed-report"></a></li>

                </ul>
              </div>

              <div class="activities left">
                <ul>
                  <li> <?php echo sizeof($model->postLikes); ?>  شخص أعجبه هذا</li>
                  <li> <?php echo $model->postDisLikes ?>  شخص لم يعجبه هذا • </li>
                  <li>10 مشاركة • </li>
                </ul>
              </div>

              <div class="clear"></div>
            </div>

            <?php if(! Yii::app()->user->isGuest || true) { // TODO remove true
              $form=$this->beginWidget('CActiveForm', array(
                'id'=>'comment-form',
                'enableAjaxValidation'=>true,
              ));
              echo '<div class="comment-area">' ;
              echo $form->textArea($comment,'content',array('rows'=>1, 'cols'=>100 , 'placeholder'=>"عَلِّق...")); 
              echo ' <button type=submit class="send-btn left">ارسل</a> <div class="clear"></div></div>' ;

              $this->endWidget(); } ?>            
                <?php 
                
                $this->renderPartial('_comments',array(
                        'post'=>$model,
                        'comments'=>$model->comments,
                )); ?>

            <?php /*  //TODO: if have more 
            <div class="comment-area more-comments">
              <p>عرض المزيد ⇓</p>
            </div>
            */ ?>



          </div>

          <div class="clear"></div>

      </div>



      <br>
      <hr>
      <p class="related center">الموضوعات المتعلقة</p>


      
      <?php
      if(isset( $model->tagLinks[0] )) { 
        $re = $model->getMelated($model->tagLinks[0]);
        $i=1 ;

        foreach ($re as $model ) {
          $i++ ;
          if( $i >5 ) break;
          $this->renderPartial('_view' , array('data' => $model, ) );
          
        } 
      }
?>