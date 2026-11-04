
<?php
/**
 * Announcements Page Redirect
 * LGU Basud Child Theme
 */

$posts_page_url = home_url('/posts/');

wp_safe_redirect($posts_page_url, 302);
exit;
