<?php
include"db.php";
if ($_COOKIE["admin"] == Null) {
    header('Location: login.php');
}
class AYBMember{
    public $name;
    public $phone;
    public $email;
    public $university;
    public $faculty;
    public $studyYear;
    public $residence;
    public $AYBYear;
}
$m = new AYBMember;
$record = "";
$sql = "SELECT * FROM project";
$project_array = $conn->query($sql);
if (isset($_POST['name'])) {
    $m->name = $_POST['name'];
    $m->phone = $_POST['phone'];
    $m->email = $_POST['email'];
    $m->university = $_POST['university'];
    $m->faculty = $_POST['faculty'];
    $m->studyYear = $_POST['studyYear'];
    $m->residence = $_POST['residence'];
    if (isset($_POST['AYBYear'])){
        $m->AYBYear = $_POST['AYBYear'];
    }
    $sql = "INSERT INTO AYBMember (name,phone,email,university,faculty,studyYear,residence,AYBYear) VALUES ('$m->name','$m->phone','$m->email','$m->university','$m->faculty','$m->studyYear','$m->residence','$m->AYBYear')";
    if ($conn->query($sql) === TRUE) {
        $record = "New member is added successfully";
        $last_id = $conn->insert_id;
        if (isset($_POST['project'])) {
            foreach ($_POST['project'] as $projectID) {
                $sql = "INSERT INTO manage (AYBMemberID,projectID) VALUES ('$last_id','$projectID')";
                $conn->query($sql);
            }
        }
    } else {
        if ($conn->errno == 1062) {
            $record = "Member is already added";
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
            <h2>Add member</h2>
            <form  class="form-horizontal " style ="padding :20px" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div style ="border-radius :25px "class ="well well-lg col-md-8 col-md-offset-2">
				<div class="col-md-offset-2" >
					<div class="form-group">	
						<label for ="name"  class="col-md-3 " >Name: </label>
						<input type="text" name="name" id="name" class="col-md-4  "  required><br>
					</div>
					<div class="form-group">
						<label for ="phone" class="col-md-3" >Phone Number: </label>	
						<input type="text" name="phone" id="phone" class="col-md-4"  required><br>
					</div>	
					<div class="form-group">
						<label for ="email" class="col-md-3">   Email: </label>
						<input type="text" name="email" id ="email" class="col-md-4" required><br>
					</div>
					<div class="form-group">
						<label for ="university" class="col-md-3">   University: </label>		
						<input type="text" name="university" id="university" class="col-md-4" required><br>
					</div>
					<div class="form-group">
						<label for ="faculty" class="col-md-3">   Faculty: </label>		
						<input type="text" name="faculty" id="faculty" class="col-md-4" required><br>
					</div>	
					<div class="form-group">
						<label for ="year" class="col-md-3">  Study Year:  </label>
						<input type="text" name="studyYear" id="year" class="col-md-4" required><br>
					</div>	
					<div class="form-group">
						<label for ="residence" class="col-md-3">  Residence:  </label>
						<input type="text" name="residence" id="residence" class="col-md-4" required><br>
					</div>	
					<div class="form-group">
						<label for ="ayb" class="col-md-3">   AYB Year:   </label>
						<input type="text" name="AYBYear" id="ayb" class="col-md-4"><br><br>
					</div>	
					</div>	
                <div class="form-group ">
                    <legend>Participated Projects</legend>
                    <?php while($row = $project_array->fetch_assoc()) { ?> 
                        <div class="form-group col-xs-4">                   
                            <label>
                                <input type="checkbox" name="project[]" value="<?php echo $row['projectID'] ?>"> 
                                <?php echo $row['projectName'] ?>
                            </label>
                        </div>
                        <?php } ?>
                </div>
				</div>
                <div class="form-group col-md-12">
                    <input type="submit" class="btn btn-primary btn-primary" name="submit" value="Add Member">
                    <a href="crew.php" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-backward"></span> Back</a><br><br>
                </div>
            </form>
        </div>
        <?= $record ?>
    </div>

</body>
</html>