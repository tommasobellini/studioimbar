<?php
$zozo_theme = wp_get_theme();
if($zozo_theme->parent_theme) {
    $template_dir =  basename( get_template_directory() );
    $zozo_theme = wp_get_theme($template_dir);
}
$zozo_theme_version = $zozo_theme->get( 'Version' );
$zozo_theme_name = $zozo_theme->get('Name');
$zozothemes_url = 'http://zozothemes.com/';
$ins_demo_stat = get_theme_mod( 'zoacres_demo_installed' );
$ins_demo_id = get_theme_mod( 'zoacres_installed_demo_id' );
?>
<div class="wrap about-wrap welcome-wrap zozothemes-wrap">
	<h1 class="hide" style="display:none;"></h1>
	<div class="zozothemes-welcome-inner">
		<div class="welcome-wrap">
			<h1><?php echo esc_html__( "Welcome to", "zoacres" ) . ' ' . '<span>'. $zozo_theme_name .'</span>'; ?>
			<p class="theme-logo"><span class="theme-version"><?php echo esc_attr( $zozo_theme_version ); ?></span></p></h1>
			
			<div class="about-text"><?php echo esc_html__( "Nice!", "zoacres" ) . ' ' . $zozo_theme_name . ' ' . esc_html__( "is now installed and ready to use. Get ready to build your site with more powerful WordPress theme. We hope you enjoy using it.", "zoacres" ); ?></div>
		</div>
		<h2 class="zozo-nav-tab-wrapper nav-tab-wrapper">
			<?php
			printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "System Status", "zoacres" ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=zoacres-installation' ), esc_html__( "Plugin and Demo", "zoacres" ) );
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=zoacres-support' ),  esc_html__( "Support", "zoacres" ) );
			?>
		</h2>
	</div>
	
	<div class="system-status-wrapper">
		<?php 
			$zoacres_theme = wp_get_theme();
			$max_execution_time = ini_get('max_execution_time');
			$max_input_vars = ini_get('max_input_vars');
			$post_max_size = ini_get('post_max_size');
			$php_version = phpversion();
			$php_version_class = version_compare( $php_version, '5.4.7', '>=') ? ' success' : ' warning';
			
			ob_start();
			phpinfo(INFO_MODULES);
			$info = ob_get_contents();
			ob_end_clean();
			$info = stristr($info, 'Client API version');
			preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
			$mysql_version = $match[0]; 
			$mysql_version_class = version_compare( $mysql_version, '5', '>=') ? ' success' : ' warning';
			
			$max_exe_class = $max_execution_time >= 300 ? ' success' : ' warning';
			$max_input_class = $max_input_vars >= 2000 ? ' success' : ' warning';
			$post_max = str_replace("M","",$post_max_size);
			$post_max_class = $post_max >= 10 ? ' success' : ' warning';
			
			$wp_version = get_bloginfo('version');
			$wp_version_class = version_compare( $wp_version, '4.5', '>=') ? ' success' : ' warning';
			
			$wp_mem = str_replace("M","",WP_MEMORY_LIMIT);
			$wp_mem_class = $wp_mem >= 64 ? ' success' : ' warning';
		?>
		<h3><?php esc_html_e('Zoacres System Status', 'zoacres'); ?></h3>
	
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="4"><b><?php esc_html_e('Theme Config', 'zoacres'); ?></b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="20%"><?php esc_html_e('Theme Name', 'zoacres'); ?></td>
					<td><?php esc_html_e('Zoacres', 'zoacres'); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Theme Version', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $zoacres_theme->get( 'Version' ) ); ?></td>
				</tr>
			</tbody>
		</table>
		
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="4"><b><?php esc_html_e('PHP Config', 'zoacres'); ?></b></th>
				</tr>
			</thead>
			<tbody>
				<?php if( class_exists( "ZoacresFamework" ) ): ?>
				<tr>
					<td width="20%"><?php esc_html_e('Server Software', 'zoacres'); ?></td>
					<td width="30%"><?php echo esc_html( zoacres_get_server_software() ); ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td><?php esc_html_e('PHP', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $php_version ); ?></td>
					<td width="40%"><?php esc_html_e('Required version 5.4.0. Recommended 5.6 or greater.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $php_version_class ); ?>" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('MySQL', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $mysql_version ); ?></td>
					<td><?php esc_html_e('Required version 5. Recommended 5.0 or greater.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $php_version_class ); ?>" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('max_execution_time', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $max_execution_time ); ?></td>
					<td><?php esc_html_e('Required max_execution_time 300.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $max_exe_class ); ?>" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('max_input_vars', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $max_input_vars ); ?></td>
					<td><?php esc_html_e('Required max_input_vars 2000.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $max_input_class ); ?>" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('post_max_size', 'zoacres'); ?></td>
					<td><?php echo esc_attr( $post_max_size ); ?></td>
					<td><?php esc_html_e('Required post_max_size 10M.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $post_max_class ); ?>" aria-hidden="true"></i></td>
				</tr>
			</tbody>
		</table>
		
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="4"><b><?php esc_html_e('WordPress Config', 'zoacres'); ?></b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="20%"><?php esc_html_e('Site URL', 'zoacres'); ?></td>
					<td><?php echo esc_url( get_site_url() );?></td>
				</tr>
				<tr>
					<td width="20%"><?php esc_html_e('Home URL', 'zoacres'); ?></td>
					<td><?php echo esc_url( get_home_url() ); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php esc_html_e('WP version', 'zoacres'); ?></td>
					<td width="30%"><?php echo esc_attr( $wp_version ); ?></td>
					<td width="40%"><?php echo esc_html__('Required version 4.5. Recommended ', 'zoacres') . esc_attr( $wp_version ); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $wp_version_class ); ?>" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td width="20%"><?php esc_html_e('WP Multisite Status', 'zoacres'); ?></td>
					<td><?php echo is_multisite() ? esc_html('Yes', 'zoacres') : esc_html('No', 'zoacres'); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php esc_html_e('WP Language', 'zoacres'); ?></td>
					<td><?php echo get_locale(); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php esc_html_e('WP Memory Limit', 'zoacres'); ?></td>
					<td><?php echo WP_MEMORY_LIMIT; ?></td>
					<td width="40%"><?php esc_html_e('Required memory limit 64M.', 'zoacres'); ?></td>
					<td><i class="ti-check<?php echo esc_attr( $wp_mem_class ); ?>" aria-hidden="true"></i></td>
				</tr>
			</tbody>
		</table>
		
	</div>
	
	<div class="zozothemes-thanks">
        <hr />
    	<p class="description"><?php echo esc_html__( "Thank you for choosing", "zoacres" ) . ' ' . $zozo_theme_name . '.'; ?></p>
    </div>
</div>