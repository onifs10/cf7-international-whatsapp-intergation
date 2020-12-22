<?php
 
if ( ! defined( 'WPINC' ) ) { die; }

class Contact_Form_whatsapp_Integration_abn_Admin extends Contact_Form_whatsapp_Integration_abn {
 
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu'));
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ),99);
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_action( 'admin_init', array( $this, 'admin_init' ));
	}
	
	public function add_menu(){
		$this->page_slug = 'cf7iwa-options';
		add_submenu_page( 'wpcf7', 
						 __('Whatsapp Integration', Contact_FormWI_TXT),
						 __('Whatsapp Integration', Contact_FormWI_TXT), 'manage_options',
						 $this->page_slug, array($this,'admin_page') );
	}
	
	
	public function admin_page(){
		global $Custom_pagetitle,$slugs;
		$this->save_settings();
		$slugs = $this->page_slug; 
		Contact_FormWI()->load_files(Contact_FormWI()->get_vars('PATH').'template/cf7-conf-header.php');
		Contact_FormWI()->load_files(Contact_FormWI()->get_vars('PATH').'template/cf7-conf-footer.php');
	}
	
	public function save_settings(){
		if(isset($_POST['save_api_settings'])){
			$url = $_POST['api_urls'];
			$phone = $_POST['phone_parameter_name'];
			$message = $_POST['message_parameter_name'];
			update_option(Contact_FormWI_DB_SLUG.'api_urls',$url);
			update_option(Contact_FormWI_DB_SLUG.'phone_parameter_name',$phone);
			update_option(Contact_FormWI_DB_SLUG.'message_parameter_name',$message);
		}
	}

 
    public function admin_init(){
        new Contact_Form_whatsapp_Integration_abn_Plugin_Integration;
    }
 
  
	public function enqueue_styles() { 
        if(in_array($this->current_screen() , $this->get_screen_ids())) {
            wp_enqueue_style(Contact_FormWI_SLUG.'_core_style',plugins_url('css/style.css',__FILE__) , array(), $this->version, 'all' );
        }
	}
	
    
    /**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
        if(in_array($this->current_screen() , $this->get_screen_ids())) {
            wp_enqueue_script(Contact_FormWI_SLUG.'_core_script', plugins_url('js/script.js',__FILE__), array('jquery'), $this->version, false );
        }
 
	}
    
    /**
     * Gets Current Screen ID from wordpress
     * @return string [Current Screen ID]
     */
    public function current_screen(){
       $screen =  get_current_screen();
       return $screen->id;
    }
    
    /**
     * Returns Predefined Screen IDS
     * @return [Array] 
     */
    public function get_screen_ids(){
        $screen_ids = array();
        $screen_ids[] = 'contact_page_cf7iwa-options';
        return $screen_ids;
    }
    
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( Contact_FormWI()->get_vars('FILE') == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('Settings', Contact_FormWI_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/onifs10/cf7-international-whatsapp-intergation', __('View On Github', Contact_FormWI_TXT) );
		}
		return $plugin_meta;
	}	    
}