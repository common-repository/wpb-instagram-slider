<?php

/**
 * WPB Instagram Slider Plugin
 *
 * Template file for admin page
 *
 * Author: WpBean
 */

wp_enqueue_style( 'wpb-is-admin' );
wp_enqueue_script( 'wpb-is-admin-js' );

$wpb_is_access_token = get_option('wpb_is_access_token');
$wpb_is_user_id = get_option('wpb_is_user_id');

$wpb_is_plugin_data = get_plugin_data( WPB_IS_PLUGIN_DIR_FILE );
$version = $wpb_is_plugin_data['Version'];
?>

<div class="wrap wpb-about-wrap">
	<h2 class="nav-tab-wrapper">
        <a href="#wpb_is_welcome" class="nav-tab" id="wpb_is_welcome-tab"><?php esc_html_e( 'Welcome', WPB_IS_TEXTDOMAIN ) ?></a>
        <a href="#wpb_is_use" class="nav-tab" id="wpb_is_use-tab"><?php esc_html_e( 'How To Use', WPB_IS_TEXTDOMAIN ) ?></a>
        <a href="#wpb_is_shortcode" class="nav-tab" id="wpb_is_use-tab"><?php esc_html_e( 'ShortCode', WPB_IS_TEXTDOMAIN ) ?></a>
		<a href="#wpb_is_shortcode_parameters" class="nav-tab" id="wpb_is_use-tab"><?php esc_html_e( 'ShortCode Parameters', WPB_IS_TEXTDOMAIN ) ?></a>
	</h2>
	<div class="metabox-holder">
		<div id="wpb_is_welcome" class="group">
			<h1><?php esc_html_e( 'WPB Instagram Slider - ' . esc_html( $version ), WPB_IS_TEXTDOMAIN );?></h1>
			<div class="wpb-about-text">
				<?php esc_html_e( 'This plugin helps you by showing the Instagram images slider in your site. It comes with a nice and clean design, image LightBox popup, Image Grid etc. All the customization options are available in the plugin settings.', WPB_IS_TEXTDOMAIN );?>
			</div>
			<div class="wpb_plugin_btns">
                <?php if( $wpb_is_access_token == '' || $wpb_is_user_id == '' ): ?>
				    <a class="wpb_button wpb_button_lg wpb_button_success" href="https://instagram.com/oauth/authorize/?client_id=81379547dcf44db19ed8aae77e7fb652&scope=basic+public_content&redirect_uri=https://wpbean.com/plugins/instagram_slider?instagram_return_uri=<?php echo admin_url('admin.php?page=wpb-instagram-slider-about'); ?>&response_type=token"><?php echo esc_html__('Log in to Instagram account and click here to get your Access Token and User ID', WPB_IS_TEXTDOMAIN ); ?></a>
                <?php else: ?>
                    <?php printf( '<div class="alert alert-success"> <strong>%s</strong> %s</div>', esc_html__( 'Well done!', WPB_IS_TEXTDOMAIN ), esc_html__( 'You successfully configure the Access Token and User ID', WPB_IS_TEXTDOMAIN ) ) ?>
                <?php endif; ?>
			</div>

            <?php settings_errors(); ?>
            <form class="wpb-is-configure-access-token" method="post" action="options.php">
                <?php settings_fields('wpb_is_settings'); ?>
                <?php do_settings_sections('wpb_is_options'); ?>
                <?php submit_button(); ?>
            </form>
		</div>

        <div id="wpb_is_use" class="group">
            <h3><?php esc_html_e( 'How to use:', WPB_IS_TEXTDOMAIN );?></h3>
            <ol>
                <li>Install it as a regular WordPress plugin</li>
                <li>After install the plugin make sure you configure your Instagram Access Token with this plugin.</li>
                <li>Use this plugin’s ShortCode to show the Instagram slider or grid in your site.</li>
            </ol>
        </div>

        <div id="wpb_is_shortcode" class="group">
            <h3><?php esc_html_e( 'ShortCode:', WPB_IS_TEXTDOMAIN );?></h3>
            <ol>
                <li><b>Default Use</b><input type="text" value='[wpb_instagram_slider]'></li>
                <li><b>Content type Grid, Number of columns</b><input type="text" value='[wpb_instagram_slider content_type="grid" column="3"]'></li>
                <li><b>Content type Slider</b><input type="text" value='[wpb_instagram_slider content_type="slider"]'></li>
                <li><b>Image Count</b><input type="text" value='[wpb_instagram_slider count="6"]'></li>
                <li><b>Image size</b><input type="text" value='[wpb_instagram_slider image_size="low_resolution"]'></li>
                <li><b>Show in Sidebar</b><input type="text" value='[wpb_instagram_slider content_type="grid" column="3" count="6" show_follow_btn="off" show_load_more_btn="off" show_in_sidebar="on"]'></li>
            </ol>
        </div>

        <div id="wpb_is_shortcode_parameters" class="group">
            <h3><?php esc_html_e( 'ShortCode Parameters:', WPB_IS_TEXTDOMAIN );?></h3>

            <ol>
                <li><b>content_type</b>Content type. Accepted values: slider, grid. Default value: slider</li>
                <li><b>column</b>Grid column. Accepted values: 1, 2, 3, 4, 6. Default value: 3</li>
                <li><b>count</b>Number of images to show. Accepted values: any number. Default value: 20</li>
                <li><b>image_size</b>Image Size. Accepted values: thumbnail, low_resolution, standard_resolution. Default value: low_resolution</li>
                <li><b>lightbox</b>Need lightbox or not. Accepted values: on, off. Default value: on</li>
                <li><b>show_load_more_btn</b>Show load more button. Accepted values: on, off. Default value: on</li>
                <li><b>show_follow_btn</b>Show Instagram follow button. Accepted values: on, off. Default value: on</li>
                <li><b>show_caption</b>Show image caption. Accepted values: on, off. Default value: on</li>
                <li><b>pagination</b>Show slider pagination. Accepted values: on, off. Default value: on</li>
                <li><b>navigation</b>Show slider navigation. Accepted values: on, off. Default value: off</li>
                <li><b>autoplay</b>Slider autoplay. Accepted values: on, off. Default value: on</li>
                <li><b>loop</b>Slider loop. Accepted values: on, off. Default value: on</li>
                <li><b>items</b>Slider columns in normal screen. Accepted values: any number. Default value: 3</li>
                <li><b>desktopsmall</b>Slider columns in desktop small. Accepted values: any number. Default value: 3</li>
                <li><b>tablet</b>Slider columns in tablet. Accepted values: any number. Default value: 2</li>
                <li><b>mobile</b>Slider columns in mobile. Accepted values: any number. Default value: 2</li>
                <li><b>show_in_sidebar</b>It apply some CSS style for showing the images nice in sidebar area. Accepted values: on, off. Default value: off</li>
            </ol>
        </div>    
	</div>	
