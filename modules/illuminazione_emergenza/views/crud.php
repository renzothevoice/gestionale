<div class="riquadro_bianco">
<?php
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

<?php endforeach; ?>
<?php foreach($js_files as $file): ?>

    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>
</div>
<!-- JQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery.form.js"></script>
