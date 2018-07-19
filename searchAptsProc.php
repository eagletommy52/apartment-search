<?php 

// 1.) there is no form to process, so skip the POST / GET vars part
// 2.) connect to MySQL

require_once("conn/connApts.php"); //import connection code

$bldg = $_GET['bldg'];
$bdrms = $_GET['bdrms'];
$baths = $_GET['baths'];
$maxRent = $_GET['maxRent'];
$minRent = $_GET['minRent'];
$orderBy = $_GET['orderBy'];
$ascDesc = $_GET['ascDesc'];
$rowsPerPg = $_GET['rowsPerPg'];

// ##**##** NPFL CODE BLOCK 1 START **##**##

$currentPage = $_SERVER["PHP_SELF"];
$pageNum = 0;
if(isset($_GET['pageNum'])) {
  $pageNum = $_GET['pageNum'];
}
$startRow = $pageNum * $rowsPerPg;

// ##**##** NPFL CODE BLOCK 1 END **##**##

$query = "SELECT * from apartments, buildings, neighborhoods 
WHERE apartments.bldgID = buildings.IDbldg 
AND buildings.hoodID = neighborhoods.IDhood ";
if($bdrms!="999"){$query .= "AND bdrms IN ($bdrms) ";}
if($baths != "999"){$query .= "AND baths IN ($baths) ";}
if($bldg != "none") {$query .= "AND bldgID = '$bldg' ";}
if(isset($_GET['doorman'])) {$query .= " AND isDoorman=1";}
if(isset($_GET['pets'])) {$query .= " AND isPets=1";}
if(isset($_GET['parking'])) {$query .= " AND isParking=1";}
if(isset($_GET['gym'])) {$query .= " AND isGym=1";}
if($_GET['search'] != "") {
  $search = $_GET['search'];
  $query .= " AND (aptDesc LIKE '%$search%'
             OR bldgDesc LIKE '%$search%'
             OR hoodDesc LIKE '%$search%'
             OR bldgName LIKE '%$search%'
             OR aptTitle LIKE '%$search%')";
}
$query .= " AND rent BETWEEN '$minRent' AND '$maxRent' ORDER BY $orderBy $ascDesc";

// $result = mysqli_query($conn, $query);  
// ##**##** NPFL CODE BLOCK 2 START **##**##

$query_limit = sprintf("%s LIMIT %d, %d", $query, $startRow, $rowsPerPg);
$result = mysqli_query($conn, $query_limit) or die(mysqli_error);

if(isset($_GET['totalRows'])) { // true only if not on first page
  $totalRows = $_GET['totalRows'];
} else {
  $all = mysqli_query($conn, $query);
  $totalRows = mysqli_num_rows($all);
}
//for 17 records with 5 per page, we need 4 total pages: 
// ceil = round up, so ceil(17/5) = 4 - 1 = 3, but first page is zero, so totalPages=3 is really 4
$totalPages = ceil($totalRows/$rowsPerPg)-1;  

