<?php
/**
 * Basud Child Theme
 */

function basudcamnorte_enqueue_styles() {

    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array('parent-style'),
        wp_get_theme()->get('Version')
    );

}

add_action('wp_enqueue_scripts', 'basudcamnorte_enqueue_styles');

function basud_register_services() {

    $labels = array(
        'name'               => 'Government Services',
        'singular_name'      => 'Government Service',
        'menu_name'          => 'Government Services',
        'add_new'            => 'Add Service',
        'add_new_item'       => 'Add New Government Service',
        'edit_item'          => 'Edit Government Service',
        'new_item'           => 'New Government Service',
        'view_item'          => 'View Government Service',
        'search_items'       => 'Search Government Services',
        'not_found'          => 'No government services found',
        'not_found_in_trash' => 'No government services found in Trash',
    );

    $args = array(
        'labels'       => $labels,
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => 'services',

        'rewrite' => array(
            'slug' => 'services',
        ),

        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),

        'menu_icon' => 'dashicons-admin-tools',
    );

    register_post_type('government_service', $args);
}

add_action('init', 'basud_register_services');

/**
 * Government Services - Requirements Metabox
 */
function basud_add_requirements_metabox() {
    add_meta_box(
        'basud_service_requirements',
        'Citizen\'s Charter Requirements',
        'basud_render_requirements_metabox',
        'government_service',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'basud_add_requirements_metabox');


function basud_render_requirements_metabox($post) {

    wp_nonce_field(
        'basud_save_requirements',
        'basud_requirements_nonce'
    );

    $requirements = get_post_meta(
        $post->ID,
        '_basud_requirements',
        true
    );

    if (!is_array($requirements)) {
        $requirements = array();
    }

    ?>

    <div id="basud-requirements">

        <?php foreach ($requirements as $index => $requirement) : ?>

            <div class="basud-requirement">

                <p>
                    <label>
                        <strong>Requirement</strong>
                    </label>
                    <br>

                    <textarea
                        name="basud_requirements[<?php echo esc_attr($index); ?>][requirement]"
                        rows="2"
                        style="width:100%;"
                    ><?php echo esc_textarea($requirement['requirement'] ?? ''); ?></textarea>
                </p>

                <p>
                    <label>
                        <strong>Where to Secure</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_requirements[<?php echo esc_attr($index); ?>][where_to_secure]"
                        value="<?php echo esc_attr($requirement['where_to_secure'] ?? ''); ?>"
                        style="width:100%;"
                    >
                </p>

                <button
                    type="button"
                    class="button basud-remove-requirement"
                >
                    Remove Requirement
                </button>

                <hr>

            </div>

        <?php endforeach; ?>

    </div>

    <button
        type="button"
        class="button button-secondary"
        id="basud-add-requirement"
    >
        + Add Requirement
    </button>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('basud-requirements');
        const addButton = document.getElementById('basud-add-requirement');

        let index = <?php echo count($requirements); ?>;

        addButton.addEventListener('click', function () {

            const wrapper = document.createElement('div');

            wrapper.className = 'basud-requirement';

            wrapper.innerHTML = `
                <p>
                    <label>
                        <strong>Requirement</strong>
                    </label>
                    <br>

                    <textarea
                        name="basud_requirements[${index}][requirement]"
                        rows="2"
                        style="width:100%;"
                    ></textarea>
                </p>

                <p>
                    <label>
                        <strong>Where to Secure</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_requirements[${index}][where_to_secure]"
                        style="width:100%;"
                    >
                </p>

                <button
                    type="button"
                    class="button basud-remove-requirement"
                >
                    Remove Requirement
                </button>

                <hr>
            `;

            container.appendChild(wrapper);

            index++;
        });


        container.addEventListener('click', function (event) {

            if (
                event.target.classList.contains(
                    'basud-remove-requirement'
                )
            ) {
                event.target
                    .closest('.basud-requirement')
                    .remove();
            }

        });

    });
    </script>

    <?php
}


function basud_save_requirements($post_id) {

    if (
        !isset($_POST['basud_requirements_nonce']) ||
        !wp_verify_nonce(
            $_POST['basud_requirements_nonce'],
            'basud_save_requirements'
        )
    ) {
        return;
    }

    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }

    if (
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (
        get_post_type($post_id) !== 'government_service'
    ) {
        return;
    }

    $requirements = $_POST['basud_requirements'] ?? array();

    $clean_requirements = array();

    if (is_array($requirements)) {

        foreach ($requirements as $requirement) {

            $clean_requirements[] = array(
                'requirement' => sanitize_textarea_field(
                    $requirement['requirement'] ?? ''
                ),

                'where_to_secure' => sanitize_text_field(
                    $requirement['where_to_secure'] ?? ''
                ),
            );

        }

    }

    update_post_meta(
        $post_id,
        '_basud_requirements',
        $clean_requirements
    );
}

