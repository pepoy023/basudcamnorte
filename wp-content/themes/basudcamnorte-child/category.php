
<?php
/**
 * Category Archive Redirect
 * LGU Basud Child Theme
 */

// Get the currently viewed category.
$category_id = absint(get_queried_object_id());

// Build the Posts landing page URL.
$posts_page_url = home_url('/posts/');

// Preserve the selected category.
if ($category_id > 0) {
    $posts_page_url = add_query_arg(
        'post_category',
        $category_id,
        $posts_page_url
    );
}

// Redirect to the Posts landing page.
wp_safe_redirect($posts_page_url, 302);
exit;
