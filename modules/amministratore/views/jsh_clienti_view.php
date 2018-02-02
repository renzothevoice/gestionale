<?php defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'it_IT.UTF-8');?>
<!-- Fullcalendar-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.css"></script>
<script src="<?php echo base_url(); ?>assets/moment/moment-with-locales.js"></script>
<script src="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo base_url(); ?>assets/fullcalendar/locale/it.js"></script>
<!-- DataTables -->
<script>
$(document).ready(function() {
  $('#dtfatture').DataTable({
    "paging":   true,
      "ordering": false,
      "info":     false,
      "scrollY":  "300px",
      "scrollCollapse": true,
      "language": {"search": "Cerca: ",
      "lengthMenu": "Mostra _MENU_ fatture",
      "zeroRecords": "Non è presente alcuna fattura.",
      "paginate": {
          "first":      "Primo",
          "last":       "Ultimo",
          "next":       "Successivo",
          "previous":   "Precedente"
      }
    }
  });
  $('#calendar').fullCalendar({
    // put your options and callbacks here
    defaultView: 'listYear',
    editable: true,
    events: '<?php echo base_url(); ?>dashboard/eventi_cliente/1',
  })
} );
</script>
