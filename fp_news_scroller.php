<?php
/*
Plugin Name: FP News Scroller
Plugin URI: http://flourishpixel.com/
Description: FP News Scroller allows you to display news/post from a specific category or from all category in a widget position with with infinity scroll effects. The scrolling options/parametrs/controls are managable from wordpress admin area. You can also assign the category and the post limit.
Author: Moshiur Rahman Mehedi
Version: 1.0.0
Author URI: http://www.flourishpixel.com/
*/

wp_enqueue_script('jquery');
wp_enqueue_script('scroller_script', plugins_url('/js/jquery.webticker.js',__FILE__), array( 'jquery' ));
wp_enqueue_style('scroller_css', plugins_url('/css/scroller.css',__FILE__) );

//Widget Code 

class NewsscrollerWidget extends WP_Widget
{
  function NewsscrollerWidget()
  {
    $widget_ops = array('classname' => 'NewsscrollerWidget', 'description' => 'Display posts as infinity scrolling' );
    $this->WP_Widget('NewsscrollerWidget', 'FP News Scroller', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category'=>'1','limit'=>'5', 'scroll_speed' =>'40', 'direction'=>'left', 'duplicate'=>'true', 'startEmpty' =>'false', 'hoverpause' =>'true','moving'=>'true') );
	$title = $instance['title'];
	$category = $instance['category'];
	$limit = $instance['limit'];
	$scroll_speed = $instance['scroll_speed'];
	$direction = $instance['direction'];
	$duplicate = $instance['duplicate'];
	$startEmpty = $instance['startEmpty'];
	$hoverpause = $instance['hoverpause'];
	$moving = $instance['moving'];
?>
<style type="text/css" media="screen">
p.fp_label input.custom {
	width:24%;
}
p.fp_label label{
	font-size:11px;
}
</style>
<p class="fp_label">
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p class="fp_label">
  <label for="<?php echo $this->get_field_id('category'); ?>">Category ID:
    <input class="custom" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
  <label for="<?php echo $this->get_field_id('limit'); ?>">Limit:
    <select name="<?php echo $this->get_field_name('limit'); ?>" id="<?php echo $this->get_field_id('limit'); ?>">
      <option value="2" <?php if(attribute_escape($limit) == '2'){echo 'selected';}?>>2</option>
      <option value="3" <?php if(attribute_escape($limit) == '3'){echo 'selected';}?>>3</option>
      <option value="4" <?php if(attribute_escape($limit) == '4'){echo 'selected';}?>>4</option>
      <option value="5" <?php if(attribute_escape($limit) == '5'){echo 'selected';}?>>5</option>
      <option value="6" <?php if(attribute_escape($limit) == '6'){echo 'selected';}?>>6</option>
      <option value="7" <?php if(attribute_escape($limit) == '7'){echo 'selected';}?>>7</option>
      <option value="8" <?php if(attribute_escape($limit) == '8'){echo 'selected';}?>>8</option>
      <option value="9" <?php if(attribute_escape($limit) == '9'){echo 'selected';}?>>9</option>
      <option value="10" <?php if(attribute_escape($limit) == '10'){echo 'selected';}?>>10</option>
      <option value="15" <?php if(attribute_escape($limit) == '15'){echo 'selected';}?>>15</option>
      <option value="20" <?php if(attribute_escape($limit) == '20'){echo 'selected';}?>>20</option>
    </select>
  </label>
</p>
<p class="fp_label">
  <label for="<?php echo $this->get_field_id('scroll_speed'); ?>">Speed:
    <input class="custom" id="<?php echo $this->get_field_id('scroll_speed'); ?>" name="<?php echo $this->get_field_name('scroll_speed'); ?>" type="text" value="<?php echo attribute_escape($scroll_speed); ?>" />
  </label>
  <label for="<?php echo $this->get_field_id('direction'); ?>">Direction:
    <select name="<?php echo $this->get_field_name('direction'); ?>" id="<?php echo $this->get_field_id('direction'); ?>">
      <option value="left" <?php if(attribute_escape($direction) == 'left'){echo 'selected';}?>>Left</option>
      <option value="right" <?php if(attribute_escape($direction) == 'right'){echo 'selected';}?>>Right</option>
    </select>
  </label>
</p>
<p class="fp_label">
 <label for="<?php echo $this->get_field_id('duplicate'); ?>">Duplicate:
    <select name="<?php echo $this->get_field_name('duplicate'); ?>" id="<?php echo $this->get_field_id('duplicate'); ?>">
      <option value="true" <?php if(attribute_escape($duplicate) == 'true'){echo 'selected';}?>>True</option>
      <option value="false" <?php if(attribute_escape($duplicate) == 'false'){echo 'selected';}?>>False</option>
    </select>
  </label>
  <label for="<?php echo $this->get_field_id('hoverpause'); ?>">Pause:
    <select name="<?php echo $this->get_field_name('hoverpause'); ?>" id="<?php echo $this->get_field_id('hoverpause'); ?>">
      <option value="true" <?php if(attribute_escape($hoverpause) == 'true'){echo 'selected';}?>>True</option>
      <option value="false" <?php if(attribute_escape($hoverpause) == 'false'){echo 'selected';}?>>False</option>
    </select>
  </label>
  </p>
  
  <p class="fp_label">
  <label for="<?php echo $this->get_field_id('startEmpty'); ?>">startEmpty:
    <select name="<?php echo $this->get_field_name('startEmpty'); ?>" id="<?php echo $this->get_field_id('startEmpty'); ?>">
      <option value="true" <?php if(attribute_escape($startEmpty) == 'true'){echo 'selected';}?>>True</option>
      <option value="false" <?php if(attribute_escape($startEmpty) == 'false'){echo 'selected';}?>>False</option>
    </select>
  </label>
  <label for="<?php echo $this->get_field_id('moving'); ?>">Moving:
    <select name="<?php echo $this->get_field_name('moving'); ?>" id="<?php echo $this->get_field_id('moving'); ?>">
      <option value="true" <?php if(attribute_escape($moving) == 'true'){echo 'selected';}?>>True</option>
      <option value="false" <?php if(attribute_escape($moving) == 'false'){echo 'selected';}?>>False</option>
    </select>
  </label> 
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['category'] = $new_instance['category'];
	$instance['limit'] = $new_instance['limit'];
	$instance['scroll_speed'] = $new_instance['scroll_speed'];
	$instance['direction'] = $new_instance['direction'];
	$instance['duplicate'] = $new_instance['duplicate'];
	$instance['startEmpty'] = $new_instance['startEmpty'];
	$instance['hoverpause'] = $new_instance['hoverpause'];
	$instance['moving'] = $new_instance['moving'];
	
	
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
	$category = empty($instance['category']) ? ' ' : apply_filters('widget_category', $instance['category']);
	$limit = empty($instance['limit']) ? ' ' : apply_filters('widget_limit', $instance['limit']);
	$scroll_speed = empty($instance['scroll_speed']) ? ' ' : apply_filters('widget_scroll_speed', $instance['scroll_speed']);
	$direction = empty($instance['direction']) ? ' ' : apply_filters('widget_direction', $instance['direction']);
	$duplicate = empty($instance['duplicate']) ? ' ' : apply_filters('widget_duplicate', $instance['duplicate']);
	$startEmpty = empty($instance['startEmpty']) ? ' ' : apply_filters('widget_startEmpty', $instance['startEmpty']);
	$hoverpause = empty($instance['hoverpause']) ? ' ' : apply_filters('widget_hoverpause', $instance['hoverpause']);
	$moving = empty($instance['moving']) ? ' ' : apply_filters('widget_moving', $instance['moving']);
	
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#news_scroller").webTicker({
		duplicate:<?php echo $duplicate; ?>,
		moving: <?php echo $moving; ?>,  
		speed: <?php echo $scroll_speed; ?>, 
		direction: '<?php echo $direction; ?>', 
		startEmpty:<?php echo $startEmpty; ?>,		
		hoverpause:<?php echo $hoverpause; ?>
		});
});
</script>

<?php
	// WIDGET CODE GOES HERE
	query_posts('cat='.$category.'&showposts='.$limit);
	if (have_posts()) : 
		echo "<ul id='news_scroller'>";
		while (have_posts()) : the_post(); 
			echo "<li class='scroll_item'>";
			echo "<a href='".get_permalink()."'>".get_the_title()."</a>";
			echo "</li>";
		endwhile;
		echo "</ul>";
	endif; 
	wp_reset_query();
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("NewsscrollerWidget");') );

?>
