        <div class="tiles <?php echo (count( explode(' ' ,$data->title ) )>7)?'width-50':'width-25';  ?> right ">
          <img  src="<?php echo User::model()->findByPk( $data->user_id)->picture ?>" class="left user-img " />


          <div class="tiles-over" data-post-id="<?php echo $data->id ;?>" >

            <ul>
                <li><a class="comment"></a></li>
                <li><a class="share"  ></a></li>
                <li><?php if ($data->current_user_like==1) echo '<a><img src="/images/detailed-like-over.png" /></a>' ; else 
                echo '<a class="like" href=" ' . $data->getLikeUrl() .'" ></a>' ;
                  //echo $data->like;
                 ?></li>
                <li><?php if ($data->current_user_like==-1) echo '<a><img src="/images/detailed-dislike-over.png" /></a>' ; else 
                echo '<a class="dislike" href="'. $data->getDisLikeUrl() .'" ></a>'  ;?> </li>
                <li><a class="report"></a></li>
            </ul>


          <div class="share-over" data-post-id="share<?php echo $data->id ;?>" >
            <ul>
              <li><a class="fb-share"  href="javascript: void(0)" onclick="return fbs_click('<?php echo Yii::app()->controller->createAbsoluteUrl('/psot', array('id'=>$data->id) ); ?>','');" ></a></li>
              <li><a class="twitter-share" href= ></a></li>
              <li><a class="g-share" href=></a></li>
            </ul>
          </div>
          </div>


          <?php $url = $this->createUrl("post/view" , array('id' =>  $data->id) ); ?>
          <a href="<?php echo $url ?> ">
            <p class=" english question"><?php echo $data->title ; ?></p>
            <p class="answer"><?php echo $data->content ;?> </p>

            <div class="clear"></div>
          </a>

          <div class="footer">
            <ul>
              <li><?php echo implode('</li> <li> ', $data->tagLinks); ?>
              </li>
            </ul>

            <div class="clear"></div>
          </div>
        </div>