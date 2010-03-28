<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://modulargaming.com/projects/modulargaming/wiki/License
 */

class Controller_Forum extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Forum';
	
	public function action_index ()


        {
                $categories = Jelly::select( 'forum_category' )
                        ->execute();


                if ($categories->count() == 0)
{

                $message = 'No categories exist';
                Message::set( Message::ERROR, $message );

}

                $this->template->content = View::factory( 'forum/index' )
                        ->set( 'categories', $categories );

        }


	public function action_category ( $id )

	{

		$this->title = 'Forum - Category '."$id";

		if ( !is_numeric( $id ) ) 

		{

                $message = 'Invalid ID';
                Message::set( Message::ERROR, $message );

		}

		$topics = Jelly::select( 'forum_topic' )
			->where( 'category_id', '=', $id )
			->execute();

		
                if ($topics->count() == 0)
{

                $message = 'No topics exist';
                Message::set( Message::ERROR, $message );

}


		$this->template->content = View::factory( 'forum/category' )
			->set( 'topics', $topics );

	}



	public function action_topic( $id )
	{
		
		$this->title = 'Forum - Topic '."$id";
		
                if ( !is_numeric( $id ) ) 

                {

                $message = 'Invalid ID';
                Message::set( Message::ERROR, $message );

                }
		
		$posts = Jelly::select( 'forum_post' )
			->where( 'topic_id', '=', $id )
			->execute();

		

                if (!$posts)
{

                $message = 'Topic does not exist';
                Message::set( Message::ERROR, $message );

}

		$this->template->content = View::factory( 'forum/topic' )
			->set( 'posts', $posts );
		
	}
	

	/**
         * Create a new post.
         */
        public function action_create( $id )
        {

		$this->title = 'Forum - Post';


                // Validate the form input
                $post = Validate::factory($_POST)
                        ->filter(TRUE,'trim')
			->callback('captcha',       array($this, 'captcha_valid'))
			//->callback($id, array($this, 'topic_exists'))
                        ->rule('title', 'not_empty')
                        ->rule('title', 'min_length', array(3))
                        ->rule('title', 'max_length', array(20))
                        ->rule('content', 'not_empty')
                        ->rule('content', 'min_length', array(10))
	                ->rule('content', 'max_length', array(1000));

                if ($post->check())
                {

                        $values = array(
                                'title'       => $post['title'],
                                'content'  => $post['content'],
                                'author'     => $this->user->id,
				'topic_id'   => $id,
                        );

                        $message = Jelly::factory('forum_post');

                        // Assign the validated data to the sprig object
                        $message->set($values);
                        $message->save();

                        Message::set(Message::SUCCESS, 'You posted a message.' );

                        $this->request->redirect('forum');

                }


 else
                {
                        $this->errors = $post->errors('forum');
                }

                if ( ! empty($this->errors))
                        Message::set(Message::ERROR, $this->errors);

                $this->template->content = View::factory('forum/create')
                        ->set('post', $post->as_array());

        }
 

        public function captcha_valid(Validate $array, $field)
        {
                if ( ! Captcha::valid($array[$field])) $array->error($field, 'invalid');
        }



public function topic_exists(Validate $array, $field)
        {

                $topic = Jelly::select('forum_topic')
                        ->where('id', '=', $array[$field])
                        ->load();

                // If no topic was found, give an error.
                if ( ! $topic->loaded())
                {
                        $array->error($field, 'incorrect');
                        return;
                }


        }


} // End Forum