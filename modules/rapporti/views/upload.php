<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php if(isset($error)){echo $error;}else{echo "non ci sono errori";}?>

<?php echo form_open_multipart('rapporti/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>
