<br><br>
<div class="container checkout">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-default">
			<div class="panel-heading"><h3>Favoritos</h3></div>
			<div class="panel-body">
				<table class="table table-striped ">
						<thead>
							<tr class="warning">
								<th>Título</th>
								<th>Status</th>
								<th>Capítulo</th>
							</tr>
						</thead>
						<tbody>
						<?php if(Tools::IsValid($favoritos)):?>
							<?php foreach($favoritos as $fav):?>
								<tr>
									<td><a href="<?php echo SITE_URL.'/visao/geral/'.$fav->id; ?>"><?php echo $fav->titulo;?></a</td>
									<td><a href="<?php echo SITE_URL.'/visao/geral/'.$fav->id; ?>"><?php echo Tools::Equals($fav->status, "A") ? "Andamento" : "Concluído"; ?></a></td>
									<td><a href="<?php echo SITE_URL.'/visao/geral/'.$fav->id; ?>"><?php echo $fav->total_capitulos;?></a></td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 ">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Últimas Visualizações</h3></div>
				<div class="panel-body">
				<table class="table table-striped ">
					<thead>
						<tr class="warning">
							<th>Título</th>
							<th>Capítulo</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>
					<?php if(Tools::IsValid($histleitura)):?>
						<?php foreach($histleitura as $hist):?>
							<tr>
								<td><a href="<?php echo SITE_URL.'/leitura/classica/'.$hist->id_revista.'/'.$hist->ordem.'/'.(float)$hist->capitulo; ?>"><?php echo $hist->titulo;?></a</td>
								<td><a href="<?php echo SITE_URL.'/leitura/classica/'.$hist->id_revista.'/'.$hist->ordem.'/'.(float)$hist->capitulo; ?>"><?php echo (float) $hist->capitulo;?></a</td>
								<td><a href="<?php echo SITE_URL.'/leitura/classica/'.$hist->id_revista.'/'.$hist->ordem.'/'.(float)$hist->capitulo; ?>"><?php echo Tools::GetMyDate($hist->data, '2x');?></a></td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Novidades</h3></div>
				<div class="panel-body">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php for($cont = 1; $cont <= sizeof($novidades); $cont++):?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $cont;?>" <?php echo $cont == 1 ? "class=\"active\"" : ""?>></li>							
							<?php endfor;?>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<?php if(Tools::IsValid($novidades)):?>							
								<?php $i = 0; 
										foreach($novidades as $novidade):?>
									<div class="item <?php echo $i == 0 ? 'active' : ''?> " style="height: 434px;">										
										<a href="<?php echo SITE_URL.'/visao/geral/'.$novidade->id; ?>">
											<img src="<?php echo SITE_URL; ?>/img/hq/<?php echo $novidade->capa;?>" alt="<?php echo $novidade->titulo;?>" width="282" height="434" class="img-thumbnail center-block">
										</a>										
										<div class="carousel-caption">
											<h4><?php echo $novidade->titulo;?></h4>
										</div>
									</div>
								<?php $i++; 
										endforeach;?>
							<?php endif;?>
						</div>

						<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>