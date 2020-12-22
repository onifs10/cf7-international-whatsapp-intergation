<?php
if (!defined('WPINC')) {
	die;
}

class Contact_Form_whatsapp_Integration_abn_Functions
{

	public function __construct()
	{
		add_action('wpcf7_before_send_mail', array($this, 'configure_send_whatsapp_message'));
	}

	public function get_cf7_tagS_To_String($value, $form)
	{
		if (function_exists('wpcf7_mail_replace_tags')) {
			$return = wpcf7_mail_replace_tags($value);
		} elseif (method_exists($form, 'replace_mail_tags')) {
			$return = $form->replace_mail_tags($value);
		} else {
			return;
		}
		return $return;
	}

	public function configure_send_whatsapp_message($form)
	{
		$options = get_option('wpcf7_international_wa_' . (method_exists($form, 'id') ? $form->id() : $form->id));
		$sendToAdmin = false;
		$sendToVisitor = false;
		$adminNumber = '';
		$adminMessage = '';
		$visitorNumber = '';
		$visitorMessage = '';

		if (isset($options['phone']) && $options['phone'] != '' && isset($options['message']) && $options['message'] != '') {
			$adminNumber = $this->get_cf7_tagS_To_String($options['phone'], $form);
			$adminMessage = $this->get_cf7_tagS_To_String($options['message'], $form);
			$sendToAdmin = true;
		}


		if (
			isset($options['visitorNumber']) && $options['visitorNumber'] != '' &&
			isset($options['visitorMessage']) && $options['visitorMessage'] != ''
		) {

			$visitorNumber = $this->get_cf7_tagS_To_String($options['visitorNumber'], $form);
			$visitorMessage = $this->get_cf7_tagS_To_String($options['visitorMessage'], $form);
			$sendToVisitor = true;
		}

		if ($sendToAdmin) {
            $response = $this->send_message($visitorNumber, $visitorMessage);
            $ADMINSEND = $response[0];
			if ($ADMINSEND) {
				$save_db = array();
				$send_res = $ADMINSEND['body'];
				$save_db['response'] = $send_res;
				$save_db['formID'] = method_exists($form, 'id') ? $form->id() : $form->id;
				$save_db['formNAME'] = method_exists($form, 'name') ? $form->name() : $form->name;
				$save_db['datetime'] = date("Y-m-d H:i:s");
				$save_db['message'] = $adminMessage;
				$save_db['to'] = $adminNumber;
				$save_db['type'] = 'admin';
				$save_db['ID'] = time() . rand(0, 1000);
				$this->save_history($save_db);
			}
		}


		if ($sendToVisitor) {
		    $response = $this->send_message($visitorNumber, $visitorMessage);
			$visitorSEND = $response[0];
			if ($visitorSEND) {
				if (!is_wp_error($visitorSEND)) {
					$save_db = array();
					$send_res = $visitorSEND['body'] . '<br> data sent '. $response[1] .'<br> url'. $response[2];
					$save_db['response'] = $send_res;
					$save_db['formID'] = method_exists($form, 'id') ? $form->id() : $form->id;
					$save_db['formNAME'] = method_exists($form, 'name') ? $form->name() : $form->name;
					$save_db['datetime'] = date("Y-m-d H:i:s");
					$save_db['message'] = $visitorMessage;
					$save_db['to'] = $visitorNumber;
					$save_db['type'] = 'visitor';
					$save_db['ID'] = time() . rand(0, 1000);
					$this->save_history($save_db);
				}

				if (is_wp_error($visitorSEND)) {
					$save_db = array();
					$save_db['response'] = json_encode($visitorSEND);
					$save_db['formID'] = method_exists($form, 'id') ? $form->id() : $form->id;
					$save_db['formNAME'] = method_exists($form, 'name') ? $form->name() : $form->name;
					$save_db['datetime'] = date("Y-m-d H:i:s");
					$save_db['message'] = $visitorMessage;
					$save_db['to'] = $visitorNumber;
					$save_db['type'] = 'visitor';
					$save_db['ID'] = time() . rand(0, 1000);
					$this->save_history($save_db);
				}
			}
		}
	}


	public function send_message($phone, $message)
	{
	    $parameters = ['phone','body'];
		$message = urlencode($message);
		$phone = urlencode($phone);
		$param1_set = get_option(Contact_FormWI_DB_SLUG.'phone_parameter_name','');
		$param2_set= get_option(Contact_FormWI_DB_SLUG.'message_parameter_name','');
		$param1 = !empty($param1_set) ? $param1_set : 'phone';
		$param2 = !empty($param2_set) ? $param2_set : 'message';
		$body = [
            $param1 =>  $phone,
             $param2 => $message
        ];
		$link = get_option(Contact_FormWI_DB_SLUG . 'api_urls', '');
		if (!empty($link)) {
			$response = wp_remote_post($link, [
                'body' => $body
            ]);
			return [$response , json_encode($body), $link]  ;

		}
		return false;
	}

	public function save_history($data)
	{
		$array = get_option('wpcf7iwa_history');
		if (empty($array)) {
			$array = array();
		}
		$array[$data['ID']] = $data;
		update_option('wpcf7iwa_history', $array);
	}
}