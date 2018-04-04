<div class="container">
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="titulos titulo_interno">
							<h3>Grupos Parceiros</h3>
						</div>
						<div class="spacer_hq"></div>
						<div class="listagem-hqs">							
						<ul class="list-group">
								<?php if(Tools::IsValid($grupos) && sizeof($grupos) > 0): ?>
									<?php foreach ($grupos as $obj): ?>
										<li class="list-group-item"><a href="<?php echo $obj->url_grupo?>"><?php echo $obj->nome_grupo?></a></li>
									<?php endforeach; ?>				
								<?php endif;?>
								</ul>
						</div>
					</div>
			</div>