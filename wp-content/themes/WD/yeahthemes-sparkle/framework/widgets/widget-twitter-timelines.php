<?php
/**
 *	Plugin Name: Twitter Timelines
 *	Description: Display your latest tweets.
 */
class YT_Twitter_Timelines_Widget extends WP_Widget {

	/**
	 * Widget Setup
	 */
 	function __construct() {
		
		$widget_ops = array(
			'classname' => 'yt-twitter-timelines-widget yt-widget',
			'description' => __('Display your latest tweets.', 'yeahthemes')
		);
		
		// Widget control settings
		$control_ops = array(
			'id_base' => 'yt-twitter-timelines-widget',
			//'width'	=> 400
		);
		
		parent::__construct( 
			'yt-twitter-timelines-widget', 
			__('(Theme) Twitter Feeds', 'yeahthemes'), 
			$widget_ops, 
			$control_ops);
	}

	/**
	 * Display Widget
	 */
	function widget( $args, $instance ) {
		
		// outputs the content of the widget
		
		extract( $args );
		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$no_of_tweets = $instance['no_of_tweets'];
		
		echo $before_widget;
		
		//Echo widget title
		if ( $title ){ echo $before_title . $title . $after_title; }
		
		if( function_exists( 'yt_twitter_user_timelines' ) ){
			$tweets = yt_twitter_user_timelines( $no_of_tweets, $username );

			if( !is_wp_error( $tweets ) && !empty( $tweets ) ):
			echo '<ul>';
	        	foreach($tweets as $tweet){
					echo '<li><div class="tweet-content">', $tweet['tweet'] ,'</div> <span class="tweet-time">', $tweet['time'] ,'</span></li>';
				}
			echo '</ul>';
			endif;
		}
			
		echo $after_widget;
	}

	/**
	 * Widget Settings
	 */
	function form($instance) {
		
		// Set up some default widget settings
		$defaults = array(
			'title' => __('Latest Tweets','yeahthemes'),
			'username' => 'Yeahthemes',
			'no_of_tweets' => '3'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','yeahthemes')?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Username:','yeahthemes')?></label>
			<input id="<?php echo $this->get_field_id( 'username' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_tweets' ); ?>"><?php _e('Number of tweets to show:','yeahthemes')?></label>
			<input id="<?php echo $this->get_field_id( 'no_of_tweets' ); ?>" class='widefat' name="<?php echo $this->get_field_name( 'no_of_tweets' ); ?>" type="number" value="<?php echo esc_attr( ( int) $instance['no_of_tweets'] ); ?>" />
		</p>
		
		<?php
	}

	/**
	 * Update Widget
	 */
	function update( $new_instance, $old_instance ) {
		
		// processes widget options to be saved
		$instance = $old_instance;

		//Strip tags for title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['no_of_tweets'] = (int) $new_instance['no_of_tweets'];
		
		return $instance;
	}
}