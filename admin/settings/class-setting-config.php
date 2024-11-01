<?php

/**
 * WPB Instagram Slider settings
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WPB_Instagram_Slider_Settings' ) ):
class WPB_Instagram_Slider_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 
            WPB_IS_TEXTDOMAIN . '-about',
            esc_html__( 'WPB Instagram Slider Settings', WPB_IS_TEXTDOMAIN ),
            esc_html__( 'Settings', WPB_IS_TEXTDOMAIN ),
            apply_filters( 'wpb_is_settings_user_capability', 'delete_posts' ),
            WPB_IS_TEXTDOMAIN . '-settings',
            array( $this, 'plugin_page' )
        );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wpb_is_general',
                'title' => esc_html__( 'General Settings', WPB_IS_TEXTDOMAIN )
            ),
            array(
                'id'    => 'wpb_is_slider_settings',
                'title' => esc_html__( 'Slider Settings', WPB_IS_TEXTDOMAIN )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wpb_is_general' => array(
                array(
                    'name'  => 'keep_settings_when_plugin_removed',
                    'label' => esc_html__( 'Keep settings when plugin is removed', WPB_IS_TEXTDOMAIN ),
                    'desc'  => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'    => 'wpb_is_image_size',
                    'label'   => esc_html__( 'Select Image Size', WPB_IS_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Select image size for slider. Default: Low Resolution', WPB_IS_TEXTDOMAIN ),
                    'type'    => 'select',
                    'default' => 'low_resolution',
                    'options' => array(
                        'thumbnail'             => esc_html__( 'Thumbnail. 150 x 150 Px.', WPB_IS_TEXTDOMAIN ),
                        'low_resolution'        => esc_html__( 'Low Resolution. 320 x 320 Px.', WPB_IS_TEXTDOMAIN ),
                        'standard_resolution'   => esc_html__( 'Standard Resolution. 640 x 640 Px.', WPB_IS_TEXTDOMAIN ),
                    )
                ),
                array(
                    'name'    => 'wpb_is_content_type',
                    'label'   => esc_html__( 'Content Type', WPB_IS_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Select content type. Default: Slider', WPB_IS_TEXTDOMAIN ),
                    'type'    => 'select',
                    'default' => 'slider',
                    'options' => array(
                        'slider'  => esc_html__( 'Slider', WPB_IS_TEXTDOMAIN ),
                        'grid'    => esc_html__( 'Grid', WPB_IS_TEXTDOMAIN ),
                    )
                ),
                array(
                    'name'      => 'wpb_is_need_lightbox',
                    'label'     => esc_html__( 'Need LightBox ?', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'      => 'wpb_is_need_follow_btn',
                    'label'     => esc_html__( 'Need Follow Button ?', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'              => 'wpb_is_follow_btn_text',
                    'label'             => esc_html__( 'Follow Button Text', WPB_IS_TEXTDOMAIN ),
                    'placeholder'       => esc_html__( 'Follow on Instagram', WPB_IS_TEXTDOMAIN ),
                    'type'              => 'text',
                    'default'           => esc_html__( 'Follow on Instagram', WPB_IS_TEXTDOMAIN ),
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'      => 'wpb_is_need_lode_more_btn',
                    'label'     => esc_html__( 'Need Load More Button ?', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'              => 'wpb_is_loading_text',
                    'label'             => esc_html__( 'Loading Text', WPB_IS_TEXTDOMAIN ),
                    'placeholder'       => esc_html__( 'Loading...', WPB_IS_TEXTDOMAIN ),
                    'type'              => 'text',
                    'default'           => esc_html__( 'Loading...', WPB_IS_TEXTDOMAIN ),
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'      => 'wpb_is_show_title',
                    'label'     => esc_html__( 'Need Image Caption ?', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'              => 'wpb_is_number_of_images',
                    'label'             => esc_html__( 'Number of Image to Show', WPB_IS_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Default: 20 images.', WPB_IS_TEXTDOMAIN ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => 1,
                    'type'              => 'number',
                    'default'           => 20,
                ),
                array(
                    'name'    => 'wpb_is_grid_column',
                    'label'   => esc_html__( 'Grid Column', WPB_IS_TEXTDOMAIN ),
                    'desc'    => esc_html__( 'Select number of columns for gird. Default: 3 columns', WPB_IS_TEXTDOMAIN ),
                    'type'    => 'select',
                    'default' => 3,
                    'options' => array(
                        1  => esc_html__( '1 Column', WPB_IS_TEXTDOMAIN ),
                        2  => esc_html__( '2 Columns', WPB_IS_TEXTDOMAIN ),
                        3  => esc_html__( '3 Columns', WPB_IS_TEXTDOMAIN ),
                        4  => esc_html__( '4 Columns', WPB_IS_TEXTDOMAIN ),
                        6  => esc_html__( '6 Columns', WPB_IS_TEXTDOMAIN ),
                    )
                )
            ),
            'wpb_is_slider_settings' => array(
                array(
                    'name'              => 'wpb_is_slider_column',
                    'label'             => esc_html__( 'Number of Slider Columns', WPB_IS_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Default: 3 columns.', WPB_IS_TEXTDOMAIN ),
                    'min'               => 0,
                    'max'               => 20,
                    'step'              => 1,
                    'type'              => 'number',
                    'default'           => 3,
                ),
                array(
                    'name'              => 'wpb_is_slider_column_desktopsmall',
                    'label'             => esc_html__( 'Number of Slider Columns in Small Desktop', WPB_IS_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Default: 3 columns.', WPB_IS_TEXTDOMAIN ),
                    'min'               => 0,
                    'max'               => 20,
                    'step'              => 1,
                    'type'              => 'number',
                    'default'           => 3,
                ),
                array(
                    'name'              => 'wpb_is_slider_column_tablet',
                    'label'             => esc_html__( 'Number of Slider Columns in Tablet', WPB_IS_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Default: 2 columns.', WPB_IS_TEXTDOMAIN ),
                    'min'               => 0,
                    'max'               => 20,
                    'step'              => 1,
                    'type'              => 'number',
                    'default'           => 2,
                ),
                array(
                    'name'              => 'wpb_is_slider_column_mobile',
                    'label'             => esc_html__( 'Number of Slider Columns in Mobile', WPB_IS_TEXTDOMAIN ),
                    'desc'              => esc_html__( 'Default: 1 column.', WPB_IS_TEXTDOMAIN ),
                    'min'               => 0,
                    'max'               => 20,
                    'step'              => 1,
                    'type'              => 'number',
                    'default'           => 1,
                ),
                array(
                    'name'      => 'wpb_is_slider_autoplay',
                    'label'     => esc_html__( 'Slider Autoplay', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'      => 'wpb_is_slider_loop',
                    'label'     => esc_html__( 'Slider Loop', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
                array(
                    'name'      => 'wpb_is_slider_navigation',
                    'label'     => esc_html__( 'Slider Navigation', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                ),
                array(
                    'name'      => 'wpb_is_slider_pagination',
                    'label'     => esc_html__( 'Slider Pagination', WPB_IS_TEXTDOMAIN ),
                    'desc'      => esc_html__( 'Yes', WPB_IS_TEXTDOMAIN ),
                    'type'      => 'checkbox',
                    'default'   => 'on',
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap wpb-settings-wrap">';
        settings_errors();
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

new WPB_Instagram_Slider_Settings();