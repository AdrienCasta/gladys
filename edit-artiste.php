<?php
require 'api/api.php';
require 'includes/header.php';
if(isset($_GET['artiste_id']) && $_GET['artiste_id']!=""){
    $artiste_id = $_GET['artiste_id'];
    $artiste=$api->artiste($artiste_id);
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
        $artiste_bio = htmlentities(trim($_POST['artiste_bio']));
        $artiste_id = htmlentities(trim($_GET['artiste_id']));
        $cat_id = $_POST['cat_id'];
        $avatar = $artiste['avatar'];
        
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
        if (empty($artiste_id)) {
            $valid = false;
        }
        
        if($valid){
            //pdebug($cat_id);
             $api->update_artiste($artiste_id, $artiste_name, $avatar, $artiste_age,$cat_id,$artiste_bio);
        }
    }
    
}else{
    
   header('Location:index.php');
}
?>

<!--Données artiste-->

 <h1>Editer la fiche de <?php echo $artiste['artiste_name'];?></h1>
    <div class="row">
        <form class="col s12" action="" method="post">
          <div class="row">
            <div class="input-field col s6">
              <input value="<?php echo $artiste['artiste_name'];?>" placeholder="<?php echo $artiste['artiste_name'];?>" name="artiste_name" id="artiste_name" type="text" class="validate">
              <label for="artiste_name">Nom de l'artiste</label>
             <span class="alert alert-warning"><?php echo !empty($nameError)?'error':'';?></span>
            </div>
            <div class="input-field col s6">
              <input value="<?php echo $artiste['artiste_age'];?>" placeholder="<?php echo $artiste['artiste_age'];?>" name="artiste_age" id="artiste_age" type="text" class="validate">
              <label for="artiste_age">Age de l'artiste</label>
            </div>
          </div>
          
          <!--Catégories-->
          
          <div id="cats" class="row">
             <?php 
                $i=0;$j=0;
                $checked="";
                foreach($categories as $cat){?>
                <div class="col s3">
                       <h4><?php echo $cat['cat_name'];?></h4>
                       <?php
                        if(isset($cat['sous_cat']) && count($cat['sous_cat'])>0){
                            foreach($cat['sous_cat'] as $sous_cat){
                                    $id=$sous_cat['sous_cat_id'];
                                if(isset($artiste['categories'][$id])){
                                    $artiste_sous_cat_id = $artiste['categories'][$id]['sous_cat_id'];
                                    if($artiste_sous_cat_id==$sous_cat['sous_cat_id']){
                                        $checked="Checked";
                                        }else{
                                            $checked="";
                                        }
                                    }else{
                                        $checked="";
                                }
                            ?>
                          <p>
                              <input <?php echo $checked;?> name="cat_id[]" value="<?php echo $sous_cat['sous_cat_id'];?>" type="checkbox" id="cat_<?php echo $i;?>"/>
                              <label for="cat_<?php echo $i;?>"><?php echo $sous_cat['sous_cat_name'];?></label>
                          </p>

                      <?php $i++;}}?>
                </div>
                        <?php } ?>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="artiste_bio" name="artiste_bio" class="materialize-textarea">
                  <?php echo $artiste['artiste_bio'];?>
              </textarea>
              <label for="artiste_bio">Biograhpie</label>
            </div>
          </div>
          <div >
            <input class="btn" type="submit">
          </div>
        </form>
      </div>
<?php require 'includes/footer.php';?>
