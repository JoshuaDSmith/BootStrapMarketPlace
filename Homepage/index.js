function checkboxClicked(data) {
  itemValue = document.getElementById(data);
  if (!itemValue.parentNode.classList.contains("checkboxSelected")) {
    console.log("clicked");
    console.log(data);

    itemValue.parentNode.classList.add("checkboxSelected");

    console.log(itemValue.parentNode);
  } else if (!!itemValue.parentNode.classList.contains("checkboxSelected")) {
    console.log("clicked");
    console.log(data);

    itemValue.parentNode.classList.remove("checkboxSelected");

    console.log(itemValue.parentNode);
  }
}

function ShowColorOptions() {
  console.log("clicked");
  var x = document.getElementById("ColorSelection");
  console.log(x);

  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function ShowPreviousOwners() {
  console.log("clicked");
  var x = document.getElementById("OwnerSelection");
  console.log(x);

  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function ShowPriceRangeDisplay() {
  console.log("clicked");
  var x = document.getElementById("PriceRangeSelection");
  console.log(x);

  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

var slider = document.getElementById("PriceRangeBar");
var output = document.getElementById("RangeBarDisplay");
output.innerHTML = slider.value;

slider.oninput = function () {
  output.innerHTML = this.value;

  console.log(this.value);
};

function SelectVehicleToModal(msg) {
  console.log(msg);

  // SET HTML IMAGE TO DISPLAY DATABASE STORED PICTURE CONTENT
  let AppendedImage = "../" + msg.Vehicle_Image;
  let ModalImage = document.getElementById("ModalImage");
  ModalImage.src = AppendedImage;

  // Get the vehicleid
  let IdentifyingObjectID = document.getElementById("VehicleSelection");

  console.log(IdentifyingObjectID);
  IdentifyingObjectID.innerHTML = msg.Vehicle_ID;

  var VehiclePrice = document.getElementById("VehiclePrice");
  var VehicleMPG = document.getElementById("VehicleMPG");
  var VehicleColor = document.getElementById("VehicleColor");
  var VehicleStock = document.getElementById("VehicleStock");
  //   IdentifyingObjectID.innerHTML = msg.Vehicle_ID;

  VehiclePrice.innerContext = msg.Vehicle_Price;
  VehicleMPG.innerContext = msg.Vehicle_MPG;
  VehicleColor.innerContext = msg.Vehicle_Color;
  VehicleStock.innerContext = msg.Vehicle_Stock;

  //   let TableContent = [];
  //   TableContent = document.getElementById("tableContent");

  //   TableContent.appendChild(VehiclePrice);
  //   TableContent.appendChild(VehicleMPG);
  //   TableContent.appendChild(VehicleColor);
  //   TableContent.appendChild(VehicleStock);

  //   // When the user clicks on <span> (x), close the modal
  //   span.onclick = function (TableContent) {
  //     modal.style.display = "none";
  //     console.log(TableContent);
}

// }

WebCookies = [];
function AddToBasket() {
  let BasketSelection = document.getElementById("VehicleSelection").innerHTML;
  WebCookies.push(BasketSelection);

  document.cookie = "myJavascriptVar = " + WebCookies;
  //window.location.reload(true);
}
