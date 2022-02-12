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
              console.log(response);
            //show div
            $("#order").removeClass("is-hidden");
            //select actual status
            $("select").val(response.data.status);
          }else{
            //hide div
            $("#order").addClass("is-hidden");
          }
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