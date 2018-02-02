<?php defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'it_IT.UTF-8');?>
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<!-- tooltip JQuery -->
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
      $('#dtclienti').DataTable({
        "paging":   true,
          "ordering": false,
          "info":     false,
          "scrollY":  "300px",
          "scrollCollapse": true,
          "language": {"search": "Cerca: ",
          "lengthMenu": "Mostra _MENU_ clienti",
          "zeroRecords": "Non è presente alcun cliente.",
          "paginate": {
              "first":      "Primo",
              "last":       "Ultimo",
              "next":       "Successivo",
              "previous":   "Precedente"
          }
        }
      });
      $('#dtfattureinsolute').DataTable({
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
} );

$( function() {
  $( document ).tooltip();
} );
</script>
<!-- Fine tooltip-->
