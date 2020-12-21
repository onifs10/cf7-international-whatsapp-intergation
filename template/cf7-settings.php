<form method="post">
	<table class="form-table">
		<tr>
			<th>
				<?php echo __('WhatsappMessage Service API',Contact_FormWI_TXT); ?> <br/><br/>
				<?php echo __('Usable Codes : ',Contact_FormWI_TXT); ?> <br/>
				<address>{MOBILENUMBER}</address>
				<address>{MESSAGE}</address>			
			</th>
			<td>
			
			<?php
		$api_urls_data =	get_option(Contact_FormWI_DB_SLUG.'api_urls','');
			?>
			
				<textarea rows="4" cols="85" name="api_urls"><?php if($api_urls_data == ""){ ?>http://tsms.allbulksms.in/sendsms.aspx?mobile=Your_Login_Mobile&pass=your_password&senderid=WhatsappMessageTST&to={MOBILENUMBER}&msg={MESSAGE}<?php }else{ echo $api_urls_data; } ?></textarea>
				<p class="description">Example : 		
	http://tsms.allbulksms.in/sendsms.aspx?mobile=<b>Your_Login_Mobile</b>&pass=<b>your_password</b>&senderid=WhatsappMessageTST&to={MOBILENUMBER}&msg={MESSAGE}
				
				</p>
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="save_api_settings" value="Update API" class="button button-primary" /> </td>
		</tr>
	</table>
</form>
