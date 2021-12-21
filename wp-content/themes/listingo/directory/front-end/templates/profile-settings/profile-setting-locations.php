<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$profile_latitude = get_user_meta($user_identity, 'latitude', true);
$profile_longitude = get_user_meta($user_identity, 'longitude', true);
$profile_country = get_user_meta($user_identity, 'country', true);
$profile_city = get_user_meta($user_identity, 'city', true);
$profile_address = get_user_meta($user_identity, 'address', true);
$provider_category	= listingo_get_provider_category($current_user->ID);

if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$profile_latitude = !empty($profile_latitude) ? $profile_latitude : $dir_longitude;
$profile_longitude = !empty($profile_longitude) ? $profile_longitude : $dir_latitude;


?>
<div class="tg-dashboardbox tg-location">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Location', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','location');?></h2>
	</div>
	<div class="tg-locationbox">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
				<div class="form-group locate-me-wrap">
					<input type="text" value="<?php echo esc_attr($profile_address); ?>" name="basics[address]" class="form-control" id="location-address-0" />
					<a href="javascript:;" data-key="fetch" class="geolocate"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_attr_e('Locate me!', 'listingo'); ?>"></a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
				<p><strong><?php esc_html_e('Important Instructions: The given below latitude and longitude fields are required to show your profile on map and location search. You can simply search location in the above location field and the system will auto detect the latitude, longitude, country and city. If for some reason this does not return the required result, you can manually type in the information.', 'listingo'); ?></strong></p>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
				<div class="form-group">
					<input type="text" placeholder="<?php esc_attr_e('Longitude', 'listingo'); ?>" value="<?php echo esc_attr($profile_longitude); ?>" name="basics[longitude]" class="form-control" id="location-longitude-0" />
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
				<div class="form-group">
					<input type="text" placeholder="<?php esc_attr_e('Latitude', 'listingo'); ?>" value="<?php echo esc_attr($profile_latitude); ?>" name="basics[latitude]" class="form-control" id="location-latitude-0" />
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
				<div class="form-group">
					<span class="tg-select">
						<select name="basics[country]" class="sp-country-select">
							<option value=""><?php esc_html_e('Choose Country', 'listingo'); ?></option>
							<?php $countries = listingo_get_term_options($profile_country, 'countries'); ?>
						</select>
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
				<div class="form-group">
					<span class="tg-select">
						<select name="basics[city]" class="sp-city-select">
							<option value=""><?php esc_html_e('Choose City', 'listingo'); ?></option>
							<?php
							if (!empty($profile_country)) {
								$country = sanitize_text_field($profile_country);
								$args = array(
									'hide_empty' => false,
									'meta_key' => 'country',
									'meta_value' => $country
								);
								$terms = get_terms('cities', $args);
								if (!empty($terms)) {
									foreach ($terms as $key => $term) {
										$selected = '';
										if ($profile_city === $term->slug) {
											$selected = 'selected';
										}
										echo '<option ' . esc_attr($selected) . ' value="' . esc_attr($term->slug) . '">' . esc_attr($term->name) . '</option>';
									}
								}
							}
							?>
						</select>
					</span>
				</div>
			</div>
			<div class="sp-data-location">
				<input class="locations-data" data-key="city" type="hidden" value="" placeholder="<?php esc_attr_e('City', 'listingo'); ?>" id="locality" disabled="true" />
				<input class="locations-data" data-key="state" type="hidden" value="" placeholder="<?php esc_attr_e('State', 'listingo'); ?>" id="administrative_area_level_1" disabled="true" />
				<input class="locations-data" data-key="country" type="hidden" value="" placeholder="<?php esc_attr_e('Country', 'listingo'); ?>" id="country" disabled="true" />
				<input class="locations-data" data-key="code" type="hidden" value="" placeholder="<?php esc_attr_e('Country Code', 'listingo'); ?>" id="country_code" disabled="true" />
				<input class="locations-data" data-key="postal_town" type="hidden" value="" placeholder="<?php esc_attr_e('Postal Town', 'listingo'); ?>" id="postal_town" disabled="true" />
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
				<div class="form-group">
					<div id="location-pickr-map" class="location-pickr-map"></div>
				</div>
			</div>

			<?php
				$script = "jQuery(document).ready(function (e) {
							jQuery.listingo_init_profile_map(0,'location-pickr-map', ". esc_js($profile_latitude) . "," . esc_js($profile_longitude) . ");
						});";
				wp_add_inline_script('listingo_maps', $script, 'after');
			?>
		</div>
	</div>
</div>
