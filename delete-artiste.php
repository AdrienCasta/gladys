<?php
require 'api/api.php';
if(isset($_GET['artiste_id']) && $_GET['artiste_id']!=""){
    $artiste_id=$_GET['artiste_id'];
    $cat_id=$_GET['cat_id'];
    $api->delete_artiste($artiste_id,$cat_id);
}
