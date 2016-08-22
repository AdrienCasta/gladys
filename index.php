<?php
require 'api/api.php';
$categories = $api->categories();
 if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['cat_name'])){
    $nameError = '';
    $parentCatRerror='';
     
    $cat_name = htmlentities(trim($_POST['cat_name']));
    $paren_cat_id = htmlentities(trim($_POST['cat_id']));
     
    $valid = true;
    if (empty($cat_name)) {
        $ageError = 'Veuillez insérer un nom à la catégorie';
        $valid = false;
    }
    if($valid){
       $api->add_categorie($cat_name,$paren_cat_id);
    }
 }

if(isset($_POST['new_cat_name']) && isset($_POST['cat_id'])){
    if(!empty($_POST['new_cat_name'])){
        $new_cat_name = htmlentities(trim($_POST['new_cat_name']));
        $cat_id = $_POST['cat_id'];
        //pdebug($cat_id);die();
        $valid=true;
        if (empty($new_cat_name)) {
            $ageError = 'Veuillez insérer un nom à la catégorie';
            $valid = false;
        }
        
        if (empty($cat_id)) {
            $valid = false;
        }
        if($valid){
            $api->update_categorie($new_cat_name,$cat_id);
        }
    }
}
require 'includes/header.php';
?>
 
    </div>
     <!--Catégories-->
     
      <ul class="collapsible" data-collapsible="accordion">
      <?php foreach($categories as $cat){
        $i=0;
          if(isset($cat['sous_cat']) && count($cat['sous_cat'])>0){?>
            <li>
              <div class="collapsible-header">
                  <span><?php echo $cat['cat_name'];?></span>
                  <a class="right" href="delete-categorie.php?cat_id=<?php echo $cat['cat_id'];?>">
                      <i class="delete material-icons">delete</i>
                  </a>
                  <a class="right modal-trigger" data-cat-name="<?php echo $cat['cat_name'];?>" data-cat-id="<?php echo $cat['cat_id'];?>" href="#modal1">
                      <i class="material-icons">edit</i>
                  </a>
              </div>
              
              <!--Sous-catégories-->
              
              <ul class="collection collapsible-body">
                 <?php  foreach($cat['sous_cat'] as $sous_cat){?>
                  <li class="collection-item"><div><a href="artistes.php?cat_id=<?php echo $sous_cat['sous_cat_id'];?>"><span><?php echo $sous_cat['sous_cat_name'];?></span></a> <a class="right" href="delete-categorie.php?sous_cat_id=<?php echo $sous_cat['sous_cat_id'];?>">
                  <i class="delete material-icons">delete</i>
              </a></div></li>
                  <?php }?>
              </ul>
            </li>
        <?php }else{?>
         <li>
             <div class="collapsible-header">
             <a href="artistes.php?cat_id=<?php echo $cat['cat_id'];?>">
                 <span><?php echo $cat['cat_name'];?></span>
             </a>
                 <a class="right" href="delete-categorie.php?cat_id=<?php echo $cat['cat_id'];?>">
                  <i class="delete material-icons">delete</i>
                 </a>
             </div>
          </li>
        <?php }?>
    <?php  }?>
  </ul>
    
    <!--Ajout de catégories-->
    
     <div class="row">
        <form class="col s6" action="" method="post">
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="Catégorie" name="cat_name" id="cat_name" type="text" class="validate">
              <label for="cat_name">Nouvelle Catégorie</label>
            </div>
              <div class="input-field col s6">
                <select name="cat_id">
                  <option value=""  selected>Catégorie parent</option>
                  <option value="">Pas de catégorie parent</option>
                   <?php foreach($categories as $cat){?>
                  <option value="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_name'];?></option>
                   <?php }?>
                </select>
                <label>Catégorie parent</label>
              </div>
             <div >
                <input class="btn" type="submit">
              </div>
        </div>
       </form>
    </div>
     
     <!--Modification de catégories-->
     
  <div id="modal1" class="modal bottom-sheet">
    <div class="modal-content">
      <h4>Renomer la catégorie</h4>
       <div class="row">
        <form class="col s6" action="" method="post">
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="Nom de la catégorie" name="new_cat_name" id="new_cat_name" type="text" class="validate">
              <label for="new_cat_name">Nom de la catégorie</label>
              <input id="cat_id" type="hidden" name="cat_id" value="">
            </div>
             <div>
                <input class="btn" type="submit">
              </div>
        </div>
       </form>
    </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Annuler</a>
    </div>
  </div>
<?php require 'includes/footer.php';?>
