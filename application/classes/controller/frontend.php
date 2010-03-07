<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

abstract class Controller_Frontend extends Controller {
	
	public $template = 'template/main';
	
	public $protected = FALSE;
	public $load_character = FALSE;
	
	public $title = 'Undefined';
	public $auto_render = TRUE;
	public $js = array('files' => array(), 'scripts' => array());
	public $css = array();
	public $errors = array();
	
	public function add_js($js, $file = TRUE)
	{
		if ($file) {
			$this->js['files'][] = $js;
		} else {
			$this->js['scripts'][] = $js;
		}
		$this->js[] = $js;
	}
	
	public function add_css($css)
	{
		$this->css[] = $css;
	}
	
	public function before()
	{
		
		$this->add_css('assets/css/main.css');
		
		$this->add_js('assets/js/jquery.js'); // Jquery 1.4
		$this->add_js('assets/js/jquery.validate.js'); // Form Validation
		// $this->add_js('assets/js/jquery-ui-1.7.2.custom.min.js');
		// $this->add_js('assets/js/main.js');
		
		// Initialize the Auth System
		$this->a2 = A2::instance();
		$this->a1 = $this->a2->a1;
		$this->user = $this->a2->get_user();
		
		View::set_global(  'user',   $this->user   );
		View::bind_global( 'errors', $this->errors );
		View::bind_global( 'title',  $this->title  );
		
		
		$this->modulargaming = new modulargaming( $this->user );
		
		if ($this->auto_render === TRUE && !Request::$is_ajax )
		{
			
			// Load the template
			$this->template = View::factory($this->template)
				->bind('js',  $this->js)
				->bind('css', $this->css);
			
			$this->template->errors = array();
		}
		
		// Check if the page is protected and if the user is not logged in
		if ($this->protected && !$this->user) {
			// Redirect the user to login page
			Request::instance()->redirect('account/login');
		}
		
		// Make sure the user got a character if characters is required in the controller
		if ( $this->load_character ) {
			
			$this->character = Jelly::select( 'character' )
				->where( 'user', '=', $this->user->id )
				->limit( 1 )
				->execute();
			
		}
		
	}
	
	public function after()
	{
		if ($this->auto_render === TRUE && !Request::$is_ajax)
		{
			// Assign the template as the request response and render it
			$this->request->response = $this->template;
		}
	}	
} // End Frontend
