<?php
get_header();
?>

<main class="site-main">

    <div class="organizational-unit-single-container">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php
                $acronym = get_field('acronym');
                $organizational_type = get_field('organizational_type');
                $parent = get_field('parent_organizational_unit');

                $mission = get_field('mission');
                $vision = get_field('vision');
                $mandate = get_field('mandate');
                $functions = get_field('functions_responsibilities');

                $head_name = get_field('head_name');
                $head_position = get_field('head_position');
                $salary_grade = get_field('salary_grade');

                $office_location = get_field('office_location');
                $contact_number = get_field('contact_number');
                $email_address = get_field('email_address');
                $office_hours = get_field('office_hours');
                ?>

                <nav class="organizational-unit-breadcrumbs" aria-label="Breadcrumb">

    <a href="<?php echo esc_url(
        get_post_type_archive_link('organizational_unit')
    ); ?>">
        Offices & Departments
    </a>

    <?php
    $breadcrumb_parents = array();
    $breadcrumb_parent = $parent;

    while (
        $breadcrumb_parent &&
        is_object($breadcrumb_parent)
    ) {

        $breadcrumb_parents[] = $breadcrumb_parent;

        $breadcrumb_parent = get_field(
            'parent_organizational_unit',
            $breadcrumb_parent->ID
        );
    }

    $breadcrumb_parents = array_reverse($breadcrumb_parents);
    ?>

    <?php foreach ($breadcrumb_parents as $breadcrumb_item) : ?>

        <span class="organizational-unit-breadcrumb-separator">
            →
        </span>

        <a href="<?php echo esc_url(
            get_permalink($breadcrumb_item->ID)
        ); ?>">
            <?php echo esc_html(
                get_the_title($breadcrumb_item->ID)
            ); ?>
        </a>

    <?php endforeach; ?>

    <span class="organizational-unit-breadcrumb-separator">
        →
    </span>

    <span class="organizational-unit-breadcrumb-current">
        <?php the_title(); ?>
    </span>

</nav>

                <header class="organizational-unit-header">

                    <?php if (has_post_thumbnail()) : ?>

                        <div class="organizational-unit-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>

                    <?php endif; ?>

                    <div class="organizational-unit-heading">

                        <?php if ($acronym) : ?>

                            <div class="organizational-unit-acronym">
                                <?php echo esc_html($acronym); ?>
                            </div>

                        <?php endif; ?>

                        <h1>
                            <?php the_title(); ?>
                        </h1>

                        <?php if ($organizational_type) : ?>

                            <div class="organizational-unit-type">
                                <?php echo esc_html($organizational_type); ?>
                            </div>

                        <?php endif; ?>

                    </div>

                </header>


                <?php if ($parent) : ?>

                    <div class="organizational-unit-parent">

                        <strong>Parent Organization:</strong>

                        <a href="<?php echo esc_url(
                            get_permalink($parent->ID)
                        ); ?>">

                            <?php echo esc_html(
                                get_the_title($parent->ID)
                            ); ?>

                        </a>

                    </div>

                <?php endif; ?>


                <section class="organizational-unit-overview">

                    <h2>Overview</h2>

                    <?php the_content(); ?>

                </section>


                <?php if ($mission) : ?>

                    <section class="organizational-unit-section">

                        <h2>Mission</h2>

                        <div class="organizational-unit-content">
                            <?php echo wp_kses_post($mission); ?>
                        </div>

                    </section>

                <?php endif; ?>


                <?php if ($vision) : ?>

                    <section class="organizational-unit-section">

                        <h2>Vision</h2>

                        <div class="organizational-unit-content">
                            <?php echo wp_kses_post($vision); ?>
                        </div>

                    </section>

                <?php endif; ?>


                <?php if ($mandate) : ?>

                    <section class="organizational-unit-section">

                        <h2>Mandate</h2>

                        <div class="organizational-unit-content">
                            <?php echo wp_kses_post($mandate); ?>
                        </div>

                    </section>

                <?php endif; ?>


                <?php if ($functions) : ?>

                    <section class="organizational-unit-section">

                        <h2>Functions / Responsibilities</h2>

                        <div class="organizational-unit-content">
                            <?php echo wp_kses_post($functions); ?>
                        </div>

                    </section>

                <?php endif; ?>


                <?php if (
                    $head_name ||
                    $head_position ||
                    $salary_grade
                ) : ?>

                    <section class="organizational-unit-section">

                        <h2>Office Head</h2>

                        <div class="organizational-unit-details">

                            <?php if ($head_name) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Name</strong>

                                    <span>
                                        <?php echo esc_html($head_name); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if ($head_position) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Position</strong>

                                    <span>
                                        <?php echo esc_html($head_position); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if ($salary_grade) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Salary Grade</strong>

                                    <span>
                                        SG <?php echo esc_html($salary_grade); ?>
                                    </span>

                                </div>

                            <?php endif; ?>

                        </div>

                    </section>

                <?php endif; ?>


                <?php if (
                    $office_location ||
                    $contact_number ||
                    $email_address ||
                    $office_hours
                ) : ?>

                    <section class="organizational-unit-section">

                        <h2>Contact Information</h2>

                        <div class="organizational-unit-details">

                            <?php if ($office_location) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Office Location</strong>

                                    <span>
                                        <?php echo esc_html(
                                            $office_location
                                        ); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if ($contact_number) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Contact Number</strong>

                                    <span>
                                        <?php echo esc_html(
                                            $contact_number
                                        ); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if ($email_address) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Email Address</strong>

                                    <span>
                                        <a href="mailto:<?php echo esc_attr(
                                            $email_address
                                        ); ?>">
                                            <?php echo esc_html(
                                                $email_address
                                            ); ?>
                                        </a>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if ($office_hours) : ?>

                                <div class="organizational-unit-detail">

                                    <strong>Office Hours</strong>

                                    <span>
                                        <?php echo esc_html(
                                            $office_hours
                                        ); ?>
                                    </span>

                                </div>

                            <?php endif; ?>

                        </div>

                    </section>

                <?php endif; ?>

                <?php
