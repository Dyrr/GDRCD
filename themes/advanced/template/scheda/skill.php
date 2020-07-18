	<div class="single">
		<h2>Skill</h2>
		PX: <?php echo gdrcd_filter_num($TAG['page']['pg']['esperienza'] - $TAG['page']['pg']['esperienza_spesa']); ?>/<?php echo gdrcd_filter_num($TAG['page']['pg']['esperienza']); ?>
	</div>
	<div class="break"></div>
<?php
	//CICLA I BLOCCKI DELLE SKILL
	foreach($TAG['page']['skill'] as $block) {
		//creando un contenitore per ogni blocco
?>
		<div class="block">
<?php
			//CICLA LE SKILL PER STATISTICA
			foreach($block as $k => $stat) {
				//inserendo il titolo della statistica
?>

				<h2><?php echo gdrcd_filter_out($TAG['page']['stats']['car'.$k]); ?></h2>
<?php
					//CICLA LE SKILL
					foreach($stat as $v) {
						//inserendo le voci delle skill
?>
						<div class="item">
							<div>
								<?php echo gdrcd_filter_out($v['nome']); ?>
							</div>
							<div>
<?php
								if($v['skill_down'] === true) {
?>
									<a href="main.php?page=scheda&pg=<?php echo gdrcd_filter_url($_REQUEST['pg']); ?>&op=addskill&what=<?php echo $v['id_abilita'] ?>">
										<i class="far fa-minus-square"></i>
									</a>
<?php
								} else {
?>
									<i class="far fa-minus-square invisible"></i>
<?php
								}
?>
<?php
								if($v['skill_up'] === true) {
?>
									<a href="main.php?page=scheda&pg=<?php echo gdrcd_filter_url($_REQUEST['pg']); ?>&op=subskill&what=<?php echo $v['id_abilita'] ?>">
										<i class="far fa-plus-square"></i>
									</a>
<?php
								} else {
?>
									<i class="far fa-plus-square invisible"></i>
<?php
								}
?>
							</div>
							<div>
								<progress value="<?php echo gdrcd_filter_out($v['grado']); ?>" max="10" />
							</div>
							<div><?php echo gdrcd_filter_out($v['grado']); ?></div>
						</div>
<?php
					}
?>
<?php
}
?>
		</div>
<?php
	}