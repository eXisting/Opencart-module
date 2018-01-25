<!-- Button one_click -->
<button type="button" id="btn-formcall<?php echo $product_id?>" class="btn btn-danger btn-lg btn-block btn-one_click">
  <?php echo $text_one_click_button;?>
</button>

<div id="one_click-form-container<?php echo $product_id;?>"></div>

<script type="text/javascript">
  $('#btn-formcall<?php echo $product_id;?>').on('click', function() {
    var data = [];

    data['product_name']    = '<?php echo $product_name;?>';
    data['price']           = '<?php echo $price;?>';
    data['product_id']      = '<?php echo $product_id;?>';
    data['product_link']    = '<?php echo $product_link;?>';

    showForm(data);
  });
</script>