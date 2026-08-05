/**
 * Event Dates — editor registration (dynamic block; save is null).
 */
( function ( blocks, element, blockEditor, serverSideRender, i18n ) {
	const { registerBlockType } = blocks;
	const { createElement: el } = element;
	const { useBlockProps } = blockEditor;
	const ServerSideRender = serverSideRender.default || serverSideRender;
	const { __ } = i18n;

	registerBlockType( 'launchpad/event-dates', {
		edit: function Edit() {
			const blockProps = useBlockProps( {
				className: 'event-dates',
			} );

			return el(
				'div',
				blockProps,
				el( ServerSideRender, {
					block: 'launchpad/event-dates',
					EmptyResponsePlaceholder: function EmptyPlaceholder() {
						return el(
							'p',
							{ className: 'event-dates event-dates--empty' },
							__( 'No dates added yet.', 'launchpad' )
						);
					},
				} )
			);
		},
		save: function save() {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.serverSideRender,
	window.wp.i18n
);
