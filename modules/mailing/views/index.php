</head>
<body>
  <div class="container">
  <div class="row">

<h1 style="color: yellow;">MAILING</h1>

<?php
      foreach ($tasks as $row) {
        echo '<p style="color: aqua;">';
        echo $row['scadenza']." - Email: ".$row['email1']." - Giorni: ".$row['giorni_mancanti'];
        echo " | ".$row['azione'];
        echo '</p>';
 }
 ?>
  </div>
  </div>
