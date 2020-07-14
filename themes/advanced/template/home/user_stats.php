	<h2>Statistiche</h2>
	<table>
		<tr>
			<td>Utenti online</td>
			<td><?php echo gdrcd_filter_num($users['online']); ?></td>
		<tr>
		<td class="label"><?php echo gdrcd_filter('out', $MESSAGE['interface']['user']['stats']['creation_date']); ?>:
		</td>
		<td><?php echo gdrcd_format_date($site_activity['date_of_activity']); ?></td>
		</tr>
		<tr>
			<td><?php echo gdrcd_filter('out', $MESSAGE['interface']['user']['stats']['characters']); ?></td>
			<td><?php echo $registered_users['num']; ?></td>
		</tr>
		<tr>
			<td><?php echo gdrcd_filter('out', $MESSAGE['interface']['user']['stats']['exiled']); ?></td>
			<td><?php echo $banned_users['num']; ?></td>
		</tr>
		<tr>
			<td><?php echo gdrcd_filter('out', $PARAMETERS['names']['master']['plur']); ?></td>
			<td><?php echo $master_users['num']; ?></td>
		</tr>
		<tr>
			<td><?php echo gdrcd_filter('out', $PARAMETERS['names']['moderators']['plur']); ?></td>
			<td><?php echo $admin_users['num']; ?></td>
		</tr>
		<tr> 
			<td>Post settimanali</td>
			<td><?php echo $weekly_posts['num']; ?></td>
		</tr>
		<tr>
			<td>Azioni settimanali</td>
			<td><?php echo $weekly_actions    ['num']; ?></td>
		</tr>
		<tr class="pair">
			<td>Iscritti settimanali</td>
			<td><?php echo $weekly_signup['num']; ?></td>
		</tr>
	</table>