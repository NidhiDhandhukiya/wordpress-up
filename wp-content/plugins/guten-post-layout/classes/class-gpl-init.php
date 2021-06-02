<?php
/**
 * GPL Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package gpl
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if( !class_exists('GPL_Init') ){
	class GPL_Init{

        private $block_obj;

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	
	
		/**
		 * Constructor
		 */
		public function __construct() {
		    $this->blocks();

            add_action( 'after_setup_theme',  array($this, 'image_sizes') );
			// Hook: Frontend assets.
			add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'front_end_assets' ) );
			
			// Hook: Editor assets.
			add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );
			
			add_filter( 'block_categories', array( $this, 'register_block_category' ), 1, 2 );
			add_action( 'after_setup_theme', array( $this, 'guten_post_layout_blocks_plugin_setup') );


            add_action('wp_ajax_gpl_post_filter', array($this, 'gpl_post_filter_callback'));
            add_action('wp_ajax_nopriv_gpl_post_filter', array($this, 'gpl_post_filter_callback'));
		}


        /**
         * Add image sizes
         */
        public function image_sizes() {
            add_image_size( 'guten_post_layout_landscape_large', 1200, 800, true );
            add_image_size( 'guten_post_layout_portrait_large', 1200, 1800, true );
            add_image_size( 'guten_post_layout_square_large', 1200, 1200, true );
            add_image_size( 'guten_post_layout_landscape', 600, 400, true );
            add_image_size( 'guten_post_layout_portrait', 600, 900, true );
            add_image_size( 'guten_post_layout_square', 600, 600, true );
        }

		public function blocks(){
            require_once GUTEN_POST_LAYOUT_DIR_PATH.'src/blocks/post-grid/post-grid.php';

            $this->block_obj['grid'] = new GPL_POST_GRID();
        }


        public function gpl_post_filter_callback(){

            if ( !wp_verify_nonce($_REQUEST['wpnonce'], 'gpl-nonce') ) {
                return ;
            }

            $filtertype      = sanitize_text_field($_POST['filtertype']);
            $taxonomy      = sanitize_text_field($_POST['taxonomy']);
            $postId        =    intval($_POST['postId']);
            $blockRaw   = sanitize_text_field($_POST['blockName']);
            $blockName  = str_replace('_','/', $blockRaw);

            if($filtertype) {
                $post = get_post($postId);

                if (has_blocks($post->post_content)) {
                    $blocks = parse_blocks($post->post_content);
                    $this->filter_post_return($blocks, $blockRaw, $blockName, $filtertype, $taxonomy);
                }

            }

        }


        public function filter_post_return($blocks, $blockRaw, $blockName, $filtertype, $taxonomy){

            foreach ($blocks as $key => $value) {
                if($blockName == $value['blockName']) {

                        $attr = $this->block_obj['grid']->get_attributes(true);

                         $value['attrs']['queryTaxonomy'] = $filtertype == 'categories' ? 'categories' : 'tags';

                        if($filtertype == 'categories' && $taxonomy) {
                            $value['attrs']['queryCat'] = $taxonomy;
                        }

                        if($filtertype == 'tags' && $taxonomy) {
                            $value['attrs']['queryTag'] = $taxonomy;
                        }

                        if(isset($value['attrs']['postscount'])){

                            $value['attrs']['postscount'] = $value['attrs']['postscount'];
                        }

                        $attr = array_merge($attr, $value['attrs']);


                        echo $this->block_obj['grid']->content($attr, true);

                        die();

                }
                if(!empty($value['innerBlocks'])){
                    $this->filter_post_return($value['innerBlocks'], $blockRaw, $blockName, $filtertype, $taxonomy);
                }
            }
        }
		
		public function register_block_category($categories, $post) {
			return array_merge(
				array(
					array(
						'slug'  => 'guten-post-layout',
						'title' => __('Guten Post Layout', 'guten-post-layout')
					),
				),
				$categories
			);
	
		}
		
		public function guten_post_layout_blocks_plugin_setup() {
			if (!current_theme_supports('align-wide')) {
				add_theme_support( 'align-wide' );
			}
		}
	
	    public function block_assets(){
            $hast_guten_post_layout = false;

            if ( function_exists( 'has_blocks' ) && has_blocks( get_the_ID() ) ) {
                $post = get_post();

                if (!is_object($post)) {
                    return;
                }

                if ( has_blocks( $post->post_content ) ) {
                    $blocks = parse_blocks($post->post_content);

                    $blockname = array_column($blocks, 'blockName');

                    $hast_guten_post_layout = in_array('guten-post-layout/post-grid', $blockname);
                }
            }

            if( $hast_guten_post_layout ) {
                wp_enqueue_style(
                    'guten-post-layout-style-css',
                    GUTEN_POST_LAYOUT_DIR_URL . 'dist/blocks.style.build.css',
                    array(),
                    filemtime(GUTEN_POST_LAYOUT_DIR_PATH . 'dist/blocks.style.build.css')
                );

                wp_enqueue_style(
                    'slick',
                    GUTEN_POST_LAYOUT_DIR_URL . 'src/assets/css/slick.css',
                    array(),
                    filemtime(GUTEN_POST_LAYOUT_DIR_PATH . 'src/assets/css/slick.css')
                );

                wp_enqueue_style(
                    'slick-theme',
                    GUTEN_POST_LAYOUT_DIR_URL . 'src/assets/css/slick-theme.css',
                    array(),
                    filemtime(GUTEN_POST_LAYOUT_DIR_PATH . 'src/assets/css/slick-theme.css')
                );


                wp_register_script(
                    'slick',
                    GUTEN_POST_LAYOUT_DIR_URL . 'src/assets/js/slick.min.js',
                    array('jquery'),
                    filemtime(GUTEN_POST_LAYOUT_DIR_PATH . 'src/assets/js/slick.min.js'),
                    true
                );

                wp_register_script(
                    'guten-post-layout-custom',
                    GUTEN_POST_LAYOUT_DIR_URL . 'src/assets/js/custom.js',
                    array('jquery'),
                    filemtime(GUTEN_POST_LAYOUT_DIR_PATH . 'src/assets/js/custom.js'),
                    true
                );
            }
		}

	     public function editor_assets(){
			wp_enqueue_script(
				'gute-post-layout-js',
				GUTEN_POST_LAYOUT_DIR_URL.'dist/blocks.build.js',
				array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' , 'wp-editor' ),
				filemtime(GUTEN_POST_LAYOUT_DIR_PATH.'dist/blocks.build.js'),
				true
			);
	
			wp_enqueue_style(
				'guten-post-layout-editor-css',
				GUTEN_POST_LAYOUT_DIR_URL.'dist/blocks.editor.build.css',
				array('wp-edit-blocks'),
				filemtime(GUTEN_POST_LAYOUT_DIR_PATH.'dist/blocks.editor.build.css')
			);
	
			wp_enqueue_style(
				'guten-post-layout-font-icons',
				GUTEN_POST_LAYOUT_DIR_URL .'src/assets/css/font-icons.css',
				array(),
				filemtime(GUTEN_POST_LAYOUT_DIR_PATH.'src/assets/css/font-icons.css')
			);
		}

		public function front_end_assets(){
			wp_enqueue_style(
				'guten-post-layout-font-icons',
				GUTEN_POST_LAYOUT_DIR_URL.'src/assets/css/font-icons.css',
				array(),
				filemtime(GUTEN_POST_LAYOUT_DIR_PATH.'src/assets/css/font-icons.css')
			);

            wp_localize_script('guten-post-layout-custom', 'gpl_data', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('gpl-nonce')
            ));
		}

	}
}

GPL_Init::get_instance();
