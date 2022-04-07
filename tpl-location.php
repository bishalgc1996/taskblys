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


					$latitude  = get_post_meta( get_the_ID(), 'latitude', true );
					$longitude = get_post_meta( get_the_ID(), 'longitude', true );


					$country_title = get_the_title();
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


					$locations = array();



					echo '<h3>' . 'Top Five Nearest Location' . '</h3>';


					while ( $the_query->have_posts() ) : $the_query->the_post();
						$latitude  = get_post_meta( get_the_ID(), 'latitude', true );
						$longitude = get_post_meta( get_the_ID(), 'longitude', true );


						$locations = array(
							array(
								"name" => get_the_title(),
								"lat"  => $latitude,
								"lng"  => $longitude
							)
						);
						$distances = array();

						foreach ( $locations as $key => $location ) {
							$a                 = $base_location['lat'] - $location['lat'];
							$b                 = $base_location['lng'] - $location['lng'];
							$distance          = sqrt( ( $a ** 2 ) + ( $b ** 2 ) );
							$distances[ $key ] = $distance;
						}


						asort( $distances );




						$closest = $locations[ key( $distances ) ];


						if ( $country_title != $closest['name'] ) {

							echo $closest['name'] . '<br>';
						}


					endwhile;


					wp_reset_postdata();

				?>


            </div>

        </div>
    </section>
<?php

	get_footer();
