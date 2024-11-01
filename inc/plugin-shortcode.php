<?php

/**
 * Plugin shortcode
 * Author : WpBean
 */



/**
 * instagram slider shortcode 
 */

add_shortcode( 'wpb_instagram_slider', 'wpb_instagram_slider_shortcode' );

if( !function_exists('wpb_instagram_slider_shortcode') ){
	function wpb_instagram_slider_shortcode( $atts ) {

		extract( shortcode_atts(
			array(
				'autoplay'				=> ( wpb_is_get_option( 'wpb_is_slider_autoplay', 'wpb_is_slider_settings', 'on' ) == 'on' ? 'true' : 'false' ),
				'loop'					=> ( wpb_is_get_option( 'wpb_is_slider_loop', 'wpb_is_slider_settings', 'on' ) == 'on' ? 'true' : 'false' ),
				'items'					=> wpb_is_get_option( 'wpb_is_slider_column', 'wpb_is_slider_settings', 3 ),
				'desktopsmall'			=> wpb_is_get_option( 'wpb_is_slider_column_desktopsmall', 'wpb_is_slider_settings', 3 ),
				'tablet'				=> wpb_is_get_option( 'wpb_is_slider_column_tablet', 'wpb_is_slider_settings', 2 ),
				'mobile'				=> wpb_is_get_option( 'wpb_is_slider_column_mobile', 'wpb_is_slider_settings', 1 ),
				'navigation'			=> ( wpb_is_get_option( 'wpb_is_slider_navigation', 'wpb_is_slider_settings', 'off' ) == 'on' ? 'true' : 'false' ),
				'pagination'			=> ( wpb_is_get_option( 'wpb_is_slider_pagination', 'wpb_is_slider_settings', 'on' ) == 'on' ? 'true' : 'false' ),
				'show_caption'			=> wpb_is_get_option( 'wpb_is_show_title', 'wpb_is_general', 'on' ),
				'show_follow_btn'		=> wpb_is_get_option( 'wpb_is_need_follow_btn', 'wpb_is_general', 'on' ),
				'btn_text'				=> wpb_is_get_option( 'wpb_is_follow_btn_text', 'wpb_is_general', esc_html__( 'Follow on Instagram', WPB_IS_TEXTDOMAIN ) ),
				'show_load_more_btn'	=> wpb_is_get_option( 'wpb_is_need_lode_more_btn', 'wpb_is_general', 'on' ),
				'loading_text'			=> wpb_is_get_option( 'wpb_is_loading_text', 'wpb_is_general', esc_html__( 'Loading..', WPB_IS_TEXTDOMAIN ) ),
				'lightbox'				=> wpb_is_get_option( 'wpb_is_need_lightbox', 'wpb_is_general', 'on' ),
				'content_type'			=> wpb_is_get_option( 'wpb_is_content_type', 'wpb_is_general', 'slider' ),
				'wpb_is_type'			=> 'default',
				'image_size'			=> wpb_is_get_option( 'wpb_is_image_size', 'wpb_is_general', 'low_resolution' ),
				'count'					=> wpb_is_get_option( 'wpb_is_number_of_images', 'wpb_is_general', 20 ),
				'column'				=> wpb_is_get_option( 'wpb_is_grid_column', 'wpb_is_general', 3 ),
				'show_in_sidebar'		=> 'off', // on
			), $atts )
		);

		if( $content_type == 'grid' ){
			wp_enqueue_style('wpb-is-bootstrap-grid');
		}

		if( $lightbox == 'on' ){
			wp_enqueue_script('lightcase');
			wp_enqueue_style('lightcase');
		}

		wp_enqueue_script('instafeed');
		wp_enqueue_script('match-height');
		wp_enqueue_script('wpb-is-main');
		wp_enqueue_style('wpb-is-main');

		$wrapper_classes = array( 'wpb-is-wrapper', 'wpb-is-content-type-'.$content_type, 'wpb-is-wpb_is_type-'.$wpb_is_type  );

		if( $content_type == 'grid' ){
			$wrapper_classes[] = 'row';
			$wrapper_classes[] = 'row-eq-height';
		}

		if( $show_in_sidebar == 'on' ){
			$wrapper_classes[] = 'sidebar-view-enable';
		}

		if( $content_type == 'slider' ){
			$wrapper_classes[] = 'owl-theme owl-carousel';
		}

		$column = apply_filters( 'wpb_is_grid_column', $column );
		if( $column ){
			$column = 12/$column;
			$column = 'wpb-is-col-md-'.$column . ' wpb-is-col-sm-6';
		}

		$userid 		= get_option( 'wpb_is_user_id' );
		$accesstoken	= get_option( 'wpb_is_access_token' );

		$username = '';
		$user_info = wp_remote_get( "https://api.instagram.com/v1/users/" . $userid . "/?access_token=" . $accesstoken );
		$instagram_user_response = json_decode( $user_info['body'] );

		if( $user_info['response']['code'] == 200 ) {
			$username = $instagram_user_response->data->username;
		}

		$data_attributes = array(
			'userid'				=> $userid,
			'contenttype'			=> $content_type,
			'column'				=> $column,
			'count'					=> $count,
			'image_size'			=> $image_size,
			'lightbox'				=> $lightbox,
			'caption'				=> $show_caption,
		);

		$data_attributes_slider = array(
	    	'loop'				=> $loop,
	    	'autoplay'			=> $autoplay,
	    	'navigation'		=> $navigation,
	    	'pagination'		=> $pagination,
	    	'items'				=> $items,
	    	'desktopsmall'		=> $desktopsmall,
	    	'tablet'			=> $tablet,
	    	'mobile'			=> $mobile,
	    	'direction'			=> ( is_rtl() ? 'true' : 'false' ),
	    );

		if( $content_type == 'slider' ){
			$data_attributes = array_merge( $data_attributes, $data_attributes_slider );
		}	    

	    $data_attributes = apply_filters( 'wpb_is_data_attributes', $data_attributes );

		ob_start();

		?>

		<?php if( $userid && $accesstoken ): ?>

			<div class="wpb-instragram-feed-wrapper">
				<div class="wpb-instragram-feed <?php echo esc_attr( apply_filters( 'wpb_is_wrapper_class', implode( ' ', $wrapper_classes ) ) ); ?>" id="wpb-instragram-feed-<?php echo rand(1000, 10000); ?>" <?php echo implode (' ', wpb_is_data_attributes( $data_attributes ) ); ?>></div>
				
				<div class="wpb-is-btns-wrapper">
					<?php if( $show_load_more_btn == 'on' ): ?><a href="#" class="wpb-instragram-load-more wpb-is-btn"><?php esc_html_e( 'Load More', WPB_IS_TEXTDOMAIN ); ?></a><?php endif; ?>
					<?php if( $show_follow_btn == 'on' ): ?><a class="wpb-is-btn wpb-is-btn-follow" href="https://www.instagram.com/<?php echo esc_html( $username )?>" target="_blank"><i class="flaticon-instagram-1"></i><?php echo esc_html( $btn_text ); ?></a><?php endif; ?>
				</div>
			</div>

			<script type="text/javascript">
				var wpb_instagram_js_options = { "wpb_instagram_accesstoken":"<?php echo trim( $accesstoken ); ?>" };
				var wpb_instagram_loading_text_options = { "wpb_is_loading_text":"<?php echo esc_html( $loading_text ); ?>" };
			</script>

		<?php else: ?>

			<div class='wpb-is-error'><b><?php esc_html_e( 'Something went wrong! Make Sure you configure your Access Token in plugin page.', WPB_IS_TEXTDOMAIN ) ?></b></div>

		<?php endif; ?>	

		<?php
		return ob_get_clean();
	}
}