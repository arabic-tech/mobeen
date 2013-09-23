<?php
return array (
  'createPost' => 
  array (
    'type' => 0,
    'description' => 'create a post',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readPost' => 
  array (
    'type' => 0,
    'description' => 'read a post',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updatePost' => 
  array (
    'type' => 0,
    'description' => 'update a post',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deletePost' => 
  array (
    'type' => 0,
    'description' => 'delete a post',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateOwnPost' => 
  array (
    'type' => 1,
    'description' => 'update a post by author himself',
    'bizRule' => 'return Yii::app()->user->id==$params["post"]->authID;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'updatePost',
    ),
  ),
  'reader' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readPost',
    ),
    'assignments' => 
    array (
      'readerA' => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'author' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'reader',
      1 => 'createPost',
      2 => 'updateOwnPost',
    ),
    'assignments' => 
    array (
      'authorB' => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'editor' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'reader',
      1 => 'updatePost',
    ),
    'assignments' => 
    array (
      'editorC' => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'editor',
      1 => 'author',
      2 => 'deletePost',
    ),
    'assignments' => 
    array (
      'adminD' => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      13 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
      14 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
);
