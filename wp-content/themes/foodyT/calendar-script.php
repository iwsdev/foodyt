                
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<?php 
 $lan = $_SESSION['lanCode'];
if($lan=='' || $lan=='es')
{
$lan = 'es';
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/datepicker/js/datepicker.js"></script>
<?php	
}
else
{?>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/datepicker/js/datepicker-en.js"></script>
<?php }
?>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri();?>/datepicker/css/base.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri();?>/datepicker/css/clean.css" />

                <link href="<?php echo get_template_directory_uri();?>/datepicker/css/prettify.css" type="text/css" rel="stylesheet" />
                 <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/datepicker/js/prettify.js"></script>
                
                <style type="text/css">
      /* Style the calendar custom widget */
      #date-range {
        position:relative;
      }
      #date-range-field {
        width: 290px;
        height: 26px;
        overflow: hidden;
        position: relative;
        cursor:pointer;
        border: 1px solid #CCCCCC;
        border-radius: 5px 5px 5px 5px;
      }
      #date-range-field a  {
        color:#B2B2B2;
        background-color:#F7F7F7;
        text-align:center;
        display: block;
        position: absolute;
        width: 26px;
        height: 23px;
        top: 0;
        right: 0;
        text-decoration: none;
        padding-top:6px;
        border-radius: 0 5px 5px 0;
      }
      #date-range-field span {
        font-size: 12px;
        font-weight: bold;
        color: #404040;
        position: relative;
        top: 0;
        height: 26px;
        line-height: 26px;
        left: 5px;
        width: 250px;
        text-align: center;
      }
      
      #datepicker-calendar {
        position: relative;
        top: 2px;
        left: 0;
        overflow: hidden;
        width: 497px;
        height:153px;
        background-color: #F7F7F7;
        border: 1px solid #CCCCCC;
        border-radius: 0 5px 5px 5px;
        display:none;
        padding:10px 0 0 10px;
      }
      
      /* Remove default border from the custom widget since we're adding our own.  TBD: rework the dropdown calendar to use the default borders */
      #datepicker-calendar div.datepicker {
        background-color: transparent;
      border: none;
      border-radius: 0;
      padding: 0;
    }
        
                  .input-group{width:100%;}
                  #date-range-field{float:right;}
                  #datepicker-calendar{float:right; clear:right;}
                  
    </style>
      
    <script type="text/javascript">
      
      $(document).ready(function() {
        
        // pretty-print the source
        prettyPrint();
        
      
       
        
       
        
        /* Special date widget */
       <?php 
		  if($fromdatetxt!="" && $todatetxt!="")
		  {
	   ?>
		
          var to = new Date('<?php echo date('l F j Y H:i:s',strtotime($todatetxt));?>');
		  var from = new Date('<?php echo date('l F j Y H:i:s',strtotime($fromdatetxt));?>');
		  
		  <?php }else{?>
        var to = new Date();
        var from = new Date(to.getTime() - 1000 * 60 * 60 * 24 * 14);
	   <?php }?>
		//var to = new Date();
        //var from = new Date(to.getTime() - 1000 * 60 * 60 * 24 * 14);
		  
        console.log("from:"+from+"to:"+to);
        $('#datepicker-calendar').DatePicker({
          inline: true,
          date: [from, to],
          calendars: 3,
          mode: 'range',
          current: new Date(to.getFullYear(), to.getMonth() - 1, 1),
          onChange: function(dates,el) {
            // update the range display
            $('#date-range-field span').text(dates[0].getDate()+' '+dates[0].getMonthName(true)+', '+dates[0].getFullYear()+' - '+
                                        dates[1].getDate()+' '+dates[1].getMonthName(true)+', '+dates[1].getFullYear());
          }
        });
        
        // initialize the special date dropdown field
		/*
        $('#date-range-field span').text(from.getDate()+' '+from.getMonthName(true)+', '+from.getFullYear()+' - '+
                                        to.getDate()+' '+to.getMonthName(true)+', '+to.getFullYear()); */
        
        // bind a click handler to the date display field, which when clicked
        // toggles the date picker calendar, flips the up/down indicator arrow,
        // and keeps the borders looking pretty
        $('#date-range-field').bind('click', function(){
          $('#datepicker-calendar').toggle();
          if($('#date-range-field a').text().charCodeAt(0) == 9660) {
            // switch to up-arrow
            $('#date-range-field a').html('&#9650;');
            $('#date-range-field').css({borderBottomLeftRadius:0, borderBottomRightRadius:0});
            $('#date-range-field a').css({borderBottomRightRadius:0});
          } else {
            // switch to down-arrow
            $('#date-range-field a').html('&#9660;');
            $('#date-range-field').css({borderBottomLeftRadius:5, borderBottomRightRadius:5});
            $('#date-range-field a').css({borderBottomRightRadius:5});
          }
          return false;
        });
        
        // global click handler to hide the widget calendar when it's open, and
        // some other part of the document is clicked.  Note that this works best
        // defined out here rather than built in to the datepicker core because this
        // particular example is actually an 'inline' datepicker which is displayed
        // by an external event, unlike a non-inline datepicker which is automatically
        // displayed/hidden by clicks within/without the datepicker element and datepicker respectively
        $('html').click(function() {
          if($('#datepicker-calendar').is(":visible")) {
            $('#datepicker-calendar').hide();
            $('#date-range-field a').html('&#9660;');
            $('#date-range-field').css({borderBottomLeftRadius:5, borderBottomRightRadius:5});
            $('#date-range-field a').css({borderBottomRightRadius:5});
          }
        });
        
        // stop the click propagation when clicking on the calendar element
        // so that we don't close it
        $('#datepicker-calendar').click(function(event){
          event.stopPropagation();
        });
      });
      /* End special page widget */
function ChangeOrder()
{
	var orderby = jQuery("#orderby").val();
	if(orderby=="")
	{
		jQuery("#orderby").css('border','1px solid #cc0000');
	}
	else
	{
		jQuery("#orderby").css('border','none');
		jQuery("#orderbycnt").val(orderby);
		jQuery("#frmfilter").submit();
	}
}
function Filterdata()
  {
    var daterange = jQuery("#date-range-field span").html();
    jQuery("#daterange").val(daterange);
    jQuery("#frmfilter").submit();
    
  }
		
    </script>