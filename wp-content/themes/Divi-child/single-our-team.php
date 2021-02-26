<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
	<?php
		if ( et_builder_is_product_tour_enabled() ):
			// load fullwidth page in Product Tour mode
			while ( have_posts() ): the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
					<div class="entry-content">
					<?php
						the_content();
					?>
					</div> <!-- .entry-content -->

				</article> <!-- .et_pb_post -->

		<?php endwhile;
		else:
	?>
	<div class="container">
		<div id="content-area" class="clearfix singleteam">
			<div id="left-area">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				/**
				 * Fires before the title and post meta on single posts.
				 *
				 * @since 3.18.8
				 */
				do_action( 'et_before_post' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?> class="teamdetails">
					<div class="et_pb_row">
					<?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
						<div class="et_post_meta_wrapper et_pb_column et_pb_column_2_5 et_pb_column_22  et_pb_css_mix_blend_mode_passthrough">
							<div class="profile_wrap">
							<?php
								if ( ! post_password_required() ) :

									et_divi_post_meta();

									$thumb = '';

									$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

									$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
									$classtext = 'et_featured_image';
									$titletext = get_the_title();
									$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
									$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
									$thumb = $thumbnail["thumb"];

									$post_format = et_pb_post_format();

									if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) {
										printf(
											'<div class="et_main_video_container">
												%1$s
											</div>',
											et_core_esc_previously( $first_video )
										);
									} else if ( ! in_array( $post_format, array( 'gallery', 'link', 'quote' ) ) && 'on' === et_get_option( 'divi_thumbnails', 'on' ) && '' !== $thumb ) {
										print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
									} else if ( 'gallery' === $post_format ) {
										et_pb_gallery_images();
									}
								?>

								<?php
									$text_color_class = et_divi_get_post_text_color();

									$inline_style = et_divi_get_post_bg_inline_style();

									switch ( $post_format ) {
										case 'audio' :
											$audio_player = et_pb_get_audio_player();

											if ( $audio_player ) {
												printf(
													'<div class="et_audio_content%1$s"%2$s>
														%3$s
													</div>',
													esc_attr( $text_color_class ),
													et_core_esc_previously( $inline_style ),
													et_core_esc_previously( $audio_player )
												);
											}

											break;
										case 'quote' :
											printf(
												'<div class="et_quote_content%2$s"%3$s>
													%1$s
												</div> <!-- .et_quote_content -->',
												et_core_esc_previously( et_get_blockquote_in_content() ),
												esc_attr( $text_color_class ),
												et_core_esc_previously( $inline_style )
											);

											break;
										case 'link' :
											printf(
												'<div class="et_link_content%3$s"%4$s>
													<a href="%1$s" class="et_link_main_url">%2$s</a>
												</div> <!-- .et_link_content -->',
												esc_url( et_get_link_url() ),
												esc_html( et_get_link_url() ),
												esc_attr( $text_color_class ),
												et_core_esc_previously( $inline_style )
											);

											break;
									}
								endif; ?>
							</div>
						</div> <!-- .et_post_meta_wrapper -->
					<?php  } ?>
						<div class="et_pb_column et_pb_column_3_5 et_pb_column_23  et_pb_css_mix_blend_mode_passthrough et-last-child entry-content">
						<?php do_action( 'et_before_content' ); ?>
							<div class="back-team"><a href="<?php echo site_url()?>/team-new/">Back to Team</a></div>
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="team-d">
							<?php $degree = get_field( "degree");
							if($degree): ?>
								<div class="degree"><?php echo $degree; ?></div>
							<?php endif; ?>

							<?php $designation = get_field( "designation");
							if($designation): ?>
								<div class="designation"><?php echo $designation; ?></div>
							<?php endif; ?>
							
							<?php 
							$email = get_field( "email");
							if($email): ?>
								<div class="email"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></div>
							<?php endif; ?>
							</div>
						<?php 
							the_content();

							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
						?>
						</div> <!-- .entry-content -->
					</div>
				</article> <!-- .et_pb_post -->
			<?php endwhile; ?>
			</div> <!-- #left-area -->
			<?php // get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
	<?php endif; ?>
</div> <!-- #main-content -->
<?php

get_footer();