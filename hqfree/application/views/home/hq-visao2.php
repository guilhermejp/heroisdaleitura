<div class="container-interno-hq">
	<div class="titulos">
			<a href="<?php echo SITE_URL.'/visao/geral/'.$revista[0]->id; ?>">    
				<h3><?php echo $revista[0]->titulo;?></h3>
			</a>
			<h4><span><b>Capitulo #</b><?php echo is_numeric($revista[0]->numero) ? (float) $revista[0]->numero : $revista[0]->numero;?></span></h4>
	</div>
	<div class="modo-exibição">
		<br />
		<span class="btn-exibicao">
			<a href="<?php echo SITE_URL.'/leitura/classica/'.$revista[0]->id.'/0/'.(float)$revista[0]->numero; ?>">Mudar para modo de leitura clássico</a>
		</span>
	</div>
	<div class="hq_ampliada" id="scroll_div">
		<!-- Exibição HQ -->
		<ul>
				<?php foreach ($revista as $obj): 
						$prox_pag = $obj->ordem + 1;
						$ult_pag  = $revista[sizeof($revista) - 1]->ordem;
						if($prox_pag > $ult_pag)
						$prox_pag = 0;
					?>
						<li id="<?php echo "scroll_li_".$obj->ordem;?>">
								<a id="<?php echo $prox_pag;?>" href="#">
									<img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $obj->arquivo;?>" class="img-responsive"/>				
								</a>
						</li>
				<?php endforeach; ?>
		</ul>
	</div>
	<!-- Final da exibição -->
</div>