<?php
/*
Template Name: Brochures
*/

get_header(); ?>

<div id="main-content">
	<div class="brochures-list-box et_had_animation">
		<?php 
			while ( have_posts() ) : the_post(); 
				the_content();
				if ( ! $is_page_builder_used )
					wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
			endwhile; 

			$terms = get_terms( array(
				'taxonomy' => 'brochure_category',
			) );
		?>
		<div class=" full-width">
			<?php
			if(!empty($terms) && isset($terms) ){
				foreach ($terms as $term) { ?>
					<div class="sub-title2 et_pb_row">
						<h4><?php echo $term->name;?></h4>
						<?php echo $term->description; ?>
					</div>
					<?php
					$args = get_posts(
							array(
							    'posts_per_page' => -1,
							    'post_type' => 'brochure',
							    'tax_query' => array(
							        array(
							            'taxonomy' => 'brochure_category',
							            'field' => 'term_id',
							            'terms' => $term->term_id,
							        ),							
								'order' => 'ASC'
							    )
							)
						);
					?>
					<div class="et_pb_row  guides-box ">
						<?php
						foreach( $args as $post ){	
							if( have_rows('uploadpdf') ):
								while ( have_rows('uploadpdf') ) : the_row();
									$date = get_sub_field('pdf_file')['date'];
									$monthNum  = date('m',strtotime($date));
									$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
									$pdffilepath = get_sub_field('pdf_file')['url'];
									$external_link = get_sub_field('external_link');
									if( $pdffilepath != ''){
										$filelink = $pdffilepath;
									}else{
										$filelink = $external_link;
									}
									?>
									<div class="et_pb_column">
										<div class="gides-img-box full-width">
											<a target="_blank" href="<?php echo $filelink; ?>">
												<img src="<?php echo get_sub_field('pdf_image'); ?>">
											</a>
										</div>	
									<div class="guide-desc full-width">
										<div class="guide-desc-top full-width">
											<?php 
												$pdffilename = '';
												$pdftitle = get_sub_field('pdf_file_name');
												$pdfilename = get_sub_field('pdf_file')['title'];
												$pdf_date = get_sub_field('pdf_date');
												if( $pdffilepath != '' && $external_link == ''){ ?>	
													<h3><?php if( $pdftitle != '') { echo $pdftitle; } else{ echo $pdfilename; } ?></h3>										
												<?php } elseif( $pdftitle != '' && $external_link != '' && $pdffilepath == '') { ?>
													<h3><?php echo $pdftitle; ?></h3>
												<?php }else{ ?>
													<h3><?php echo $pdftitle; ?></h3>
												<?php } 

												if($pdf_date != '') { ?> 
													<span><?php echo $pdf_date; ?> </span>
												<?php }else{ ?>
													<span><?php echo $monthName.' '.date('Y',strtotime($date)); ?></span>
												<?php } ?>
										</div>	
										<?php  
										if( $pdffilepath != '' ){ ?>				
											<a class="download-btn" target="_blank" href="<?php echo $pdffilepath; ?>">iij</a>
										<?php }elseif( $external_link != '' ) { ?>
											<div class="brochures technical-resource-arrow">
												<a class="download-btn" target="_blank" href="<?php echo  $external_link;?> ">Download</a>
											</div>
										<?php }else{ ?>
											<a class="download-btn" target="_blank" href="#">iij</a>
										<?php } ?>
									</div>
								</div>
									<?php 
								endwhile;
							else :
						endif;					
				} 	?>
				</div>
				<?php				
			}
		} ?>
		</div>	
		<?php 
		/* code to load custom shortcode */
		echo do_shortcode('[et_pb_section global_module="645"][/et_pb_section]'); ?>
	</div>
</div> <!-- #main-content -->
<?php
get_footer();
