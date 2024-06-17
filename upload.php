<?php

    // Backend credentials
    $servername='localhost';
    $username='weaponary';
    $password='weaponary';
    $dbname='image-upload-asyncronously';

    $conn = new mysqli($servername, $username, $password, $dbname);



    // Connection error
    if ($conn->connect_error){
        echo 'Connection Failed : ' . $conn->connect_error;
    }



    // Operation Image File Uploading
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset($_FILES['image'])){
            $file_path = 'uploads/';
            $file_name = basename($_FILES['image']['name']);
            $upload_path = $file_path . $file_name;



            if(move_uploaded_file( $_FILES['image']['tmp_name'] , $upload_path )){
                $dbprocess = $conn->prepare("INSERT INTO image (image, image_name) VALUES(? , ?)");
                $dbprocess->bind_param( "ss" , $upload_path , $file_name);


                // Executing the db query
                if($dbprocess->execute()){
                    echo json_encode([
                        'message' => "File Uploaded Successfully",
                        'imagePath' => $upload_path
                    ]);
                   
                } else {
                    echo json_encode(
                        [
                            'message' => 'File upload unsuccessfull. '. $dbprocess->error,
                        ]
                        );
                }
            }



        }


        }
    //-----------------------------------------------------------------
 


//     // File naming configouration
//     if (isset($_POST['submit'])){
//         $target_dir = 'uploads/';
//         $target_file = $target_dir . basename($_FILES['image']['name']); 
//         $imageFileType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//     }



//     // Check if the image file is an actual image or a fake image
//     $check = getimagesize($_FILES['image']['tmp_name']);
//     if ($check === false){
//         die("File is not an Image.");
//     }



//     // Check if file already exists
//     if (file_exists($target_file)){
//         die('The File Already Exists.');
//     }



//     // Check if the file is larger that "> 5mb"
//     if ($_FILES['image']['size'] > 5000000) {
//         die('Sorry, the file size is too large.');
//     }



//     // Allowed file types configouration
//     $allowed_extensions = array('jpg' , 'png', 'jpeg' , 'gif');
//     if (!in_array($imageFileType, $allowed_extensions)){
//         die("Sorry, only 'jpg' , 'png', 'jpeg' and 'gif' - are allowed");
//     }



//     // If everything is okay, try to upload
//     if (move_uploaded_file($_FILES['image']['tmp_name'] , $target_file)){
//         $image_name = htmlspecialchars(basename($_FILES['image']['name']));
//         $sql= "INSERT INTO images (image, image_name) VALUES('$target_file', '$image_name')";

//         if ($conn->query($sql) === true){
//             echo "The Image " . $image_name . " has been uploaded successfully.";
//             header("Location: index.php");
//             exit();
//         } else {
//             echo "Error: Image has not been uploaded." . $conn->error;
//         }
//     } else {
//         echo "There has been an issue uploading your photo.";
//     }



//     // Closing the connection
//     $conn->close();



// 

?>