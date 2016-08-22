<?php
require 'api/api.php';
require 'includes/header.php';
$err="";
$url="";
if(isset($_GET['artiste_id']) && $_GET['artiste_id']!=""){
    $artiste=$api->artiste($_GET['artiste_id']);
    $url="?cat_id=".$_GET['cat_id']."&artiste_id=".$artiste['artiste_id'];
}
else{
    $err="Il n'éxiste pas de fiche pour cet artiste";
}
?>

    <?php if($err==""){?>
     <div class="row">
        <div class="col s12 m12">
          <div class="card">
            <div class="card-image">
              <img class="circle" style="max-width:100px" src="<?php echo $artiste['avatar'];?>">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                  <h1 class="card-title"><?php echo $artiste['artiste_name'];?></h1>
                  <ul class="chips">
                  <?php 
                       foreach($artiste['categories'] as $cat){
                    ?>
                    <li>
                        <a href="artistes.php?cat_id=<?php echo $cat['sous_cat_id']; ?>" class="chip"><?php echo $cat['sous_cat_name'];?></a>
                    </li>
                     <?php 
                       }
                    ?>
                      
                  </ul>
                  <strong>Age : <?php echo $artiste['artiste_age'];?></strong>
                  <div>
                      <p><?php echo $artiste['artiste_bio'];?></p>
                  </div>
                </div>
                <div class="card-action">
                  <a href="edit-artiste.php<?php echo $url;?>" class=" right btn-floating btn-large waves-effect waves-light red"><i class="material-icons">edit</i></a>
                </div>
            </div>
          </div>
        </div>
      </div>
   <?php }else{ ?>
       <h1><?php echo $err;?></h1>
   <?php }?>
            
<?php require 'includes/footer.php'?>