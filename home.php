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
<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css" type="text/css"  />
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
        <a class="navbar-brand" href="#">DBMS</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
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
    	<h3>Restaurant <span class="pull-right"><button class="btn btn-danger upper-btn" id="trackstatus"><span class="glyphicon glyphicon-cutlery" /> Delivery-Status </button><button class="btn btn-danger upper-btn" id="show-cart"><span class="glyphicon glyphicon-shopping-cart" /> Cart </button><button class="btn btn-danger upper-btn" id="checkout-btn"><span class="glyphicon glyphicon-new-window" /> Checkout</button> Amount: ₹ <span id="cart-amount">0</span> </span> </h3>
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

              <!-- <div class="result-box panel panel-default col-md-12">
                <div class="col-md-8">
                <p><b>That Food Truck</b></p>
                <p class="light-text">Near RDB Boulevard, Sector 5, Salt Lake</p>
                </div>
                <div class="col-md-2">
                <h3>₹ 200</h3>
                </div>
                <div class="col-md-2">
                  <input type="button" value="-" class="qtyminus" field="quantity" />
                  <input type="text" name="quantity" value="0" class="qty" />
                  <input type="button" value="+" class="qtyplus" field="quantity" />
                  <br>
                  <button class="btn btn-default modified-btn">Add to Cart</button>
                </div>
              </div>
            </div> -->

          </div>
        </div>

      </div>
  </div>
  
</div>

<!-- Modal -->
<div id="cart-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My Cart</h4>
      </div>
      <div class="modal-body" id="cart-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Status Modal -->
<div id="order-status-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My Order</h4>
      </div>
      <div class="modal-body" id="status-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- CheckButton  Modal -->
<div id="check-status-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My Track_id</h4>
      </div>
      <div class="modal-body" id="check-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script src="assets/jquery-1.11.3-jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.9.3/typeahead.min.js"></script>
<script type="text/javascript">
$("document").ready(function(){
  $("#search-box").typeahead({
      name : 'cuisine',
      remote: {
          url : 'search.php?query=%QUERY'
      }
  });
  function generateDOM(index, name, location, cost) {
    var dom = '<div class="result-box panel panel-default col-md-12"><div class="col-md-8"><p><b>'+name+'</b></p><p class="light-text">'+location+'</p></div><div class="col-md-2"><h3>₹ '+cost+'</h3></div><div class="col-md-2"><input type="button" value="-" class="qtyminus" field='+index+' /><input type="text" name='+index+' value="0" class="qty" /><input type="button" value="+" class="qtyplus" field='+index+' /><br><input type="button" data-id='+index+' data-name="'+name+'" data-location="'+location+'" data-cost="'+cost+'" class="btn btn-default modified-btn add-cart" value="Update Cart" /></div></div></div>';
    return dom;
  }

  $("#form").on('submit', function(e) {
    e.preventDefault();
    var value = $("#search-box").val();
    // console.log(value);
    if(value != "" || value != undefined) {
      $.ajax({
         type: 'GET',
         url: 'get-cuisines.php',
         data: { data: value },
         success: function(data) {
          data = $.parseJSON(data);
          $("#search-results-wrapper").empty();
          if (data.length != 0) {
            $.each(data, function(i, item) {
              /*var mydom = $('<div class="result-box panel panel-default">'+item.name+' | '+item.location+' | '+item.average_cost_for_two+'</div>');*/
              var mydom = $(generateDOM(item.p_key, item.name, item.location, item.average_cost_for_two));
              $("#search-results-wrapper").append(mydom);
            });
          } else {
              $("#search-results-wrapper").append('<div class="result-box panel panel-default col-md-12"><h5> No results found! </h5></div>');
          }
         }
      });
    }
  });
$("#trackstatus").on('click', function(event) {
    event.preventDefault();
    var tracking_id = prompt("Enter your tracking id");
    console.log(tracking_id);
    $.ajax({
       type: 'POST',
       url: 'get-track.php',
       data: { data:  <?php echo $_SESSION['user'] ?> , tracking_id: tracking_id},
       success: function(data) {
        // $("#search-results-wrapper").empty();
        console.log(data);
        var dstring = '<div><p>Your order status: <b>'+data+'</b></p></div>';
        $("#status-body").html(dstring);
        $('#order-status-modal').modal('show');
        //alert("Your order has been successfully placed.Your tr id is : " + data);
       }
    });

});

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}
function set_cart_amount() {
    var amount = 0;
    cart.forEach( function (value){
        amount = amount + value.count*value.cost;
    });
    $("#cart-amount").text(amount);
}
$("#checkout-btn").on('click', function(event) {
    event.preventDefault();
    if (isEmpty(cart)) {
        alert('Your cart is empty!');
        return false;
    } else {

        description = "";
        cart.forEach( function (value){
            console.log(value);
            description += "Name : " + value.name + ", " + "Location : " + value.location + ", " + "Cost :" + value.cost +", "+"Quantity : "  + value.count + "\n";
          
            // var mydom = $('<div class="result-box panel panel-default col-md-12"><div class="col-md-8"><p><b>'+value.name+'</b></p><p class="light-text">'+value.location+'</p></div><div class="col-md-4"><h3>₹ '+value.cost+' ('+value.count+') = ₹ '+ value.cost*value.count+ '</h3></div><div class="col-md-2"></div></div></div>');
            // $("#cart-body").append(mydom);
            // console.log(mydom);
        });
        console.log(description);
        $.ajax({
         type: 'POST',
         url: 'get_orderid.php',
         data: { data:  <?php echo $_SESSION['user'] ?> , description: description},
         success: function(data) {
          var dstring = '<div><p>Your Track id is : <b>'+data+'</b></p></div>';
          $("#check-body").html(dstring);
          $('#check-status-modal').modal('show');
          //alert("Your order has been successfully placed.Your tracking id is : " + data);
          cart = [];
          set_cart_amount();
         }
      });
    }

});


});
</script>
    
</body>
</html>
