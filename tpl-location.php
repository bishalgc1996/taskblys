<?php

	/**
	 * Template Name: Location Page
	 *
	 * @package WordPress
	 * @subpackage Blys Task
	 */

	get_header();


?>
    <section class="location-details">
        <div class="container">
            <div class="row">
				<?php
					$latitude  = floatval( get_post_meta( get_the_ID(), 'latitude', true ) );
					$longitude = floatval( get_post_meta( get_the_ID(), 'longitude', true ) );
				?>

                <p>Latitude: <?php echo $latitude; ?> </p>
                <p>Longitude: <?php echo $longitude; ?> </p>
                <p>Location Name: <?php the_title(); ?></p>
				<?php

					$base_location = array(
						'lat' => $latitude,
						'lng' => $longitude
					);


					$args      = array(
						'post_type'  => 'page',
						'meta_query' => array(
							array(
								'key'   => '_wp_page_template',
								'value' => 'tpl-location.php'
							)
						)
					);
					$the_query = new WP_Query( $args );


					$locations = array(
						array(
							'name' => '',
							'lat'  => '',
							'lng'  => ''
						)
					);


					echo '<h3>' . ' Nearest Location' . '</h3>';
					$count = 0;


					while ( $the_query->have_posts() ) : $the_query->the_post();
						$latitude  = get_post_meta( get_the_ID(), 'latitude', true );
						$longitude = get_post_meta( get_the_ID(), 'longitude', true );

						if ( $base_location['lat'] != $latitude ) {

							$locations[ $count ]['name'] = get_the_title();
							$locations[ $count ]['lat']  = $latitude;
							$locations[ $count ]['lng']  = $longitude;
						}


						$count ++;


					endwhile;

					$distances = array();
					foreach ( $locations as $key => $location ) {
						$lat_num  = floatval( $location['lat'] );
						$long_num = floatval( $location['lng'] );


						$a                 = $base_location['lat'] - $lat_num;
						$b                 = $base_location['lng'] - $long_num;
						$distance          = sqrt( ( $a ** 2 ) + ( $b ** 2 ) );
						$distances[ $key ] = $distance;
					}


					asort( $distances );


					$keys_list = array_keys( $distances );

					foreach ( $keys_list as $key_item ) {
						$location_name = ( $locations[ $key_item ]['name'] );
						echo $location_name . '<br>';
					}


					wp_reset_postdata();

				?>


            </div>

        </div>
    </section>
<?php

	get_footer();
