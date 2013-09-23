<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/share.js');

 if(isset($_REQUEST['autopage'])  ){
 	$this->widget('zii.widgets.CListView', array(
	'dataProvider'=> $dataProvider ,
	'itemView'=>'../post/_view',
                'template'=>'{items}{pager}',
	));
	        exit;
 }


	$this->widget('zii.widgets.CListView', array(
	'dataProvider'=> $dataProvider ,
	'itemView'=>'../post/_view',
                'template'=>'{items}{pager}',


	));

	?>

	<script>


	$('.tiles').hover( function(){
		$(this).children('.tiles-over').show();
		
	} );
	
	$('.tiles').mouseleave( function(){
		$(this).children('.tiles-over').hide();
	} );
	

	

	$('.pager').css( 'visibility' , 'hidden'  );

	var container = document.getElementById('container');
	this.refresh ();
	// var msnry = new Masonry( container, { columnWidth: 0,        itemSelector: '.tiles'     ,"gutter": 1 });
	// var msnry = new Masonry( container, { columnWidth: 0,        itemSelector: '.tiles'     ,"gutter": 1 });
	var coninue = true ;
	while(( $(document).height() ==  $(window).height()  ) && coninue){
		
		coninue = !nextPage()		;
	}
	var lock = false;

	$(window).scroll(function() {
	if(!lock)
	if(( $(window).scrollTop() + $(window).height() ) == $(document).height()  ) {	
		lock =true ; 
		lock = nextPage() ; 
		lock =false ; 
		
	} } );

	function nextPage(){
		$('.loading').css( 'visibility' , 'visible') ;
		if(! $('.next' ).hasClass('hidden') )
			$.ajax({
				url: "" +  $('.next' ).find('a').attr('href')+'&ajax=entry-grid&autopage=1',  
				type:'GET', 
				async: false, 
				success: function(html){
					next = $('.next' ).find('a').attr('href');
					$('.pager').remove();   
					container.innerHTML +=html ;
					$('.pager').css( 'visibility' , 'hidden'  );
					//document.getElementById('entry-list').innerHTML +=html;
					
				}, 
				 statusCode: {
				 	404: function() {
				 		$(window).die("scroll") ;
				 		lock = true;
				 		return false;
				 	}
				 }
				
			} ); else{
                                $('.loading' ).css( 'visibility' , 'hidden'  ); 
                                $('.pager').css( 'visibility' , 'hidden'  );
                                $('#foot-page').css( 'visibility' , 'hidden') ;
        
                        }

                        this.refresh ();
                        return true;
	}
	

 function refresh (){  new Masonry( container, { columnWidth: 0,        itemSelector: '.tiles'     ,"gutter": 1 });   $('.tiles').hover( function(){
    $(this).children('.tiles-over').show();
    
  } );
  
  $('.tiles').mouseleave( function(){
    $(this).children('.tiles-over').hide();
  } );

 };


	$('.tiles').hover( function(){
		$(this).children('.tiles-over').show();
		
	} );
	
	$('.tiles').mouseleave( function(){
		$(this).children('.tiles-over').hide();
	} );


	$('.tiles-over').hover( function(){
		$(this).children('.share-over').show();
	} );

	$('.tiles-over').mouseleave( function(){
		$(this).children('.share-over').hide();
	} );


	


</script>
