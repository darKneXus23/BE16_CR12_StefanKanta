<?php 
require_once "components/db_connect.php";
require_once "components/nav.php";
require_once 'components/footer.php';
require_once "components/formcreate.php";
require_once "components/file_upload.php";
$id = $_GET["id"];
$sql = "SELECT * FROM property WHERE id = '$id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$entry = "  <div class='col-md-4 d-flex'>
                <img src='image/{$row["image"]}' class='img-fluid align-self-center'>
            </div>
            <div class='col-4'>
                <div class='card-body'>
                    <h6 class='card-title'>{$row["title"]}</h6>
                    <p class='card-text'>Area: {$row["size"]}m²</p>
                    <p class='card-text'>Rooms: {$row["rooms"]}</p>
                    <p class='card-text'>{$row["city"]}</p>
                    <p class='card-text'>{$row["address"]}</p>
                    <p class='card-text'>latitude: {$row["latitude"]}</p>
                    <p class='card-text'>longitude: {$row["longitude"]}</p>

                </div>
            </div>
            <div class='col-4'>
                <div class='card-body'>
                    <p class='card-text'>Price: {$row["price"]} €</p>
                    <p class='card-text'>".( ($row["reduction"] == 1)? "reduced" : "not reduced") ."</p>
                </div>
            </div>
            <div class='col-12'>
                <div class='card-body'>
                    <h6 class='card-title'>{$row["description"]}</h6>
                    <hr>
                    <a href='detail.php?update&id={$row["id"]}'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
                    <a href='detail.php?delete&id={$row["id"]}'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
                    <hr>
                </div>
            </div>
            ";
$lat = $row["latitude"]; 
$lng = $row["longitude"];
$form = "<a href='index.php'><button class='btn btn-secondary btn-sm m-3' type='button'>index</button></a>";
if (isset($_GET["update"])) {
    $form = "   <a href='detail.php?id={$row["id"]}'><button class='btn btn-secondary btn-sm' type='button'>back</button></a>
                <form action=" . htmlspecialchars($_SERVER['PHP_SELF']) ."?id={$id} method='POST' class='m-1 d-flex flex-column align-items-center' enctype='multipart/form-data'>
                    <input class='btn btn-sm btn-success mt-3 mx-5' type='submit' name='submit' value='UPDATE'>
                    <div class='d-flex flex-wrap justify-content-between'>
                        " . formCreate($connect, "value", $row) . "
                    </div>
                </form>";
} else if (isset($_GET["delete"])) {
    $form = "   <div class='d-flex'>
                    <div class='h5'>
                        deleting the entry:
                    </div>
                    <a href='detail.php?deleteyes&id={$row["id"]}'><button class='btn btn-danger btn-sm m-1' type='button'>yes</button></a>
                    <a href='detail.php?id={$row["id"]}'><button class='btn btn-success m-1' type='button'>NO</button></a>
                </div>
    ";
} else if (isset($_GET["deleteyes"])) {
    $imageName = $row["image"];
    ($row["image"] == "default.png")?: unlink("image/$imageName");
    $sql = "DELETE FROM property WHERE `id` = '{$id}'";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        $form = "<div class='h5'>
                    this entry got deleted:
                </div>";
        header("refresh:5;url=index.php");
    } else {
        $deleted = "error";
    };
};
if ($_POST) {
    $title = $_POST['title']; $size = $_POST['size']; $rooms = $_POST['rooms'];
    $city = $_POST['city']; $address = $_POST['address']; $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude']; $price = $_POST['price']; $reduction = $_POST['reduction'];
    $description = $_POST['description']; 
    $uploadError = '';
    $image = file_upload($_FILES['image']);
    if ($image->ErrorMessage == "No image was chosen. It can always be updated later."){
        $imageName = $row["image"];
    } else {
        $imageName = "$image->fileName";
    };
    if ($image->error === 0) {
        ($imageName == "default.png") ?: unlink("image/{$row["image"]}");
        $sql1 = "UPDATE `property` SET `title`='$title',`image`='$imageName',`size`='$size', `rooms`='$rooms',`city`='$city',`address`='$address',`latitude`='$latitude',`longitude`='$longitude',`price`='$price',`reduction`='$reduction',`description`='$description' WHERE `id` = '$id'";
    } else {
        $sql1 = "UPDATE `property` SET `title`='$title',`size`='$size', `rooms`='$rooms',`city`='$city',`address`='$address',`latitude`='$latitude',`longitude`='$longitude',`price`='$price',`reduction`='$reduction',`description`='$description' WHERE `id` = '$id'";
    }
    if (mysqli_query($connect, $sql1) === true) {
        $form = "  <div class='h5'>This entry got updated:</div>
                    <table class='table w-75'>
                        <tr>
                            <td>{$id}</td><td>{$title}</td><td>{$size}</td><td>{$imageName}</td>
                        </tr>
                        <tr>
                            <td>{$rooms}</td><td>{$city}</td><td>{$address}</td>
                        </tr>
                        <tr>
                            <td>{$latitude}</td><td>{$longitude}</td><td>{$price}</td><td>{$reduction}</td>
                        </tr>
                        <tr>
                            <td>{$description}</td>
                        </tr>
                    </table>
                    <hr><br>";
        header("refresh:3;url=detail.php?id={$id}");
    } else {
        $entry = "Error while creating record. Try again: <br>" . $connect->error;
    };
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php"; ?>
    <title>Detail: <?= $row["title"] ?></title>
</head>
<body>
    <?=$navbar?>
    <div class="wrapper d-flex flex-column justify-content-between align-items-center">
        <div class="w-100 d-flex flex-column align-items-center my-5">
        <?= $form ?>
            <div class="card mb-3 w-75 border-0">
                <div class="row g-0">
                    <?= $entry ?>
                </div>
            </div>
        </div>
        <div id="map" style="height:500px; width: 500px">
        </div>
        <?= $footer ?>
    </div>
    <script>
        var map;
        function initMap() {
            var location = { 
                lat: <?= $lat ?>, 
                lng: <?= $lng ?>
            };
            map = new google.maps.Map(document.getElementById('map'), {
                center: location,
                zoom: 13
            })
            pinpoint = new google.maps.Marker({
                position: location,
                map: map
            })
            pinpoint = new google.maps.Marker({
                position: {lat: <?= $row["latitude"]?>, lng: <?= $row["longitude"]?>},
                map: map
            })
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtjaD-saUZQ47PbxigOg25cvuO6_SuX3M&callback=initMap" async defer></script>
</body>
</html>