<?php
/**
 *  @file       themes/advanced/template/presenti/index.php
 *  
 *  @brief      Template della padina principale dei presenti
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
?>
<section class="presenti">
		<div class="page_title">
			<h2>test</h2>
		</div>
		<h2>Entrati</h2>
<?php
		//SE CI SONO PG NELL'ELENCO DEGLI ENTRATI DI RECENTE
		if($TAG['page']['entrati']['lista'] !== false){
			//visualizza l'elenco degli entrati
			\template\load('presenti/lista',$TAG['page']['entrati'],false);
		}
?>
		<h2>Usciti</h2>
<?php
		//SE CI SONO PG NELL'ELENCO DEGLI ENTRATI DI RECENTE
		if($TAG['page']['usciti']['lista'] !== false){
			//visualizza l'elenco degli entrati
			\template\load('presenti/lista',$TAG['page']['usciti'],false);
		}
?>
		<h2>In luogo</h2>
<?php
		//SE CI SONO PG NELL'ELENCO DEGLI ENTRATI DI RECENTE
		if($TAG['page']['inluogo']['lista'] !== false){
			//visualizza l'elenco degli entrati
			\template\load('presenti/lista',$TAG['page']['inluogo'],false);
		}
?>
</section>
<script>
	setTimeout(function(){
		$('.modulo.presenti').load('main.php?page=presenti');				
	}, 10000);
</script>