<?php

namespace BookPress\MetaBoxes;

class Item_Info {

	public static $post_types = array ('item');


	public function __construct() {
		
		add_action('add_meta_boxes', array (__CLASS__, 'add_meta_boxes'));
		add_action('save_post', array (__CLASS__,  'save_post'));
		
	}
	
	public static function add_meta_boxes ($post_type){
		
		if (in_array($post_type, static::$post_types)){
			add_meta_box(
				__CLASS__, 
				__('Item Info', 'bookpress'), 
				array (__CLASS__, 'callback'), 
				$post_type, 
				'side', 
				'high' 
				);
		}
		
	}
	public static function save_post ($post_id) {
		
		$nonce = filter_input(INPUT_POST, __CLASS__ . '_nonce');
		
		if (empty($nonce)){
			
			return $post_id;			
		}
		if (!wp_verify_nonce( $nonce, __CLASS__ )){
			return $post_id;
		}
		if (  defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;			
		}
		
		$post_type = filter_input(INPUT_POST, 'post_type');
		if (!in_array( $post_type, static::$post_types )){
			return $post_id;
		}		
		
		$year = sanitize_text_field(filter_input(INPUT_POST, 'year'));
		update_post_meta($post_id, '_year', $year);
		
}
	
	public static function callback ($post){
		wp_nonce_field(__CLASS__, __CLASS__ . '_nonce');
		
		$year = get_post_meta( $post->ID, '_year', true );
		$current_year = date('Y');
		
		if (empty($year)) {
			$year = $current_year;
		}
		
		//$moth = get_post_meta( $post->ID, '_moth', true );
		
?>
<p>
	<label for="year">
		<?php _e( 'Year published', 'bookpress' ) ?>
	</label>
	<input		
		id ="year"
		max ="<?php echo $current_year ?>"
		name ="year"
		step ="1"
		type ="number"
		value ="<?php echo esc_attr($year); ?>"
		/>
</p>	
<?php


		
		
	}
}

return new Item_Info ();