<!-- Modal one_click -->
<div style="display:none; padding: 10px;" class="modal fade modal-one_click" id="bs-one_click<?php echo $product_id;?>" tabindex="-1" role="dialog" aria-labelledby="bs-one_clickLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 style="text-align: center;" class="modal-title" id="bs-one_clickLabel"><?php echo $text_one_click_form_header;?></h1>
            </div>
            <div class="modal-body">
                <div role="form" id="one_click">
                    <fieldset>
                        <?php //echo $text_one_click_form_info;?>
                        <!-- Alert form validation -->
                        <div id="error-msg" class="alert alert-danger" role="alert" style="display: none;">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <?php echo $txt_text_one_click_form_info_message;?>
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="txt_name"><?php echo $text_one_click_name;?>*</label>
                            <input type="text" class="form-control" id="name<?php echo $product_id;?>" name="name<?php echo $product_id;?>" placeholder="<?php echo $text_one_click_input_name_placeholder;?>" required autofocus value="<?php if(isset($username)){echo $username;}?>">
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="txt_phone"><?php echo $text_one_click_phone;?>*</label>
                            <input type="tel" class="form-control" id="phone<?php echo $product_id;?>" name="phone<?php echo $product_id;?>" placeholder="<?php echo $text_one_click_input_phone_placeholder;?>" required value="<?php if(isset($telephone)){echo $telephone;}?>">
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="txt_mail">Email</label>
                            <input type="email" class="form-control" id="mail<?php echo $product_id;?>" name="mail<?php echo $product_id;?>" placeholder="<?php echo $text_one_click_input_mail_placeholder;?>" required value="<?php if(isset($email)){echo $email;}?>">
                        </div>
                        <div class="form-group input-group-sm">
                            <label for="txta_comment"><?php echo $text_one_click_comment;?></label>
                            <textarea class="form-control" id="comment<?php echo $product_id;?>" name="comment<?php echo $product_id;?>" rows="3" placeholder="<?php echo $text_one_click_input_comment_placeholder;?>"></textarea>
                        </div>

                        <div class="form-group input-group-sm">
                            <label for="txt_count"><?php echo $text_one_click_count;?></label>
                       <!--      <input type="text" onchange="priceCalc(this.value)" class="form-control" id="count<?php echo $product_id;?>" name="count<?php echo $product_id;?>" placeholder="<?php echo $text_one_click_input_count_placeholder;?>" value='1'></input> -->
                         <select onchange="priceCalc(this.value)" class="form-control" id="count<?php echo $product_id;?>" name="count<?php echo $product_id;?>" placeholder="<?php echo $text_one_click_input_count_placeholder;?>" default='1'>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                         </select>
                        </div>

                        <button style="width: 100%" type="submit" id="btn_submit<?php echo $product_id;?>" class="btn btn-success btn-lg"><?php echo $text_one_click_button_submit;?></button>
                        <!-- <button style="float:right; margin: 10px;" type="button" class=" btn btn-danger btn-lg" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><?php echo $text_one_click_button_cancel;?></span></button> -->
                        <div id="tt" class="form-group">
                            <label for="txta_comment"></label>
                            <input class="form-control" style="display:none" id="product_name<?php echo $product_id;?>" name="product_name<?php echo $product_id;?>" value="<?php echo $product_name;?>">
                            <input class="form-control" style="display:none" id="price<?php echo $product_id;?>" name="price<?php echo $product_id;?>" value="<?php echo $price; ?>">
                            <input class="form-control" style="display:none" id="product_id<?php echo $product_id;?>" name="product_id<?php echo $product_id;?>" value="<?php echo $product_id;?>">
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <ul style="list-style: none; margin-bootm:0; padding-left: 0;">
                    <li><?php echo $text_one_click_mail_msg_order;?>: <strong style="color: #000;"><?php echo htmlspecialchars_decode($product_name); ?></strong></li>
                    <li>
                        <?php echo $text_one_click_mail_msg_price;?>: <strong><?php echo $symbolLeft;?></strong><strong id="total-price<?php echo $product_id;?>"><?php echo $price;?></strong><strong><?php echo $symbolRight;?></strong>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal one_click success -->
<div class="modal fade modal-one_click-success" id="one_click-success<?php echo $product_id;?>" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $text_one_click_success_title;?></h4>
            </div>
            <div class="modal-body">
                <?php echo $text_one_click_success_message;?>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button"  class="btn btn-default btn-success" data-dismiss="modal"><?php echo $text_one_click_button_close;?></button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $('#bs-one_click<?php echo $product_id?>').modal('show');
    $('#btn_submit<?php echo $product_id;?>').on('click', function() {

        // Form fill variables
        var data = [];

        data['name']          = $('#name<?php echo $product_id;?>').val();
        data['phone']         = $('#phone<?php echo $product_id;?>').val();
        data['mail']          = $('#mail<?php echo $product_id;?>').val();
        data['comment']       = $('#comment<?php echo $product_id;?>').val();
        data['product_name']  = $('#product_name<?php echo $product_id;?>').val();
        data['count']         = $('#count<?php echo $product_id;?>').val();
        data['price']         = $('#price<?php echo $product_id;?>').val();
        data['total']         = data['price'] * data['count'];
        data['product_id']    = $('#product_id<?php echo $product_id;?>').val();
        data['product_link']  = '<?php echo $product_link;?>';

        $.ajax({
            url: 'index.php?route=product/one_click/sender',
            type: 'post',
            data: {
                name: data['name']
                , phone: data['phone']
                , mail: data['mail']
                , comment: data['comment']
                , product_name: data['product_name']
                , price: data['price']
                , count: data['count']
                , total: data['total']
                , product_id: data['product_id']
                , product_link: data['product_link']
            },
            dataType: 'json',
            beforeSend: function() {
                // Do form valdation
                if (!$('#phone<?php echo $product_id;?>').val() || !$('#mail<?php echo $product_id;?>').val() )
                {
                    $('#error-msg').show();
                    return false;
                }
            },
            complete: function() {
                $('#error-msg').hide();
                $('#bs-one_click<?php echo $product_id;?>').modal('hide');
            },
            success: function(json) {
                $('#one_click-success<?php echo $product_id;?>').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
</script>