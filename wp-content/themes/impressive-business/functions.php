<?php
require_once (get_template_directory() . '/functions/class-tgm-plugin-activation.php');
function impressive_business_setup() {
	load_theme_textdomain( 'impressive-business',get_template_directory() . '/languages' );	
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus( array(
		'primary'    => esc_html__( 'Top Menu', 'impressive-business' ),
	) );
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	$impressive_business_defaults = array(
		'default-image'          => get_template_directory_uri().'/assets/images/ban1.jpeg',
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => false,
		'default-text-color'     => '',
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $impressive_business_defaults );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
}
add_action( 'after_setup_theme', 'impressive_business_setup' );
function impressive_business_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'impressive_business_content_width', 640 );
}
add_action( 'after_setup_theme', 'impressive_business_content_width', 0 );
add_action( 'admin_menu', 'impressive_business_admin_menu');
function impressive_business_admin_menu( ) {
    add_theme_page( __('Pro Feature','impressive-business'), __('Impressive Business Pro','impressive-business'), 'manage_options', 'impressive-business-pro-buynow', 'impressive_business_pro_buy_now', 300 ); 
  
}
function impressive_business_pro_buy_now(){ ?>  
  <div class="impressive_business_pro_version">
  <a href="<?php echo esc_url('https://voilathemes.com/wordpress-themes/impressive-business-pro/'); ?>" target="_blank">
    <img src ="<?php echo esc_url(get_template_directory_uri().'/assets/images/impressive-business-pro-feature.png') ?>" width="100%" height="auto" />
  </a>
</div>
<?php }
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function impressive_business_widgets_init() {
	register_sidebar( array(
		'name'          		=> esc_html__( 'Sidebar', 'impressive-business' ),
		'id'            		=> 'sidebar-1',
		'romana_description'   	=> esc_html__( 'Add widgets here to appear in your sidebar.', 'impressive-business' ),
		'before_widget' 		=> '<div id="%1$s" class="%2$s about-us-blog"><div class="about-us-blog-sidebar">',
		'after_widget'  		=> '</div></div>',
		'before_title'  		=> '<h4>',
		'after_title'   		=> '</h4>',
	) );	
	register_sidebar( array(
		'name'          		=> esc_html__( 'Footer 1', 'impressive-business' ),
		'id'            		=> 'footer-1',
		'romana_description'	=> esc_html__( 'Add widgets here to appear in your footer.', 'impressive-business' ),
		'before_widget' 		=> '<div id="%1$s" class="%2$s our-work-heding-text tag-text">',
		'after_widget'  		=> '</div>',
		'before_title'  		=> '<h1>',
		'after_title'   		=> '</h1>',
	) );
	register_sidebar( array(
		'name'          		=> esc_html__( 'Footer 2', 'impressive-business' ),
		'id'            		=> 'footer-2',
		'romana_description'   	=> esc_html__( 'Add widgets here to appear in your footer.', 'impressive-business' ),
		'before_widget' 		=> '<div id="%1$s" class="%2$s our-work-heding-text tag-text">',
		'after_widget'  		=> '</div>',
		'before_title'  		=> '<h1>',
		'after_title'   		=> '</h1>',
	) );
	register_sidebar( array(
		'name'          		=> esc_html__( 'Footer 3', 'impressive-business' ),
		'id'            		=> 'footer-3',
		'romana_description'   	=> esc_html__( 'Add widgets here to appear in your footer.', 'impressive-business' ),
		'before_widget' 		=> '<div id="%1$s" class="%2$s our-work-heding-text tag-text">',
		'after_widget'  		=> '</div>',
		'before_title'  		=> '<h1>',
		'after_title'   		=> '</h1>',
	) );
	register_sidebar( array(
		'name'          		=> esc_html__( 'Footer 4', 'impressive-business' ),
		'id'            		=> 'footer-4',
		'romana_description'   	=> esc_html__( 'Add widgets here to appear in your footer.', 'impressive-business' ),
		'before_widget' 		=> '<div id="%1$s" class="%2$s our-work-heding-text tag-text">',
		'after_widget'  		=> '</div>',
		'before_title'  		=> '<h1>',
		'after_title'   		=> '</h1>',
	) );
}
add_action( 'widgets_init', 'impressive_business_widgets_init' );
add_filter('get_custom_logo','impressive_business_change_logo_class');
function impressive_business_change_logo_class($html)
{
    $html = str_replace('class="custom-logo"', 'class="img-responsive logo-light"', $html);
    $html = str_replace('width=', 'original-width=', $html);
    $html = str_replace('height=', 'original-height=', $html);
    $html = str_replace('class="custom-logo-link"', 'class="img-responsive logo-light"', $html);
    return $html;
}


