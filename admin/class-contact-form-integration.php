<?php
/**
 * The admin-specific functionality of the plugin.
 * @author     Varun Sridharan <varunsridharan23@gmail.com>
 */
if ( ! defined( 'WPINC' ) ) { die; }

class Contact_Form_whatsapp_Integration_abn_Plugin_Integration extends Contact_Form_whatsapp_Integration_abn{
	
    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
		add_action( 'wp_ajax_Contact_FormISIWAHISTORYDELETE', array($this,'delete_cf7wa_history') );
		add_action( 'wp_ajax_Contact_FormISIWAHISTORYEMPTY', array($this,'empty_cf7wa_history') );
		
		add_filter( 'wpcf7_editor_panels' , array($this, 'new_menu'),99);
		add_action( 'wpcf7_after_save', array( &$this, 'save_form' ) );
	}
	
	public function empty_cf7wa_history(){
		update_option('wpcf7iwa_history',array());
		exit;
	}
	
	public function delete_cf7wa_history(){
		$array = get_option( 'wpcf7iwa_history');
		if(empty($array)){echo '1'; exit;}
		$deleteID = $_REQUEST['deleteID'];
		if(isset($array[$deleteID])){
			unset($array[$deleteID]); 
			update_option('wpcf7iwa_history',$array);
			echo '1'; exit;
		}
		
	}

	public function new_menu ($panels) {
		$panels['cf7wi-sms-panel'] = array(
				'title' => __('Whatsapp',Contact_FormWI_TXT),
				'callback' => array($this, 'add_panel')
		);
		return $panels;
	}
	
	public function add_panel($form) { 
		if ( wpcf7_admin_has_edit_cap() ) {
		  $options = get_option( 'wpcf7_international_wa_' . (method_exists($form, 'id') ? $form->id() : $form->id) );
		  if( empty( $options ) || !is_array( $options ) ) {
			$options = array( 'phone' => '', 'message' => '', 'visitorNumber' => '','visitorMessage' => '');
		  }
		  $options['form'] = $form;
          $data =  $options; 
		  include(Contact_FormWI()->get_vars('PATH').'template/cf7-template.php');
		}
	}
	
  
  /**
   * Save SMS options when contact form is saved
   *
   * @param object $cf Contact form
   * @return void
   * @author James Inman
   */
  public function save_form( $form ) {
    update_option( 'wpcf7_international_wa_' . (method_exists($form, 'id') ? $form->id() : $form->id), $_POST['wpcf7wi-settings'] );
  }	
	 
}