</div>

<div class="clear"></div>

<div class="wpb_wpbean_socials">
    <h4><?php esc_html_e( 'For getting updates of our plugins, features update, WordPress new trend, New web technology etc. Follows Us.', WPB_IS_TEXTDOMAIN );?></h4>
    <a href="https://twitter.com/wpbean" title="Follow us on Twitter" class="wpb_twitter" target="_blank"><?php esc_html_e( 'Follow Us On Twitter', WPB_IS_TEXTDOMAIN );?></a>
    <a href="https://plus.google.com/u/0/+WpBean/posts" title="Follow us on Google+" class="wpb_googleplus" target="_blank"><?php esc_html_e( 'Follow Us On Google Plus', WPB_IS_TEXTDOMAIN );?></a>
    <a href="https://www.facebook.com/wpbean" title="Follow us on Facebook" class="wpb_facebook" target="_blank"><?php esc_html_e( 'Like Us On FaceBook', WPB_IS_TEXTDOMAIN );?></a>
    <a href="https://www.youtube.com/user/wpbean/videos" title="Follow us on Youtube" class="wpb_youtube" target="_blank"><?php esc_html_e( 'Subscribe Us on YouTube', WPB_IS_TEXTDOMAIN );?></a>
    <a href="https://wpbean.com/support/" title="Get Support" class="wpb_support" target="_blank"><?php esc_html_e( 'Get Support', WPB_IS_TEXTDOMAIN );?></a>
    <a href="http://docs.wpbean.com/docs/wpb-instagram-gallery-slider-and-grid/installing/" title="Documentation" class="wpb_documentation" target="_blank"><?php esc_html_e( 'Online Documentation', WPB_IS_TEXTDOMAIN );?></a>
</div>

<script>
    jQuery(document).ready(function($) {

        // Switches option sections
        $('.group').hide();
        var activetab = '';
        if (typeof(localStorage) != 'undefined' ) {
            activetab = localStorage.getItem("activetab");
        }
        if (activetab != '' && $(activetab).length ) {
            $(activetab).fadeIn();
        } else {
            $('.group:first').fadeIn();
        }
        $('.group .collapsed').each(function(){
            $(this).find('input:checked').parent().parent().parent().nextAll().each(
            function(){
                if ($(this).hasClass('last')) {
                    $(this).removeClass('hidden');
                    return false;
                }
                $(this).filter('.hidden').removeClass('hidden');
            });
        });

        if (activetab != '' && $(activetab + '-tab').length ) {
            $(activetab + '-tab').addClass('nav-tab-active');
        }
        else {
            $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
        }
        $('.nav-tab-wrapper a').click(function(evt) {
            $('.nav-tab-wrapper a').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active').blur();
            var clicked_group = $(this).attr('href');
            if (typeof(localStorage) != 'undefined' ) {
                localStorage.setItem("activetab", $(this).attr('href'));
            }
            $('.group').hide();
            $(clicked_group).fadeIn();
            evt.preventDefault();
        });

        $(".wpb-about-wrap input[type='text']").on("click", function () {
		   $(this).select();
		});
	});
</script>