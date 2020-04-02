<?php
require_once( '../config.php' );
$page_head[ 'title' ] = 'Calendar';
$page_head[ 'trail' ] = 'calendar';



require_login();


index_head();

?>
<meta charset='utf-8' />
<link href='fullcalendar.min.css' rel='stylesheet' />
<link href='fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='<?=ROOT?>calendar/lib/moment.min.js'></script>
<!--<script src='<?=ROOT?>calendar/lib/jquery.min.js'></script>-->
<script src='<?=ROOT?>calendar/fullcalendar.min.js'></script>
<script>
    jQuery(function(){		pushMeThf.auto_create();	});
    //	jQuery(function(){		pushMeThf.auto_demo();	});
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
        eventClick: function(eventObj) {
            edit_task(eventObj.id);
             // change the border color just for fun
            $(this).css('border-color', 'red');

        },
      defaultDate: '<?=date("Y-m-d")?>',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
        events: [
        <?php foreach ($tasks as $id=>$task) {
            if($task['completed'] > 0) { continue;}?>
            {
                id:<?=$task['task_id']?>,
                title: '(<?=strtoupper($task['type_task'])?>) '+'<?=$task['task_name']?>',
               // url: 'http://google.com/',
                start: '<?=$task['deadline']?>'
            },
        <?php } ?>


      ]
    });

  });

</script>
<style>
.chosen-container{ width: 100% !important;}
  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>

<p>Tipuri task-uri : C : cumparator, V : vanzare, G : general</p>
  <div id='calendar'></div>
<?php index_footer();?>
