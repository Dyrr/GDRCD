<nav>
	<ul>
		<li><i class="fas fa-user"></i> Pg
			<ul>

				<li>				
					<a href="main.php?page=scheda__scheda&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						Descrizione & look
					</a>
				</li>				
				<li>				
					<a href="main.php?page=scheda__scheda&op=storia&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						Storia
					</a>		
				</li>
			</ul>
		</li>		
		<li>				
			<a href="main.php?page=scheda__scheda&op=stats&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
				<i class="fas fa-chart-bar"></i> Skill
			</a>		
		</li>				
		<li><i class="fas fa-sitemap"></i> Oggetti
			<ul>

				<li>				
					<a href="main.php?page=scheda_oggetti&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['inventory']); ?>
					</a>
				</li>				
				<li>				
					<a href="main.php?page=scheda_equip&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['equipment']); ?>
					</a>		
				</li>
			</ul>
		</li>
		<li><i class="fas fa-tools"></i> Tools
			<ul>
<?php
				if(   $_REQUEST['pg'] == $_SESSION['login'] 
				   || $_SESSION['permessi'] >= GUILDMODERATOR) {
?>				
					<li>
						<a href="main.php?page=scheda_modifica&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
							<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['update']); ?>
						</a>
					</li>
<?php 
				}
?>					
<?php
				if($_SESSION['permessi'] >= MODERATOR) {
?>
					<li>	
						<a href="main.php?page=scheda_log&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
							<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['log']); ?>
						</a>
					</li>
					<li>
						<a href="main.php?page=scheda_gst&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
							<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['gst']); ?>
						</a>
					</li>
<?php 
				}
?>		
				<li>	
					<a href="main.php?page=scheda_trans&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['transictions']); ?>
					</a>
				</li>				
				<li>				
					<a href="main.php?page=scheda_px&pg=<?php echo gdrcd_filter('url', $_REQUEST['pg']); ?>">
						<?php echo gdrcd_filter('out', $MESSAGE['interface']['sheet']['menu']['experience']); ?>
					</a>
				</li>			
			</ul>
		</li>
	</ul>
</nav>