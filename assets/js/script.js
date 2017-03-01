$(document).ready(function(){

// Cart Logic here
cart = [];

// This button will increment the value
$('#search-results-wrapper').on('click', '.qtyplus', function(e){
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name='+fieldName+']').val());
    // If is not undefined
    if (!isNaN(currentVal)) {
        // Increment
        $('input[name='+fieldName+']').val(currentVal + 1);
    } else {
        // Otherwise put a 0 there
        $('input[name='+fieldName+']').val(0);
    }
});
// This button will decrement the value till 0
$('#search-results-wrapper').on('click', '.qtyminus', function(e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name='+fieldName+']').val());
    // If it isn't undefined or its greater than 0
    if (!isNaN(currentVal) && currentVal > 0) {
        // Decrement one
        $('input[name='+fieldName+']').val(currentVal - 1);
    } else {
        // Otherwise put a 0 there
        $('input[name='+fieldName+']').val(0);
    }
});

// This button will add to cart
$('#search-results-wrapper').on('click', '.add-cart', function(e){
    e.preventDefault();

    // Get the field names
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var location = $(this).attr('data-location');
    var cost = $(this).attr('data-cost');

    var count = parseInt($('input[name='+id+']').val());
    if (count > 0) {
        // cart.push({ id:id, name:name, location:location, cost:cost, count:count });
        cart[id] = { id:id, name:name, location:location, cost:cost, count:count };
        console.log(cart);
        console.log("Item added!");
        set_cart_amount();

    } else if (count == 0 ) {
        cart.splice(id, 1);
        set_cart_amount();
    }


});
function set_cart_amount() {
    var amount = 0;
    cart.forEach( function (value){
        amount = amount + value.count*value.cost;
    });
    $("#cart-amount").text(amount);
}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}



function generateDOM(index, name, location, cost) {
var dom = '<div class="result-box panel panel-default col-md-12"><div class="col-md-8"><p><b>'+name+'</b></p><p class="light-text">'+location+'</p></div><div class="col-md-2"><h3>₹ '+cost+'</h3></div><div class="col-md-2"><input type="button" value="-" class="qtyminus" field='+index+' /><input type="text" name='+index+' value="0" class="qty" /><input type="button" value="+" class="qtyplus" field='+index+' /><br><input type="button" data-id='+index+' data-name="'+name+'" data-location="'+location+'" data-cost="'+cost+'" class="btn btn-default modified-primary add-cart" value="Add to Cart" /></div></div></div>';
return dom;
}

$("#show-cart").on('click', function(event) {
    event.preventDefault();
    $("#cart-body").empty();

    // console.log(cart);
    if (!isEmpty(cart) && cart.length > 0) {

        cart.forEach( function (value){
            console.log(value);
            var mydom = $('<div class="result-box panel panel-default col-md-12"><div class="col-md-8"><p><b>'+value.name+'</b></p><p class="light-text">'+value.location+'</p></div><div class="col-md-4"><h3>₹ '+value.cost+' ('+value.count+') = ₹ '+ value.cost*value.count+ '</h3></div><div class="col-md-2"></div></div></div>');
            $("#cart-body").append(mydom);
            console.log(mydom);
        });

    } else {
        $("#cart-body").append('<div class="result-box panel panel-default col-md-12"><h5>Cart Empty!</h5></div>');
    }

    $('#cart-modal').modal('show');
    /* Act on the event */
});

});