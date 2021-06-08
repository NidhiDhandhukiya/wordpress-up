<?php
function get_sb_breadcrumbs($args) {
	global $post;

	$output = '';

	$home_link    = home_url('/');
	$link         = '<li><a href="%1$s">%2$s</a></li>';
	$parent_id    = $post->post_parent;
	$frontpage_id = get_option('page_on_front');

	$text = $args['text'];

	if((is_home() || is_front_page())) {
		if (isset($args['display']['show_on_home'])) {
			$output .= '<div class="sb-breadcrumbs"><ul>';
			$output .= '<li class="first"><a href="'.$home_link.'">'.$text['home'].'</a></li>';
			$output .= '</ul></div><!-- End.sb-breadcrumbs -->';
		}
	}else{
		$output .= '<div class="sb-breadcrumbs"><ul>';
		$output .= '<li class="first"><a href="'.$home_link.'">'.$text['home'].'</a></li>';
		if(is_single()) {
			$output .= '<li class="last"><span class="current">'.get_the_title($post->ID).'</span></li>';
		}

		if(is_tag()){
			$str = sprintf($text['tag'], get_query_var('tag' ));
			$output .= '<li class="last"><span class="current">'.$str.'</span></li>';
		}

		if(is_404()){
			$output .= '<li class="last"><span class="current">'.$text['p404'].'</span></li>';
		}

		if(is_author()){
			global $author;
			$userdata = get_userdata($author);
			$str = sprintf($text['author'], $userdata->display_name);
			$output .= '<li class="last"><span class="current">'.$str.'</span></li>';
		}

		if(is_day()){
			$y_link = sprintf($link, get_year_link(get_the_time('Y')) , get_the_time('Y'));
			$m_link = sprintf($link, get_month_link( get_the_time('Y'), get_the_time('m')), get_the_time('m'));
			$d_str  = sprintf($text['day'], get_the_time('F d, Y'));

			$output .= $y_link . $m_link . '<li class="last"><span class="current">'.$d_str.'</span></li>';
		}

		if(is_month()){
			$y_link = sprintf($link, get_year_link(get_the_time('Y')) , get_the_time('Y'));
			$m_str  = sprintf($text['month'], get_the_time(' F Y'));
			$output .= $y_link .'<li class="last"><span class="current">'.$m_str.'</span></li>';
		}

		if(is_year()){
			$y_str  = sprintf($text['year'], get_the_time('Y'));
			$output .= '<li class="last"><span class="current">'.$y_str.'</span></li>';
		}


		if(is_search()){
			$str = sprintf($text['search'], get_query_var('s'));
			$output .= '<li class="last"><span class="current">'.$str.'</span></li>';
		}

		if(is_page()){
			if($post->post_parent == 0){
				$output .= '<li class="last"><span class="current">'.get_the_title().'</span></li>';
			}else{
				$post_parent = $post->post_parent; $_temp = array();
				while ($post_parent != 0) {
					$_page = get_page($post_parent);
					$_temp[] = sprintf($link, get_page_link($_page->ID), get_the_title($_page->ID));
					$post_parent = $_page->post_parent;
				}

				$_temp = array_reverse($_temp);
				for ($i = 0; $i < count($_temp); $i++) {
					$output .= $_temp[$i];
				}

				$output .= '<li class="last"><span class="current">'.get_the_title().'</span></li>';
			}
		}

		if(is_category()){
			$cat_current = get_category(get_query_var('cat'), false);

			if ($cat_current->parent != 0) {
				$parent_cats = get_category_parents($cat_current->parent, TRUE, '');
				$parent_cats = str_replace('<a','<li><a',$parent_cats);
				$parent_cats = str_replace('</a>','</a></li>',$parent_cats);
				$output .= $parent_cats;
			}

			$str = sprintf($text['category'], single_cat_title('',false));
			$output .= '<li class="last"><span class="current">'.$str.'</span></li>';
		}

		$output .= '</ul></div><!-- End.sb-breadcrumbs -->';
	}


	return $output;
}

function register_breadcrumbs_styles()
{
	$options = (array) get_option( 'sb_breadcrumbs_display' );

	if(!isset($options['use_def_style'])){
		wp_enqueue_style( 'breadcrumbs-styles', plugins_url( 'sb-breadcrumbs/css/sb-breadcrumbs.css' ) );
	}
}
?>