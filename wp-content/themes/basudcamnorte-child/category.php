
<?php
/**
 * Category Archive Template
 * LGU Basud Child Theme
 */

get_header();
include_once get_template_directory() . '/inc/banner.php';
?>

<?php govph_displayoptions('govph_panel_top'); ?>

<div id="container-main" class="container-main" role="document">

    <div id="main-content" class="row">

        <div id="content"
            class="text-justify <?php govph_displayoptions('govph_content_position'); ?>columns"
            role="main">

            <header class="category-header">

                <h1 class="page-title">
                    <?php single_cat_title(); ?>
                </h1>

                <?php
                $category_description = category_description();

                if (!empty($category_description)) :
                ?>
                    <div class="taxonomy-description">
                        <?php echo $category_description; ?>
                    </div>
                <?php endif; ?>

            </header>

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php
                    get_template_part(
                        'template-parts/content',
                        get_post_format()
                    );
                    ?>

                <?php endwhile; ?>

                <?php gwt_wp_content_nav('nav-below'); ?>

            <?php else : ?>

                <?php get_template_part('no-results', 'archive'); ?>

            <?php endif; ?>

        </div>

        <?php
        if (is_active_sidebar('left-sidebar')) {
            govph_displayoptions('govph_sidebar_left');
        }

        if (is_active_sidebar('right-sidebar')) {
            govph_displayoptions('govph_sidebar_right');
        }
        ?>

    </div>

</div>

<?php govph_displayoptions('govph_panel_bottom'); ?>

<?php get_footer(); ?>
