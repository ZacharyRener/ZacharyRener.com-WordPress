<?php

// define( 'HEADLESS_MODE_CLIENT_URL', 'https://zacharyrener.com' );


// Restrict Gutenberg for specific post types and add a toggle in Gutenberg settings panel
function enqueue_custom_css_for_restricted_post_types($hook_suffix) {
    global $post;
    
    $restricted_post_types = ['projects', 'page'];
    
    if (isset($post) && in_array($post->post_type, $restricted_post_types)) {
        $use_classic_editor = get_field('use_classic_editor', $post->ID);
        
        if (!$use_classic_editor) {
            // Append CSS to restrict certain Gutenberg features
            echo '<style>
                body .editor-styles-wrapper .is-root-container,
				:root body :where(.editor-styles-wrapper)::after,
                body .editor-document-tools__document-overview-toggle,
                body button[aria-label="Tools"],
                body button[aria-label="View"],
                body .components-accessible-toolbar,
                body button#tabs-0-edit-post\/block,
                body .components-dropdown.components-dropdown-menu {
                    display: none;
                }
				body .editor-visual-editor {
					flex: none;
				}
            </style>';
        } else {
			echo '<style>
				body div#postdivrich, 
				body div#slugdiv {
					display: none;
				}
			</style>';
		}
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_css_for_restricted_post_types');

// Disable Gutenberg for specific post if 'Use Classic Editor' is checked
function disable_gutenberg_for_specific_post($can_edit, $post) {
    $restricted_post_types = ['projects', 'page'];
    
    if (in_array($post->post_type, $restricted_post_types)) {
        $use_classic_editor = get_field('use_classic_editor', $post->ID);
        
        if ($use_classic_editor) {
            return false;
        }
    }
    
    return $can_edit;
}
add_filter('use_block_editor_for_post', 'disable_gutenberg_for_specific_post', 10, 2);

// Add ACF field for toggling classic editor in Gutenberg settings side panel
function register_acf_classic_editor_toggle_field() {
    if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_use_classic_editor',
            'title' => 'Editor Settings',
            'fields' => array(
                array(
                    'key' => 'field_use_classic_editor',
                    'label' => 'Use Classic Editor',
                    'name' => 'use_classic_editor',
                    'type' => 'true_false',
                    'ui' => 1,
                    // 'message' => 'Use Classic Editor for this post',
					'instructions' => 'After toggling this field, update the post, and refresh your browser to switch editors.',
                    'wrapper' => array(
                        'class' => 'gutenberg-panel-field',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'projects',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'side',
        ));
    }
}
add_action('acf/init', 'register_acf_classic_editor_toggle_field');

function custom_admin_css() {
    echo '<style>
    #menu-posts, #menu-comments, div#commentsdiv, div#pageparentdiv, div#wpfooter, div#preview-action  {
        display: none !important;
    }
	.menu-icon-page .wp-menu-name::after,
	.menu-icon-projects .wp-menu-name::after {
		content: "ACF";
		display: block;
		font-size: 11px;
		font-weight: 800;
	}
	.menu-icon-articles .wp-menu-name::after {
		content: "Gutenberg";
		display: block;
		font-size: 11px;
		font-weight: 800;
	}
    </style>';
}
add_action('admin_head', 'custom_admin_css');

function create_post_type_projects() {
	// Register Projects post type
	register_post_type('projects',
		array(
			'labels' => array(
				'name' => __('Projects'),
				'singular_name' => __('Project'),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'menu_icon' => 'dashicons-portfolio',
			'show_in_rest' => true,
		)
	);

	// Register Project Types taxonomy for Projects post type
	register_taxonomy('project_types', 'projects',
		array(
			'labels' => array(
				'name' => __('Project Types'),
				'singular_name' => __('Project Type'),
			),
			'public' => true,
			'hierarchical' => true,
			'show_in_rest' => true,
		)
	);

	// Register Articles post type
	register_post_type('articles',
		array(
			'labels' => array(
				'name' => __('Articles'),
				'singular_name' => __('Article'),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'menu_icon' => 'dashicons-portfolio',
			'show_in_rest' => true,
		)
	);
}
add_action('init', 'create_post_type_projects');

function my_custom_allowed_block_types($allowed_blocks, $editor_context) {
    return array(
        'core/paragraph',    // Core Paragraph Block
        'core/button',       // Core Button Block
        'core/buttons',      // Core Buttons Block (container for multiple button blocks)
        'core/columns',      // Core Columns Block
        'core/column',       // Core Column Block (individual columns inside the Columns block)
        'core/spacer',       // Core Spacer Block
        'core/shortcode',    // Core Shortcode Block
        'core/heading',      // Core Heading Block
        'core/list',         // Core List Block
		'core/image',        // Core Image Block
		'core/pullquote',    // Core Pullquote Block
		'code-samples-zach-rener/header',         // Custom Header Block
		'code-samples-zach-rener/post-grid',      // Custom Post Grid Block
    );
}

add_filter('allowed_block_types_all', 'my_custom_allowed_block_types', 10, 2);

function remove_default_block_patterns() {
    remove_theme_support('core-block-patterns');
}

add_action('after_setup_theme', 'remove_default_block_patterns');

add_shortcode( 'button', function( $atts ) {

	$atts = shortcode_atts( array(
		'text' => 'Button Text',
		'title' => '',
		'link' => "#",
		'url' => '',
		'target' => '_self',
		'new_tab' => '',
		'style' => 'default',
	), $atts );

	if(!empty($atts['title'])):
		$atts['text'] = $atts['title'];
	endif;

	if(!empty($atts['url'])):
		$atts['link'] = $atts['url'];
	endif;

	if(!empty($atts['new_tab'])):
		if($atts['new_tab'] == 'true'):
			$atts['target'] = '_blank';
		else:
			$atts['target'] = '_self';
		endif;
	endif;

	ob_start();
	if($atts['style'] == 'default'): ?>

		<div class='button-wrapper'>
			<a class="button version-accent" href="<?php print $atts['link']; ?>" target="<?php print $atts['target']; ?>" rel="noopener"><?php print $atts['text']; ?></a>
		</div>
		
	<?php endif;
	return ob_get_clean();

});

add_action('init', 'redirect_non_admin_and_non_rest_pages');

function redirect_non_admin_and_non_rest_pages() {
    $request_uri = $_SERVER['REQUEST_URI'];

    // Do not redirect if the request is for wp-admin, wp-login.php, or the REST API
    if (
        strpos($request_uri, '/wp-admin/') === 0 ||
        strpos($request_uri, '/wp-login.php') === 0 ||
        strpos($request_uri, '/wp-json/') === 0
    ) {
        return; // Allow access to admin pages, login, and REST API
    }

    // Build the new URL
    $redirect_url = 'http://localhost:3000' . $request_uri;

    // Perform the redirect
    wp_redirect($redirect_url);
    exit;
}

function custom_acf_wysiwyg_p_tags($value, $post_id, $field) {
    // Check if the value is empty, and return early if so
    if(empty($value)) {
        return $value;
    }

    // Automatically wrap the content in <p> tags if not already wrapped
    return wpautop($value);
}

// Hook into ACF's load_value filter for WYSIWYG fields
add_filter('acf/load_value/type=wysiwyg', 'custom_acf_wysiwyg_p_tags', 10, 3);