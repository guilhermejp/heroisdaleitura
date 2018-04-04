<?php 
$baseURL            = $_REQUEST['baseURL'];
$idRevista          = $_REQUEST['idRevista'];
$idRevistaProcesso  = $_REQUEST['idRevistaProcesso'];
$idCapitulo         = $_REQUEST['idCapitulo'];
$targetPath         = $_SERVER['DOCUMENT_ROOT'] ."/img/temp/$idRevistaProcesso/$idCapitulo/";
$targetURL          = "$baseURL/img/temp/$idRevistaProcesso/$idCapitulo/";

if ( !empty($idRevista) ) {
    $targetPath = $_SERVER['DOCUMENT_ROOT'] .'/img/hq/'.$idRevista.'/Capitulo-'.$idCapitulo.'/';    
    $targetURL  = $baseURL.'/img/hq/'.$idRevista.'/Capitulo-'.$idCapitulo.'/';
}

if (is_dir($targetPath) && strlen($targetPath)>0):
    $files = scandir($targetPath);
    unset($files[0]);
    unset($files[1]);
    asort($files);    
?>
  <div class="col-md-12" id="sortable">
    <?php
        foreach( $files as $chave => $valor ):
          if (file_exists($targetPath.$valor)):
?>
      <div class="gallery" id="pagina_<?php echo $chave;?>">
        <div class="gallery-body">
          <a target="_blank" href="<?php echo $targetURL.$valor; ?>">
            <img src="<?php echo $targetURL.$valor; ?>" width="300" height="200">
            <input type="hidden" name="hdnPaginas[]" id="hdnPaginas_<?php echo $chave;?>" value="<?php echo $valor;?>">
          </a>
        </div>
        <div class="desc">
          <button type="button" class="btn btn-danger" data-toggle="modal" onclick="javascript: $(pagina_<?php echo $chave;?>).remove();">
            Remover
          </button>
        </div>
      </div>
        <?php endif; ?>
      <?php endforeach;?>
  </div>
  <script>
    $("#sortable").sortable();
    $("#sortable").disableSelection();
  </script>
  
<?php endif;?>
