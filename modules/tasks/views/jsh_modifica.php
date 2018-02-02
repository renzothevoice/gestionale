<script>
/** Script per la pagina di creazione evento **/
$(document).ready(function() {

  $.datepicker.regional['it'] = {
          closeText: 'Chiudi', // set a close button text
          currentText: 'Oggi', // set today text
          monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'], // set month names
          monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'], // set short month names
          dayNames: ['Domenica', 'Luned&#236', 'Marted&#236', 'Mercoled&#236', 'Gioved&#236', 'Venerd&#236', 'Sabato'], // set days names
          dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'], // set short day names
          dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gio', 'Ve', 'Sa'], // set more short days names
          dateFormat: 'dd/mm/yy' // set format date
      };

      //Datepicker Popups calendario per scegliere una data in formato dd/mm/YY
      $.datepicker.setDefaults($.datepicker.regional['it']);

      //$("#data_scadenza").datepicker({dateFormat: 'dd-mm-yy'}).datepicker('setDate', 'today');
      $("#data_scadenza").datepicker({dateFormat: 'dd-mm-yy'}).datepicker('setDate', 'today');
      //Imposto il dialog per le flash comunicazioni
      //$('#datescad').datepicker({dateFormat: 'dd-mm-yy', defaultDate: +30}).datepicker('setDate', 30);
      var date = new Date();
      var anno = date.getFullYear();
      var mese = ("0" + (date.getMonth() + 1)).slice(-2);
      var date = "05-" + mese + "-" + anno;
      $('#datescad').datepicker({dateFormat: 'dd-mm-yy'}).datepicker('setDate', date);
      $('#datemod, #datescmod').datepicker({dateFormat: 'dd-mm-yy'});
      $(function () {
          $("#dialog").dialog();
      });
});
</script>
