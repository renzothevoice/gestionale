<?php defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'it_IT.UTF-8');?>
<!-- JS DataTables -->
<script>
$(document).ready(function() {
      $('#dtutenti').DataTable({
        "paging":   false,
          "ordering": false,
          "info":     false,
          "scrollY":  "300px",
          "scrollCollapse": true,
          "language": {"search": "Cerca utente: ",
          "lengthMenu": "Mostra _MENU_ utenti",
          "zeroRecords": "Non è presente alcun utente.",
          "paginate": {
              "first":      "Primo",
              "last":       "Ultimo",
              "next":       "Successivo",
              "previous":   "Precedente"
          }
        }
      });
		} );
		</script>
<!-- Fine JS DataTables-->
