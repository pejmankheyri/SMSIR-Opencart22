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
<table class="table">
    <tr>
        <td class="col-xs-3"><h5><strong><span class="required">* </span><?php echo $entry_code; ?></strong></h5></td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <select name="SMSIR[Enabled]" id="module_status" class="form-control">
                      <option value="yes" <?php echo (!empty($data['SMSIR']['Enabled']) && $data['SMSIR']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                      <option value="no"  <?php echo (empty($data['SMSIR']['Enabled']) || $data['SMSIR']['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><?php echo $smsir_panel_credit; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> <?php echo $smsir_panel_credit_desc; ?> </span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="btn-group">
                  <button type="button" class="btn btn-success text"><span id="balance"> <?php if(isset($getcredit)) { echo $getcredit; } else { echo ""; }?> <?php echo $smsir_sms; ?> </span></button>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">* </span> <?php echo $smsir_Apidomain; ?></strong></h5>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" id="api_input" >
                    <input type="text" id="apidomain" class="form-control" name="SMSIR[apidomain]" value="<?php if(isset($data['SMSIR']['apidomain'])) { echo $data['SMSIR']['apidomain']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">* </span> <?php echo $smsir_ApiKey; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> <a href="<?php echo $smsir_Keys_link; ?>" target="_blank"><?php echo $smsir_Keys_link_desc; ?></a> </span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" id="api_input" >
                    <input type="text" id="apiKey" class="form-control" name="SMSIR[apiKey]" value="<?php if(isset($data['SMSIR']['apiKey'])) { echo $data['SMSIR']['apiKey']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">* </span> <?php echo $smsir_SecretKey; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> <a href="<?php echo $smsir_Keys_link; ?>" target="_blank"><?php echo $smsir_SecretKey_link_desc; ?></a> </span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" id="SecretKey_input" >
                    <input type="password" id="SecretKey" class="form-control" name="SMSIR[SecretKey]" value="<?php if(isset($data['SMSIR']['SecretKey'])) { echo $data['SMSIR']['SecretKey']; } else { echo ""; }?>" />
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3">
            <h5><strong><span class="required">* </span><?php echo $smsir_linenumber; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i> <a href="<?php echo $smsir_linenumber_link; ?>" target="_blank"><?php echo $smsir_linenumber_desc; ?></a> </span>
        </td>
        <td class="col-xs-9">
            <div class="col-xs-4">
                <div class="form-group" id="linenumber_input" >
                    <input type="text" id="linenumber" class="form-control" name="SMSIR[linenumber]" value="<?php if(isset($data['SMSIR']['linenumber'])) { echo $data['SMSIR']['linenumber']; } else { echo ""; }?>" />
					<input id="IsCustomerClubNum" name="SMSIR[IsCustomerClubNum]" type="checkbox" <?php echo (!empty($data['SMSIR']['IsCustomerClubNum']) && $data['SMSIR']['IsCustomerClubNum'] == 'on') ? 'checked="checked"' : '' ?> /> 
					<label for="IsCustomerClubNum"><?php echo $smsir_ifcustomerclubdesc; ?></label>
                </div>
            </div>
        </td>
    </tr>
</table>

