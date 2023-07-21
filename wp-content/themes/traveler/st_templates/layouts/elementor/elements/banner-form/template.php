<div class="st-banner-search-form <?php echo esc_attr( $style ); ?>">
	<?php
	if ( ! empty( $type_form ) && ! empty( $services ) && ( $type_form !== 'single' ) ) {
		if ( is_array( $services ) ) {
			$services = '';
		}
		$services = ST_Elementor::st_explode_select2( $services );
		if ( count( $services ) > 1 ) {
			echo '<ul class="multi-search nav nav-pills" role="tablist">';
				$j = 0;

			foreach ( $services as $vtab => $item ) {
				$tab_title    = $item;
				$active_class = ( $j == 0 ) ? 'active' : '';
				echo '<li class="nav-item" role="presentation">
                        <a class="nav-link ' . esc_attr( $active_class ) . '" data-bs-toggle="pill" href="#" data-bs-target="#nav-' . esc_attr( $vtab ) . '" type="button" role="tab" aria-controls="nav-' . esc_attr( $vtab ) . '"  data-bs-target="#tab' . esc_attr( $vtab ) . '">' . esc_attr( $tab_title ) . '</a>
                        </li>';
				++$j;
			}
			echo '</ul>';

			echo '<div class="tab-content">';
				$jj = 0;
			foreach ( $services as $vtabcontent => $item ) {
				switch ( $vtabcontent ) {
					case 'st_rental':
						$folder_name = 'rental';
						break;
					case 'st_tours':
						$folder_name = 'tour';
						break;
					case 'st_activity':
						$folder_name = 'activity';
						break;
					case 'st_cars':
						$folder_name = 'car';
						break;
					case 'st_cartransfer':
						$folder_name = 'car_transfer';
						break;
					case 'tp_flight':
						$folder_name = 'tp_flight';
						break;
					case 'tp_hotel':
						$folder_name = 'tp_hotel';
						break;

					case 'hotels_combined':
						$folder_name = 'hotels_combined';
						break;
					case 'bookingdc':
						$folder_name = 'bookingdc';
						break;
					case 'expedia':
						$folder_name = 'expedia';
						break;
					default:
						$folder_name = 'hotel';
						break;
				}
				$active_class = ( $jj == 0 ) ? 'show active' : '';
				echo '<div class="tab-pane fade' . esc_attr( $active_class ) . '" id="nav-' . esc_attr( $vtabcontent ) . '" role="tabpanel">';
				?>
					<div class="st-search-form-el st-border-radius">
						<div class="st-search-el">
							<?php
							echo apply_filters( 'get_search_form_tab', st()->load_template( 'layouts/elementor/' . esc_attr( $folder_name ) . '/elements/search-form', '', [
								'in_tab'      => true,
								'vtabcontent' => $vtabcontent,
								] ), [
								'in_tab'      => true,
								'vtabcontent' => $vtabcontent,
							] );
							?>
						</div>
					</div>

				<?php
				echo '</div>';
				++$jj;
			}
			echo '</div>';
		} else {

			foreach ( $services as $vtabcontent => $item ) {
				if ( ! empty( $vtabcontent ) ) {
					switch ( $vtabcontent ) {
						case 'st_rental':
							$folder_name = 'rental';
							break;
						case 'st_tours':
							$folder_name = 'tour';
							break;
						case 'st_activity':
							$folder_name = 'activity';
							break;
						case 'st_cars':
							$folder_name = 'car';
							break;
						case 'st_cartransfer':
							$folder_name = 'car_transfer';
							break;
						case 'tp_flight':
							$folder_name = 'tp_flight';
							break;
						case 'tp_hotel':
							$folder_name = 'tp_hotel';
							break;

						case 'hotels_combined':
							$folder_name = 'hotels_combined';
							break;
						case 'bookingdc':
							$folder_name = 'bookingdc';
							break;
						case 'expedia':
							$folder_name = 'expedia';
							break;
						default:
							$folder_name = 'hotel';
							break;
					}
				} else {
					$vtabcontent = '';
					$folder_name = '';
				}
			}
			if ( ! empty( $folder_name ) ) {
				?>

				<div class="st-search-form-el st-border-radius">
					<div class="st-search-el">
						<?php
							echo apply_filters( 'get_search_form_tab', st()->load_template( 'layouts/elementor/' . esc_attr( $folder_name ) . '/elements/search-form' ), [
								'in_tab'      => true,
								'vtabcontent' => $vtabcontent,
							] );
						?>
					</div>
				</div>
				<?php
			}
		}
	} else {
		switch ( $service ) {
			case 'st_rental':
				$folder_name = 'rental';
				break;
			case 'st_tours':
				$folder_name = 'tour';
				break;
			case 'st_activity':
				$folder_name = 'activity';
				break;
			case 'st_cars':
				$folder_name = 'car';
				break;
			case 'st_cartransfer':
				$folder_name = 'car_transfer';
				break;
			case 'tp_flight':
				$folder_name = 'tp_flight';
				break;
			case 'tp_hotel':
				$folder_name = 'tp_hotel';
				break;

			case 'hotels_combined':
				$folder_name = 'hotels_combined';
				break;
			case 'bookingdc':
				$folder_name = 'bookingdc';
				break;
			case 'expedia':
				$folder_name = 'expedia';
				break;
			default:
				$folder_name = 'hotel';
				break;
		}

		?>

		<div class="st-search-form-el st-border-radius">
			<div class="st-search-el">
				<?php
					echo apply_filters( 'get_search_form_tab', st()->load_template( 'layouts/elementor/' . esc_attr( $folder_name ) . '/elements/search-form' ), [
						'in_tab'      => true,
						'vtabcontent' => $service,
					] );
				?>
			</div>
		</div>
	<?php } ?>
</div>
