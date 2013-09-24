<?php
class TestCommand extends CConsoleCommand {
  public function run($args) {


    $id = new MongoId('5132835b7f8b9afc56000004');
    $e = Entry::model()->findBy_id($id);
    print_r($e->attributes);
    echo "Before : " . $e->popularity['likes'], PHP_EOL;
    $e->like();
    $e = Entry::model()->findBy_id($id);
    echo "After : " . $e->popularity['likes'], PHP_EOL;
    die();


    $entries = Yii::app()->mongodb->entries;
    $entry = $entries->findOne(array('_id'=>$id), array('popularity.likes'=>true));

    echo "Before : " . $entry['popularity']['likes'], PHP_EOL;    

    //$entries->update(array('_id'=> $id), array('$inc'=>array('popularity.likes'=>1)));
    //$entries->findAndModify(array('_id'=>$entry['_id']), array('$inc'=>array('popularity.likes'=>1)), array('popularity.likes'=>1, '_id'=>0));

    $entry = $entries->findOne(array('_id'=>$id), array('popularity.likes'=>true));
    echo "After : " . $entry['popularity']['likes'], PHP_EOL;    
/*
    die();
 
    $d = new EMongoDataProvider('Entry');
 
    $a = $d->fetchData();

    foreach($a as $o) 
      print_r($o->attributes);


    die();
    echo "Hello \n";
    $e = new Entry();
    $e->author = 'kefah';
    $e->title = 'a word';
    $e->popularity = array('likes'=>5, 'dislikes'=>4);
    $e->comments = array( array('author'=>'her', 'text'=>'like', 'created_at'=> new MongoDate(time())));
    $e->tags = array('science', 'computer');
    if(!$e->save())
      print_r($u->errors);
   
    die();

    $u = new User('testUnqiue');
    $u->username ='ali';
    $u->job_title ='coder';
    $u->notnewthing="sadfas";
    $u->addresses= array(array('road'=>'something', 'telephone'=>'1234'));
    if(!$u->save()) 
      print_r($u->errors);

   print_r($u->attributes);
    die();


    $parentDocs = array(
      array('username' => 'sam', 'job_title' => 'awesome guy'),
      array('username' => 'john', 'job_title' => 'co-awesome guy'),
      array('username' => 'dan', 'job_title' => 'programmer'),
      array('username' => 'lewis', 'job_title' => 'programmer'),
      array('username' => 'ant', 'job_title' => 'programmer')
    );

    $childDocs = array(
      array('name' => 'jogging'),
      array('name' => 'computers'),
      array('name' => 'biking'),
      array('name' => 'drinking'),
      array('name' => 'partying'),
      array('name' => 'cars')
    );

    // Lets save all the child docs
    foreach($childDocs as $doc){
      $i = new Interest;
      foreach($doc as $k=>$v) $i->$k=$v;
      echo "Saving "  . $i->save(), PHP_EOL;
    }

    // Lets make sure those child docs actually went in
    $c=Interest::model()->find();
    echo "Count " . $c->count(), PHP_EOL;

    // Let's build an array of the all the _ids of the child docs
    $interest_ids = array();
    foreach($c as $row){
      $interest_ids[] = $row->_id;
    }

    // Create the users with each doc having the value of the interest ids
    $user_ids = array();
    foreach($parentDocs as $doc){
      $u = new User();
      foreach($doc as $k=>$v) $i->$k=$v;
      $u->interests = array('one'=>array('hello'=>'yes'),'two'=>'no','three',234);//$interest_ids;
      echo "Saving " . $u->save(), PHP_EOL;

      $user_ids[] = $u->_id;
    }

    $interests = array_values(iterator_to_array($c));

    // Now 50^6 times re-insert each interest with a parnt user _id
    // So we have two forms of the document in interests, one without the parent user and one with
    for($i=0;$i<50;$i++){

      $randInt = rand(0,sizeof($interests)-1);
      $row =$interests[$randInt];

      $randPos = rand(0, sizeof($user_ids)-1);
      $row->i_id = $user_ids[$randPos];

      $row->setIsNewRecord(true);
      $row->_id = null;
      $row->setScenario('insert');

      echo "Saving row " . $row->save(), PHP_EOL;
    }
*/



/*
    $interest = new Interest();
    $interest->name = 'Mo';
    //$interest->save();

    $user = User::model()->findOne();
    $user->interests = array($interest);
    $user->save();

    print_r($user);
    die();

    $users = Yii::app()->mongodb->users;
    $counters = Yii::app()->mongodb->counters;
 
    $users->ensureIndex(array('name'=>true), array('unique' => true)); 

    $out = $counters->findAndModify(array('_id'=>'users'), array('$inc'=>array('last'=>1)), array('last'=>1, '_id'=>0), array('upsert'=>true, 'new'=>true));
    $user_id = $out['last'];

    $users->insert(array('_id'=>$user_id, 'name'=>'Mo', 'password'=>'yes', 'value'=>23423));
    $out = $users->find();
    foreach($out as $one) {
      print_r($one);
    }
*/
    
/*
    $counters = Yii::app()->db->counters;
    $users = Yii::app()->db->users;
 
    $users->ensureIndex(array('name'=>true), array('unique' => true)); 

    $out = $counters->findAndModify(array('_id'=>'users'), array('$inc'=>array('last'=>1)), array('last'=>1, '_id'=>0), array('upsert'=>true, 'new'=>true));
    //echo "Use this {$out['last']}\n";
    $user_id = $out['last'];


    //print_r($out);
    //die();
    $users->insert(array('_id'=>$user_id, 'name'=>'Ali', 'password'=>'yes', 'value'=>23423));
    $out = $users->find();
    foreach($out as $one) {
      print_r($one);
    }
*/
//$auth = Yii::app()->authManager;

/*
$users = $auth->getCollection('users');
$out = $users->find();
foreach($out as $one)  print_r($one);
*/

/*
// Create our operations
$auth->createOperation('createUser', 'Create a user');
$auth->createOperation('editUser', 'Edit a user');
$auth->createOperation('updateUserStatus', 'Update a user\'s status');
$auth->createOperation('deleteUser', 'Delete a user');
$auth->createOperation('purgeUser', 'Purge a user');

// Create the moderator roles
$role = $auth->createRole('userModerator', 'User with user moderation permissions');
$role->addChild('updateUserStatus');

// Create the admin roles
$role = $auth->createRole('userAdmin', 'User with user administration permissions');
$role->addChild('userModerator');
$role->addChild('createUser');
$role->addChild('editUser');

$auth->save();
*/
  }
}

