<?php 
require_once 'components/db_connect.php';
require_once 'components/nav.php';
require_once 'components/footer.php';
require_once 'components/formcreate.php';
require_once 'components/file_upload.php';

$sql = "SELECT * FROM property";
if (isset($_GET['filter'])) {
    if ($_GET['filter'] == "senior") {
        $sql = "SELECT * FROM property WHERE age > 8";
    } else if ($_GET['filter'] == "adopted") {
        $sql = "SELECT * FROM property WHERE adopted = 1";
    } else if ($_GET['filter'] == "notadopted") {
        $sql = "SELECT * FROM property WHERE adopted = 0";
    }
};
$result = mysqli_query($connect ,$sql);
$body='';
$entry = "";
if(mysqli_num_rows($result)  > 0) {    
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){       
        $body .= "
            <div class='col'>
                <div class='card border-0'>
                    <img src='image/{$row["image"]}' class='card-img-top rounded-0'>
                    <div class='card-body'>
                        <h6 class='card-title'>{$row["title"]}</h6>
                        <p class='card-text'>{$row["size"]}</p>
                        <p class='card-text'>{$row["rooms"]}</p>
                        <p class='card-text'>{$row["city"]}</p>
                        <hr>
                        <a href='detail.php?id={$row["id"]}&update'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
                        <a href='detail.php?id={$row["id"]}&delete'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
                        <a href='detail.php?id={$row["id"]}' class='btn btn-sm btn-warning my-1'>Details</a>
                        <hr>
                    </div>
                </div>
            </div>
            ";
   };
} else {
   $body =  "<h1 class='text-danger'>No Data Available</h1>";
}
if (isset($_POST['submit'])) {  
    $title = $_POST['title']; $size = $_POST['size']; $rooms = $_POST['rooms'];
    $city = $_POST['city']; $address = $_POST['address']; $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude']; $price = $_POST['price']; $reduction = $_POST['reduction']; $description = $_POST['description'];
    $uploadError = '';
    $image = file_upload($_FILES['image']);
    $imageName = "$image->fileName";
    $sql = "INSERT INTO `property`(`title`, `image`, `size`, `rooms`, `city`, `address`, `longitude`, `latitude`,`price`, `reduction`, `description`) 
            VALUES ('$title','$imageName', '$size', '$rooms', '$city', '$address', '$longitude', '$latitude', '$price', '$reduction', '$description')";
    if (mysqli_query($connect, $sql) === true) {
        $entry = "<div class='h5'>This entry got created:</div>
                    <table class='table w-75'>
                        <tr>
                            <td>{$title}</td><td>{$size}</td><td>{$imageName}</td>
                        </tr>
                        <tr>
                            <td>{$rooms}</td><td>{$city}</td><td>{$address}</td>
                        </tr>
                        <tr>
                            <td>{$city}</td><td>{$longitude}</td><td>{$latitude}</td>
                        </tr>
                        <tr>
                            <td>{$price}</td><td>{$reduction}</td><td>{$description}</td>
                        </tr>
                    </table>
                    <hr><br>
                    <h3>Please Insert Data</h3><br>";
        $uploadError = ($image->error !=0)? $image->ErrorMessage :'';
        header("refresh:3; url=index.php");
        } else {
            $entry = "Error while creating record. Try again: <br>" . $connect->error;
            $uploadError = ($image->error !=0)? $image->ErrorMessage :'';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php" ?>
    <title>BE16-CR12-StefanKanta</title>
</head>
<body>
    <?= $navbar ?>
    <div class="d-flex flex-column align-items-center">
        <div class="d-flex flex-column align-items-center w-100">
            <?= $entry ?>
        </div>
        <h3 class="my-3">Propertys:</h1>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">
                <?= $body ?>
            </div>
            <div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mx-5 d-flex flex-column align-items-center" enctype="multipart/form-data">
                    <div>
                        <h3>Please Insert Data</h3>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between">
                        <?= formCreate($connect) ?>
                    </div>
                    <input class="btn btn-sm btn-success mt-3 mx-5" type="submit" name="submit" value="CREATE">
                </form>   
            </div>
        </div>
    </div>
    <?= $footer ?>
</body>
</html>