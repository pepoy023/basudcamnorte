<?php
/**
 * Government Services Archive
 */

get_header();
?>

<main class="basud-service-page">

    <div class="basud-service-container">

        <!-- PAGE HEADER -->

        <header class="basud-service-header">

            <div class="basud-service-label">
                SERVICES
            </div>

            <h1>Government Services</h1>

            <p>
                Access municipal services, requirements, and Citizen's Charter information.
            </p>

        </header>

        <!-- SERVICE SEARCH -->

        <form
            class="basud-service-search"
            method="get"
            action="<?php echo esc_url(get_post_type_archive_link('government_service')); ?>"
        >

            <label for="basud-service-search">
                Search Government Services
            </label>

            <div class="basud-service-search-row">

                <input
                    type="search"
                    id="basud-service-search"
                    name="service_search"
                    value="<?php echo esc_attr(get_search_query()); ?>"
                    placeholder="Search for a government service..."
                >

                <button type="submit">
                    Search
                </button>

            </div>

        </form>

<!-- OFFICE / DIVISION FILTER -->

<form
    class="basud-service-filter"
    method="get"
    action="<?php echo esc_url(get_post_type_archive_link('government_service')); ?>"
>

    <?php
    $selected_office = isset($_GET['service_office'])
        ? sanitize_text_field(wp_unslash($_GET['service_office']))
        : '';

    $office_values = get_posts(array(
    'post_type'      => 'organizational_unit',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
));

    $transaction_values = array();

$transaction_query = new WP_Query(array(
    'post_type'      => 'government_service',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields'         => 'ids',
));

if ($transaction_query->have_posts()) {

    foreach ($transaction_query->posts as $service_id) {

        $transaction = get_field(
            'type_of_transaction',
            $service_id
        );

        if ($transaction) {
            $transaction_values[] = $transaction;
        }
    }
}

wp_reset_postdata();

$transaction_values = array_unique($transaction_values);
sort($transaction_values);
    ?>

    <p class="basud-filter-field">
    <label for="basud-service-office">
        Office / Division
    </label>

    <select
        id="basud-service-office"
        name="service_office"
    >

        <option value="">
            All Offices
        </option>

        <?php foreach ($office_values as $office) : ?>

    <option
        value="<?php echo esc_attr($office->ID); ?>"
        <?php selected($selected_office, $office->ID); ?>
    >
        <?php echo esc_html($office->post_title); ?>
    </option>

<?php endforeach; ?>

    </select>
    </p>

    <?php if (!empty($_GET['service_search'])) : ?>

        <input
            type="hidden"
            name="service_search"
            value="<?php echo esc_attr(
                sanitize_text_field(
                    wp_unslash($_GET['service_search'])
                )
            ); ?>"
        >

    <?php endif; ?>

    <p class="basud-filter-field">

    <label for="basud-service-classification">
        Classification
    </label>

    <?php
    $selected_classification = isset($_GET['service_classification'])
        ? sanitize_text_field(
            wp_unslash($_GET['service_classification'])
        )
        : '';
    ?>

    <select
        id="basud-service-classification"
        name="service_classification"
    >

        <option value="">
            All Classifications
        </option>

        <option
            value="Simple Transaction"
            <?php selected(
                $selected_classification,
                'Simple Transaction'
            ); ?>
        >
            Simple Transaction
        </option>

        <option
            value="Complex Transaction"
            <?php selected(
                $selected_classification,
                'Complex Transaction'
            ); ?>
        >
            Complex Transaction
        </option>

        <option
            value="Highly Technical"
            <?php selected(
                $selected_classification,
                'Highly Technical'
            ); ?>
        >
            Highly Technical
        </option>

    </select>

</p>

<p class="basud-filter-field">

    <label for="basud-service-transaction">
        Type of Transaction
    </label>

    <?php
    $selected_transaction = isset($_GET['service_transaction'])
        ? sanitize_text_field(
            wp_unslash($_GET['service_transaction'])
        )
        : '';
    ?>

    <select
    id="basud-service-transaction"
    name="service_transaction"
>

    <option value="">
        All Transaction Types
    </option>

    <?php foreach ($transaction_values as $transaction) : ?>

        <option
            value="<?php echo esc_attr($transaction); ?>"
            <?php selected($selected_transaction, $transaction); ?>
        >
            <?php echo esc_html($transaction); ?>
        </option>

    <?php endforeach; ?>

</select>

</p>

    <div class="basud-filter-actions">

    <button type="submit">
        Apply Filter
    </button>

    <a
        class="basud-clear-filters"
        href="<?php echo esc_url(
            get_post_type_archive_link('government_service')
        ); ?>"
    >
        Clear Filters
    </a>

</div>

</form>
        
        <!-- SERVICES LIST -->

        <div class="basud-services-grid">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php
                    $organizational_unit = get_field('organizational_unit');
                    $classification      = get_field('classification');
                    $transaction_type    = get_field('type_of_transaction');
                    ?>

                    <article class="basud-service-card">

                        <div class="basud-service-card-content">

                            <h2>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>


                            <?php if ($organizational_unit) : ?>

                                <p class="basud-service-office">
                                    <?php echo esc_html(
                                        get_the_title($organizational_unit->ID)
                                    ); ?>
                                </p>

                            <?php endif; ?>


                            <div class="basud-service-meta">

                                <?php if ($classification) : ?>

                                    <span>
                                        <?php echo esc_html($classification); ?>
                                    </span>

                                <?php endif; ?>


                                <?php if ($transaction_type) : ?>

                                    <span>
                                        <?php echo esc_html($transaction_type); ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <a
                                class="basud-service-view"
                                href="<?php the_permalink(); ?>"
                            >
                                View Service →
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>


            <?php else : ?>

                <p>No government services are currently available.</p>

            <?php endif; ?>

        </div>

        <?php if ($wp_query->max_num_pages > 1) : ?>

    <nav class="basud-service-pagination" aria-label="Government Services pagination">

        <?php
        echo paginate_links(array(
            'total'     => $wp_query->max_num_pages,
            'current'   => max(1, get_query_var('paged')),
            'mid_size'  => 2,
            'end_size'  => 1,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'type'      => 'list',
            'add_args'  => array_filter(array(
                'service_search'         => $_GET['service_search'] ?? '',
                'service_office'         => $_GET['service_office'] ?? '',
                'service_classification' => $_GET['service_classification'] ?? '',
                'service_transaction'    => $_GET['service_transaction'] ?? '',
            )),
        ));
        ?>

    </nav>

<?php endif; ?>

    </div>

</main>

<?php
get_footer();