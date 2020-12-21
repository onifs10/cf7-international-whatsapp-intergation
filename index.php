<?php 
/**
* Plugin Name:       Contact Form WhatsApp integration
* Description:       Using Contact Form 7 Whatsapp integration ....few changes from sms integration
* Version:           1.1
* Author:            onifs-bincom
* Author URI:        https://github.com/onifs10
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt 
*/

if( ! defined( 'WPINC' ) ){ die; }
 
class Contact_Form_whatsapp_Integration_abn{
	public $version = '0.3';
	public $plugin_vars = array();
	protected static $_instance = null;
	protected static $functions = null;
	public function __construct(){
		$this->define_constant();
		$this->set_vars();
		$this->load_required_files();
		$default_args = array(
			'dbslug' => 'cf7iwa',
			'welcome_slug' => Contact_FormWI_SLUG.'-welcome-page',
			'wp_plugin_slug' => Contact_FormWI_SLUG,
			'wp_plugin_url' => 'https://profiles.wordpress.org/witsolution/#content-plugins/',
			'tweet_text' => __('Adds an SMS box to your Contact Form 7 options pages, fill this in and you\'ll get a text message each time somebody fills out one of your forms',Contact_FormWI_TXT),
			'twitter_user' => 'varunsridharan2',
			'twitter_hash' => 'Contact_FormInternationSMSintegration',
			'gitub_user' => 'onifs10',
			'github_repo' => 'cf7-international-sms-intergation',
			'plugin_name' => Contact_FormWI_NAME,
			'version' => $this->version,
			'template' => $this->get_vars('PATH').'template/welcome-page.php',
			'menu_name' => Contact_FormWI_NAME.' Welcome Page',
			'plugin_file' => __FILE__,
		);
		new cf7iwi_activation_welcome_page($default_args);
		$this->init_class();
		add_action('plugins_loaded', array( $this, 'after_plugins_loaded' ));
		add_filter('load_textdomain_mofile',  array( $this, 'load_plugin_mo_files' ), 10, 2);
	}
	public static function get_instance(){
		if( null == self::$_instance ){
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	private function init_class(){
		self::$functions = new Contact_Form_whatsapp_Integration_abn_Functions();
		if($this->is_request('admin')){
			$this->admin = new Contact_Form_whatsapp_Integration_abn_Admin();
		}
	}
	public function load_plugin_mo_files($mofile, $domain){
		if(Contact_FormWI_TXT === $domain)
		return $this->get_vars('LANGPATH').'/'.get_locale().'.mo';
		return $mofile;
	}
	protected function func(){
		return self::$functions;
	}
	protected function load_files($path,$type = 'require'){
		foreach( glob( $path ) as $files ){
			if($type == 'require'){
				require_once( $files );
			} else if($type == 'include'){
				include_once( $files );
			}
		} 
	}
	private function load_required_files(){
		$this->load_files($this->get_vars('PATH').'includes/class-*.php');
		$this->load_files($this->get_vars('PATH').'includes/common-class-*.php');
		if($this->is_request('admin')){
			$this->load_files($this->get_vars('PATH').'admin/class-*.php');
		} 

	}
	public function after_plugins_loaded(){
		load_plugin_textdomain(Contact_FormWI_TXT, false, $this->get_vars('LANGPATH') );
	}
   

	private function set_vars(){
		$this->add_vars('URL',plugins_url('', __FILE__ )); 
		$this->add_vars('FILE',plugin_basename( __FILE__ ));
		$this->add_vars('PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
		$this->add_vars('LANGPATH',$this->get_vars('PATH').'languages');
	}
	private function add_vars($key, $val){
		if(!isset($this->plugin_vars[$key])){
			$this->plugin_vars[$key] = $val;
		}
	}
	private function define_constant(){
		$this->define('Contact_FormWI_NAME',__('Contact Form SMS Integration','cf7-wa-integration-abs')); # Plugin Name
		$this->define('Contact_FormWI_SLUG','cf7-wa-integration-abs'); # Plugin Slug
		$this->define('Contact_FormWI_DB_SLUG','cf7wa'); # Plugin DB Slug
		$this->define('Contact_FormWI_TXT','cf7-wa-integration-abs'); #plugin lang Domain
	}
	protected function define($key,$value){
		if(!defined($key)){
			define($key,$value);
		}
	}
	public function get_vars($key){
		if(isset($this->plugin_vars[$key])){
			return $this->plugin_vars[$key];
		}
		return false;
	}	
	
	
	private function is_request( $type ){
		switch( $type ){
			case 'admin' :
			return is_admin();
			case 'ajax' :
			return defined( 'DOING_AJAX' );
			case 'cron' :
			return defined( 'DOING_CRON' );
			case 'frontend' :
			return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}
}
if(!function_exists('Contact_FormWI')){
	function Contact_FormWI(){
		return Contact_Form_whatsapp_Integration_abn::get_instance();
	}
	Contact_FormWI();
}