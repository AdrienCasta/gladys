$(document).ready(function() {
    $('select').material_select();
    $('.collapsible').collapsible({
      accordion : false 
    });
    $('.modal-trigger').leanModal();
    $('.modal-trigger').click(function(){
        $id=$(this).attr('data-cat-id');
        $name=$(this).attr('data-cat-name');
        $('#new_cat_name').attr('placeholder',$name);
        $('#modal1 #cat_id').attr('value',$id);
    });
  });