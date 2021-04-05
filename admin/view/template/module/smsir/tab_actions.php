<?php

/**
 * 
 * PHP version 5.6.x | 7.x
 * 
 * @category Modules
 * @package OpenCart 2.2
 * @author Pejman Kheyri <pejmankheyri@gmail.com>
 * @copyright 2021 All rights reserved.
 */

?>
<div class="row">
  <div class="col-md-3">
    <ul class="nav nav-pills nav-stacked" id="preSaleTabs">
        <h4 style="line-height: 22px;"><span class="fa fa-minus"></span> <?php echo $smsir_send_sms_to_customers; ?> </h4>
        <li><input id="Check_CustomerPlaceOrder" type="checkbox" class="optionsSmsIR" <?php echo (!empty($data['SMSIR']['CustomerPlaceOrder']['Enabled']) && $data['SMSIR']['CustomerPlaceOrder']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerOrder" data-toggle="tab"><span class="pillLink"><?php echo $smsir_on_new_order; ?></span></a></li>
        <li><input id="Check_OrderStatusChange" type="checkbox" class="optionsSmsIR" <?php echo (!empty($data['SMSIR']['OrderStatusChange']['Enabled']) && $data['SMSIR']['OrderStatusChange']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#orderStatusChange" data-toggle="tab"><span class="pillLink"><?php echo $smsir_on_order_status_change; ?></span></a></li>
        <li><input id="Check_CustomerRegister" type="checkbox" class="optionsSmsIR" <?php echo (!empty($data['SMSIR']['CustomerRegister']['Enabled']) && $data['SMSIR']['CustomerRegister']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerRegister" data-toggle="tab"><span class="pillLink"><?php echo $smsir_on_new_registration; ?></span></a></li>
        <h4 style="line-height: 22px;"><span class="fa fa-minus"></span> <?php echo $smsir_send_sms_to_admins; ?> </h4>
        <li><input id="Check_AdminPlaceOrder" type="checkbox" class="optionsSmsIR" <?php echo (!empty($data['SMSIR']['AdminPlaceOrder']['Enabled']) && $data['SMSIR']['AdminPlaceOrder']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerOrderAdmin" data-toggle="tab"><span class="pillLink"><?php echo $smsir_on_new_order; ?></span></a></li>
        <li><input id="Check_AdminRegister" type="checkbox" class="optionsSmsIR" <?php echo (!empty($data['SMSIR']['AdminRegister']['Enabled']) && $data['SMSIR']['AdminRegister']['Enabled'] == 'yes') ? 'checked="checked"' : '' ?> /><a href="#customerRegisterAdmin" data-toggle="tab"><span class="pillLink"><?php echo $smsir_on_new_registration; ?></span></a></li>
    </ul>
  </div>
  <div class="col-md-9">
  <div class="tab-content">
    <div id="customerOrder" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_status; ?> : </h5></td>
                <td class="col-xs-8">
                    <div class="col-xs-3">
                        <select name="SMSIR[CustomerPlaceOrder][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['SMSIR']['CustomerPlaceOrder']['Enabled']) && $data['SMSIR']['CustomerPlaceOrder']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['SMSIR']['CustomerPlaceOrder']['Enabled']) || $data['SMSIR']['CustomerPlaceOrder']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_message; ?> : </h5>
                    <span class="help"><?php echo $smsir_short_codes; ?> :
                        <br/>
                        <i>* <?php echo $smsir_short_codes_desc; ?></i> 
                        <br/>
                    <br/>{SiteName} - <?php echo $smsir_store_name; ?><br/>{OrderID} - <?php echo $smsir_order_id; ?><br/>{CartTotal} - <?php echo $smsir_order_total; ?><br/>{ShippingAddress} - <?php echo $smsir_shipping_address; ?><br/>{ShippingMethod} - <?php echo $smsir_shipping_method; ?><br/>{PaymentAddress} - <?php echo $smsir_payment_address; ?><br/>{PaymentMethod} - <?php echo $smsir_payment_method; ?></span></td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs">
                          <?php $class="active";  foreach ($languages as $language) { ?>
                              <li class="<?php echo $class; ?>"><a href="#tabOrder-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url'] ?>"/> <?php echo $language['name']; ?></a></li>
                          <?php  $class="";}?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) { ?>
                              <div id="tabOrder-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" id="text-customer-place-order" class="form-control" name="SMSIR[CustomerPlaceOrderText][<?php echo $language['language_id']; ?>]"><?php if(!empty($data['SMSIR']['CustomerPlaceOrderText'][$language['language_id']])) echo $data['SMSIR']['CustomerPlaceOrderText'][$language['language_id']]; else echo $smsir_customer_new_order_default_text; ?></textarea>
                                    <div style="margin-top:5px"> <span><?php echo $smsir_written_chars; ?> : <span id="text-customer-place-order-characters">0</span></span><span style="padding-right:20px;"><?php echo $smsir_sms; ?> : <span id="text-customer-place-order-sms">1</span></span> </div>
                              </div>
                            <?php $class="";} ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="orderStatusChange" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_status; ?> : </h5></td>
                <td class="col-xs-8">
                    <div class="col-xs-3">
                        <select name="SMSIR[OrderStatusChange][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['SMSIR']['OrderStatusChange']['Enabled']) && $data['SMSIR']['OrderStatusChange']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['SMSIR']['OrderStatusChange']['Enabled']) || $data['SMSIR']['OrderStatusChange']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4">
                  <h5><?php echo $smsir_order_status; ?>:</h5>
                  <span class="help"><?php echo $smsir_which_order_status_send_sms; ?></span>
                </td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <?php foreach ($order_statuses as $order_statuses) { ?>
                        <div class="orderStatuses checkbox">
                          <label><input type="checkbox" <?php if(!empty($data['SMSIR']['OrderStatusChange']['OrderStatus']) && in_array($order_statuses['order_status_id'], $data['SMSIR']['OrderStatusChange']['OrderStatus'])) echo "checked=checked" ?> name="SMSIR[OrderStatusChange][OrderStatus][]" value="<?php echo $order_statuses['order_status_id']; ?>"> <?php echo $order_statuses['name']; ?> </label>
                        </div> <?php } ?>
                        <a id="selectall" href="#"><?php echo $smsir_select_all; ?></a> | <a id="deselectall" href="#"><?php echo $smsir_deselect_all; ?></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_message; ?> : </h5><span class="help"><?php echo $smsir_short_codes; ?> : <br/>{StatusFrom} - <?php echo $smsir_status_changed_from; ?><br/>{StatusTo} - <?php echo $smsir_status_changed_to; ?><br/>{SiteName} - <?php echo $smsir_store_name; ?><br/>{OrderID} - <?php echo $smsir_order_id; ?></span></td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs">
                          <?php $class="active";  foreach ($languages as $language) { ?>
                              <li class="<?php echo $class; ?>"><a href="#tabOrderChange-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url'] ?>"/> <?php echo $language['name']; ?></a></li>
                          <?php  $class="";}?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) { ?>
                              <div id="tabOrderChange-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" id="text-customer-order-status-change" class="form-control" name="SMSIR[OrderStatusChangeText][<?php echo $language['language_id']; ?>]"><?php if(!empty($data['SMSIR']['OrderStatusChangeText'][$language['language_id']])) echo $data['SMSIR']['OrderStatusChangeText'][$language['language_id']]; else echo $smsir_order_status_change_default_text; ?></textarea>
                                     <div style="margin-top:5px"> <span><?php echo $smsir_written_chars; ?>: <span id="text-customer-order-status-change-characters">0</span></span><span style="padding-right:20px;"><?php echo $smsir_sms; ?> : <span id="text-customer-order-status-change-sms">1</span></span> </div>
                              </div>
                            <?php $class="";} ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerRegister" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_status; ?> : </h5></td>
                <td class="col-xs-8">
                    <div class="col-xs-3">
                        <select name="SMSIR[CustomerRegister][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['SMSIR']['CustomerRegister']['Enabled']) && $data['SMSIR']['CustomerRegister']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['SMSIR']['CustomerRegister']['Enabled']) || $data['SMSIR']['CustomerRegister']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_message; ?> : </h5><span class="help"><?php echo $smsir_short_codes; ?> : <br/>{SiteName} - <?php echo $smsir_store_name; ?><br/>{CustomerName} - <?php echo $smsir_customer_name; ?></span></td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs mainMenuTabs">
                          <?php $class="active";  foreach ($languages as $language) { ?>
                              <li class="<?php echo $class; ?>"><a href="#tabSignup-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url'] ?>"/> <?php echo $language['name']; ?></a></li>
                          <?php  $class="";}?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php $class=" active"; foreach ($languages as $language) { ?>
                              <div id="tabSignup-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane<?php echo $class; ?> language">
                                    <br /><textarea rows="3" id="text-customer-register" class="form-control" name="SMSIR[CustomerRegisterText][<?php echo $language['language_id']; ?>]"><?php if(!empty($data['SMSIR']['CustomerRegisterText'][$language['language_id']])) echo $data['SMSIR']['CustomerRegisterText'][$language['language_id']]; else echo $smsir_new_registration_default_text; ?></textarea>
                                    <div style="margin-top:5px"> <span><?php echo $smsir_written_chars; ?>: <span id="text-customer-register-characters">0</span></span><span style="padding-right:20px;"><?php echo $smsir_sms; ?> : <span id="text-customer-register-sms">1</span></span> </div>
                              </div>
                            <?php $class="";} ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerOrderAdmin" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_status; ?> : </h5></td>
                <td class="col-xs-8">
                    <div class="col-xs-3">
                        <select name="SMSIR[AdminPlaceOrder][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['SMSIR']['AdminPlaceOrder']['Enabled']) && $data['SMSIR']['AdminPlaceOrder']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['SMSIR']['AdminPlaceOrder']['Enabled']) || $data['SMSIR']['AdminPlaceOrder']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_message; ?> : </h5><span class="help"><?php echo $smsir_short_codes; ?> : <br/>{SiteName} - <?php echo $smsir_store_name; ?><br/>{OrderID} - <?php echo $smsir_order_id; ?><br/>{CartTotal} - <?php echo $smsir_order_total; ?></span></td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <br /><textarea rows="3" id="text-admin-order-placed" class="form-control" name="SMSIR[AdminPlaceOrderText]"><?php if(!empty($data['SMSIR']['AdminPlaceOrderText'])) echo $data['SMSIR']['AdminPlaceOrderText']; else echo $smsir_new_order_admin_default_text; ?></textarea>
                        <div style="margin-top:5px"> <span><?php echo $smsir_written_chars; ?>: <span id="text-admin-order-placed-characters">0</span></span><span style="padding-right:20px;"><?php echo $smsir_sms; ?> : <span id="text-admin-order-placed-sms">1</span></span> </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div id="customerRegisterAdmin" class="tab-pane fade">
        <table class="table">
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_status; ?> : </h5></td>
                <td class="col-xs-8">
                    <div class="col-xs-3">
                        <select name="SMSIR[AdminRegister][Enabled]" class="form-control">
                              <option value="yes" <?php echo (!empty($data['SMSIR']['AdminRegister']['Enabled']) && $data['SMSIR']['AdminRegister']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                              <option value="no"  <?php echo (empty($data['SMSIR']['AdminRegister']['Enabled']) || $data['SMSIR']['AdminRegister']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-xs-4"><h5><?php echo $smsir_message; ?> : </h5><span class="help"><?php echo $smsir_short_codes; ?> : <br/>{SiteName} - <?php echo $smsir_store_name; ?><br/>{CustomerName} - <?php echo $smsir_customer_name; ?></span></td>
                <td class="col-xs-8">
                    <div class="col-xs-12">
                        <br /><textarea rows="3" id="text-admin-on-register" class="form-control" name="SMSIR[AdminRegisterText]"><?php if(!empty($data['SMSIR']['AdminRegisterText'])) echo $data['SMSIR']['AdminRegisterText']; else echo $smsir_new_registration_admin_default_text; ?></textarea>
                         <div style="margin-top:5px"> <span><?php echo $smsir_written_chars; ?>: <span id="text-admin-on-register-characters">0</span></span><span style="padding-right:20px;"><?php echo $smsir_sms; ?> : <span id="text-admin-on-register-sms">1</span></span> </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
   </div>
  </div>
</div>
<script>
$('#selectall').click(function(event) {  //on click 
    event.preventDefault();
    event.stopPropagation();

    $('.orderStatuses.checkbox input').each(function() {
        this.checked = true;          
    });
});

$('#deselectall').click(function(event) {  //on click 
    event.preventDefault();
    event.stopPropagation();
    
    $('.orderStatuses.checkbox input').each(function() {
        this.checked = false;          
    });
});

$( "input[id='Check_CustomerPlaceOrder']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
    $('[name="SMSIR[CustomerPlaceOrder][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
    $('[name="SMSIR[CustomerPlaceOrder][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_OrderStatusChange']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
    $('[name="SMSIR[OrderStatusChange][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
    $('[name="SMSIR[OrderStatusChange][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_CustomerRegister']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
    $('[name="SMSIR[CustomerRegister][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
    $('[name="SMSIR[CustomerRegister][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_AdminPlaceOrder']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
    $('[name="SMSIR[AdminPlaceOrder][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
    $('[name="SMSIR[AdminPlaceOrder][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});

$( "input[id='Check_AdminRegister']" ).change(function() {
  var isChecked = $(this).is(':checked');
  if (isChecked) {
    $('[name="SMSIR[AdminRegister][Enabled]"] option[value="yes"]').prop('selected', 'selected');  
  } else {
    $('[name="SMSIR[AdminRegister][Enabled]"] option[value="no"]').prop('selected', 'selected');   
  }
});
//count characters for each template
countCharactersAndSMS('text-customer-place-order', 'text-customer-place-order-characters', 'text-customer-place-order-sms');
countCharactersAndSMS('text-customer-order-status-change', 'text-customer-order-status-change-characters', 'text-customer-order-status-change-sms');
countCharactersAndSMS('text-customer-register', 'text-customer-register-characters', 'text-customer-register-sms');
countCharactersAndSMS('text-admin-order-placed', 'text-admin-order-placed-characters', 'text-admin-order-placed-sms');
countCharactersAndSMS('text-admin-on-register', 'text-admin-on-register-characters', 'text-admin-on-register-sms');




function countCharactersAndSMS(selector, charCounter, smsCounter){
    var count = $('#'+selector+'').val().length;
    $('#'+charCounter+'').html(count);
    var sms = 1;
    $('#'+smsCounter+'').html(sms);
    window.messageLength = $('#'+selector+'').val().length;


    var tripleSymbols = new Array();
    tripleSymbols = ['@', '#', '$', '%', '[', ']', ':', '&', ';', ',', '?', '+', '=', '/'];
    //tripleSymbols = ['@', '#', '$', '%', ':', '&', ';', ',', "/", "="];

    $('#'+selector+'').keyup(function(e) {
        debugger;
        
        count = $(this).val().length;
        window.messageLength = $(this).val().length;     

        $('#'+charCounter+'').html(count); 
        bytes_count = getByteLen($(this).val());   
        if (bytes_count > 0 && bytes_count < 160) {
            $('#'+smsCounter+'').html(1);    
        } else if (bytes_count >= 160) {        
            $('#'+smsCounter+'').html(Math.floor(bytes_count / 160) + 1);    
        } else {
            $('#'+smsCounter+'').html(0); 
        }
    });
};



function getByteLen(normal_val) {
    // Force string type
    normal_val = String(normal_val);
    var byteLen = 0;
    for (var i = 0; i < normal_val.length; i++) {
        var c = normal_val.charCodeAt(i);
        byteLen += c < (1 <<  7) ? 1 :
                   c < (1 << 11) ? 2 :
                   c < (1 << 16) ? 3 :
                   c < (1 << 21) ? 4 :
                   c < (1 << 26) ? 5 :
                   c < (1 << 31) ? 6 : Number.NaN;
    }
    return byteLen;
}
</script>
