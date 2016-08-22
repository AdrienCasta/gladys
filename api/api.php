<?php
    function pdebug ($var, $msg = '', $displayNone = 0) {
        if($displayNone)
            $displayNone = 'display:none;';
        else 
            $displayNone = '';
            echo '<pre style="border:1px solid; text-align:left; background:grey; font-size:16px; padding:5px; ',$displayNone,'">',$msg, ' : '
            , print_r($var, true), '</pre> <hr/>';
    }
	function vdebug ($var, $msg = '', $displayNone = 0) {
		if($displayNone)
			$displayNone = 'display:none;';
		else 
			$displayNone = '';
			echo '<pre style="border:1px solid; text-align:left; background:grey; font-size:16px; padding:5px; ',$displayNone,'">',$msg, ' : '
			, var_dump($var), '</pre> <hr/>';
	}
error_reporting(E_ALL);
ini_set('display_errors', 1);	
class API  {
    public $data = "";
    const DB_SERVER = 'localhost';
    const DB = 'gladys';
    const DB_USER = 'root';
    const DB_PASSWORD = '';

    private $bdd = NULL;

    public function __construct(){
        $this->dbConnect();
    }

    /*
    *  Connect to Database
    */
    private function dbConnect() {
        try{
            $this->bdd = new PDO('mysql:host='.self::DB_SERVER.';dbname='.self::DB,self::DB_USER, self::DB_PASSWORD);
        }catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }
    
    function categories(){
        $query="
           SELECT cat_name, sous_cat_id, categories.cat_id,`sous_cat_name` FROM categories 
           LEFT JOIN `sous_categories` AS s_c ON s_c.`cat_id`=categories.cat_id
            ";
        $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
        $r->execute();
        $etat = $r->rowCount();
        if($etat > 0) {
            $retour=[];
            $i=0;
            $j=0;
            
            while($data = $r->fetch(PDO::FETCH_ASSOC)){
                if (isset ($retour[$i]['cat_id']) && $data['cat_id']!=$retour[$i]['cat_id'])
                {$i++;$j=0;}
                $retour[$i]['cat_name']=$data['cat_name'];
                $retour[$i]['cat_id']=$data['cat_id'];
                if($data['sous_cat_id']!=NULL){
                    $retour[$i]['sous_cat'][$j]['sous_cat_name']=$data['sous_cat_name'];
                    $retour[$i]['sous_cat'][$j]['sous_cat_id']=$data['sous_cat_id'];
                    $j++;
                }
                 
            }
            return $retour; 
        }
    }
    
