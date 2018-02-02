<?php defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'it_IT.UTF-8');?>
<!-- tooltip JQuery -->
<script>
$(document).ready(function() {
      $('#dttodo').DataTable({
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
          dayClick: function() {
            alert('a day has been clicked!');
          },
          header: {
        center: 'month,prox7' // buttons for switching between views
        },
        views: {
        prox7: {
            type: 'agenda',
            duration: { days: 7 },
            buttonText: 'Prossimi 7 gg'
        }
      }
      })
} );



$( function() {
  $( document ).tooltip();
} );
</script>
<!-- Fine tooltip-->
