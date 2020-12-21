<div id="cf7si-whatsapp-sortables" class="meta-box-sortables ui-sortable">
	<h3><?php _e("Admin Whatsapp Notifications",Contact_FormWI_TXT); ?></h3>
	<fieldset>
		<legend><?php _e("In the following fields, you can use these tags:",Contact_FormWI_TXT); ?>
			<br />
			<?php $data['form']->suggest_mail_tags(); ?>
		</legend>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="wpcf7-whatsapp-recipient"><?php _e("To:",Contact_FormWI_TXT); ?></label>
					</th>
					<td>
						<input type="text" id="wpcf7-whatsapp-recipient" name="wpcf7wi-settings[phone]" class="wide" size="70" value="<?php echo $data['phone']; ?>">
						<br/> <?php _e("<small>Enter Numbers By <code>,</code> for multiple</small>",Contact_FormWI_TXT); ?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="wpcf7-mail-body"><?php _e("Message body:",Contact_FormWI_TXT); ?></label>
					</th>
					<td>
<textarea id="wpcf7-mail-body" name="wpcf7wi-settings[message]" cols="100" rows="6" class="large-text code"><?php echo $data['message']; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	
	<hr/>
	<h3><?php _e("Visitor Whatsapp Notifications",Contact_FormWI_TXT); ?></h3>
	<fieldset>
		<legend><?php _e("In the following fields, you can use these tags:",Contact_FormWI_TXT); ?>
			<br />
			<?php $data['form']->suggest_mail_tags(); ?>
		</legend>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="wpcf7-whatsapp-recipient"><?php _e("Visitor Mobile: ",Contact_FormWI_TXT); ?></label>
					</th>
					<td>
						<input type="text" id="wpcf7-whatsapp-recipient" name="wpcf7wi-settings[visitorNumber]" class="wide" size="70" value="<?php echo @$data['visitorNumber']; ?>">
						<br/> <?php _e("<small>Use <b>Contact_Form Tags</b> To Get Visitor Mobile Number | Enter Numbers By <code>,</code> for multiple</small>",Contact_FormWI_TXT);?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="wpcf7-mail-body"><?php _e("Message body:",Contact_FormWI_TXT); ?></label>
					</th>
					<td>
						<textarea id="wpcf7-mail-body" name="wpcf7wi-settings[visitorMessage]" cols="100" rows="6" class="large-text code"><?php echo @$data['visitorMessage']; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
</div>