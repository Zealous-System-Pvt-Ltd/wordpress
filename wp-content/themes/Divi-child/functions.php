<?php 

/**
 * Proper way to enqueue scripts and styles
 */
function add_our_team_style_script() {
    wp_enqueue_style( 'our-team-style', get_template_directory_uri() . '/css/our-team.css', array(), '0.1.0', 'all');
	wp_enqueue_script( 'our-team-script', get_template_directory_uri() . '/js/our-team.js', array ( 'jquery' ), 1.1, true);
}
add_action( 'wp_enqueue_scripts', 'add_our_team_style_script' );

/* Short Code created to show in team page using Advance custom field plugin */
add_shortcode( 'out-team-list', 'ourTeam' );

function ourTeam( $atts ) {
	
	// Display Team Lising		
	$args = array('post_type' => 'our-team', 'posts_per_page' => -1,'orderby'=>'menu_order','post_status' => 'publish', 'order' => 'ASC' );
	$myQuery = new WP_Query($args);
	$html = '';
	global $post;
	if ($myQuery->have_posts()) :
	$html = '
	<div class="team-block">
		<div class="wrapper">
			<div class="text-center row">';
			while ($myQuery->have_posts()) : $myQuery->the_post();
				$nonce = wp_create_nonce("my_team_details");
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				<?php /* code to get custom fields ( ACF ) start */ ?>
				$designation = get_field( "designation", $post->ID);
				$module_header = get_field( "module_header", $post->ID);
				$degree = get_field( "degree", $post->ID);
				$gifImage = get_field( "gif_image", $post->ID);
				<?php /* code to get custom fields ( ACF ) end */ ?>
				
				if($degree){
					$degree = ",".$degree;
				}else{
					$degree = '';
				}
				$html .='<div class="inner-column">
					<div class="single-wrapper">
						<a href="'.get_the_permalink($post->ID).'" data-id="'.$post->ID.'" data-nonce="'.$nonce.'" class="read-more">
							<div class="membber-image">
								<img src="'.$image[0].'" alt="'.get_the_title().'" height="200" width="200" />
							</div>
							<div class="back-gif"> <img src="'.$gifImage.'" height="200" width="200"></div>
						</a>
					</div>
					<div class="member-details">
						<div class="et_pb_team_member_description">
							<h1 class="et_pb_module_header"><a href="'.get_the_permalink($post->ID).'" data-id="'.$post->ID.'" data-nonce="'.$nonce.'" class="read-more">'.get_the_title().'</a></h1>';
							if(!empty($module_header)){ $html .='<p class="et_pb_member_position tr-member-pos">“'.$module_header.'”</p>'; }
							$html .='<p class="et_pb_member_position tr-mm-pos">'.$designation.'</p>
						</div>
					</div>
				</div>';
			endwhile;  
			wp_reset_postdata();
			$html .= '</div>
		</div>
	</div>';
	endif;
    return $html;
}
?>