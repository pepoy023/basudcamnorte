<?php
/**
 * Single Post Template
 * Used for ordinary WordPress Posts.
 */

get_header();
?>

<main class="basud-single-post-page">

    <div class="basud-single-post-container">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('basud-single-post'); ?>>

                    <!-- POST HEADER -->

                    <header class="basud-single-post-header">

                        <h1>
                            <?php the_title(); ?>
                        </h1>

                        <div class="basud-single-post-meta">

                            <span class="basud-single-post-date">
                                <?php echo esc_html(get_the_date('F j, Y')); ?>
                            </span>

                            <span class="basud-single-post-categories">
                                <?php echo get_the_category_list(', '); ?>
                            </span>

                        </div>

                    </header>

                    <!-- FEATURED IMAGE -->

                    <?php if (has_post_thumbnail()) : ?>

                        <div class="basud-single-post-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>

                    <?php endif; ?>

                    <!-- POST CONTENT -->

                    <div class="basud-single-post-content">

                        <?php the_content(); ?>

                    </div>

                </article>

            <?php endwhile; ?>

            <!-- BACK TO ANNOUNCEMENTS -->

            <div class="basud-single-post-navigation">

                <a href="<?php echo esc_url(home_url('/announcements/')); ?>">
                    ← Back to Announcements
                </a>

            </div>

        <?php else : ?>

            <p>This announcement could not be found.</p>

        <?php endif; ?>

    </div>

</main>

<?php
get_footer();