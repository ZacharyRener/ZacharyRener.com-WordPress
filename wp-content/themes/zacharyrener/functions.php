<?php

// define( 'HEADLESS_MODE_CLIENT_URL', 'https://zacharyrener.com' );

function custom_admin_css() {
    echo '<style>
    #menu-posts, #menu-comments {
        display: none !important;
    }
    </style>';
}
add_action('admin_head', 'custom_admin_css');

function create_post_type_projects() {
	register_post_type('projects',
		array(
			'labels' => array(
				'name' => __('Projects'),
				'singular_name' => __('Project'),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'menu_icon' => 'dashicons-portfolio', // Add the dashicons-portfolio icon
		)
	);
}
add_action('init', 'create_post_type_projects');
