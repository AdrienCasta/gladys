<?php
require 'api/api.php';
$artistes = $api->artistes();
require 'includes/header.php';
?>
  <ul class="collection">
   <?php foreach($artistes as $artiste){
        $url="?cat_id=".$_GET['cat_id']."&artiste_id=".$artiste['artiste_id'];
    ?>
      <li class="collection-item avatar">
          <a href="artiste.php<?php echo $url;?>">
             <img src="<?php echo $artiste['avatar'];?>" alt="" class="circle">
             <h4 class="title"><?php echo $artiste['artiste_name'];?></h4>
          </a>
          <a class="secondary-content" href="delete-artiste.php?artiste_id=<?php echo $artiste['artiste_id'];?>&cat_id=<?php echo $_GET['cat_id'];?>">
              <i class="delete material-icons">delete</i>
          </a>
      </li>
    <?php }?>
  </ul>
<?php require 'includes/footer.php';?>
