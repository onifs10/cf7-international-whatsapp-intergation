<form method="post">
	<table class="form-table">
		<tr>
			<th>
				<?php echo __('WhatsappMessage Service API',Contact_FormWI_TXT); ?> <br/><br/>
				<?php echo __('Usable Codes : ',Contact_FormWI_TXT); ?> <br/>
                <br/><br/>
                <br/><br/>
				<address>Parameters name</address>
                <br/><br/>
                <br/><br/>
                <br/><br/>
                <br/><br/><br/><br/>
                <address>Authorization</address>
            </th>
			<td>
			
			<?php
		$api_urls_data =	get_option(Contact_FormWI_DB_SLUG.'api_urls','');
		$parameter_name_phone = get_option(Contact_FormWI_DB_SLUG.'phone_parameter_name','');
		$parameter_name_message = get_option(Contact_FormWI_DB_SLUG.'message_parameter_name','');
		$auth = get_option(Contact_FormWI_DB_SLUG.'Authentication','');

			?>
			
				<textarea rows="4" cols="85" name="api_urls"><?php if($api_urls_data == ""){ ?>http://tsms.allbulksms.in/sendsms.aspx<?php }else{ echo $api_urls_data; } ?></textarea>
				<p class="description">Example : 		
	                Post request -------- > url  http://tsms.allbulksms.in/sendsms.aspx
				
				</p>
                <br/><br/>
                <input name="phone_parameter_name" value="<?php echo $parameter_name_phone ? $parameter_name_phone : 'phone' ?>" >
                <br/><br/>
                <input name="message_parameter_name" value="<?php echo $parameter_name_message ? $parameter_name_message : 'message' ?>" >
                <p class="description">
                    input the parameter name that would be used for the data field when sending the post request to your api <br>
                    Example : <br>
                        phone --> would be  parameter name for the phone number {NUMBER} <br>
                        message --> would be the parameter name for the message {MESSAGE}  to be sent the user <br>
                    so post request would have array like this in the body <br>
                    [ 'phone' => {NUMBER} , 'message' => {MESSAGE}] <br>
                </p>
                <br/><br/>
                <input name="auth" value="<?php echo $auth  ? $auth : '' ?>" placeholder="Eg Bearer 2sndiosdv1dqd3" style="width:50%; height: 40px; padding: 10px " >
                <p class="description">
                    input the authentication key if needed  <br>
                    Example : <br>
                    Bearer -->  Bearer {token} <br>
                </p>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="save_api_settings" value="Update API" class="button button-primary" /> </td>
		</tr>
	</table>
</form>
