<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SUPERMERCATO CIUFFETELLI:Rapporto Cliente</title>
    <meta name="author" content="Luigi Tessitore">
    <meta name="description" content="Rapporto Cliente">
    <meta name="keywords" content="cliente,noleggio,ciuffetelli">
    
  </head>
<!-- corpo -->
<body>
  <h1>Parliamo del cliente <?php echo $id_cliente;?></h1>
  <table class="" width="100%" height="100%">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Location</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Dave Gamache</td>
        <td>26</td>
        <td>Male</td>
        <td>San Francisco</td>
      </tr>
      <tr>
        <td>Dwayne Johnson</td>
        <td>42</td>
        <td>Male</td>
        <td>Hayward</td>
      </tr>
    </tbody>
  </table>
<!-- footer -->
<p>Copyright 2016-<?php echo date('Y');?> - Tessitore Luigi (389.7982643) www.tessi.it </p>
</body>
</html>