    function categorie($sous_cat_id){
        $query="
            SELECT sous_cat_name, sous_cat_id FROM sous_categories
            WHERE sous_cat_id=:sous_cat_id
            ";
        $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
        $r->execute(array('sous_cat_id'=>$sous_cat_id));
        $etat = $r->rowCount();
        if($etat > 0) {
            $data = $r->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }
    
    function artistes(){
        if(isset($_GET['cat_id']) && $_GET['cat_id']!=""){
            $cat_id=$_GET['cat_id'];
            $query="
                SELECT artiste_name, artistes.artiste_id, avatar FROM artistes_categories AS a_c
                JOIN sous_categories ON sous_categories.sous_cat_id=a_c.sous_cat_id
                JOIN artistes ON artistes.artiste_id=a_c.artiste_id
                WHERE a_c.sous_cat_id='$cat_id'
                ";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            $etat = $r->rowCount();
            if($etat > 0) {
                $data = $r->fetchALl(PDO::FETCH_ASSOC);
                return $data;
            }
        }else{
            header('Location:index.php');
        }
    }
    
     function artiste(){
        if(isset($_GET['artiste_id']) && $_GET['artiste_id']!=""){
            $artiste_id = $_GET['artiste_id'];
             $query = "
                SELECT artiste_name, artistes.artiste_id, avatar, artiste_age, artiste_bio, a_c.sous_cat_id, sous_cat.sous_cat_name AS artiste_cat FROM artistes
                JOIN artistes_categories AS a_c ON a_c.artiste_id=artistes.artiste_id
                JOIN sous_categories AS sous_cat ON sous_cat.sous_cat_id=a_c.sous_cat_id
                WHERE artistes.artiste_id='$artiste_id' 
                ";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            $etat = $r->rowCount();
            if($etat > 0) {
                $retour = array();
                $i=0;
                while($req = $r->fetch(PDO::FETCH_ASSOC)) {
                    $data['artiste_id'] = $req['artiste_id'];
                    $data['artiste_name'] = $req['artiste_name'];
                    $data['avatar'] = $req['avatar'];
                    $data['artiste_age'] = $req['artiste_age'];
                    $data['categories'][$req['sous_cat_id']]['sous_cat_id'] = $req['sous_cat_id']; 
                    $data['categories'][$req['sous_cat_id']]['sous_cat_name'] = $req['artiste_cat']; 
                    $data['artiste_bio'] = $req['artiste_bio'];
                    $i++;
                }
                  return $data;
            }
        }else{
            header('Location:index.php');
        }
    }
    
    function delete_artiste($artiste_id, $cat_id){
            $query = "
                DELETE FROM `artistes`
                WHERE artiste_id='$artiste_id'
                ";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            header('Location:artistes.php?cat_id='.$cat_id);
    }
    
    function delete_categorie($cat_id){
            $query="
                DELETE FROM `categories`
                WHERE cat_id='$cat_id'
                ";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            header('Location:index.php');
    }
    
    function delete_sous_categorie($sous_cat_id){
            $query="
                DELETE FROM `sous_categories`
                WHERE sous_cat_id='$sous_cat_id'
                ";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            header('Location:index.php');
    }
    
    function add_artiste($artiste_name, $artiste_age, $cat_id, $artiste_bio){
        
        // Add row in artistes
        
        $avatar = "https://randomuser.me/api/portraits/med/men/".rand(0,100).".jpg";
        $query = "
            INSERT INTO artistes (artiste_id, avatar, artiste_name, artiste_age, artiste_bio)
            VALUES (NULL, :avatar, :artiste_name, :artiste_age, :artiste_bio)
            ";
        $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
        $req = $r->execute(array(
            "artiste_name" => $artiste_name, 
            "avatar" => $avatar, 
            "artiste_age" => $artiste_age,
            "artiste_bio" => $artiste_bio
            ));
        
        // Add row in artistes_categories
    
        if($req){
            $query="SELECT MAX(artiste_id) AS id FROM `artistes`";
            $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
            $r->execute();
            $data = $r->fetch(PDO::FETCH_ASSOC);
            $max_id=$data['id'];
            
            foreach($cat_id as $id) {
            $query_artistes_categories="
                INSERT INTO artistes_categories (artiste_id, sous_cat_id)
                VALUES($max_id,$id)
                ";
                echo $query_artistes_categories;
                $r = $this->bdd->prepare($query_artistes_categories) or die($this->bdd->error.__LINE__);
                $r->execute();
            }
        }
        header('Location:index.php');
    }
    
    function update_categorie($new_cat_name,$cat_id){
        $query="
            UPDATE categories
            SET cat_name=:cat_name
            WHERE cat_id=:cat_id
        ";
         $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
         $req = $r->execute(array(
             "cat_name" => $new_cat_name,
             "cat_id" => $cat_id
         ));
        header('Location:index.php');
    }
    function update_artiste($artiste_id, $artiste_name, $avatar, $artiste_age, $cat_id, $artiste_bio){
        $query="
            UPDATE artistes
            SET 
                artiste_id=:artiste_id, 
                artiste_name=:artiste_name,
                avatar=:avatar,
                artiste_age=:artiste_age,
                artiste_bio=:artiste_bio
            WHERE artiste_id=:artiste_id
            ";
        $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
        $req = $r->execute(array(
            "artiste_id" => $artiste_id, 
            "artiste_name" => $artiste_name, 
            "avatar" => $avatar, 
            "artiste_age" => $artiste_age,
            "artiste_bio" => $artiste_bio
            ));
        
        if($req){
            if(isset($cat_id)){
                $query_delete_cat="
                    DELETE FROM `artistes_categories`
                    WHERE artiste_id='$artiste_id'
                    ";
                $r = $this->bdd->prepare($query_delete_cat) or die($this->bdd->error.__LINE__);
                $r->execute();
            }
            foreach($cat_id as $id) {
            $query_artistes_categories="
                INSERT INTO artistes_categories (artiste_id, sous_cat_id)
                VALUES($artiste_id, $id)
                ";
                $r = $this->bdd->prepare($query_artistes_categories) or die($this->bdd->error.__LINE__);
                $r->execute();
            }
        }
        header('Location:index.php');
    }
    
    function add_categorie($cat_name,$parent_cat_id){
        if(isset($parent_cat_id) && $parent_cat_id!=""){
            $query="
            INSERT INTO sous_categories (sous_cat_id, sous_cat_name, cat_id)
            VALUES (NULL, :cat_name, :cat_parent_id)
            ";
            $array = ["cat_name"=>$cat_name,"cat_parent_id" => $parent_cat_id];
        }else{
            $query="
                INSERT INTO categories (cat_id, cat_name)
                VALUES (NULL, :cat_name)
                ";
            $array = ["cat_name"=>$cat_name];
        }
        $r = $this->bdd->prepare($query) or die($this->bdd->error.__LINE__);
        $debug=$r->execute($array);
        header('Location:index.php');
    }
}
$api = new API;

























