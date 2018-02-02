<?php /***** MENU SECONDARIO DASHBOARD AQP *****/ ?>
<div class="container">
  <nav class="breadcrumb">
    <span class="breadcrumb-item">
      <b>DASHBOARD:</b>
      <a href="<?php echo base_url();?>aquilaprem/elenco">HOME</a> |
    </span>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-list-alt"></i> FILTRO <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url();?>aquilaprem/elenco"><i class="glyphicon glyphicon-indent-left"></i> Elenco Scadenze</a></li>
        <li><a href="<?php echo base_url();?>aquilaprem/elenco/A"><i class="fa fa-trash-o"></i> Filtra Annullate</a></li>
        <li><a href="<?php echo base_url();?>aquilaprem/elenco/C"><i class="fa fa-remove"></i> Filtra Chiuse</a></li>
      </ul>
    </li>
  </nav>
</div>
