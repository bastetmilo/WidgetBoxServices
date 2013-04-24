<?php
/**
* Widgety
*/

add_action('widgets_init', 'bm_WidgetBoxServices_register');

function bm_WidgetBoxServices_register(){
	register_widget('bm_WidgetBoxServices');
}

class bm_WidgetBoxServices extends WP_Widget
{
	function bm_WidgetBoxServices(){
			$widget_ops = array('classname' => 'bm_WidgetBoxServices', 'description' => 'Wyświetla boksy usług');
			$this->WP_Widget('bm_WidgetBoxServices','Box usługi',$widget_ops);
	}	

	function form($instance){
		$defaults = array('title' => 'Skup zbóż', 'class' => 'grainPurchase');

		$instance = wp_parse_args( (array) $instance, $defaults);
		$title = $instance['title'];
		$class = $instance['class'];
		$webID = $instance['webID'];
		$webExcerpt = $instance['webExcerpt'];
		?>
			<p>Tytuł: <input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>
			<p>Typ usługi: 
			<select name="<?php echo $this->get_field_name('class'); ?>">
				<option value="grainPurchase" <?php selected($class, 'grainPurchase') ?>>Skup zbóż</option>
				<option value="labs" <?php selected($class, 'labs') ?>>Laboratoria</option>
				<option value="transport" <?php selected($class, 'transport') ?>>Transport</option>	
			</select></p>
			<p>Wybierz stronę:
			<select name="<?php echo $this->get_field_name('webID'); ?>">
				<?php 
  				$pages = get_pages(); 
  					foreach ( $pages as $page ) {
  						$option = '<option value="' . $page->ID  . '" '. selected($webID,  $page->ID ) .'>';
						$option .= $page->post_title;
						$option .= '</option>';
						echo $option;
  					}
 				?>
			</select>
			</p>
			<p>Opis: 
			<textarea name="<?php echo $this->get_field_name('webExcerpt'); ?>"><?php echo esc_attr($webExcerpt); ?></textarea>
			</p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title']);
		$instance['class'] = $new_instance['class'];
		$instance['webID'] = $new_instance['webID'];
		$instance['webExcerpt'] = $new_instance['webExcerpt'];
		return $instance;
	}

	function widget($args, $instance){
		extract($args);
		//echo $before_widget;
		$title = apply_filters('widget_title', $instance['title']);
		$class = empty($instance['class']) ? '' : $instance['class'];
		$webID = empty($instance['webID']) ? '' : $instance['webID'];
		$webExcerpt = empty($instance['webExcerpt']) ? '' : $instance['webExcerpt'];
		
		$morePageData = get_page($webID);
		echo '<div class="box '.$class.'">';
		echo '<a href="'.get_permalink($webID).'">';
		if (!empty($title)) {
			echo $title;
		}
		echo '<p>'.$webExcerpt.'</p>';
		echo '</a></div>';
		//echo $after_widget;
	}

}