<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

abstract class Controller_Backend extends Controller {
	
	public $template = 'template/admin';
	public $protected = TRUE; // All admin pages requires the user to be loged in.
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
		
		$this->add_css('assets/css/admin.css');
		
		$this->add_js('assets/js/jquery-1.3.2.min.js');
		$this->add_js('assets/js/jquery-ui-1.7.2.custom.min.js');
		$this->add_js('assets/js/main.js');
		
		
		$this->a2 = A2::instance();
		$this->a1 = $this->a2->a1;
		
		$this->user = $this->a2->get_user();
		
		View::set_global( 'user', $this->user );
		View::bind_global( 'errors', $this->errors );
		
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