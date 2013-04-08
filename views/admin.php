<?php
global $sysinfo;

$theme = wp_get_theme();
$browser = $sysinfo->get_browser();
$plugins = $sysinfo->get_all_plugins();
$active_plugins = $sysinfo->get_active_plugins();
$memory_limit = ini_get('memory_limit');
$memory_usage = $sysinfo->get_memory_usage();

$info_data = array(
	__( 'Server Info', 'sysinfo' ) => array(
		'WordPress Version' => get_bloginfo( 'version' ),
		'PHP Version' => PHP_VERSION,
		'MySQL Version' => mysql_get_server_info(),
		'Web Server' => $_SERVER['SERVER_SOFTWARE'],
	),
	__( 'Site Info', 'sysinfo' ) => array(
		'WordPress URL' => get_bloginfo('wpurl'),
		'Home URL' => get_bloginfo('url'),
		'Content Directory' => WP_CONTENT_DIR,
		'Content URL' => WP_CONTENT_URL,
		'Plugin Directory' => WP_PLUGIN_DIR,
		'Plugin URL' => WP_PLUGIN_URL,
		'Uploads Directory' => ( defined('UPLOADS') ? UPLOADS : WP_CONTENT_DIR . '/uploads' ),
		'Cookie Domain' => ( defined('COOKIE_DOMAIN') ? ( COOKIE_DOMAIN ? COOKIE_DOMAIN : __('Disabled', 'sysinfo') ) : __('Not set', 'sysinfo') ),
	),
	__( 'PHP Info', 'sysinfo' ) => array(
		'PHP cURL Support' => ( function_exists( 'curl_init' ) ? __( 'Yes', 'sysinfo' ) : __( 'No', 'sysinfo' ) ),
		'PHP GD Support' => ( function_exists( 'gd_info' ) ? __( 'Yes', 'sysinfo' ) : __( 'No', 'sysinfo' ) ),
		'PHP Memory Limit' => $memory_limit,
		'PHP Memory Usage' => $memory_usage . 'M (' . round( $memory_usage / $memory_limit * 100, 0 ) . '%)',
		'PHP Post Max Size' => ini_get('post_max_size'),
		'PHP Upload Max Size' => ini_get('upload_max_filesize'),
	),
	__( 'Debug', 'sysinfo' ) => array(
		'WP_DEBUG' => ( defined( 'WP_DEBUG' ) ? ( WP_DEBUG ? __( 'Enabled', 'sysinfo' ) : __( 'Disabled', 'sysinfo' ) ) : __( 'Not set', 'sysinfo' ) ),
		'SCRIPT_DEBUG' => ( defined( 'SCRIPT_DEBUG' ) ? ( SCRIPT_DEBUG ? __( 'Enabled', 'sysinfo' ) : __( 'Disabled', 'sysinfo' ) ) : __( 'Not set', 'sysinfo' ) ),
		'SAVEQUERIES' => ( defined( 'SAVEQUERIES' ) ? ( SAVEQUERIES ? __( 'Enabled', 'sysinfo' ) : __( 'Disabled', 'sysinfo' ) ) : __( 'Not set', 'sysinfo' ) ),
	),
	__( 'Post Config' ) => array(
		'AUTOSAVE_INTERVAL' => ( defined( 'AUTOSAVE_INTERVAL' ) ? ( AUTOSAVE_INTERVAL ? AUTOSAVE_INTERVAL : __( 'Disabled', 'sysinfo' ) ) : __( 'Not set', 'sysinfo' ) ),
		'WP_POST_REVISIONS' => ( defined( 'WP_POST_REVISIONS' ) ? ( WP_POST_REVISIONS ? WP_POST_REVISIONS : __( 'Disabled', 'sysinfo' ) ) : __( 'Not set', 'sysinfo' ) ),
	),
	__( 'Multi-Site', 'sysinfo' ) => array(
		'Multi-Site Active' => ( is_multisite() ? __( 'Yes', 'sysinfo' ) : __( 'No', 'sysinfo' ) ),
	),
	__( 'Client Info', 'sysinfo' ) => array(
		'Operating System' => $browser['platform'],
		'Browser' => $browser['name'] . ' ' . $browser['version'],
		'User Agent' => $browser['user_agent'],
	),
);
?>

<div id="sysinfo">
	<div class="wrap">
		<div class="icon32">
			<img src="<?php echo plugins_url('sysinfo/images/sysinfo.png') ?>" />
		</div>
		
		<h2 class="title"><?php _e('SysInfo', 'sysinfo') ?> <span><a class="button-primary" href="#" onclick="window.open('<?php echo plugins_url('sysinfo/views/phpinfo.php') ?>', 'PHPInfo', 'width=800, height=600, scrollbars=1'); return false;"><?php _e('PHP Info', 'sysinfo') ?></a></span></h2>
		
		<div class="clear"></div>

<?php
foreach( $info_data as $section => $info ) :
?>
		<div class="section">
			<div class="header">
				<?php echo $section; ?>
			</div>
			
			<div class="inside">
				<table class="wp-list-table widefat" cellspacing="0">
					<tbody>
						<?php foreach( $info as $label => $data ) : ?>
						<tr>
							<td class="fixed label"><?php echo $label; ?>:</td>
							<td><?php echo $data; ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
<?php
endforeach;
?>

		<div class="section">
			<div class="header">
				<?php _e('Themes &amp; Plugins', 'sysinfo') ?>
			</div>
			
			<div class="inside">
				<h3>Active Theme:</h3>
				<table class="wp-list-table widefat" cellspacing="0">
					<tbody>
						<tr>
							<td class="fixed label"><?php echo $theme->get('Name'); ?> <?php echo $theme->get('Version'); ?></td>
							<td><?php echo $theme->get('ThemeURI'); ?></td>
						</tr>
					</tbody>
				</table>

				<h3>Active Plugins:</h3>
				<table class="wp-list-table widefat" cellspacing="0">
					<tbody>
				<?php
				foreach ($plugins as $plugin_path => $plugin) {
					// Only show active plugins
					if (in_array($plugin_path, $active_plugins)) {
						echo '<tr>';
						echo '<td class="fixed label">' . $plugin['Name'] . ' ' . $plugin['Version'] . '</td>';

						if (isset($plugin['PluginURI'])) {
							echo '<td>' . $plugin['PluginURI'] . '</td>';
						}
						else {
							echo '<td>&nbsp;</td>';
						}

						echo '</tr>';
					}
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
