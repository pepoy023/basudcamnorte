<?php
/**
 * Announcements Page Template
 */

get_header();
?>

<main class="basud-announcements-page">

    <div class="basud-announcements-container">

        <header class="basud-announcements-header">

            <h1>Announcements</h1>

            <p>
                Stay updated with the latest announcements,
                public advisories, and notices from the
                Municipality of Basud.
            </p>

        </header>

        <?php
        $paged = max(
            1,
            get_query_var('paged'),
            get_query_var('page')
        );

        $announcements_query = new WP_Query(array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'paged'          => $paged,
            'category_name'  => 'announcements',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        ?>

        <section class="basud-announcements-list">

            <?php if ($announcements_query->have_posts()) : ?>

                <?php while ($announcements_query->have_posts()) : ?>

                    <?php $announcements_query->the_post(); ?>

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
                                <?php echo esc_html(
                                    get_the_date('F j, Y')
                                ); ?>
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

                <?php if ($announcements_query->max_num_pages > 1) : ?>

                    <nav class="basud-announcements-pagination">

                        <?php
                        echo paginate_links(array(
                            'total'     => $announcements_query->max_num_pages,
                            'current'   => $paged,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                        ));
                        ?>

                    </nav>

                <?php endif; ?>

            <?php else : ?>

                <p>
                    There are currently no announcements available.
                </p>

            <?php endif; ?>

        </section>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php
get_footer();