add_action(
    'save_post_government_service',
    'basud_save_requirements'
);

/**
 * Government Services - Procedures Metabox
 */
function basud_add_procedures_metabox() {

    add_meta_box(
        'basud_service_procedures',
        'Citizen\'s Charter Procedures',
        'basud_render_procedures_metabox',
        'government_service',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'basud_add_procedures_metabox');


function basud_render_procedures_metabox($post) {

    wp_nonce_field(
        'basud_save_procedures',
        'basud_procedures_nonce'
    );

    $procedures = get_post_meta(
        $post->ID,
        '_basud_procedures',
        true
    );

    if (!is_array($procedures)) {
        $procedures = array();
    }

    ?>

    <div id="basud-procedures">

        <?php foreach ($procedures as $step_index => $step) : ?>

            <div class="basud-procedure-step"
                 style="border:1px solid #ccd0d4; padding:15px; margin-bottom:15px;">

                <h3>Step</h3>

                <p>
                    <label>
                        <strong>Step Number</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[<?php echo esc_attr($step_index); ?>][step_number]"
                        value="<?php echo esc_attr($step['step_number'] ?? ''); ?>"
                        style="width:150px;"
                    >
                </p>

                <p>
                    <label>
                        <strong>Step Title</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[<?php echo esc_attr($step_index); ?>][step_title]"
                        value="<?php echo esc_attr($step['step_title'] ?? ''); ?>"
                        style="width:100%;"
                    >
                </p>

                <div class="basud-substeps">

                    <h4>Substeps</h4>

                    <?php
                    $substeps = $step['substeps'] ?? array();

                    if (!is_array($substeps)) {
                        $substeps = array();
                    }
                    ?>

                    <?php foreach ($substeps as $sub_index => $substep) : ?>

                        <div class="basud-substep"
                             style="background:#f6f7f7; padding:12px; margin-bottom:10px;">

                            <p>
                                <label>
                                    <strong>Substep Number</strong>
                                </label>
                                <br>

                                <input
                                    type="text"
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][substep_number]"
                                    value="<?php echo esc_attr($substep['substep_number'] ?? ''); ?>"
                                    style="width:150px;"
                                >
                            </p>

                            <p>
                                <label>
                                    <strong>Applicant Action</strong>
                                </label>
                                <br>

                                <textarea
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][applicant_action]"
                                    rows="3"
                                    style="width:100%;"
                                ><?php echo esc_textarea($substep['applicant_action'] ?? ''); ?></textarea>
                            </p>

                            <p>
                                <label>
                                    <strong>Agency Action</strong>
                                </label>
                                <br>

                                <textarea
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][agency_action]"
                                    rows="3"
                                    style="width:100%;"
                                ><?php echo esc_textarea($substep['agency_action'] ?? ''); ?></textarea>
                            </p>

                            <p>
                                <label>
                                    <strong>Duration</strong>
                                </label>
                                <br>

                                <input
                                    type="text"
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][duration]"
                                    value="<?php echo esc_attr($substep['duration'] ?? ''); ?>"
                                    style="width:100%;"
                                >
                            </p>

                            <p>
                                <label>
                                    <strong>Person / Office-in-Charge</strong>
                                </label>
                                <br>

                                <input
                                    type="text"
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][person_office]"
                                    value="<?php echo esc_attr($substep['person_office'] ?? ''); ?>"
                                    style="width:100%;"
                                >
                            </p>

                            <p>
                                <label>
                                    <strong>Amount</strong>
                                </label>
                                <br>

                                <input
                                    type="text"
                                    name="basud_procedures[<?php echo esc_attr($step_index); ?>][substeps][<?php echo esc_attr($sub_index); ?>][amount]"
                                    value="<?php echo esc_attr($substep['amount'] ?? ''); ?>"
                                    style="width:100%;"
                                >
                            </p>

                            <button
                                type="button"
                                class="button basud-remove-substep"
                            >
                                Remove Substep
                            </button>

                        </div>

                    <?php endforeach; ?>

                </div>

                <button
                    type="button"
                    class="button basud-add-substep"
                >
                    + Add Substep
                </button>

                <button
                    type="button"
                    class="button basud-remove-step"
                    style="margin-left:10px;"
                >
                    Remove Step
                </button>

            </div>

        <?php endforeach; ?>

    </div>

    <p>
        <button
            type="button"
            class="button button-primary"
            id="basud-add-step"
        >
            + Add Step
        </button>
    </p>


    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('basud-procedures');
        const addStepButton = document.getElementById('basud-add-step');

        let stepIndex = <?php echo count($procedures); ?>;


        function createSubstep(stepIndex, subIndex) {

            const wrapper = document.createElement('div');

            wrapper.className = 'basud-substep';

            wrapper.style.background = '#f6f7f7';
            wrapper.style.padding = '12px';
            wrapper.style.marginBottom = '10px';

            wrapper.innerHTML = `
                <p>
                    <label>
                        <strong>Substep Number</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][substep_number]"
                        style="width:150px;"
                    >
                </p>

                <p>
                    <label>
                        <strong>Applicant Action</strong>
                    </label>
                    <br>

                    <textarea
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][applicant_action]"
                        rows="3"
                        style="width:100%;"
                    ></textarea>
                </p>

                <p>
                    <label>
                        <strong>Agency Action</strong>
                    </label>
                    <br>

                    <textarea
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][agency_action]"
                        rows="3"
                        style="width:100%;"
                    ></textarea>
                </p>

                <p>
                    <label>
                        <strong>Duration</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][duration]"
                        style="width:100%;"
                    >
                </p>

                <p>
                    <label>
                        <strong>Person / Office-in-Charge</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][person_office]"
                        style="width:100%;"
                    >
                </p>

                <p>
                    <label>
                        <strong>Amount</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${stepIndex}][substeps][${subIndex}][amount]"
                        style="width:100%;"
                    >
                </p>

                <button
                    type="button"
                    class="button basud-remove-substep"
                >
                    Remove Substep
                </button>
            `;

            return wrapper;
        }


        function createStep(index) {

            const wrapper = document.createElement('div');

            wrapper.className = 'basud-procedure-step';

            wrapper.style.border = '1px solid #ccd0d4';
            wrapper.style.padding = '15px';
            wrapper.style.marginBottom = '15px';

            wrapper.innerHTML = `
                <h3>Step</h3>

                <p>
                    <label>
                        <strong>Step Number</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${index}][step_number]"
                        style="width:150px;"
                    >
                </p>

                <p>
                    <label>
                        <strong>Step Title</strong>
                    </label>
                    <br>

                    <input
                        type="text"
                        name="basud_procedures[${index}][step_title]"
                        style="width:100%;"
                    >
                </p>

                <div class="basud-substeps">

                    <h4>Substeps</h4>

                </div>

                <button
                    type="button"
                    class="button basud-add-substep"
                >
                    + Add Substep
                </button>

                <button
                    type="button"
                    class="button basud-remove-step"
                    style="margin-left:10px;"
                >
                    Remove Step
                </button>
            `;

            return wrapper;
        }


        addStepButton.addEventListener('click', function () {

            const step = createStep(stepIndex);

            container.appendChild(step);

            stepIndex++;
        });


        container.addEventListener('click', function (event) {

            if (
                event.target.classList.contains(
                    'basud-remove-step'
                )
            ) {

                event.target
                    .closest('.basud-procedure-step')
                    .remove();

            }


            if (
                event.target.classList.contains(
                    'basud-remove-substep'
                )
            ) {

                event.target
                    .closest('.basud-substep')
                    .remove();

            }


            if (
                event.target.classList.contains(
                    'basud-add-substep'
                )
            ) {

                const step = event.target
                    .closest('.basud-procedure-step');

                const substeps = step
                    .querySelector('.basud-substeps');

                const stepInputs = step.querySelectorAll(
                    'input[name*="[step_number]"]'
                );

                const stepNumber = stepInputs.length;

                const stepIndexMatch =
                    step.querySelector(
                        'input[name^="basud_procedures"]'
                    );

                const name = stepIndexMatch
                    .name
                    .match(
                        /basud_procedures\[(\d+)\]/
                    );

                if (!name) {
                    return;
                }

                const currentStepIndex = name[1];

                const subIndex =
                    substeps.querySelectorAll(
                        '.basud-substep'
                    ).length;

                const substep = createSubstep(
                    currentStepIndex,
                    subIndex
                );

                substeps.appendChild(substep);
            }

        });

    });
    </script>

    <?php
}


