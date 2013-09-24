<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php
echo '<h1> النتائج  </h1>';

foreach ( $hits as $hit )
{
	$title =  $hit->_source->title;
	// if(isset( $hit->highlight ) ) {  
	// 	preg_match('/<tag>(.*?)<\/tag>/s',  $hit->highlight->title[0]  , $matches); 
	//   $title =      str_replace($matches[1], '<span style="background-color:yellow" >' . $matches[1] . '</span>', $title ) ;
	// }

	echo '<a href="/post/'. $hit->_id .'" > ' . $title  . '<br / > '. $hit->_source->content. '<a/> <hr />';
}



 ?>

