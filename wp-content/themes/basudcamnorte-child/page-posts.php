
<?php
/**
 * Posts Landing Page Template
 */

get_header();
?>

<main class="basud-announcements-page">

    <div class="basud-announcements-container">

        <header class="basud-announcements-header">

            <h1>Posts</h1>

            <p>
                Stay updated with the latest news, announcements,
                public advisories, and information from the
                Municipality of Basud.
            </p>

        </header>

        <?php
        // Get selected category and search keyword.
        $selected_category = isset($_GET['post_category'])
            ? absint(wp_unslash($_GET['post_category']))
            : 0;

        $search_keyword = isset($_GET['posts_search'])
            ? sanitize_text_field(wp_unslash($_GET['posts_search']))
            : '';

        // Determine current page.
        $paged = max(
            1,
            get_query_var('paged'),
            get_query_var('page')
        );

        // Build the posts query.
        $posts_args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        // Apply category filter.
        if ($selected_category > 0) {
            $posts_args['cat'] = $selected_category;
        }

        // Apply search filter.
        if (!empty($search_keyword)) {
            $posts_args['s'] = $search_keyword;
        }

        $posts_query = new WP_Query($posts_args);

        // Retrieve categories dynamically.
        $post_categories = get_categories(array(
            'taxonomy'   => 'category',
            'hide_empty' => false,
            'exclude'    => array(
                get_option('default_category')
            ),
            'orderby'    => 'name',
            'order'      => 'ASC',
        ));
        ?>

        <!-- Category and Search Filters -->
        <form
            method="get"
            action="<?php echo esc_url(get_permalink()); ?>"
            class="basud-posts-filter"
        >

            <div class="basud-posts-filter-category">

                <label for="post_category">
                    Filter by Category
                </label>

                <select
                    name="post_category"
                    id="post_category"
                    onchange="this.form.submit()"
                >

                    <option value="0">
                        All Categories
                    </option>

                    <?php foreach ($post_categories as $category) : ?>

                        <?php
                        $ancestors = get_ancestors(
                            $category->term_id,
                            'category'
                        );

                        $indent = str_repeat(
                            '— ',
                            count($ancestors)
                        );
                        ?>

                        <option
                            value="<?php echo esc_attr($category->term_id); ?>"
                            <?php selected(
                                $selected_category,
                                $category->term_id
                            ); ?>
                        >
                            <?php
                            echo esc_html(
                                $indent . $category->name
                            );
                            ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="basud-posts-filter-search">

                <label for="posts_search">
                    Search Posts
                </label>

                <input
                    type="search"
                    name="posts_search"
                    id="posts_search"
                    value="<?php echo esc_attr($search_keyword); ?>"
                    placeholder="Search posts..."
                >

            </div>

            <a href="<?php echo esc_url(get_permalink()); ?>">
                Clear Filters
            </a>

        </form>

        <!-- Posts Listing -->
        <section class="basud-announcements-list">

            <?php if ($posts_query->have_posts()) : ?>

                <?php while ($posts_query->have_posts()) : ?>

                    <?php $posts_query->the_post(); ?>

                    <article class="basud-announcement-card">

                        <?php if (has_post_thumbnail()) : ?>

                            <a
                                href="<?php the_permalink(); ?>"
                                class="basud-announcement-image"
                            >
                                <?php the_post_thumbnail('large'); ?>
                            </a>

                        <?php endif; ?>

                        <div class="basud-announcement-content">

                            <div class="basud-announcement-date">
                                <?php
                                echo esc_html(
                                    get_the_date('F j, Y')
                                );
                                ?>
                            </div>

                            <h2>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="basud-announcement-categories">
                                <?php
                                echo get_the_category_list(', ');
                                ?>
                            </div>

                            <div class="basud-announcement-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a
                                href="<?php the_permalink(); ?>"
                                class="basud-announcement-read-more"
                            >
                                Read More →
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>

                <!-- Pagination -->
                <?php if ($posts_query->max_num_pages > 1) : ?>

                    <nav class="basud-announcements-pagination">

                        <?php
                        $pagination_args = array(
                            'total'     => $posts_query->max_num_pages,
                            'current'   => $paged,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                            'add_args'  => array(
                                'post_category' => $selected_category,
                                'posts_search'  => $search_keyword,
                            ),
                        );

                        echo paginate_links($pagination_args);
                        ?>

                    </nav>

                <?php endif; ?>

            <?php else : ?>

                <p>
                    No posts were found matching your selection.
                </p>

            <?php endif; ?>

        </section>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php
get_footer();
