<?php 
require_once("conn/connApts.php"); 
$bldgID = $_GET['bldgID'];
$query = "SELECT * FROM buildings, images WHERE IDbldg = '$bldgID';";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $row['bldgName']; ?> Details</title>
    <link href="css/apts.css" rel="stylesheet">
</head>
<body>
<style>
    table, tr, td {
        border: 1px solid black;
        min-width:10px;
        min-height:10px;
    }
</style>
    <table>
        <tr>
            <td colspan="3"><h1><?php echo $row['bldgName']; ?></h1></td>
            
        </tr>
        <tr>
            <td rowspan="2">
                <img src="images/propPics/<?php echo $row['bldgPic']; ?>">
            </td>
            <td>Floors: <?php echo $row['floors']; ?></td>
            <td>Year Built: <?php echo $row['yearBuilt']; ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $row['bldgDesc']; ?></td>
        </tr>
        <tr>
            <td>Address: <?php echo $row['address']; ?></td>
            <td>Phone: <?php echo $row['phone']; ?></td>
            <td>Email: <?php echo $row['email']; ?></td>
        </tr>
    </table>
    <br>
    <button class="backButt" onclick="goBack()" width="100px">Click to go back</button>

    <script>
		function goBack() {
			window.history.back();
		}
    </script>
</body>
</html>