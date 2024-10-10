<?php
// Ensure the attributes are set with default values.
$postCount = $attributes['postCount'] ?? 3;
$postType = $attributes['postType'] ?? 'post';
$title = $attributes['title'] ?? 'The Latest';

// Query arguments to fetch posts.
$args = [
    'post_type'      => $postType,
    'posts_per_page' => $postCount,
];

// Create a new WP_Query instance with the provided arguments.
$postsQuery = new WP_Query($args);

// Check if there are any posts matching the query.
if ($postsQuery->have_posts()) : ?>
    <section <?php echo get_block_wrapper_attributes(); ?> >
        <div class="title"><h3><?php echo esc_html($title); ?></h3></div>
        <div class="posts">
            <?php while ($postsQuery->have_posts()) : $postsQuery->the_post(); ?>
                <div class="post">
					<a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                    <div class="date"><?php echo get_the_date(); ?></div>
                    <h4><?php the_title(); ?></h4>
                    <div class="excerpt"><?php the_excerpt(); ?></div>
					</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php 
endif; 
// Reset post data to ensure global post data isn't corrupted.
wp_reset_postdata(); 
?>
