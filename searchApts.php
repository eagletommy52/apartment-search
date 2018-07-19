<?php 
require_once("conn/connApts.php");
$query = "SELECT IDbldg, bldgName FROM buildings ORDER BY bldgName ASC";
$result = mysqli_query($conn, $query);
echo mysqli_error($conn);
?>
<!doctype html>
<html>
<head>
    <title>Apartment Search</title>
    <script>
        
            function validateRents(){
                    //check if the min/max conflict
                var maxRent = Number(document.getElementById("maxRent").value);
                var minRent = Number(document.getElementById("minRent").value);
                if(maxRent <= minRent){
                    alert("Max Rent must be higher than Min Rent!");
                    return false;
                } // end if
            } // end function
        
    </script>
    <script src="js/nouislider.js"></script>
    <script src="js/wNumb.js">
    </script>
    <link href="css/apts.css" rel="stylesheet">
    <link href="css/nouislider.css" rel="stylesheet">
</head>
<body>
    <div id="container">  <!-- open the container -->
    <h1>Apartment Rent Search</h1>

    <!-- We use "get" here because we are only GETting information -->
    
    <form method="get" action="searchAptsProc.php" onsubmit="return validateRents()">
        <p>Search:
        <input type="text" name="search" id="search"></p>
        <p>Building:
            <select name="bldg" id="bldg">
                <option value="none">Any</option>
                <?php 
                while($row = mysqli_fetch_array($result)) {echo '<option value="' . $row['IDbldg'] . '">' . $row['bldgName']. '</option>';}
                ?>
            </select>
        </p>
        <p>Rent:<div id="rentSlider" class="noUiSlider"></div></p>
        <p><label>Min: $
            <input type="number" class="shortNumInput" name="minRent" id="minRent">
    </label>

        <label>Max: $
            <input type="number" class="shortNumInput" name="maxRent" id="maxRent">
                </label></p>
        
        <p><label>Bedrooms:<br><br><br>
        <div id="bedSlider"></div><br>
            <input type="hidden" name="bdrms" id="bdrms" value="999">
        <!-- <select name="bdrms" id="bdrms">
            <option value="999" selected>Any</option>
            <option value="0">Studio</option>
            <option value="1">1 bedroom</option>
            <option value="1,2,3">1+ bedrooms</option>
            <option value="2">2 bedrooms</option>
            <option value="2,3">2+ bedrooms</option>
            <option value="3">3 bedrooms</option>
        </select> -->
            </label></p>
        <p><label>Bathrooms:<br><br><br>
        <div id="bathSlider"></div><br>
            <input type="hidden" name="baths" id="baths">
            </label></p>
        
        <h2>Additional building amenities:</h2>
        
        <input class="cbW" type="checkbox" name="doorman" value="1" id="doorman"><label for="doorman">Doorman </label>
        <input id="pets" class="cbW" type="checkbox" name="pets" value="1"><label for="pets">Pet Friendly </label>
        <input id="parking" class="cbW" type="checkbox" name="parking" value="1"><label for="parking">Parking </label>
        <input id="gym" class="cbW" type="checkbox" name="gym" value="1"><label for="gym">Gym </label>
        <p>Sort By:
            <select name="orderBy" id="orderBy" class="shortSelect">
                <option value="bdrms">Bedrooms</option>
                <option value="bldgID">Buildings</option>
                <option value="rent" selected>Rent</option>
                <option value="sqft">Square Feet</option>
            </select>
            Results Per Page:<select name="rowsPerPg" id="rowsPerPg" class="shortSelect">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="25">25</option>
            </select>
            <br>
            <input class="radioInput" type="radio" name="ascDesc" value="ASC" id="asc" checked><label for="asc">Ascending </label>
            <input class="radioInput" type="radio" name="ascDesc" value="DESC" id="desc"><label for="desc">Descending</label>
            <!--Let User specify rows per page-->
            
        </p>
        <p><button style="width:100%; padding:5px; font-size:1rem; color:#363; font-weight:800; background-color:#8C8; letter-spacing:10px; text-transform:uppercase;">Submit</button></p>
        
    </form>

    </div> <!-- close the container -->
<script>
//Slider code
var rentSlider = document.getElementById('rentSlider');
noUiSlider.create(rentSlider, {
	start: [ 2000, 5000 ],
	connect: true,
    step: 250,
    range: {'min': 0,'max': 10000},
});
var minRent = document.getElementById('minRent');
var maxRent = document.getElementById('maxRent');
rentSlider.noUiSlider.on('update', function( values, handle ) {
	let value = values[handle];
	if ( handle ) {maxRent.value = value;} 
        else {minRent.value = value;}});
minRent.addEventListener('change', function(){
	rentSlider.noUiSlider.set([this.value, null]);});
maxRent.addEventListener('change', function(){
    rentSlider.noUiSlider.set([null, this.value]);})

var bedSlider = document.getElementById('bedSlider');
noUiSlider.create(bedSlider, {
	start: [ 0, 3 ],
	connect: true,
    step: 1,
    tooltips: [{
	  to: function ( value ) {
        value == 0 ? value = "Studio" : wNumb({ decimals: 0 }).to(value)
		return value;
	  },
	  from: function ( value ) {
        return value.replace('Studio', 0)
      }
    }, wNumb({ decimals: 0 })],
    range: {'min': 0,'max': 3},
});
var bedInput = document.getElementById('bdrms');
bedSlider.noUiSlider.on('update', function( values, handle ) {
    bedInput.value = values[0];
    if(values[0] < values[1]){
        for(let i = Number(values[0]) + 1; i <= values[1]; ) {
            bedInput.value += `, ${i}`;
            i += 1;
        }
    }
});

var bathSlider = document.getElementById('bathSlider');
noUiSlider.create(bathSlider, {
	start: [ 1, 2.5 ],
	connect: true,
    step: 0.5,
    
    tooltips: [wNumb({ decimals: 1 }), wNumb({ decimals: 1 })],
    range: {'min': 1,'max': 2.5},
});
var bathInput = document.getElementById('baths');
bathSlider.noUiSlider.on('update', function( values, handle ) {
    bathInput.value = values[0];
    if(values[0] < values[1]){
        for(let i = Number(values[0]) + 0.5; i <= values[1]; ) {
            bathInput.value += `, ${i}`;
            i += .5;
            
        }
    }
});


</script>
</body>
</html>