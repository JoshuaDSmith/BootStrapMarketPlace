function showDropDown(msg) {
  let CreditCard = document.getElementById("CreditCard");
  let DebitCard = document.getElementById("DebitCard");
  let PayPal = document.getElementById("PayPal");

  switch (msg) {
    case 0:
      if (CreditCard.style.display == "none") {
        CreditCard.style.display = "block";
        DebitCard.style.display = "none";
        PayPal.style.display = "none";
      }
      break;
    case 1:
      if (DebitCard.style.display == "none") {
        DebitCard.style.display = "block";
        CreditCard.style.display = "none";
        PayPal.style.display = "none";
      }
      break;
    case 2:
      console.log("hitting condition");
      if (PayPal.style.display == "none") {
        PayPal.style.display = "block";
        DebitCard.style.display = "none";
        CreditCard.style.display = "none";
      }
      break;
  }
}

fetch("https://restcountries.eu/rest/v2/all")
  .then(function (response) {
    if (response.status !== 200) {
      console.log(
        "Looks like there was a problem. Status Code: " + response.status
      );
      return;
    }

    // Examine the text in the response
    response.json().then(function (data) {
      console.log(data);

      // GRAB COUNTRY SELECT AND APPEND API AS SELECTABLE OPTIONS
      CountrySelectable = document.getElementById("CountrySelect");

      // GRAB REGION SELECT AND APPEND API AS SELECTABLE OPTIONS
      RegionSelectable = document.getElementById("RegionSelect");

      // LOOP THROUGH RETURNED INFORMATION AND APPEND OPTIONS TO SELECTS
      for (i = 0; i <= data.length; i++) {
        var CountryOptions = document.createElement("option");
        CountryOptions.value = data[i].alpha3Code;
        CountryOptions.innerHTML = data[i].name;
        CountrySelectable.appendChild(CountryOptions);

        var RegionOptions = document.createElement("option");
        RegionOptions.value = data[i].subregion;
        RegionOptions.innerHTML = data[i].subregion;
        RegionSelectable.appendChild(RegionOptions);
      }
    });
  })
  .catch(function (err) {
    console.log("Fetch Error :-S", err);
  });

const SearchBar = document.getElementById("searchBar");

let PostCodes = [];
//console.log(SearchBar);

searchBar.addEventListener("keyup", (e) => {
  const searchString = e.target.value;
  //console.log(searchString)
  loadPostCodes(searchString);
});

// POSTCODE SEARCH LOGIC
const loadPostCodes = async (SelectedPostCode) => {
  console.log(SelectedPostCode);
  const result = await fetch(
    "https://api.postcodes.io/postcodes/" + SelectedPostCode,
    {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    }
  );

  // RETURN PROMISE PROVIDING ENTERED INPUT IS VALIDATE
  PostCodes = await result.json();

  // REMOVE NO DISPLAY. ALLOW DROP DOWN SELECTABLE TO SHOW
  $("#DisplayPostCodes").removeClass("d-none");

  // INVOKE DISPLAY FUNCTION
  DisplayPostCodes(PostCodes);
};

// INVOKE LOAD POST CODE FUNCTION
loadPostCodes();

// GATHER RETURNED PROMISE INFORMATION AND STORE TO ARRAY
const DisplayPostCodes = async (data) => {
  // BUILD ARRAY
  const PostCodeInformation = [
    data.result.country,
    data.result.postcode,
    data.result.nuts,
    data.result.admin_ward,
    data.result.nhs_ha,
    data.result.admin_ward,
  ];

  // USE EMPTY HIDDEN ELEMENT TO STORE ARRAY INFORMATION
  let PostcodeInputListItem = document.getElementById("DisplayPostCodes");
  document.getElementById("HiddenPostCodeValue").innerHTML =
    PostCodeInformation;

  // APPEND STYLING TO LIST ELEMENT
  PostcodeInputListItem.classList.add("list-group-item");

  // APPEND POST CODE TO SEARCH
  PostcodeInputListItem.innerHTML = data.result.postcode;
  document.cookie = PostCodeInformation + ",expires=Thu, 01 Jan 1970 00:00:00";
};

// ON CLICK OF THE LIST ITEM AUTO POPULATE INPUT FIELDS
const PopulateAddressField = () => {
  // REMOVE LIST ITEM
  $("#DisplayPostCodes").addClass("d-none");

  // GET POST CODE INFORMATION
  PostCodeAPIInformation = document.getElementById(
    "HiddenPostCodeValue"
  ).innerHTML;
  let SplitArray = PostCodeAPIInformation.split(",");

  // ASSIGN ARRAY VALUES TO VARIABLES
  AddressLine1 = SplitArray[3];
  AddressLine2 = SplitArray[2] + ", " + SplitArray[4];
  AddressCity = SplitArray[0];
  AddressPostcode = SplitArray[1];

  // APPEND VARIABLES TO JS ELEMENTS
  document.getElementById("AddressLine1").value = AddressLine1;
  document.getElementById("searchBar").value = AddressPostcode;
  document.getElementById("AddressLine2").value = AddressLine2;
  document.getElementById("AddressCity").value = AddressCity;
};
