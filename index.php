<!DOCTYPE HTML>
<html>
  <head> 
    <title>The Awesome</title> 
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  </head>
  <body class="container"> 
    <div style="border:1px solid; margin-left:auto; margin-right:auto; width:45%"> 
        <h4 style="text-align: center">Search data by date:</h4>
        <div> 
            <form action="show.php" method="post"> 
                <div style="text-align: center" id="from" class="input-append date" placeholder="yyyy-mm-dd hh:mm:ss">
                  <label>From:</label>
                  <input type="text"  name="from"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>
                </div>

                <div style="text-align: center" id="to" class="input-append date" placeholder="yyyy-mm-dd hh:mm:ss">
                  <label>To:</label>
                  <input type="text"  name="to"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>
                </div> 
                <p style="text-align: center">
                    <button style="text-align: center"type="submit" class="btn">Submit</button> 
                </p> 
            </form>  
        </div>
    </div>
    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <script type="text/javascript">
      $('#from, #to').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'en-US'
      });
    </script>
  </body>
<html>