<?php defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'it_IT.UTF-8');
?>
<script>
<!-- Inizializzo JQuery -->
$(document).ready(function() {
  //fullCalendar
  // Recupero il parametro url per determinare lo stato di filtro presente
  var parametro_url = $(location).attr('href').substr($(location).attr('href').lastIndexOf('/') + 1);
  var filtro='';
  switch(parametro_url) {
    case 'A':
      filtro='ANNULLATO';
    break;
    case 'C':
      filtro='CHIUSO';
    break;
  }

  //alert('stai visualizzando: ' + filtro);
  //alert('stai visualizzando: ' + $(location).attr('href').substr($(location).attr('href').lastIndexOf('/') + 1));
  // Processo i dati mediante Ajax
  $.ajax({
    url: 'aquilaprem/calendario',
    type: 'POST',
    //data: 'azione=elenca; stato=CHIUSO',
    data: {'azione':'elenca', 'stato':filtro},
    async: false,
    success: function(s){
      json_events=s;
    }
  });

  $('#calendar').fullCalendar({
    events: JSON.parse(json_events),
    // put your options and callbacks here
    dayClick: function(date) {
      //alert('hai cliccato su un giorno vuoto!' + date.format());
      window.open('../tasks/nuovo/', "_self");
      return false;
    },
    eventClick: function(task) {
        window.open('../tasks/modifica/' + task.id , "_self");
        return true;
    },
    header:{
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
});
</script>