add_action( 'impressive_business_tgm_register', 'impressive_business_tgm_register_required_plugins' );
function impressive_business_tgm_register_required_plugins() {
    if(class_exists('Impressive_Business_TGM_Plugin_Activation')){
      $plugins = array(
        array(
           'name'      => __('Page Builder by SiteOrigin','impressive-business'),
           'slug'      => 'siteorigin-panels',
           'required'  => false,
        ),
        array(
           'name'      => __('SiteOrigin Widgets Bundle','impressive-business'),
           'slug'      => 'so-widgets-bundle',
           'required'  => false,
        ),
        array(
           'name'      => __('Contact Form 7','impressive-business'),
           'slug'      => 'contact-form-7',
           'required'  => false,
        ),
      );
      $config = array(
        'default_path' => '',
        'menu'         => 'impressive-business-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
           'page_title'                      => __( 'Install Recommended Plugins', 'impressive-business' ),
           'menu_title'                      => __( 'Install Plugins', 'impressive-business' ),
           'installing'                      => /* translators: 1 is plugin title. */ __(  'Installing Plugin: %s', 'impressive-business' ),           
           'return'                          => __( 'Return to Required Plugins Installer', 'impressive-business' ),
           'plugin_activated'                => __( 'Plugin activated successfully.', 'impressive-business' ),
           'complete'                        => /* translators: %s is count.*/ __( 'All plugins installed and activated successfully. %s', 'impressive-business' ), 
           'nag_type'                        => 'updated'
        )
      );
      impressive_business_tgm( $plugins, $config );
    }
}


//activate widgets start

add_filter('siteorigin_widgets_active_widgets', 'impressive_business_active_widgets');
	function impressive_business_active_widgets($active){
	//Theme widgets

    //Bundled Widgets
    $active['video'] = true;
    $active['testimonial'] = true;
    $active['taxonomy'] = true;
    $active['social-media-buttons'] = true;
    $active['simple-masonry'] = true;
    $active['slider'] = true;
    $active['cta'] = true;
    $active['contact'] = true;
    $active['features'] = true;
    $active['headline'] = true;
    $active['hero'] = true;
    $active['icon'] = true;
    $active['image-grid'] = true;
    $active['price-table'] = true;
    $active['layout-slider'] = true;
  	$active['key-features-widget'] = true;
  	$active['showcase-image-widget'] = true;
  	return $active;
  }

//activate widgets end
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 */
function impressive_business_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}
	$link = sprintf( '<div class="subscribe-btn"><a href="%1$s" class="btn btn-primary animated fadeInDown" data-animation="animated fadeInDown">%2$s</a></div>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		esc_html__( 'Read More', 'impressive-business' )
	);
	return $link;
}
add_filter( 'excerpt_more', 'impressive_business_excerpt_more' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function impressive_business_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_html(get_bloginfo( 'pingback_url' )) );
	}
}
add_action( 'wp_head', 'impressive_business_pingback_header' );


function impressive_business_comment_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$label     = $req ? '*' : ' ' . __( '(optional)', 'impressive-business' );
	$aria_req  = $req ? "aria-required='true'" : '';
	$fields['author'] =
		'<p class="comment-form-author">
			<label for="author">' . __( "Name", "impressive-business" ) . esc_html($label) . '</label>
			<input id="author" name="author" type="text" placeholder="' . esc_attr__( "Full Name", "impressive-business" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30" ' . esc_html($aria_req) . ' />
		</p>';
	$fields['email'] =
		'<p class="comment-form-email">
			<label for="email">' . __( "Email", "impressive-business" ) . esc_html($label) . '</label>
			<input id="email" name="email" type="email" placeholder="' . esc_attr__( "Email", "impressive-business" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
		'" size="30" ' . esc_html($aria_req) . ' />
		</p>';
	$fields['url'] =
		'<p class="comment-form-url">
			<label for="url">' . __( "Website", "impressive-business" ) . '</label>
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__( "Website", "impressive-business" ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" />
			</p>';
	return $fields;
}
add_filter( 'comment_form_default_fields', 'impressive_business_comment_fields' );
function impressive_business_comment_field( $comment_field ) {
	$comment_field =
    '<p class="comment-form-comment">
            <label for="comment">' . __( "Comment", "impressive-business" ) . '</label>
            <textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Enter comment Message...", "impressive-business" ) . '" cols="45" rows="8" aria-required="true"></textarea>
        </p>';
	return $comment_field;
}
add_filter( 'comment_form_field_comment', 'impressive_business_comment_field' );

function impressive_business_enqueues(){
	wp_enqueue_style( 'impressive-business-google-fonts-api', '//fonts.googleapis.com/css?family=Montserrat%3Aregular%2C700%26subset%3Dcyrillic%2Ccyrillic-ext%2Cdevanagari%2Cgreek%2Cgreek-ext%2Ckhmer%2Clatin%2Clatin-ext%2Cvietnamese', array(), null );
	wp_enqueue_style('bootstrap',get_template_directory_uri().'/assets/css/bootstrap.css', array() );
	wp_enqueue_style('owl-carousel',get_template_directory_uri().'/assets/css/owl.carousel.css', array() );

	wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/css/font-awesome.css', array() );
	wp_enqueue_style('impressive-business-default-css',get_template_directory_uri().'/assets/css/default.css', array(), null, 'all' );	
	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/assets/js/bootstrap.js', array('jquery'));
	wp_enqueue_script('owl-carousel',get_template_directory_uri().'/assets/js/owl.carousel.js', array('jquery'),null,null);
	wp_enqueue_script('impressive-business-default-js',get_template_directory_uri().'/assets/js/default.js', array('jquery'), null, true);		
	

	impressive_business_dynamic_styles();
}
add_action('wp_enqueue_scripts','impressive_business_enqueues');

include get_template_directory().'/inc/theme-customization.php';
include get_template_directory().'/inc/breadcumbs.php';
include get_template_directory().'/inc/widgets.php';