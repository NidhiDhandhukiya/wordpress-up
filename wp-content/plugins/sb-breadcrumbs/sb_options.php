<?php
/* ADD SETTINGS PAGE
------------------------------------------------------*/
add_action('admin_menu','sb_breadcrumbs_add_options_page');

function sb_breadcrumbs_add_options_page() {
	add_options_page(
		'SB Breadcrumbs Settings',			// The text to be displayed in the browser title bar
		'SB Breadcrumbs',					// The text to be used for the menu
		'manage_options',					// The required capability of users to access this menu
		'sb_breadcrumbs-setting',			// The slug by which this menu item is accessible
		'sb_breadcrumbs_setting_display'	// The name of the function used to display the page content
	);
}

/* SECTIONS - FIELDS
------------------------------------------------------*/
add_action('admin_init', 'sb_breadcrumbs_init_theme_opotion');

function sb_breadcrumbs_init_theme_opotion() {

	// Add settings Sections
	add_settings_section(
		'text_display_section', 				// The ID to use for this section
		'Display Text',							// Title of this section
		'text_display_section_display',		// Function Callback
		'text-display-section'					// The ID use when render
	);

	add_settings_section(
		'display_section', 				// The ID to use for this section
		'Display Options',							// Title of this section
		'display_section_display',		// Function Callback
		'display-section'					// The ID use when render
	);

	// Add text settings Field

	add_settings_field('sb_breadcrumbs_display[show_on_home]',	'Show on home','sb_breadcrumbs_show_on_home_display','display-section','display_section');
	add_settings_field('sb_breadcrumbs_display[use_def_style]',	'','sb_breadcrumbs_use_def_style_display','display-section','display_section');

	add_settings_field(
		'sb_breadcrumbs_text_display[home]',
		'Home',
		'sb_breadcrumbs_home_text_display',
		'text-display-section',
		'text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[category]',	'Category','sb_breadcrumbs_category_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[search]',	'Search','sb_breadcrumbs_search_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[tag]',	'Tag','sb_breadcrumbs_tag_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[author]',	'Author','sb_breadcrumbs_author_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[p404]',	'Page 404','sb_breadcrumbs_p404_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[year]',	'Year','sb_breadcrumbs_year_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[month]',	'Month','sb_breadcrumbs_month_text_display','text-display-section','text_display_section');
	add_settings_field('sb_breadcrumbs_text_display[day]',	'Day','sb_breadcrumbs_day_text_display','text-display-section','text_display_section');



	// Register Settings
	register_setting( 'sb_breadcrumbs_settings','sb_breadcrumbs_text_display');
	register_setting( 'sb_breadcrumbs_settings','sb_breadcrumbs_display');

}

/* CALLBACK
------------------------------------------------------*/
function sb_breadcrumbs_setting_display(){ ?>
	<div class="wrap">
		<?php screen_icon() ?>
		<h2>SB Breadcrumbs Settings</h2>

		<form action="options.php" method="post">
			<?php settings_fields('sb_breadcrumbs_settings' ); ?>

			<?php do_settings_sections('display-section'); ?>
			<?php do_settings_sections('text-display-section'); ?>

			<?php submit_button(); ?>
		</form>
	</div>
<?php }

/* SECTION CALLBACK
------------------------------------------------------*/

function text_display_section_display(){
	echo '<p>Text display on Breadcrumbs when breadcrumbs show. Notice to <code>%s</code> in some field</p>';
	global $text;
	$text = (array)get_option('sb_breadcrumbs_text_display');
}

function display_section_display(){
	global $display;
	$display = (array)get_option('sb_breadcrumbs_display');
}

/* SETTING FIELDS CALLBACK
------------------------------------------------------*/
function sb_breadcrumbs_show_on_home_display()
{
	global $display;
	$html =  '<input value="1" type="checkbox" name="sb_breadcrumbs_display[show_on_home]" id="sb_breadcrumbs_display[show_on_home]" '.checked( 1, $display['show_on_home'], false ).'/>';

	$html .= '<label for="sb_breadcrumbs_display[show_on_home]">Show breadcrumbs on homepage</label>';

	echo $html;

}

function sb_breadcrumbs_use_def_style_display()
{
	global $display;
	$html =  '<input value="1" type="checkbox" name="sb_breadcrumbs_display[use_def_style]" id="sb_breadcrumbs_display[use_def_style]" '.checked( 1, $display['use_def_style'], false ).'/>';

	$html .= '<label for="sb_breadcrumbs_display[use_def_style]">No use default style for breadcrumbs</label>';

	echo $html;
}

function sb_breadcrumbs_home_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['home'].'" name="sb_breadcrumbs_text_display[home]">';
	echo '<p class="description">Default: <code>Home</code></p>';
}

function sb_breadcrumbs_category_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['category'].'" name="sb_breadcrumbs_text_display[category]">';
	echo '<p class="description">Default: <code>Category Archives: %s</code></p>';
}

function sb_breadcrumbs_search_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['search'].'" name="sb_breadcrumbs_text_display[search]">';
	echo '<p class="description">Default: <code>Search Results for: %s</code></p>';
}

function sb_breadcrumbs_tag_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['tag'].'" name="sb_breadcrumbs_text_display[tag]">';
	echo '<p class="description">Default: <code>Tag Archives: %s</code></p>';
}

function sb_breadcrumbs_author_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['author'].'" name="sb_breadcrumbs_text_display[author]">';
	echo '<p class="description">Default: <code>Author Archives: %s</code></p>';
}

function sb_breadcrumbs_p404_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['p404'].'" name="sb_breadcrumbs_text_display[p404]">';
	echo '<p class="description">Default: <code>Page not found</code></p>';
}

function sb_breadcrumbs_year_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['year'].'" name="sb_breadcrumbs_text_display[year]">';
	echo '<p class="description">Default: <code>Yearly Archives: %s</code></p>';
}

function sb_breadcrumbs_month_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['month'].'" name="sb_breadcrumbs_text_display[month]">';
	echo '<p class="description">Default: <code>Monthly Archives: %s</code></p>';
}

function sb_breadcrumbs_day_text_display(){
	global $text;
	echo '<input type="text" class="regular-text" value="'.$text['day'].'" name="sb_breadcrumbs_text_display[day]">';
	echo '<p class="description">Default: <code>Daily Archives: %s</code></p>';
}
