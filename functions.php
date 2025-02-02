<?php
/**
 * Membership functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Membership
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function membership_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Membership, use a find and replace
		* to change 'membership' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'membership', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'membership' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'membership_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'membership_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function membership_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'membership_content_width', 640 );
}
add_action( 'after_setup_theme', 'membership_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function membership_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'membership' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'membership' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'membership_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function membership_scripts() {
	

	wp_enqueue_style( 'membership-standard', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'membership-style', get_template_directory_uri() . '/assets/css/main.css' , array(), _S_VERSION );
	wp_style_add_data( 'membership-style', 'rtl', 'replace' );

	wp_enqueue_script( 'membership-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script(
        'theme-scripts',
        get_template_directory_uri() . '/assets/js/dist/main.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'membership_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function add_mepr_product_identifier_meta_box() {
    add_meta_box(
        'mepr-product-identifier',
        __('Product Settings', 'your-text-domain'), 
        'render_mepr_product_identifier_meta_box',
        'memberpressproduct',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_mepr_product_identifier_meta_box');

function render_mepr_product_identifier_meta_box($post) {
    $product_id = get_post_meta($post->ID, '_mepr_product_identifier', true);
    $hide_box = get_post_meta($post->ID, '_mepr_hide_box', true);
    
    wp_nonce_field('mepr_product_settings_nonce', 'mepr_product_settings_nonce');
    ?>
    <div style="margin-bottom: 15px;">
        <label for="mepr_product_identifier" style="display: block; margin-bottom: 5px;">
            <?php _e('Product ID:', 'your-text-domain'); ?>
        </label>
        <input type="text" id="mepr_product_identifier" name="mepr_product_identifier" 
               value="<?php echo esc_attr($product_id); ?>" style="width:100%;">
    </div>

    <div>
        <label for="mepr_hide_box" style="display: block; margin-bottom: 5px;">
            <input type="checkbox" id="mepr_hide_box" name="mepr_hide_box" 
                <?php checked($hide_box, 'on'); ?>>
            <?php _e('Hide Box', 'your-text-domain'); ?>
        </label>
        <p class="description"><?php _e('Check to hide this product', 'your-text-domain'); ?></p>
    </div>
    <?php
}

function save_mepr_product_identifier_meta($post_id) {
    if (!isset($_POST['mepr_product_settings_nonce']) || 
        !wp_verify_nonce($_POST['mepr_product_settings_nonce'], 'mepr_product_settings_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['mepr_product_identifier'])) {
        update_post_meta(
            $post_id,
            '_mepr_product_identifier',
            sanitize_text_field($_POST['mepr_product_identifier'])
        );
    }

    $hide_box = isset($_POST['mepr_hide_box']) ? 'on' : 'off';
    update_post_meta($post_id, '_mepr_hide_box', $hide_box);
}
add_action('save_post_memberpressproduct', 'save_mepr_product_identifier_meta');



// NEW CUSTOM FIELDS

function add_memberpress_custom_fields() {
    add_meta_box(
        'memberpress_price_fields',
        'Price Display Settings',
        'render_memberpress_price_fields',
        'memberpressproduct'
    );
}
add_action('add_meta_boxes', 'add_memberpress_custom_fields');

function render_memberpress_price_fields($post) {
    wp_nonce_field('memberpress_price_fields', 'memberpress_price_fields_nonce');

    $card_price = get_post_meta($post->ID, '_card_price_display', true);
    $price_description = get_post_meta($post->ID, '_card_price_description', true);
    ?>
    <div class="memberpress-custom-fields">
        <p>
            <label for="card_price_display"><strong>Card Price Display:</strong></label>
            <input type="text" 
                   id="card_price_display" 
                   name="card_price_display" 
                   value="<?php echo wp_kses_post($card_price); ?>" 
                   class="widefat">
            <span class="description">Enter the price to be displayed on the card. HTML tags like &lt;span&gt; are allowed.</span>
        </p>
        
        <p>
            <label for="card_price_description"><strong>Price Description:</strong></label>
            <textarea id="card_price_description" 
                      name="card_price_description" 
                      class="widefat" 
                      rows="4"><?php echo wp_kses_post($price_description); ?></textarea>
            <span class="description">Enter the description for the price. HTML formatting is allowed.</span>
        </p>
    </div>
    <?php
}

function save_memberpress_price_fields($post_id) {
    if (!isset($_POST['memberpress_price_fields_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['memberpress_price_fields_nonce'], 'memberpress_price_fields')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $allowed_html = array(
        'span' => array(
            'class' => array(),
            'id' => array(),
            'style' => array()
        ),
        'strong' => array(),
        'em' => array(),
        'br' => array(),
        'p' => array(
            'class' => array()
        )
    );

    if (isset($_POST['card_price_display'])) {
        update_post_meta(
            $post_id,
            '_card_price_display',
            wp_kses($_POST['card_price_display'], $allowed_html)
        );
    }

    if (isset($_POST['card_price_description'])) {
        update_post_meta(
            $post_id,
            '_card_price_description',
            wp_kses($_POST['card_price_description'], $allowed_html)
        );
    }
}
add_action('save_post_memberpressproduct', 'save_memberpress_price_fields');

function get_memberpress_price_fields($post_id) {
    return array(
        'card_price' => get_post_meta($post_id, '_card_price_display', true),
        'price_description' => get_post_meta($post_id, '_card_price_description', true)
    );
}

function display_memberpress_card_price($post_id) {
    $price = get_post_meta($post_id, '_card_price_display', true);
    return wp_kses_post($price);
}

function formatPrice($price) {
    if ($price === 'Free') {
        return 'Free';
    }
    
    if (strpos($price, '/month') !== false) {
        $price_parts = explode('/', $price);
        $price_value = trim($price_parts[0]);
        
        return sprintf(
            '%s <span class="period">/month</span>',
            $price_value
        );
    }else if (strpos($price, '/year') !== false) {
		$price_parts = explode('/', $price);
		$price_value = trim($price_parts[0]);
		
		return sprintf(
			'%s <span class="period">/year</span>',
			$price_value
		);
	}
    
    return sprintf('<h2 class="price">%s</h2>', $price);
}

function mytheme_add_theme_page() {
    add_menu_page(
        'Theme Options', 
        'Theme Options', 
        'manage_options', 
        'theme-options', 
        'mytheme_theme_options_page', 
        'dashicons-admin-generic' 
    );
}
add_action('admin_menu', 'mytheme_add_theme_page');

function mytheme_register_settings() {
    register_setting(
        'mytheme_options', 
        'mytheme_header_text', 
        array(
            'sanitize_callback' => 'wp_kses_post' 
        )
    );

    register_setting(
        'mytheme_options', 
        'mytheme_benefits_list',
        array(
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
}
add_action('admin_init', 'mytheme_register_settings');


function mytheme_theme_options_page() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('mytheme_options');
            do_settings_sections('mytheme_options');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="mytheme_header_text">Header Text</label>
                    </th>
                    <td>
                        <textarea 
                            id="mytheme_header_text" 
                            name="mytheme_header_text" 
                            rows="5" 
                            cols="50" 
                            class="large-text"
                        ><?php echo wp_kses_post(get_option('mytheme_header_text')); ?></textarea>
                        <p class="description">Enter the text you want to display in the header. HTML is allowed.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mytheme_benefits_list">List All Benefits</label>
                    </th>
                    <td>
                        <textarea 
                            id="mytheme_benefits_list" 
                            name="mytheme_benefits_list" 
                            rows="8" 
                            cols="50" 
                            class="large-text"
                        ><?php echo wp_kses_post(get_option('mytheme_benefits_list')); ?></textarea>
                        <p class="description">Enter the list of benefits. Type enter for a new line.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function mytheme_get_benefits_array() {
    $benefits_text = get_option('mytheme_benefits_list');
    if (empty($benefits_text)) {
        return array();
    }
    
    $benefits = array_filter(
        explode("\n", $benefits_text),
        function($line) {
            return trim($line) !== '';
        }
    );
    
    $benefits = array_map('trim', $benefits);
    
    return array_values($benefits); 
}

/**
 * Display the header text
 */
 function mytheme_display_header_text() {
    $header_text = get_option('mytheme_header_text');
    if (!empty($header_text)) {
        echo '<h1 class="text-center mb-5 header-white">' . wp_kses_post($header_text) . '</h1>';
    }
}

/**
 * Display the benefits list
 */
function mytheme_display_benefits_list() {
    $benefits_list = get_option('mytheme_benefits_list');
    if (!empty($benefits_list)) {
        echo '<div class="site-benefits-list">' . wp_kses_post($benefits_list) . '</div>';
    }
}
?>