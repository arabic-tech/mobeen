<?php foreach($comments as $comment): 

?>


<div class="comment-area">
	<img src="<?php echo $comment->author->picture ?>" class="right" />
	 <a href="/"> <?php echo nl2br(CHtml::encode($comment->author->pretty_name)) . ' يقول '; ?>   </a>  
	<p>
		<?php echo nl2br(CHtml::encode($comment->content)); ?>    
	</p>
	<div class="clear"></div>
</div>

<?php endforeach; ?>
