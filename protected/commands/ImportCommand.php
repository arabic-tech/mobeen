<?php
class ImportCommand extends CConsoleCommand {
  public function run($args) {
$i = 1 ;
    $file_path = dirname(__FILE__) . '/../data/tr.csv';
    $file = fopen($file_path, "r");
    if(!isset($file)) { echo "Failed to open file\n"; die();}
    $count = 1;
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
      $entry = new Post();
      $entry->id = ++$i ; 
      $entry->user_id=1;
      $entry->title = $data[0];
      $entry->content = $data[1];
      $entry->status = 2;
      $entry->type= 1;

      //$entry->id = $count;
      if(isset($data[3]))
       $entry->tags =  $data[3];

      if(!$entry->save()){
        print_r($entry->errors);  }
      else { 
        echo "Created new entry : " . $entry->id, PHP_EOL;
        $count++;
      }
continue ; 

      $data[2] = trim($data[2]);
      if(!empty($data[2])) {
	$comment = new Comment();
	$comment->content = $data[2] ;
 	$comment->user_id = 2 ; 
//	$comment->type='example';
        print_r($entry->addComment( $comment ));
      }
    }
    echo "completed importing $count entries\n";
  }
}

