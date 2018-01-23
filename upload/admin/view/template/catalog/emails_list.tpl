<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php echo $column_customer_name; ?></a></td>
                  <td class="text-left"><?php echo $column_customer_phone; ?></a></td>
                  <td class="text-left"><?php echo $column_name; ?></a></td>
                  <td class="text-left"><?php echo $column_product_id; ?></a></td>
                  <td class="text-left"><?php echo $column_order_price; ?></a></td>
                  <td class="text-left"><?php echo $column_product_count; ?></a></td>
                  <td class="text-left"><?php echo $column_subject; ?></a></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($emails) { ?>
                <?php foreach ($emails as $email) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($email['email_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $email['email_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $email['email_id']; ?>" />
                    <?php } ?></td>
                    <td class="text-center">
                        <span>
                            <?php echo $email['customer_name']; ?>
                        </span>
                    </td>
                    <td>
                        <span>
                            <?php echo $email['phone_number']; ?>
                        </span>
                    </td>
                    <td class="text-left"><?php echo $email['email_adress']; ?></td>
                    <td class="text-center">
                        <span>
                            <?php echo $email['product_id']; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span>
                            <?php echo $email['order_cost']; ?>
                        </span>
                    </td>
                    <td class="text-right"><?php if ($email['product_count'] <= 0) { ?>
                    <span class="label label-warning"><?php echo $email['product_count']; ?></span>
                    <?php } elseif ($email['product_count'] <= 5) { ?>
                    <span class="label label-danger"><?php echo $email['product_count']; ?></span>
                    <?php } else { ?>
                    <span class="label label-success"><?php echo $email['product_count']; ?></span>
                    <?php } ?></td>
                     <td class="text-left"><?php echo $email['subject']; ?></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>