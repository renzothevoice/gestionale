<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('rapporti/upload', 'Upload Another File!'); ?></p>
<p>
  <h1>Errori:</h1>
<?php echo $display_errors; ?>
</p>
</body>
</html>
