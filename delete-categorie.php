<?php
require 'api/api.php';
if(isset($_GET['cat_id']) && $_GET['cat_id']!=""){
    $cat_id=$_GET['cat_id'];
    $api->delete_categorie($cat_id);
}
if(isset($_GET['sous_cat_id']) && $_GET['sous_cat_id']!=""){
    $sous_cat_id=$_GET['sous_cat_id'];
    $api->delete_sous_categorie($sous_cat_id);
}