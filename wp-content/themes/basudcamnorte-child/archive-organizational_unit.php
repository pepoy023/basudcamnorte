<?php
get_header();

/**
 * Get all organizational units.
 */
$organizational_units = get_posts(array(
    'post_type'      => 'organizational_unit',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
));

/**
 * Organize units by their parent.
 */
$units_by_parent = array();

foreach ($organizational_units as $unit) {

    $parent = get_field(
        'parent_organizational_unit',
        $unit->ID
    );

    $parent_id = $parent ? $parent->ID : 0;

    if (!isset($units_by_parent[$parent_id])) {
        $units_by_parent[$parent_id] = array();
    }

    $units_by_parent[$parent_id][] = $unit;
}

/**
 * Sort organizational units by Display Order.
 */
foreach ($units_by_parent as &$units) {

    usort($units, function ($a, $b) {

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
}

unset($units);

/**
 * Display organizational units recursively.
 */
function basud_display_organizational_units(
    $parent_id = 0,
    $level = 0
) {

    global $units_by_parent;

    if (
        !isset($units_by_parent[$parent_id]) ||
        empty($units_by_parent[$parent_id])
    ) {
        return;
    }

    echo '<ul class="organizational-unit-level level-' . esc_attr($level) . '">';

    foreach ($units_by_parent[$parent_id] as $unit) {

        $type = get_field(
            'organizational_type',
            $unit->ID
        );

        echo '<li class="organizational-unit-item">';

        echo '<div class="organizational-unit-content">';

        echo '<a class="organizational-unit-link" href="' . esc_url(
            get_permalink($unit->ID)
        ) . '">';

        echo '<span class="organizational-unit-name">';
        echo esc_html($unit->post_title);
        echo '</span>';

        echo '</a>';

        if ($type) {

            echo '<span class="organizational-unit-type">';
            echo esc_html($type);
            echo '</span>';

        }

        echo '</div>';

        basud_display_organizational_units(
            $unit->ID,
            $level + 1
        );

        echo '</li>';
    }

    echo '</ul>';
}
?>

<main class="site-main">

    <div class="organizational-units-container">

        <h1 class="organizational-units-title">
            Offices & Departments
        </h1>

        <?php
        basud_display_organizational_units();
        ?>

    </div>

</main>

<?php
get_footer();