$queryString = "";
if (!empty($_SERVER['QUERY_STRING'])) { // if URL has vars
  // explode querystring into $params array using & as delimiter
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array(); // make a new empty array
  // loop through the array made (exploded) from querystring vars
  foreach ($params as $param) {  
      // stristr() method finds first occurance of substring
      // if the array element string is not pageNum or totalRows
      // so the if statement code is running only on the form variables 
    if (stristr($param, "pageNum") == false && 
        stristr($param, "totalRows") == false) {
        // add that element to the new array
      array_push($newParams, $param); // these are the form variables
    }
  }
  if (count($newParams) != 0) { // if at least one item got added to array, then there must have been a querystring
      // reassemble the queryt
    $queryString = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString = sprintf("&totalRows=%d%s", $totalRows, $queryString);
// ##**##** NPFL CODE BLOCK 2 END **##**##

$numResults = mysqli_num_rows($result);
?>

<!doctype html>

<html lang="en-us">
    
<head>
    
    <meta charset="utf-8">
    
    <title>Apt Search Processor</title>
    <link href="css/apts.css" rel="stylesheet">
</head>

<body>
    <table border="1" cellpadding="5">
    <tr>
        <td colspan="14" align="center">
            <h1 align="center">Lofty Heights Apartments - <?php echo $numResults; ?> Results Found</h1>
            </td>
        </tr>

<tr>
<td colspan="14">
  <!-- THIRD and FINAL NPFL CODE BLOCK contains HTML & PHP mix -->
			<!-- NPFL CODE BLOCK 3 of 3 START -->

                  <a href="searchApts.php">New Search</a>

&nbsp; &nbsp; &nbsp; &nbsp; | 
&nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;
    
<!-- show the results range: "Results X-Z of Z" -->
<!-- X = $startRow + 1 (+1 cuz $startRow is by index, starting w 0) -->
<strong>Results <?php echo ($startRow + 1); ?> - 
<!-- min() returns smaller of 2 values, which is either the last item
in the current result range or the last result: 
$startRow + $rowsPerPg = current range: 11-20 ($rowsPerPg = )
Results 11-20 of 24 or Results 21-24 of 24 -->
  <?php echo min($startRow + $rowsPerPg, $totalRows); ?> 
  of <?php echo $totalRows; ?></strong>  

&nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; 

<!-- The Next link carries all the POST vars, turning them into GET  -->
<?php // Show if not last page
    if($pageNum < $totalPages) { ?>
      <a href="<?php printf("%s?pageNum=%d%s", $currentPage, min($totalPages, $pageNum + 1), $queryString); ?>">Next</a> &nbsp; | &nbsp; 
<?php } // Show if not last page ?>

 <?php 
        if($pageNum > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum=%d%s", $currentPage, max(0, $pageNum - 1), $queryString); ?>">Previous</a> &nbsp;&nbsp;| &nbsp;&nbsp;
<?php } // Show if not first page ?>

 <?php
if($pageNum > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum=%d%s", $currentPage, 0, $queryString); ?>">First &nbsp;&nbsp;| &nbsp;&nbsp;</a>
<?php } // Show if not first page ?>

<!-- The Last link carries all the POST vars, turning them into GET  -->
  <?php
 if($pageNum < $totalPages) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum=%d%s", $currentPage, $totalPages, $queryString); ?>">Last</a>
   <?php } // Show if not last page ?>    

<!-- ######  END NPFL CODE BLOCK 3 OF 3 -- DONE!! ########   -->
</td>
</tr>

        <?php 
        if ($numResults == 0) {
          echo '<tr><td colspan="14">Try your search again <br><br> Redirecting... <br>
          <button class="backButt" onclick="goBack()" width="100px">Click to go back</button></td></tr>';
          header("Refresh:3; url=searchApts.php", true, 303);
        } else { echo '      
          <tr>
            <th>ID</th>
            <th>Apt</th>
            <th>Building</th>
            <th>Bedrooms</th>
            <th>Baths</th>
            <th>Rent</th>
            <th>Floor</th>
            <th>Sqft</th>
            <th>Status</th>
            <th>Neighborhood</th>
            <th>Doorman</th>
            <th>Pets</th>
            <th>Gym</th>
            <th>Parking</th>
            
        </tr>';} ?>
        <?php
        while($row = mysqli_fetch_array($result)){ ?>
          <tr>
              <td><?php echo $row['IDapt']; ?></td>
              <td>
                <a href="aptDetails.php?IDapt=<?php echo $row['IDapt']. '"';?>>
                <?php 
              echo $row['apt']; 
              ?></a>
              </td>
              <td>
                <a href="bldgDetails.php?bldgID=<?php echo $row['bldgID']. '"';?>>
                <?php 
              echo $row['bldgName']; 
              ?></a>
              </td>
              <td><?php 
              if($row['bdrms'] == 0) {
                  echo "Studio";
              }
              else {
              echo $row['bdrms']; 
              }
              ?></td>
              <td><?php echo $row['baths']; ?></td>
              <td><?php echo '$' . number_format($row['rent']); ?></td>
              <td><?php echo $row['floor']; ?></td>
              <td><?php echo $row['sqft']; ?></td>
              <td><?php 
              if($row['isAvail'] == 0){
                echo "Occupied";
              }
              else {
                echo "Available";
              }
              
              ?></td>
              <td><?php echo $row['hoodName']; ?></td>
              <td><?php 
              
                if($row['isDoorman'] == 0){
                  echo 'No'; 
                }else{
                  echo 'Yes';
                }
              ?></td>
              <td><?php echo $row['isPets'] == 0 ? 'No':'Yes'; ?></td>
              <td><?php echo $row['isGym'] == 0 ? 'No':'Yes'; ?></td>
              <td><?php echo $row['isParking'] == 0 ? 'No':'Yes'; ?></td>
              
          </tr>
        
        <?php } ?>
    
    </table>
    <script>
		function goBack() {
			window.history.back();
		}
    </script>
</body>
</html>

<!-- End of file -->