function basud_save_procedures($post_id) {

    if (
        !isset($_POST['basud_procedures_nonce']) ||
        !wp_verify_nonce(
            $_POST['basud_procedures_nonce'],
            'basud_save_procedures'
        )
    ) {
        return;
    }

    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }

    if (
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (
        get_post_type($post_id) !== 'government_service'
    ) {
        return;
    }

    $procedures = $_POST['basud_procedures'] ?? array();

    $clean_procedures = array();

    if (is_array($procedures)) {

        foreach ($procedures as $step) {

            $clean_step = array(
                'step_number' => sanitize_text_field(
                    $step['step_number'] ?? ''
                ),

                'step_title' => sanitize_text_field(
                    $step['step_title'] ?? ''
                ),

                'substeps' => array(),
            );


            $substeps = $step['substeps'] ?? array();

            if (is_array($substeps)) {

                foreach ($substeps as $substep) {

                    $clean_step['substeps'][] = array(
                        'substep_number' => sanitize_text_field(
                            $substep['substep_number'] ?? ''
                        ),

                        'applicant_action' => sanitize_textarea_field(
                            $substep['applicant_action'] ?? ''
                        ),

                        'agency_action' => sanitize_textarea_field(
                            $substep['agency_action'] ?? ''
                        ),

                        'duration' => sanitize_text_field(
                            $substep['duration'] ?? ''
                        ),

                        'person_office' => sanitize_text_field(
                            $substep['person_office'] ?? ''
                        ),

                        'amount' => sanitize_text_field(
                            $substep['amount'] ?? ''
                        ),
                    );
                }
            }

            $clean_procedures[] = $clean_step;
        }
    }

    update_post_meta(
        $post_id,
        '_basud_procedures',
        $clean_procedures
    );
}

