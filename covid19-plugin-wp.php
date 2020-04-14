<?php
/**
*  Plugin Name: COVID-19 Live Statistics
*  Plugin URI: https://1.envato.market/nyc
*  Description: The plugin allows adding statistics table/widgets via shortcode to inform site visitors about changes in the situation about Coronavirus pandemic.
*  Version: 2.1.4
*  Author: NYCreatis
*  Author URI: https://nycreatis.com/
*  License: Regular License https://1.envato.market/NycCCRL
*  Domain Path: /languages/
*  Text Domain: covid
**/
 
error_reporting(0);
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CovidNycreatis' ) ) {
	class CovidNycreatis {

		function __construct() {
			define( 'COVID_NYCREATIS_VER', '2.1.4' );
			if ( ! defined( 'COVID_NYCREATIS_URL' ) ) {
				define( 'COVID_NYCREATIS_URL', plugin_dir_url( __FILE__ ) );
			}
			if ( ! defined( 'COVID_NYCREATIS_PATH' ) ) {
				define( 'COVID_NYCREATIS_PATH', plugin_dir_path( __FILE__ ) );
			}
			add_action( 'init', array( $this, 'load_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ) );
			add_action( 'admin_menu', array( $this, 'register_custom_menu_page' ) );
			$this->wp_parse_args();
			$this->nycreatisDL();
			add_action( 'init', array( $this, 'register_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'nycreatis_enqueues' ) );			
			add_shortcode( 'COVID19-WIDGET', array($this, 'nycreatis_shortcode') );
			add_shortcode( 'COVID19-LINE', array($this, 'nycreatis_short_line') );
			add_shortcode( 'COVID19-SHEET', array($this, 'nycreatis_short_sheet') );
			add_shortcode( 'COVID19-ROLL', array($this, 'nycreatis_short_roll') );
			add_shortcode( 'COVID19-GRAPH', array($this, 'nycreatis_short_graph') );
			add_shortcode( 'COVID19', array($this, 'nycreatis_short_map') );
			add_shortcode( 'COVID19-MAPUS', array($this, 'nycreatis_short_mapus') );
		}

		function register_custom_menu_page(){
			add_options_page( 
				esc_attr__( 'Covid-19 Options', 'covid' ),
				esc_attr__( 'Covid-19 Options', 'covid' ),
				'manage_options',
				'covid-plugin-options',
				array($this, 'true_option_page')
			); 
		}
		
		function register_assets() {
			$nycreatisAll = get_option('nycreatisAL');
			$nycreatisGC = get_option('nycreatisCC');
			$nycreatisGS = get_option('nycreatisUS');
			$nycreatisGH = get_option('nycreatisCH');
			wp_register_style( 'covid', COVID_NYCREATIS_URL . 'assets/css/styles.css', array(), COVID_NYCREATIS_VER );
			wp_register_script( 'jquery.datatables', '//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', array( 'jquery' ), COVID_NYCREATIS_VER, true );
			wp_register_script( 'covid', COVID_NYCREATIS_URL . 'assets/js/scripts.js', array( 'jquery' ), COVID_NYCREATIS_VER, true );
			wp_register_script( 'graph', 'https://cdn.jsdelivr.net/npm/chart.js@2.9.3', array( 'jquery' ), COVID_NYCREATIS_VER, true );
			$translation_array = array(
				'all' => $nycreatisAll,
				'countries' => $nycreatisGC,
				'story' => $nycreatisGH
			);
			wp_localize_script( 'covid', 'covid', $translation_array );
		}

		public function admin_enqueue_assets() {
			wp_enqueue_script( 'covid-admin', COVID_NYCREATIS_URL . 'assets/js/admin-script.js', array( 'jquery' ), COVID_NYCREATIS_VER, true );
			wp_enqueue_style( 'covid-admin', COVID_NYCREATIS_URL . 'assets/admin-style.css', array(), COVID_NYCREATIS_VER );
		}
		
		function wp_parse_args(){
			add_filter( 'cron_schedules', array( $this, 'add_wp_cron_schedule' ) );
			if ( ! wp_next_scheduled( 'wp_schedule_event' ) ) {
				$next_timestamp = wp_next_scheduled( 'wp_schedule_event' );
				if ( $next_timestamp ) {
					wp_unschedule_event( $next_timestamp, 'wp_schedule_event' );
				}
				wp_schedule_event( time(), 'every_10minute', 'wp_schedule_event' );
			}
			add_action( 'wp_schedule_event', array($this,'ncrtsGetA') );
		}
		
		function add_wp_cron_schedule( $schedules ) {
			$schedules['every_10minute'] = array(
				'interval' => 10*60,
				'display'  => esc_attr__( '10 min', 'covid' ),
			);
			return $schedules;
		}
		
		function ncrtsGetA() {
			$all = $this->ncrtsGen(false);
			$countries = $this->ncrtsGen(true);
			$story = $this->ncrtsGen(false, true);
			$nycreatisAll = get_option('nycreatisAL');
			$nycreatisGC = get_option('nycreatisCC');
			$nycreatisGH = get_option('nycreatisCH');

			if ($nycreatisAll) {
				update_option( 'nycreatisAL', $all );
			} else {
				add_option('nycreatisAL', $all);
			}
			if ($nycreatisGC) {
				update_option( 'nycreatisCC', $countries );
			} else {
				add_option('nycreatisCC', $countries);
			}
			if ($nycreatisGH) {
				update_option( 'nycreatisCH', $story );
			} else {
				add_option('nycreatisCH', $story);
			}
		}
		
		function nycreatisDL(){
			$nycreatisAll = get_option('nycreatisAL');
			$nycreatisGC = get_option('nycreatisCC');
			$nycreatisGH = get_option('nycreatisCH');
			if (!$nycreatisGC) {
				$countries = $this->ncrtsGen(true);
				update_option( 'nycreatisCC', $countries );
			}
			if (!$nycreatisAll) {
				$all = $this->ncrtsGen(false);
				update_option( 'nycreatisAL', $all );
			}
			if (!$nycreatisGH) {
				$story = $this->ncrtsGen(false, true);
				update_option( 'nycreatisCH', $story );
			}
		}

		function load_textdomain() {
			load_plugin_textdomain( 'covid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		function ncrtsGen($countries=false,$story=false){
			$ncrtsURI 	= 'https://corona.lmao.ninja/';
			$ncrtsTrack = 'all';
			
			if ($story) {
				$ncrtsTrack = 'v2/historical/all';
			}

			if ($countries && !$story) {
				$ncrtsTrack = 'countries/?sort=cases';
			} else if ($story && $countries) {
				$ncrtsTrack = 'v2/historical/'.$countries;
			}

			$ncrtsURI = $ncrtsURI.$ncrtsTrack;
			$args = array(
				'timeout' => 60
			); 
			$request = wp_remote_get($ncrtsURI, $args);
			$body = wp_remote_retrieve_body( $request );
			$data = json_decode( $body );

			$ncrtsGen = current_time('timestamp');
			if (get_option('setUpd')) {
				update_option( 'setUpd', $ncrtsGen);
			} else {
				add_option( 'setUpd', $ncrtsGen );
			}

			return $data;
		}
		
		function nycreatis_shortcode( $atts ){
			$params = shortcode_atts( array(
				'title_widget' => esc_attr__( 'Worldwide', 'covid' ),
				'country' => null,
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'today_cases' => esc_attr__( 'New Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'total_title' => esc_attr__( 'Total', 'covid' ),
				'format' => 'default'
			), $atts );

			$data = get_option('nycreatisAL');
			if ($params['country'] || $params['format'] == 'card' ) {
				$data = get_option('nycreatisCC');
				if ($params['country'] && $params['format'] !== 'card' ) {
					$new_array = array_filter($data, function($obj) use($params) {
						if ($obj->country === $params['country']) {
							return true;
						}
						return false;
					});
					if ($new_array) {
						$data = reset($new_array);
					}
				}
			}
			ob_start();
			if ($params['format'] == 'card') {
				echo $this->render_card($params, $data);
			} else {
				echo $this->render_widget($params, $data);
			}
			return ob_get_clean();
		}
		
		function nycreatis_short_line( $atts ){
			$params = shortcode_atts( array(
				'country' => null,
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'today_title' => esc_attr__( 'Today', 'covid' ),
			), $atts );
			$data = get_option('nycreatisAL');
			if ($params['country'] || $params['type'] == 'list' ) {
				$data = get_option('nycreatisCC');
				if ($params['country'] && $params['type'] !== 'list' ) {
					$new_array = array_filter($data, function($obj) use($params) {
						if ($obj->country === $params['country']) {
							return true;
						}
						return false;
					});
					if ($new_array) {
						$data = reset($new_array);
					}
				}
			}
			ob_start();
			echo $this->render_line($params, $data);
			return ob_get_clean();
		}
		
		function nycreatis_short_sheet( $atts ){
			$params = shortcode_atts( array(
				'confirmed_title' => esc_attr__( 'Total Cases', 'covid' ),
				'today_cases' => esc_attr__( 'New Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Total Deaths', 'covid' ),
				'today_deaths' => esc_attr__( 'New Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'active_title' => esc_attr__( 'Active', 'covid' ),
				'country_title' => esc_attr__( 'Country', 'covid' ),
				'lang_url' => "",
				"search" => true,
				"showing" => 10
			), $atts );
			$data = get_option('nycreatisCC');
			ob_start();
			echo $this->render_sheet($params, $data);
			return ob_get_clean();
		}
		
		function nycreatis_short_roll( $atts ){
			$params = shortcode_atts( array(
				'title_widget' => esc_attr__( 'Worldwide Stat', 'covid' ),
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'country_title' => esc_attr__( 'Country', 'covid' )
			), $atts );
			$data = get_option('nycreatisCC');

			ob_start();
			echo $this->render_roll($params, $data);
			return ob_get_clean();
		}
		
		function nycreatis_short_map( $atts ){
			$params = shortcode_atts( array(
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'active_title' => esc_attr__( 'Active', 'covid' )
			), $atts );
			$data = [];

			ob_start();
			echo $this->render_map($params, $data);
			return ob_get_clean();
		}
		
		function nycreatis_short_mapus( $atts ){
			$params = shortcode_atts( array(
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'active_title' => esc_attr__( 'Active', 'covid' )
			), $atts );
			$data = [];

			ob_start();
			echo $this->render_mapus($params, $data);
			return ob_get_clean();
		}

		function nycreatis_short_graph( $atts ){
			$params = shortcode_atts( array(
				'title' => esc_attr__( 'Worldwide', 'covid' ),
				'country' => null,
				'confirmed_title' => esc_attr__( 'Cases', 'covid' ),
				'deaths_title' => esc_attr__( 'Deaths', 'covid' ),
				'recovered_title' => esc_attr__( 'Recovered', 'covid' ),
				'updated_title' => esc_attr__( 'Updated: ', 'covid' )
			), $atts );
			$data = get_option('nycreatisAL');
			if ($params['country']) {
				$data = $this->ncrtsGen($params['country'], true);
			}
			ob_start();
			echo $this->render_graph($params, $data);
			return ob_get_clean();
		}
		
		function render_graph($params, $data){
			wp_enqueue_style( 'covid' );
			wp_enqueue_script( 'covid' );
			wp_enqueue_script( 'graph' );
			$uniqId = 'covid_graph_'.md5(uniqid(rand(),1));
			$all_options = get_option( 'covid_options' );
			ob_start();
			?>
				<div class="covid19-graph <?php echo $all_options['cov_theme'];?> <?php if($all_options['cov_rtl']==!$checked) echo 'rtl_enable'; ?>" style="font-family:<?php echo $all_options['cov_font'];?>"><span class="covid19-graph-title"><?php esc_attr_e($params['title']); ?></span>
					<canvas id="<?php echo esc_attr($uniqId); ?>" data-confirmed="<?php esc_attr_e($params['confirmed_title']); ?>" data-deaths="<?php esc_attr_e($params['deaths_title']); ?>" data-recovered="<?php esc_attr_e($params['recovered_title']); ?>" data-json="<?php esc_attr_e(json_encode($data)); ?>" data-country="<?php esc_attr_e($params['country']); ?>"
					></canvas>
				</div>
			<?php
			return ob_get_clean();
		}
		
		function render_map($params, $data){
			ob_start();
			include( COVID_NYCREATIS_PATH .'includes/render_map.php');
			return ob_get_clean();
		}
		
		function render_mapus($params, $data){
			ob_start();
			include( COVID_NYCREATIS_PATH .'includes/render_mapus.php');
			return ob_get_clean();
		}
		
		function render_card($params, $data){
			ob_start();
			include( COVID_NYCREATIS_PATH .'includes/render_card.php');
			return ob_get_clean();
		}

		function render_widget($params, $data){
			wp_enqueue_style( 'covid' );
			$all_options = get_option( 'covid_options' );
			ob_start();
			?>
			<div class="covid19-card  <?php echo $all_options['cov_theme'];?> <?php if($all_options['cov_rtl']==!$checked) echo 'rtl_enable'; ?>" style="font-family:<?php echo $all_options['cov_font'];?>">
				<h4 class="covid19-title-big"><?php echo esc_html(isset($params['title_widget']) ? $params['title_widget'] : ''); ?></h4>
				<div class="covid19-row">
					<div class="covid19-col covid19-confirmed">
						<div class="covid19-num"><?php echo number_format($data->cases); ?></div>
						<div class="covid19-title"><?php echo esc_html($params['confirmed_title']); ?></div>
					</div>
					<div class="covid19-col covid19-deaths">
						<div class="covid19-num"><?php echo number_format($data->deaths); ?></div>
						<div class="covid19-title"><?php echo esc_html($params['deaths_title']); ?></div>
					</div>
					<div class="covid19-col covid19-recovered">
						<div class="covid19-num"><?php echo number_format($data->recovered); ?></div>
						<div class="covid19-title"><?php echo esc_html($params['recovered_title']); ?></div>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		function render_line($params, $data){
			wp_enqueue_style( 'covid' );
			$all_options = get_option( 'covid_options' );
			ob_start();
			?>
			<span class="covid19-value">
				<?php echo esc_html($params['confirmed_title']); ?> <?php echo number_format($data->cases); ?>, <?php echo esc_html($params['deaths_title']); ?> <?php echo number_format($data->deaths); ?>, <?php echo esc_html($params['recovered_title']); ?> <?php echo number_format($data->recovered); ?>
			</span>
			<?php
			return ob_get_clean();
		}
		
		function render_roll($params, $data){
			wp_enqueue_style( 'covid' );
			$dataAll = get_option('nycreatisAL');
			$all_options = get_option( 'covid_options' );
			ob_start();
			?>
			<div class="covid19-roll <?php echo $all_options['cov_theme'];?> <?php if($all_options['cov_rtl']==!$checked) echo 'rtl_enable'; ?>" style="font-family:<?php echo $all_options['cov_font'];?>">
				<div class="covid19-title-big"><?php echo esc_html(isset($params['title_widget']) ? $params['title_widget'] : ''); ?></div>
				<ul class="covid19-roll2">
					<li class="covid19-country aiByXc">
						<div class=""></div>
						<div class="covid19-country-stats covid19-head">
							<div class="covid19-col covid19-confirmed">
								<div class="covid19-label"><?php echo esc_html($params['confirmed_title']); ?></div>
							</div>
							<div class="covid19-col covid19-deaths">
								<div class="covid19-label"><?php echo esc_html($params['deaths_title']); ?></div>
							</div>
							<div class="covid19-col covid19-recovered">
								<div class="covid19-label"><?php echo esc_html($params['recovered_title']); ?></div>
							</div>
						</div>
					</li>
				<?php foreach ($data as $key => $value) : ?>
					<li class="covid19-country">
						<div class="">
							<?php if (isset($value->countryInfo->flag)) : ?>
								<span class="country_flag" style="background:url(<?php echo esc_html($value->countryInfo->flag); ?>) center no-repeat;background-size:cover;"></span>
							<?php endif; ?>
							<?php echo esc_html($value->country); ?>
						</div>
						<div class="covid19-country-stats">
							<div class="covid19-col covid19-confirmed">
								<div class="covid19-value"><?php echo number_format_i18n($value->cases); ?></div>
							</div>
							<div class="covid19-col covid19-deaths">
								<div class="covid19-value"><?php echo number_format_i18n($value->deaths); ?></div>
							</div>
							<div class="covid19-col covid19-recovered">
								<div class="covid19-value"><?php echo number_format_i18n($value->recovered); ?></div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
				<div class="covid19-country covid19-total">
					<div class=""><?php esc_html_e($params['total_title']); ?></div>
					<div class="covid19-country-stats">
						<div class="covid19-col covid19-confirmed">
							<div class="covid19-value"><?php echo number_format_i18n($dataAll->cases); ?></div>
						</div>
						<div class="covid19-col covid19-deaths">
							<div class="covid19-value"><?php echo number_format_i18n($dataAll->deaths); ?></div>
						</div>
						<div class="covid19-col covid19-recovered">
							<div class="covid19-value"><?php echo number_format_i18n($dataAll->recovered); ?></div>
						</div>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
		
		function render_sheet($params, $data){
			wp_enqueue_style( 'covid' );
			wp_enqueue_style( 'jquery.datatables' );
			wp_enqueue_script( 'jquery.datatables' );
			$uniqId = 'covid_table_'.md5(uniqid(rand(),1));
			$all_options = get_option( 'covid_options' );
			ob_start();
			?>
				<div class="table100 ver1 <?php echo $all_options['cov_theme'];?> <?php if($all_options['cov_rtl']==!$checked) echo 'rtl_enable'; ?>" style="font-family:<?php echo $all_options['cov_font'];?>">
				<div class="covid19-sheet table100-nextcols">
					<table class="responsive" id="<?php echo esc_attr($uniqId); ?>" data-page-length="<?php echo esc_attr($params['showing']); ?>" role="grid" width="100%">
						<thead>
							<tr class="row100 head">
								<th class="cell100 column2"><?php echo esc_html($params['country_title']); ?></th>
								<th class="cell100 column3"><?php echo esc_html($params['confirmed_title']); ?></th>
								<th class="cell100 column5"><?php echo esc_html($params['today_cases']); ?></th>
								<th class="cell100 column6"><?php echo esc_html($params['deaths_title']); ?></th>								
								<th class="cell100 column7"><?php echo esc_html($params['today_deaths']); ?></th>
								<th class="cell100 column8"><?php echo esc_html($params['recovered_title']); ?></th>
								<th class="cell100 column9"><?php echo esc_html($params['active_title']); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($data as $key => $value) : ?>
							<tr class="row100 body">
								<td class="cell100 column2 Ncrts-<?php $arr = explode(' ',trim($value->country)); echo $arr[0]; ?>" data-label="<?php echo esc_html($params['country_title']); ?>" title="<?php echo esc_html($value->country); ?>">
								<?php if (isset($value->countryInfo->flag)) : ?>
									<span class="country_flag" style="background:url(<?php echo esc_html($value->countryInfo->flag); ?>) center no-repeat;background-size:cover;"></span>
								<?php endif; ?>
								<?php echo esc_html($value->country); ?></td>
								<td class="cell100 column3" data-label="<?php echo esc_html($params['confirmed_title']); ?>"><?php echo number_format($value->cases); ?></td>
								<td class="cell100 column5" data-label="<?php echo esc_html($params['today_cases']); ?>"><?php echo number_format($value->todayCases); ?></td>
								<td class="cell100 column6" data-label="<?php echo esc_html($params['deaths_title']); ?>"><?php echo number_format($value->deaths); ?></td>
								<td class="cell100 column7" data-label="<?php echo esc_html($params['today_deaths']); ?>"><?php echo number_format($value->todayDeaths); ?></td>
								<td class="cell100 column8" data-label="<?php echo esc_html($params['recovered_title']); ?>"><?php echo number_format($value->recovered); ?></td>
								<td class="cell100 column9" data-label="<?php echo esc_html($params['active_title']); ?>"><?php echo number_format($value->active); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<script>
						jQuery(document).ready(function($) {
							$('#<?php echo esc_attr($uniqId); ?>').DataTable({
								"responsive": true,
								"bInfo" : false,
								"order": [[ 1, "desc" ]],
								"searching": <?php echo esc_attr($params['search']); ?>,
								"language": {
									"url": "<?php echo esc_url($params['lang_url']); ?>",
									"search": "_INPUT_",
									"sLengthMenu": "_MENU_",
									"searchPlaceholder": "Country search..",
									"paginate": {
										"next": "»",
										"previous": "«"
									}
								}
							});
						});
					</script>
				</div>
				</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * Callback
		 */ 
		function true_option_page(){
			global $true_page;
			?><div id="ncrts-admin-container">
				<div class="grid-x grid-container grid-padding-y admin-settings">
				<div class="cell small-12">
				<div class="callout">
					<h2><?php echo esc_html__( 'COVID-19 Options', 'covid' );?><span class="v">2.1.4</span></h2>
					<p><?php echo esc_html__( 'The plugin allows adding statistics table/widgets via shortcode to inform site visitors about changes in the situation about Coronavirus pandemic.', 'covid' );?></p>
				</div>
				<div class="tabs-content grid-x" data-tabs-content="setting-tabs">
				<div class="tabs-panel is-active" id="options" role="tabpanel" aria-labelledby="options-label">
				<!--<div class="notify"></div>-->
				<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
					<form method="post" enctype="multipart/form-data" action="options.php">
						<?php 
						settings_fields('covid_options');
						do_settings_sections($true_page);
						?>
						<p class="submit">  
							<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
						</p>
					</form>
				</div>
						
		<?php $data = get_option('nycreatisCC');?>
		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Widget Shortcode', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Sidebar Text widget</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<h4><?php esc_html_e('Countries:', 'covid'); ?></h4>
			</div>
			<div class="small-12 cell">
				<select name="covid_country">
					<option value=""><?php esc_html_e('All Countries - Worldwide Statistics', 'covid'); ?></option>
					<?php
					foreach ($data as $item) {
						echo '<option value="'.$item->country.'">'.$item->country.'</option>';
					}
					?>
				</select>
			</div>
			<p id="covidsh" class="covid_shortcode"><?php esc_html_e('[COVID19-WIDGET title_widget="Worldwide" confirmed_title="Cases" deaths_title="Deaths" recovered_title="Recovered"]', 'covid'); ?></p>
		</div>
		
		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Map of Countries', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Posts or Pages</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<div id="covid19">
					<p id="covidsh" class="covid_shortcode"><?php esc_html_e('[COVID19 confirmed_title="Cases" deaths_title="Deaths" recovered_title="Recovered"]', 'covid'); ?></p>
				</div>
			</div>
		</div>
		
		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Map of the USA', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Posts or Pages</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<div id="covid19">
					<p id="covidsh" class="covid_shortcode"><?php esc_html_e('[COVID19-MAPUS confirmed_title="Confirmed" deaths_title="Deaths" active_title="Active"]', 'covid'); ?></p>
				</div>
			</div>
		</div>
		
		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('List of Countries', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Posts or Pages</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<div id="covid19">
					<p id="covidsh" class="covid_shortcode"><?php esc_html_e('[COVID19-ROLL title_widget="Worldwide" total_title="Total" confirmed_title="Cases" deaths_title="Deaths" recovered_title="Recovered"]', 'covid'); ?></p>
				</div>
			</div>
		</div>
		
		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Graph', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Posts or Pages</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<h4><?php esc_html_e('Countries:', 'covid'); ?></h4>
			</div>
			<div class="small-12 cell">
				<select name="covid_country_graph">
					<option value=""><?php esc_html_e('All Countries - Worldwide Statistics', 'covid'); ?></option>
					<?php
					foreach ($data as $item) {
						echo '<option value="'.$item->country.'">'.$item->country.'</option>';
					}
					?>
				</select>
			</div>
			<p id="covidsh-graph" class="covid_shortcode"><?php _e('[COVID19-GRAPH title="World History Chart" confirmed_title="Confirmed" deaths_title="Deaths" recovered_title="Recovered"]', 'covid'); ?></p>
		</div>

		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Table of Countries', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>Posts or Pages</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<div id="covid19">
					<p id="covidsh" class="covid_shortcode"><?php esc_html_e('[COVID19-SHEET country_title="Country" confirmed_title="Cases" today_cases="New Cases" deaths_title="Deaths" today_deaths="New Deaths" recovered_title="Recovered"]', 'covid'); ?></p>
				</div>
			</div>
		</div>

		<div class="grid-x display-required callout" style="opacity: 1; pointer-events: inherit;">
			<div class="small-12 cell">
				<h3><?php esc_html_e('Inline Text data', 'covid'); ?></h3>
			</div>
			<div class="small-12 cell"><small><?php _e('Paste this shortcode into <b>text</b>.', 'covid'); ?></small></div>			
			<div class="small-12 cell">
				<h4><?php esc_html_e('Countries:', 'covid'); ?></h4>
			</div>
			<div class="small-12 cell">
				<select name="covid_country_line">
					<option value=""><?php esc_html_e('All Countries - Worldwide Statistics', 'covid'); ?></option>
					<?php
					foreach ($data as $item) {
						echo '<option value="'.$item->country.'">'.$item->country.'</option>';
					}
					?>
				</select>
			</div>
			<p id="covidsh-line" class="covid_shortcode"><?php _e('[COVID19-LINE confirmed_title="cases" deaths_title="deaths" recovered_title="recovered"]', 'covid'); ?></p>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
			<?php
		}
		
		function nycreatis_enqueues(){
			$covid_options = get_option('covid_options');
			wp_enqueue_style('nycreatis_style', COVID_NYCREATIS_URL . 'assets/style.css', array(), COVID_NYCREATIS_VER );
			$nycreatis_custom_css = "{$covid_options['cov_css']}";
			wp_add_inline_style('nycreatis_style', $nycreatis_custom_css);
		}
	}
		new CovidNycreatis();			
}
	
		add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'covid_add_plugin_page_contact_link');
		function covid_add_plugin_page_contact_link( $links ) {
			$links[] = '<a href="http://1.envato.market/CovidHelp" target="_blank">' . __('Get Help') . '</a>';
			return $links;
		}

		add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'covid_add_plugin_page_settings_link');
		function covid_add_plugin_page_settings_link( $links ) {
			$links[] = '<a href="' .
				admin_url( 'options-general.php?page=covid-plugin-options' ) .
				'">' . __('Settings') . '</a>';
			return $links;
		}
	
		function true_option_settings() {
			global $true_page;
			// ( true_validate_settings() )
			register_setting( 'covid_options', 'covid_options', 'true_validate_settings' );
		 
			// Add section
			add_settings_section( 'true_section_1', esc_html__( 'Customization', 'covid' ), '', $true_page );

			$true_field_params = array(
				'type'      => 'text',
				'id'        => 'cov_title',
				'default'	=> esc_html__( 'An interactive web-based dashboard to track COVID-19 in real time.', 'covid' ),
				'desc'      => '',
				'label_for' => 'cov_title'
			);
			add_settings_field( 'my_text_field', esc_html__( 'Worldwide Map Title', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );
		 
			$true_field_params = array(
				'type'      => 'textarea',
				'id'        => 'cov_desc',
				'default'	=> esc_html__( 'To identify new cases, we monitor various twitter feeds, online news services, and direct communication sent through the dashboard.', 'covid' ),
				'desc'      => '',
				'label_for' => 'cov_desc'
			);
			add_settings_field( 'cov_desc_field', esc_html__( 'Worldwide Map Subtitle', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

			//	$true_field_params = array(
			//		'type'      => 'checkbox',
			//		'id'        => 'cov_countries_hide',
			//		'desc'      => esc_html__( 'Hide', 'covid' )
			//	);
			//	add_settings_field( 'cov_countries_hide_field', esc_html__( 'List of countries', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );
				
			//	$true_field_params = array(
			//		'type'      => 'checkbox',
			//		'id'        => 'cov_map_hide',
			//		'desc'      => esc_html__( 'Hide', 'covid' )
			//	);
			//	add_settings_field( 'cov_map_hide_field', esc_html__( 'Worldwide Map', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_2', $true_field_params );

			$true_field_params = array(
				'type'      => 'checkbox',
				'id'        => 'cov_rtl',
				'desc'      => esc_html__( 'Enable', 'covid' ),
				'label_for' => 'cov_rtl'
			);
			add_settings_field( 'cov_rtl_field', esc_html__( 'Right-to-Left support', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );


			$true_field_params = array(
				'type'      => 'select',
				'id'        => 'cov_theme',
				'desc'      => '',
				'vals'		=> array( 'dark_theme' => esc_html__( 'Dark', 'covid' ), 'light_theme' => esc_html__( 'Light', 'covid' )),
				'label_for' => 'cov_theme'
			);
			add_settings_field( 'cov_theme_field', esc_html__( 'Theme', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );
			
			$true_field_params = array(
				'type'      => 'select',
				'id'        => 'cov_font',
				'desc'      => '',
				'label_for' => 'cov_font',
				'vals'		=> array( '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Ubuntu,Helvetica Neue,sans-serif' => 'Default', 'inherit' => 'As on the website', 'Arial,Helvetica,sans-serif' => 'Arial, Helvetica', 'Tahoma,Geneva,sans-serif' => 'Tahoma, Geneva', 'Trebuchet MS, Helvetica,sans-serif' => 'Trebuchet MS, Helvetica', 'Verdana,Geneva,sans-serif' => 'Verdana, Geneva', 'Georgia,sans-serif' => 'Georgia', 'Palatino,sans-serif' => 'Palatino', 'Times New Roman,sans-serif' => 'Times New Roman')
			);
			add_settings_field( 'cov_font_field', esc_html__( 'Font', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );
		 
			$true_field_params = array(
				'type'      => 'textarea',
				'id'        => 'cov_css',
				'default'	=> null,
				'desc'      => esc_html__( 'Without &lt;style&gt; tags', 'covid' ),
				'label_for' => 'cov_css'
			);
			add_settings_field( 'cov_css_field', esc_html__( 'Custom CSS', 'covid' ), 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );
		}
		add_action( 'admin_init', 'true_option_settings' );
		 
		/*
		 * Show fields
		 */
		function true_option_display_settings($args) {
			extract( $args );
		 
			$option_name = 'covid_options';
		 
			$o = get_option( $option_name );
		 
			switch ( $type ) {  
				case 'text':  
					$o[$id] = esc_attr( stripslashes($o[$id]) );
					echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$default' />";  
					echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
				break;
				case 'textarea':  
					$o[$id] = esc_attr( stripslashes($o[$id]) );
					echo "<textarea class='code regular-text' cols='12' rows='3' type='text' id='$id' name='" . $option_name . "[$id]'>$o[$id]</textarea>";    
					echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
				break;
				case 'checkbox':
					$checked = ($o[$id] == 'on') ? " checked='checked'" :  '';  
					echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";  
					echo ($desc != '') ? $desc : "";
					echo "</label>";  
				break;
				case 'select':
					echo "<select id='$id' name='" . $option_name . "[$id]'>";
					foreach($vals as $v=>$l){
						$selected = ($o[$id] == $v) ? "selected='selected'" : '';  
						echo "<option value='$v' $selected>$l</option>";
					}
					echo ($desc != '') ? $desc : "";
					echo "</select>";  
				break;
				case 'radio':
					echo "<fieldset>";
					foreach($vals as $v=>$l){
						$checked = ($o[$id] == $v) ? "checked='checked'" : '';  
						echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
					}
					echo "</fieldset>";  
				break; 
			}
		}
		 
		/*
		 * Check fields
		 */
		function true_validate_settings($input) {
			foreach($input as $k => $v) {
				$valid_input[$k] = trim($v);
			}
			return $valid_input;
		}

		function insert_jquery(){
			wp_enqueue_script('jquery', false, array(), false, false);
			}
		add_filter('wp_enqueue_scripts','insert_jquery',1);
