<?php
/**
 * LaunchPad theme functions.
 *
 * @package LaunchPad
 */

declare(strict_types=1);

/**
 * Register custom Gutenberg blocks for the theme.
 *
 * @return void
 */
function launchpad_register_blocks(): void {
	$blocks = [
		'event-dates',
		// 'event-location',
		// 'event-speakers',
	];

	foreach ( $blocks as $block ) {
		register_block_type( __DIR__ . '/blocks/' . $block );
	}
}
add_action( 'init', 'launchpad_register_blocks' );

/**
 * Assign a default block template to the Events CPT.
 *
 * The Events post type is registered by ACF Pro, so we filter its args
 * rather than calling register_post_type() directly. Leaving template_lock
 * unset keeps the layout fully editable in the block editor.
 *
 * @param array  $args      Post type registration arguments.
 * @param string $post_type Post type key.
 * @return array
 */
function launchpad_events_block_template( array $args, string $post_type ): array {
	if ( 'events' !== $post_type ) {
		return $args;
	}

	$args['template'] = [
    [
        'core/group',
        [
            'style' => [
                'spacing' => [
                    'padding' => [
                        'top'    => 'var:preset|spacing|50',
                        'right'  => 'var:preset|spacing|40',
                        'bottom' => 'var:preset|spacing|50',
                        'left'   => 'var:preset|spacing|40',
                    ],
                ],
                'color' => [
                    'background' => '#008ca80f',
                ],
            ],
            'layout' => [
                'type' => 'constrained',
            ],
        ],
        [
            [
                'core/columns',
                [],
                [
                    [
                        'core/column',
                        [
                            'verticalAlignment' => 'center',
                        ],
                        [
                            [
    							'core/heading',
    							[
    								'level' => 1,
    								'placeholder' => 'Event title...',
    							],
    						],
                        ],
                    ],
                    [
                        'core/column',
                        [],
                        [
                            [
                                'core/post-featured-image',
                                [
                                    'style' => [
                                        'dimensions' => [
                                            'aspectRatio' => '16/9'
                                        ]
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

	// Allow editors to freely add, move, and remove blocks.
	$args['template_lock'] = false;

	return $args;
}
add_filter( 'register_post_type_args', 'launchpad_events_block_template', 10, 2 );