add_action(
    'save_post_government_service',
    'basud_save_procedures'
);

/**
 * Government Services Search
 */
function basud_government_services_search($query) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service') &&
        isset($_GET['service_search']) &&
        $_GET['service_search'] !== ''
    ) {

        $search = sanitize_text_field(
            wp_unslash($_GET['service_search'])
        );

        $query->set('s', $search);
    }
}

add_action(
    'pre_get_posts',
    'basud_government_services_search'
);

/**
 * Government Services - Search ACF Fields
 */
function basud_government_services_acf_search(
    $search,
    $query
) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service') &&
        isset($_GET['service_search']) &&
        $_GET['service_search'] !== ''
    ) {

        global $wpdb;

        $service_search = sanitize_text_field(
            wp_unslash($_GET['service_search'])
        );

        $like = '%' . $wpdb->esc_like($service_search) . '%';

        $search = $wpdb->prepare(
            "
            AND (
                {$wpdb->posts}.post_title LIKE %s
                OR {$wpdb->posts}.post_content LIKE %s
                OR EXISTS (
                    SELECT 1
                    FROM {$wpdb->postmeta}
                    WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID
                    AND {$wpdb->postmeta}.meta_key IN (
                        'office__division',
                        'classification',
                        'type_of_transaction'
                    )
                    AND {$wpdb->postmeta}.meta_value LIKE %s
                )
            )
            ",
            $like,
            $like,
            $like
        );
    }

    return $search;
}

add_filter(
    'posts_search',
    'basud_government_services_acf_search',
    10,
    2
);

/**
 * Government Services - Office / Division Filter
 */
function basud_government_services_office_filter($query) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service') &&
        isset($_GET['service_office']) &&
        $_GET['service_office'] !== ''
    ) {

        $office = sanitize_text_field(
            wp_unslash($_GET['service_office'])
        );

        $meta_query = $query->get('meta_query');

        if (!is_array($meta_query)) {
            $meta_query = array();
        }

        $meta_query[] = array(
            'key'     => 'office__division',
            'value'   => $office,
            'compare' => '=',
        );

        $query->set('meta_query', $meta_query);
    }
}

add_action(
    'pre_get_posts',
    'basud_government_services_office_filter'
);

/**
 * Government Services - Classification Filter
 */
function basud_government_services_classification_filter($query) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service') &&
        isset($_GET['service_classification']) &&
        $_GET['service_classification'] !== ''
    ) {

        $classification = sanitize_text_field(
            wp_unslash($_GET['service_classification'])
        );

        $meta_query = $query->get('meta_query');

        if (!is_array($meta_query)) {
            $meta_query = array();
        }

        $meta_query[] = array(
            'key'     => 'classification',
            'value'   => $classification,
            'compare' => '=',
        );

        $query->set('meta_query', $meta_query);
    }
}

add_action(
    'pre_get_posts',
    'basud_government_services_classification_filter'
);

/**
 * Government Services - Transaction Type Filter
 */
function basud_government_services_transaction_filter($query) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service') &&
        isset($_GET['service_transaction']) &&
        $_GET['service_transaction'] !== ''
    ) {

        $transaction = sanitize_text_field(
            wp_unslash($_GET['service_transaction'])
        );

        $meta_query = $query->get('meta_query');

        if (!is_array($meta_query)) {
            $meta_query = array();
        }

        $meta_query[] = array(
            'key'     => 'type_of_transaction',
            'value'   => $transaction,
            'compare' => '=',
        );

        $query->set('meta_query', $meta_query);
    }
}

add_action(
    'pre_get_posts',
    'basud_government_services_transaction_filter'
);

/**
 * Government Services - Pagination
 */
function basud_government_services_per_page($query) {

    if (
        !is_admin() &&
        $query->is_main_query() &&
        $query->is_post_type_archive('government_service')
    ) {

        $query->set('posts_per_page', 10);
    }
}

add_action(
    'pre_get_posts',
    'basud_government_services_per_page'
);