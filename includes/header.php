<!DOCTYPE html>
<html>
<head>
    <title>Exercice Gladys</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
   <nav class=" indigo darken-4">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo">Gladys</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a class="btn" href="add-artiste.php">Ajouter un artiste</a></li>    
      </ul>
    </div>
  </nav>
  <nav class="indigo darken-3">
    <div class="nav-wrapper">
      <div class="col s12">
        <a href="index.php" class="breadcrumb">Catégories</a>
        <?php if (isset($_GET['cat_id'])){
           $categorie = $api->categorie($_GET['cat_id']);
          ?>
        <a href="artistes.php?cat_id=<?php echo $categorie['sous_cat_id'];?>" class="breadcrumb"><?php echo $categorie['sous_cat_name'];?></a>
          <?php if (isset($_GET['artiste_id'])){
           $artiste = $api->artiste($_GET['artiste_id']);
          ?>
        <a href="artistes.php?cat_id=<?php echo $artiste['artiste_id'];?>" class="breadcrumb"><?php echo $artiste['artiste_name'];?></a>
        <?php }?>
    <?php }?>
      </div>
    </div>
  </nav>
