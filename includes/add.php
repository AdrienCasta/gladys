<?php
require '../api/api.php';
if(isset($_POST['artiste_name']) && $_POST['artiste_name']!="" &&
  isset($_POST['artiste_age']) && $_POST['artiste_age']!="" &&
  isset($_POST['cat_id']) && $_POST['cat_id']!="" &&
  isset($_POST['artiste_bio']) && $_POST['artiste_bio']!=""){
}
   $new_artiste=$api->add_artiste($_POST['artiste_name'],$_POST['artiste_age'],$_POST['cat_id'],$_POST['artiste_bio']);
    //pdebug($_POST['artiste_name']);die();
