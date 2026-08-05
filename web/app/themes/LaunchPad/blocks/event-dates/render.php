<?php
/**
 * Event Dates block template.
 *
 * Displays each row from the Events "dates" repeater as:
 * Tuesday, August 4, 2026 • 9:00 am – 5:00 pm
 *
 * @package LaunchPad
 *
 */

declare(strict_types=1);

if ( ! function_exists( 'have_rows' ) || ! have_rows( 'dates' ) ) {
	if ( is_admin() ) {
		echo '<p class="event-dates event-dates--empty">' . esc_html__( 'No dates added yet.', 'launchpad' ) . '</p>';
	}
	return;
}

$items = [];

while ( have_rows( 'dates' ) ) {
	the_row();

	$date_raw   = (string) get_sub_field( 'date' );
	$start_time = (string) get_sub_field( 'start_time' );
	$end_time   = (string) get_sub_field( 'end_time' );

	if ( '' === $date_raw || '' === $start_time || '' === $end_time ) {
		continue;
	}

	$date = DateTime::createFromFormat( 'd/m/Y', $date_raw );
	if ( false === $date ) {
		continue;
	}

	$items[] = sprintf(
		'%s • %s – %s',
		$date->format( 'l, F j, Y' ),
		$start_time,
		$end_time
	);
}

if ( [] === $items ) {
	if ( is_admin() ) {
		echo '<p class="event-dates event-dates--empty">' . esc_html__( 'No complete dates to display.', 'launchpad' ) . '</p>';
	}
	return;
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<ul class="event-dates__list">
		<?php foreach ( $items as $item ) : ?>
			<li class="event-dates__item"><?php echo esc_html( $item ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>