$current_unit_id = get_the_ID();

$all_units = get_posts(array(
    'post_type'      => 'organizational_unit',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
));

$child_units = array();

foreach ($all_units as $child) {

    $parent = get_field(
        'parent_organizational_unit',
        $child->ID
    );

    if (
        $parent &&
        is_object($parent) &&
        (int) $parent->ID === (int) $current_unit_id
    ) {
        $child_units[] = $child;
    }
}

usort($child_units, function ($a, $b) {

    $order_a = (int) get_field(
        'display_order',
        $a->ID
    );

    $order_b = (int) get_field(
        'display_order',
        $b->ID
    );

    return $order_a <=> $order_b;
});
?>

<?php if (!empty($child_units)) : ?>

    <section class="organizational-unit-section organizational-unit-children">

        <h2>Offices Under This Organization</h2>

        <div class="organizational-unit-children-list">

            <?php foreach ($child_units as $child) : ?>

                <?php
                $child_type = get_field(
                    'organizational_type',
                    $child->ID
                );
                ?>

                <article class="organizational-unit-child">

                    <a
                        href="<?php echo esc_url(
                            get_permalink($child->ID)
                        ); ?>"
                        class="organizational-unit-child-link"
                    >

                        <span class="organizational-unit-child-name">
                            <?php echo esc_html(
                                get_the_title($child->ID)
                            ); ?>
                        </span>

                        <?php if ($child_type) : ?>

                            <span class="organizational-unit-child-type">
                                <?php echo esc_html($child_type); ?>
                            </span>

                        <?php endif; ?>

                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    </section>

<?php endif; ?>

<?php
/**
 * Get government services under this organizational unit.
 */
$current_unit_id = get_the_ID();

$government_services = get_posts(array(
    'post_type'      => 'government_service',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'organizational_unit',
    'meta_value'     => $current_unit_id,
    'orderby'        => 'title',
    'order'          => 'ASC',
));
?>

<?php if (!empty($government_services)) : ?>

    <section class="organizational-unit-section organizational-unit-services">

        <h2>Government Services</h2>

        <div class="organizational-unit-services-list">

            <?php foreach ($government_services as $service) : ?>

                <?php
                $service_classification = get_field(
                    'classification',
                    $service->ID
                );

                $service_transaction = get_field(
                    'type_of_transaction',
                    $service->ID
                );
                ?>

                <article class="organizational-unit-service">

                    <a
                        href="<?php echo esc_url(
                            get_permalink($service->ID)
                        ); ?>"
                        class="organizational-unit-service-link"
                    >

                        <div class="organizational-unit-service-content">

                            <span class="organizational-unit-service-name">
                                <?php echo esc_html(
                                    get_the_title($service->ID)
                                ); ?>
                            </span>

                            <?php if (
                                $service_classification ||
                                $service_transaction
                            ) : ?>

                                <div class="organizational-unit-service-meta">

                                    <?php if ($service_classification) : ?>

                                        <span>
                                            <?php echo esc_html(
                                                $service_classification
                                            ); ?>
                                        </span>

                                    <?php endif; ?>

                                    <?php if ($service_transaction) : ?>

                                        <span>
                                            <?php echo esc_html(
                                                $service_transaction
                                            ); ?>
                                        </span>

                                    <?php endif; ?>

                                </div>

                            <?php endif; ?>

                        </div>

                        <span class="organizational-unit-service-arrow">
                            →
                        </span>

                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    </section>

<?php endif; ?>

        <!-- PARENT ORGANIZATION NAVIGATION -->

        <?php
$current_parent = get_field(
    'parent_organizational_unit',
    get_the_ID()
);
?>

<?php if (
    $current_parent &&
    is_object($current_parent)
) : ?>

    <div class="organizational-unit-parent-navigation">

        <a
            href="<?php echo esc_url(
                get_permalink($current_parent->ID)
            ); ?>"
            class="organizational-unit-parent-link"
        >
            ← Back to <?php echo esc_html(
                get_the_title($current_parent->ID)
            ); ?>
        </a>

    </div>

<?php endif; ?>

<div class="organizational-unit-directory-navigation">

    <a
        href="<?php echo esc_url(
    home_url('/offices-departments/')
); ?>"
        class="organizational-unit-directory-link"
    >
        ← Back to Offices & Departments
    </a>

</div>


            <?php endwhile; ?>

        <?php endif; ?>

    </div>

</main>

<?php
get_footer();