<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_60d9bb989b433',
	'title' => 'Site settings',
	'fields' => array(
		array(
			'key' => 'field_60dad5ab4de9a',
			'label' => 'Social networks',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_in_graphql' => 1,
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_60d9bbc79e92f',
			'label' => 'Social networks',
			'name' => 'social_networks',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_in_graphql' => 1,
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_60d9bbeb9e930',
					'label' => 'LinkedIn',
					'name' => 'social_linkedin',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'show_in_graphql' => 1,
					'default_value' => '',
					'placeholder' => '',
				),
				array(
					'key' => 'field_60d9bbfa9e931',
					'label' => 'Twitter',
					'name' => 'social_twitter',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'show_in_graphql' => 1,
					'default_value' => '',
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_60dad5c44de9b',
			'label' => 'Copyright',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_in_graphql' => 1,
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_60dad5d14de9c',
			'label' => 'Copyright',
			'name' => 'footer_copyright',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'show_in_graphql' => 1,
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'site-content',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

?>