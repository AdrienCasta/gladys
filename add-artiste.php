<?php
require 'includes/header.php';
require 'api/api.php';
$categories = $api->categories();
if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST)){

    //Message d'erreur
    $nameError = '';
    $ageError='';
    $catError ='';
    $bioError ='';

    // on recupère nos valeurs
    $artiste_name = htmlentities(trim($_POST['artiste_name']));
    $artiste_age = htmlentities(trim($_POST['artiste_age']));
    $cat_id = $_POST['sous_cat_id'];
    $artiste_bio = htmlentities(trim($_POST['artiste_bio']));

    $valid = true;
    if (empty($artiste_age)) {
        $ageError = 'Rentrez un age';
        $valid = false;
    }
    if (empty($artiste_name)) {
        $nameError = 'Rentrez le nom et prénom de l\'artise';
        $valid = false;
    }
    if (empty($cat_id)) {
        $catError = 'Choisissez une catégorie';
        $valid = false;
    }
    if (empty($artiste_bio)) {
        $bioError = 'Rentrez la biographie de l\'artiste';
        $valid = false;
    }
    if($valid){
         $api->add_artiste($artiste_name,$artiste_age,$cat_id,$artiste_bio);
    }
}
?>
 <h1>Ajouter un artiste</h1>
    <div class="row">
        <form class="col s12" action="" method="post">
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="Nom de l'artiste" name="artiste_name" id="artiste_name" type="text" class="validate">
              <label for="artiste_name">Nom de l'artiste</label>
            </div>
            <div class="input-field col s6">
              <input placeholder="Age de l'artiste" name="artiste_age" id="artiste_age" type="text" class="validate">
              <label for="artiste_age">Age de l'artiste</label>
            </div>
          </div>
          <div id="cats" class="row">
             <?php $j=1; $i=1; foreach($categories as $cat){
                 if(isset($cat['sous_cat']) && count($cat['sous_cat'])>0){?>
                  <div class="col s3">
                     <h4><?php echo $cat['cat_name'];?></h4>
                     <?php  ; foreach($cat['sous_cat'] as $sous_cat){?>
                          <p>
                              <input name="sous_cat_id[]" value="<?php echo $sous_cat['sous_cat_id'];?>" type="checkbox" id="sous_cat_<?php echo $j;?>"/>
                              <label for="sous_cat_<?php echo $j;?>"><?php echo $sous_cat['sous_cat_name'];?></label>
                          </p>
                     <?php $j++; }?>
                  <?php }else{?>
                  <h4><?php echo $cat['cat_name'];?></h4>
                  <p>
                      <input name="cat_id[]" value="<?php echo $cat['cat_id'];?>" type="checkbox" id="cat_<?php echo $i;?>"/>
                      <label for="cat_<?php echo $i;?>"><?php echo $cat['cat_name'];?></label>
                  </p>
              <?php  }?>
              <?php $i++;?> 
              </div>
              <?php }?>
              </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="artiste_bio" name="artiste_bio" class="materialize-textarea"></textarea>
              <label for="artiste_bio">Biograhpie</label>
            </div>
          </div>
          <div >
            <input class="btn" type="submit">
          </div>
        </form>
      </div>
<?php require 'includes/footer.php';?>
