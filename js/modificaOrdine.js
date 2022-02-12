const ORDER_URL = "api/order.php";

$("document").ready(function () {
  prepareInput();
  prepareSelector();
});

var memory;


function prepareInput(){
    $("#order-id").keyup(function (e) { 
      var val = $("#order-id").val();
      $.getJSON(ORDER_URL,{
        id:val
      },function (data) {
        var response = parseResponseWithData(data);
          if(response.success){
            //show div
            $("#order").removeClass("is-hidden");
            //select actual status
            $("select").val(response.data.status);
          }else{
            //hide div
            $("#order").addClass("is-hidden");
          }
      }).fail(function(data){
        $("#order").addClass("is-hidden");
      })
    });
  }


function prepareSelector() {
  
  memory = $("select").children(":selected").val();

  $("select").change(function () {
    var id = $("#order-id").val();
    var status = $(this).children(":selected").val();
    setStatus(id, status);
  });
}

/**
 * @param {int} product_id
 * @param {int} quantity
 */
function setStatus(order_id, status) {
  $.getJSON(
    ORDER_URL,
    {
      id: order_id,
      status: status,
    },
    function (data) {
      var success = parseResponse(data);
      if (success) {
        setValueInField(status);
      } else {
        resetValueInField();
      }
    }
  );
}

function parseResponse(data) {
  var status = data["status"];
  var message = data["status"];
  var pl = data["data"];
  var flag = status == "OK" ? true : false;
  return flag;
}

function setValueInField(status) {
  memory = status;
  $(this).val(memory);
}

function resetValueInField() {
  $(this).val(memory);
}

function parseResponseWithData(data) {
  var status = data["status"];
  var message = data["status"];
  var pl = data["data"];
  var flag = status == "OK" ? true : false;
  var pl = pl === undefined ? {} : pl;
  return { success: flag, msg: message, data: pl };
}


/*"<br />
<b>Fatal error</b>:  Uncaught ArgumentCountError: Too few arguments to function database\Order::__construct(), 0 passed in C:\xampp\htdocs\ProgettoTecWeb\lib\database\DatabaseObjectFactory.php on line 193 and exactly 4 expected in C:\xampp\htdocs\ProgettoTecWeb\lib\database\Order.php:9
Stack trace:
#0 C:\xampp\htdocs\ProgettoTecWeb\lib\database\DatabaseObjectFactory.php(193): database\Order-&gt;__construct()
#1 C:\xampp\htdocs\ProgettoTecWeb\api\order.php(44): database\DatabaseObjectFactory-&gt;getOrder(1883)
#2 {main}
  thrown in <b>C:\xampp\htdocs\ProgettoTecWeb\lib\database\Order.php</b> on line <b>9</b><br />
" */