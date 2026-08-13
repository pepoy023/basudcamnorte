<?php
/**
 * Single Government Service
 */

get_header();

while (have_posts()) :
    the_post();

    // ACF fields
    $service_overview = get_field('service_overview');
    $office_division = get_field('office__division');
    $classification   = get_field('classification');
    $transaction_type = get_field('type_of_transaction');
    $who_may_avail    = get_field('who_may_avail');
    $total_duration   = get_field('total_duration');

    // Custom metabox data
    $requirements = get_post_meta(
        get_the_ID(),
        '_basud_requirements',
        true
    );

    $procedures = get_post_meta(
        get_the_ID(),
        '_basud_procedures',
        true
    );

    if (!is_array($requirements)) {
        $requirements = array();
    }

    if (!is_array($procedures)) {
        $procedures = array();
    }
?>

<main class="basud-service-page">

    <div class="basud-service-container">

        <!-- SERVICE HEADER -->

        <header class="basud-service-header">

            <div class="basud-service-label">
                GOVERNMENT SERVICE
            </div>

            <h1>
                <?php the_title(); ?>
            </h1>

        </header>


        <!-- SERVICE OVERVIEW -->

        <?php if ($service_overview) : ?>

            <section class="basud-service-section">

                <h2>Service Overview</h2>

                <div class="basud-service-content">
                    <?php echo wpautop(esc_html($service_overview)); ?>
                </div>

            </section>

        <?php endif; ?>


        <!-- SERVICE INFORMATION -->

        <section class="basud-service-section">

            <h2>Service Information</h2>

            <div class="basud-service-info-grid">

                <?php if ($office_division) : ?>

                    <div class="basud-service-info-item">

                        <strong>Office / Division</strong>

                        <span>
                            <?php echo esc_html($office_division); ?>
                        </span>

                    </div>

                <?php endif; ?>


                <?php if ($classification) : ?>

                    <div class="basud-service-info-item">

                        <strong>Classification</strong>

                        <span>
                            <?php echo esc_html($classification); ?>
                        </span>

                    </div>

                <?php endif; ?>


                <?php if ($transaction_type) : ?>

                    <div class="basud-service-info-item">

                        <strong>Type of Transaction</strong>

                        <span>
                            <?php echo esc_html($transaction_type); ?>
                        </span>

                    </div>

                <?php endif; ?>


                <?php if ($total_duration) : ?>

                    <div class="basud-service-info-item">

                        <strong>Total Duration</strong>

                        <span>
                            <?php echo esc_html($total_duration); ?>
                        </span>

                    </div>

                <?php endif; ?>


                <?php if ($who_may_avail) : ?>

                    <div class="basud-service-info-item basud-service-info-wide">

                        <strong>Who May Avail?</strong>

                        <div class="basud-who-may-avail">
                            <?php echo wp_kses_post($who_may_avail); ?>
                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </section>


        <!-- REQUIREMENTS -->

        <?php if (!empty($requirements)) : ?>

            <section class="basud-service-section">

                <h2>Checklist of Requirements</h2>

                <div class="basud-table-wrapper">

                    <table class="basud-service-table">

                        <thead>

                            <tr>
                                <th>Requirement</th>
                                <th>Where to Secure</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($requirements as $requirement) : ?>

                                <tr>

                                    <td>
                                        <?php
                                        echo nl2br(
                                            esc_html(
                                                $requirement['requirement'] ?? ''
                                            )
                                        );
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo nl2br(
                                            esc_html(
                                                $requirement['where_to_secure'] ?? ''
                                            )
                                        );
                                        ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </section>

        <?php endif; ?>


        <!-- PROCEDURES -->

        <?php if (!empty($procedures)) : ?>

            <section class="basud-service-section">

                <h2>Procedure</h2>

                <div class="basud-table-wrapper">

                    <table class="basud-service-table basud-procedure-table">

                        <thead>

                            <tr>
                                <th>Step</th>
                                <th>Applicant Action</th>
                                <th>Agency Action</th>
                                <th>Duration</th>
                                <th>Person / Office-in-Charge</th>
                                <th>Amount</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($procedures as $step) : ?>

                                <?php
                                $substeps = $step['substeps'] ?? array();

                                if (!is_array($substeps)) {
                                    $substeps = array();
                                }
                                ?>


                                <?php if (!empty($substeps)) : ?>

                                    <?php foreach ($substeps as $substep) : ?>

                                        <tr>

                                            <td>

                                                <strong>
                                                    <?php
                                                    echo esc_html(
                                                        $substep['substep_number'] ?? ''
                                                    );
                                                    ?>
                                                </strong>

                                                <?php if (!empty($step['step_title'])) : ?>

                                                    <div class="basud-step-title">

                                                        <?php
                                                        echo esc_html(
                                                            $step['step_title']
                                                        );
                                                        ?>

                                                    </div>

                                                <?php endif; ?>

                                            </td>


                                            <td>
                                                <?php
                                                echo nl2br(
                                                    esc_html(
                                                        $substep['applicant_action'] ?? ''
                                                    )
                                                );
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo nl2br(
                                                    esc_html(
                                                        $substep['agency_action'] ?? ''
                                                    )
                                                );
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo esc_html(
                                                    $substep['duration'] ?? ''
                                                );
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo nl2br(
                                                    esc_html(
                                                        $substep['person_office'] ?? ''
                                                    )
                                                );
                                                ?>
                                            </td>


                                            <td>
                                                <?php
                                                echo nl2br(
                                                    esc_html(
                                                        $substep['amount'] ?? ''
                                                    )
                                                );
                                                ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>


                                <?php else : ?>

                                    <tr>

                                        <td>

                                            <strong>
                                                <?php
                                                echo esc_html(
                                                    $step['step_number'] ?? ''
                                                );
                                                ?>
                                            </strong>

                                            <?php if (!empty($step['step_title'])) : ?>

                                                <div class="basud-step-title">

                                                    <?php
                                                    echo esc_html(
                                                        $step['step_title']
                                                    );
                                                    ?>

                                                </div>

                                            <?php endif; ?>

                                        </td>

                                        <td colspan="5">
                                            No procedure details entered.
                                        </td>

                                    </tr>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </section>

        <?php endif; ?>


        <!-- BACK LINK -->

        <div class="basud-service-back">

            <a href="<?php echo esc_url(
                home_url('/services/')
            ); ?>">
                ← Back to Government Services
            </a>

        </div>


    </div>

</main>

<?php

endwhile;

get_footer();