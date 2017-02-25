<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) || $_SESSION['userName'] == 'admin' ) {
		header("Location: logout.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Coding Cage</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.codingcage.com/2015/01/user-registration-and-login-script-using-php-mysql.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </nav> 

	<div id="wrapper">

	<div class="container">
    
    	<div class="page-header">
    	<h3>Restaurant</h3>
    	</div>
        
      <div class="row">

        <div class="col-md-12">
          <form name="form" action="" id="form" method="POST">
            
          <div class="col-md-4">
              <input type="text" class="input form-control typeahead" name="cuisine" id="search-box" required> 
          </div>
          <div class="col-md-4">
            <input type="submit" id="search-btn" class="btn btn-primary" name="submit" value="Search by Cuisine"> 
          </div>
          </form>
        </div>

        <div class="container">
          
          <div class="col-md-12" style="margin-top: 30px;">
            <div id="search-results-wrapper">
              <!-- <div class="result-box panel panel-default">ok | ok | ok</div>
              <div class="result-box panel panel-default">ok | ok | ok</div>
              <div class="result-box panel panel-default">ok | ok | ok</div> -->
              
            </div>

          </div>
        </div>

      </div>
    </div>
    
    </div>
    
<script src="assets/jquery-1.11.3-jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.9.3/typeahead.min.js"></script>
<!-- <script src="assets/js/typeahead.bundle.min.js"></script> -->
<script type="text/javascript">
$("document").ready(function(){
  $("#search-box").typeahead({
      name : 'cuisine',
      remote: {
          url : 'search.php?query=%QUERY'
      }
  });
  $("#form").on('submit', function(e) {
    e.preventDefault();
    var value = $("#search-box").val();
    console.log(value);
    if(value != "" || value != undefined) {
      $.ajax({
         type: 'GET',
         url: 'get-cuisines.php',
         data: { data: value },
         success: function(data) {
          data = $.parseJSON(data);
          $("#search-results-wrapper").empty();

          $.each(data, function(i, item) {
            var mydom = $('<div class="result-box panel panel-default">'+item.name+' | '+item.location+' | '+item.average_cost_for_two+'</div>');
            $("#search-results-wrapper").append(mydom);
          });
         }
      });
    }
  });
});
</script>
    
</body>
</html>
<?php ob_end_flush(); ?>