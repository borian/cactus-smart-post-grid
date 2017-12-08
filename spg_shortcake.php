<?php


// [s_post_grid post_type="post" order="latest" layout="7"  cats="News" filter_style="0" ]

add_action( 'init', 'shortcode_ui_detection' );

function shortcode_ui_detection() {
	if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
		add_action( 'admin_notices', 'shortcode_ui_dev_example_notices' );
	}
}

function shortcode_ui_dev_example_notices() {
	if ( current_user_can( 'activate_plugins' ) ) {
		?>
		<div class="error message">
			<p><?php esc_html_e( 'Shortcode UI plugin must be active for SmartPostgrid Preview to function.', 'shortcode-ui-example', 'shortcode-ui' ); ?></p>
		</div>
		<?php
	}
}
/*
 * 1. Register the shortcodes.
 */
add_action( 'init', 'shortcode_ui_dev_register_shortcodes' );

function shortcode_ui_dev_register_shortcodes() { /* ... */ }
/*
 * 2. Register the Shortcode UI setup for the shortcodes.
 */
add_action( 'register_shortcode_ui', 'shortcode_ui_dev_minimal_example' );

function shortcode_ui_dev_minimal_example() {
	shortcode_ui_register_for_shortcode(
		'shortcake-no-attributes', // Shortcode tag this UI is for.
		array(                     // Shortcode UI args.
		                           'label' => esc_html__( 'Shortcake With No Attributes', 'shortcode-ui-example', 'shortcode-ui' ),
		)
	);
}
add_action( 'register_shortcode_ui', 'spg_shortcode_ui' );



function spg_shortcode_ui() {
	/*
	 * Each array must include 'attr', 'type', and 'label'.
	 * * 'attr' should be the name of the attribute.
	 * * 'type' options include: text, checkbox, textarea, radio, select, email,
	 *     url, number, and date, post_select, attachment, color.
	 * * 'label' is the label text associated with that input field.
	 *
	 * Use 'meta' to add arbitrary attributes to the HTML of the field.
	 *
	 * Use 'encode' to encode attribute data. Requires customization in shortcode callback to decode.
	 *
	 * Depending on 'type', additional arguments may be available.
	 */
	$fields = array(
        array(
            'label'    => 'Kategorie',
			'attr'     => 'cats',
			'type'     => 'term_select',
            'taxonomy' => 'category',
            'multiple' => true,
        ),
		array(
			'label'    => 'Hervorgehobene Beiträge',
			'attr'     => 'pinned',
			'type'     => 'post_select',
			'query'    => array( 'post_type' => 'post' ),
			'multiple' => true,
		),
	
		array(
			'label'       => 'Layout',
			// 'description' => esc_html__( 'Whether the quotation should be displayed as pull-left, pull-right, or neither.', 'shortcode-ui-example', 'shortcode-ui' ),
			'attr'        => 'layout',
			'type'        => 'select',
			'options'     => array(
				array( 'value' => '1', 'label' => esc_html__( 'Layout 1', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '2', 'label' => esc_html__( 'Layout 2', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '3', 'label' => esc_html__( 'Layout 3', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '4', 'label' => esc_html__( 'Layout 4', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '5', 'label' => esc_html__( 'Layout 5', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '6', 'label' => esc_html__( 'Layout 6', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '7', 'label' => esc_html__( 'Layout 7', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '8', 'label' => esc_html__( 'Layout 8', 'shortcode-ui-example', 'shortcode-ui' ) ),
				array( 'value' => '9', 'label' => esc_html__( 'Layout 9', 'shortcode-ui-example', 'shortcode-ui' ) ),
			),
		)
	);
	/*
	 * Define the Shortcode UI arguments.
	 */
	$shortcode_ui_args = array(
		/*
		 * How the shortcode should be labeled in the UI. Required argument.
		 */
		'label' => 'SmartPostGrid-SC',
		'listItemImage' => 'dashicons-tagcloud',
		'attrs' => $fields,
	);
	shortcode_ui_register_for_shortcode( 's_post_grid', $shortcode_ui_args );
}
