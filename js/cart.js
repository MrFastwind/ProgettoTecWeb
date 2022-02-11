const CART_URL = "api/cart.php";
const PROD_URL = "api/product.php";

$("document").ready(function () {
  prepare();
});

var memory = {};

function prepare() {
  $("select")
    .toArray()
    .forEach((it) => {
      memory[$(it).attr("id")] = $(it).children(":selected").val();
    });

  $("select").change(function () {
    var id = $(this).attr("id");
    var quantity = $(this).children(":selected").val();
    setQuantity(id, quantity);
  });
}

/**
 * @param {int} product_id
 * @param {int} quantity
 */
function setQuantity(product_id, quantity) {
  $.getJSON(
    CART_URL,
    {
      product_id: product_id,
      quantity: quantity,
    },
    function (data) {
      var success = parseResponse(data);
      if (success) {
        setValueInField(product_id, quantity);
        updatePrice();
      } else {
        resetValueInField(product_id);
      }
    }
  );
}

function onSelectionChange(product_id) {
  var quantity = $("select #" + product_id).value;
  console.log(quantity);
  setQuantity(product_id, quantity);
}

function parseResponse(data) {
  var status = data["status"];
  var message = data["status"];
  var pl = data["data"];
  var flag = status == "OK" ? true : false;
  return flag, message, pl === undefined ? {} : pl;
}

function setValueInField(id, quantity) {
  memory[id] = quantity;
  $(this).val(memory[id]);
}

function resetValueInField(id) {
  $(this).val(memory[id]);
}

function updatePrice() {
  var total = 0;
  memory.forEach((it, k) => {
    $get
      .getJSON(PROD_URL, {
        id: k,
      })
      .then(function (data) {
        var success,
          msg,
          prod = parseResponse(data);
        if (success) {
          total += prod.Price * it;
        }
      });
  });

  $("#price").val(total);
}
