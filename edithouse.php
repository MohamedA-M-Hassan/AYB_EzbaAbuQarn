<?php
include"db.php";
if ($_COOKIE["admin"] == Null) {
    header('Location: login.php');
}
$sql = "SELECT * FROM house WHERE houseCode='".$_GET['id']."'";
$housedetails = $conn->query($sql);
$housedetails = $housedetails->fetch_assoc();
class house{
    public $area;
    public $houseCode;
    public $noOfFloors;
    public $noOfAppartments;
    public $specialSign;
    public $sanitation;
}
$m = new house;
$record = "";
if (isset($_POST['area'])) {
    $m->area = $_POST['area'];
    $m->houseCode = $_POST['houseCode'];
    $m->noOfFloors = $_POST['noOfFloors'];
    $m->noOfAppartments = $_POST['noOfAppartments'];
    $m->specialSign = $_POST['specialSign'];
    $m->sanitation = $_POST['sanitation'];

    $sql = "UPDATE house SET area='".$m->area."', houseCode='".$m->houseCode."', noOfFloors='".$m->noOfFloors."', noOfAppartments='".$m->noOfAppartments."', specialSign='".$m->specialSign. " ', sanitation=' " .$m->sanitation." ' WHERE houseCode='".$_POST['id']."'";
	if ($conn->query($sql) === TRUE) {
        $record = "New house is added successfully";
        $sql = "DELETE FROM house WHERE houseCode=''".$_GET['id']."'";
        header('Location: showhouse.php');
    } else {
        if ($conn->errno == 1062) {
            $record = "House is already added";
        } else {
            $record = "There is something wrong";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/add.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script language="JavaScript" type="text/javascript">
    $(document).ready(function(){
    $("a.delete").click(function(e){
        if(!confirm('Are you sure?')){
            e.preventDefault();
            return false;
        }
        return true;
        });
    });
    </script>
    <style>
        body {margin: 0;
            margin-top: 50px;
            font-family: "Lato", sans-serif;}

        ul.topnav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        ul.topnav li {float: left;}

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) {background-color: #111;}

        ul.topnav li a.active {background-color: #4CAF50;}

        ul.topnav li.right {float: right;}
        td{
            direction: rtl;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even){background-color: #f2f2f2}
        a{
            text-align: center
        }
        img{
            height: 50px;
        }
        th{
            width: 11%;
            background-color: silver;
        }
        td {
            word-break: break-all;
        }
        span{
            font-size: 20px;
        }
        .mySlides {display: none}
        .demo {cursor:pointer}
        .w3-left, .w3-right, .w3-badge {cursor:pointer}
        .w3-badge {height:13px;width:13px;padding:0}
    </style>

</head>
<body>
<!-- navbar -->
    <div class="w3-top">
        <ul class="w3-navbar w3-black w3-card-2 w3-left-align">
          <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
            <a class="w3-padding-large" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
          </li>
          <li><a href="interface.php" class="w3-padding-large">HOME</a></li>
          <li class="w3-hide-small"><a href="crew.php" class="w3-padding-large">CREW</a></li>
          <li class="w3-hide-small"><a href="project.php" class="w3-padding-large">PROJECTS</a></li>
          <li class="w3-hide-small w3-dropdown-hover">
            <a href="javascript:void(0)" class="w3-hover-none w3-padding-large" title="More"> EZBA <i class="fa fa-caret-down"></i></a>     
            <div class="w3-dropdown-content w3-white w3-card-4">
              <a href="house.php">Houses</a>
              <a href="family.php">Families</a>
              <a href="ezbamember.php">Ezba People</a>
            </div>
          </li>
          <li class="w3-hide-small w3-dropdown-hover">
            <a href="javascript:void(0)" class="w3-hover-none w3-padding-large" title="More">MORE <i class="fa fa-caret-down"></i></a>     
            <div class="w3-dropdown-content w3-white w3-card-4">
              <a href="#">Events</a>
              <a href="#">Extras</a>
              <a href="#">Media</a>
            </div>
          </li>
          <li class="w3-hide-small w3-right"><a href="logout.php" class="w3-padding-large">Log out</a></li>
          <li class="w3-hide-small w3-right"><a class="w3-hover-none w3-hover-text-grey w3-padding-large"><?php echo $_COOKIE["admin"]; ?></a></li>
        </ul>
    </div>
<!-- end of navbar -->

    <!-- <div class="container"> -->
    <!-- <div class="row">
        <a href="family.php" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-backward"></span> Back</a><br><br>
    </div> -->
    <div class="container">
        <div class="row">
            <h2>Edit House</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?> ">
                Area: <input type="text" name="area" value="<?php echo $housedetails['area'] ?>" required><br><br>
                House Code: <input type="text" name="houseCode" value="<?php echo $housedetails['houseCode'] ?>" required><br><br>
                No. of Floors in House: <input type="text" name="noOfFloors" value="<?php echo $housedetails['noOfFloors'] ?>"><br><br>
                No. of Appartments in House: <input type="text" name="noOfAppartments" value="<?php echo $housedetails['noOfAppartments'] ?>"><br><br>
                Special Sign: <input type="text" name="specialSign" value="<?php echo $housedetails['specialSign'] ?>"><br><br>
                Sanitation: <label><input type="radio" name="sanitation" value="<?php echo $housedetails['sanitation'] ?>"> Yes</label>
                            <label><input type="radio" name="sanitation" value="<?php echo $housedetails['sanitation'] ?>"> No</label>
                <div class="row">
                    <input type="submit" class="btn btn-primary btn-primary" name="submit" value="Edit House">
                    <a href="house.php" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-backward"></span> Back</a><br><br>
                </div>
            </form>
        </div>
        <?= $record ?>
    </div>
</body>
</html>