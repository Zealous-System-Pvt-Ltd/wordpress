<?php
/*
Template Name: Brickspiration Page
*/

get_header(); ?>

<div id="main-content">
	<div class="et_pb_section brickspiration-main">
		<div class="et_pb_row sub-title">
			<h3><?php echo get_the_title(); ?></h3>
			<?php /* code to get custom fields ( ACF ) */ ?>
			<div><?php echo get_field('brick_101_main_content', get_the_ID()); ?></div>
		</div>
		<div class="et_pb_row et_pb_row_4col filter-main">	
			<?php /* code for advance filters */ ?>
			<form action=""  class="filter-drop" method="GET" id="GalleryCatFilter">
				<select name="gallery_cat" id="gallery_cat" >
				<option value="">Filter By</option>	
			<?php 	if($_GET['gallery_cat'] == '') {
						$selected = 'selected="selected"';
					} else {
						$selected = ' ';
					} ?>
					<option value="" >All</option>
					<?php   $categories = get_categories('taxonomy=gallery_cat&post_type=gallery'); 
							foreach ($categories as $category) : 
								if($_GET['gallery_cat'] == $category->name) {
										$selected = 'selected="selected"';
									} else {
										$selected = ' ';
									}
								echo '<option value="'.$category->name.'" ' . $selected . '>'.$category->name.'</option>';
							endforeach; ?>
				</select>
			</form>
			<?php 
			/* code to custom query to get results */
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;  
			if( !isset($_GET['gallery_cat']) || '' == $_GET['gallery_cat']) {
				$gallerylist = new WP_Query( 
					array(
						'post_type' => 'gallery', 
						'posts_per_page' => -1,
						'orderby' => 'DATE',
						'paged' => $paged 
					) 
				); 
			} else { 
				//if select value exists (and isn't 'show all'), the query that compares $_GET value and taxonomy term (name)
				$gallerycategory = $_GET['gallery_cat']; //get sort value
				$gallerylist = new WP_Query( 
								array(
									'post_type' => 'gallery', 
									'posts_per_page' => -1,
									'orderby' => 'DATE',
									'paged' => $paged,
									'tax_query' => array(
										array(
											'taxonomy' => 'gallery_cat',
											'field' => 'name',
											'terms' => $gallerycategory 
										) 
									) 
								)
							);
			}

			if ($gallerylist->have_posts()) : ?>
				<div class="gallery-box-main full-width">
				<?php
					while ( $gallerylist->have_posts() ) : $gallerylist->the_post(); 
						$description = get_field('description');?>
					<div class="gallery-box equal">
						<div class="et_pb_gallery_image">
							<a href="<?php the_permalink(); ?>" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
							<span class="et_overlay"></span>
							</a>
						</div>
						<h3 class="et_pb_gallery_title"><?php the_title(); ?></h3>
						<?php if( !empty($description) ){ ?>
							<div id="extrafieldrows" class="painter-box">
								<?php echo $description; ?>
							</div>
						<?php } ?>
					</div>

				<?php endwhile; ?>
					<div class="pagination"><?php pagination('»', '«'); ?></div>
				<?php else : 
					echo 'There are no gallery items in that category.'; ?>
				</div>
				<?php
				endif; 
				?>  
				<?php wp_reset_query(); ?>
			</div>
			<div class="clr"></div>
			<?php 
			/* code to load shotcode for modules data */
			echo do_shortcode('[showmodule id="645"]'); ?>
		</div>

	</div> <!-- #main-content -->

</div>

<script type="text/javascript" src="<?php echo get_template_directory_uri().'-child/js/equal_all_elements_height.js';?>"></script>
<?php
get_footer();