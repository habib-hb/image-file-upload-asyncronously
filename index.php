<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Form</title>
</head>
<body>

    <h2>Upload Image</h2>
    <form action="upload.php" id = 'main-form-itself' method="post" enctype="multipart/form-data">
        <label for="image">Select image to upload:</label>
        <input type="file" name="image" id="image" required>
        <input type="submit" value="Upload Image" name="submit" id="form-submit-button">
    </form>



    <div>

        <?php

            // Backend Credentials
            $server_name = 'localhost';
            $user_name = 'weaponary';
            $password = 'weaponary';
            $dbname =  'image-upload-asyncronously';


            // Connecting with the database 
            $conn = new mysqli($server_name, $user_name , $password , $dbname);

            if ( $conn->connect_error ){
                die('Database connection failed.' . $conn->connect_error );
            }



            // Extracting all the images
            $sql = "SELECT image FROM image";
            $image_outputs = $conn->query($sql);

            if ( $image_outputs->num_rows  >  0 ){

            while ( $row = $image_outputs->fetch_assoc() ){
                 echo "<img src='" . htmlspecialchars($row['image']) . "' alt = 'Image' width='300px' /> <br><br>";   
            }

            } else {
                echo "There's no image available.";
            }
            


        ?>

    </div>


        <script>
            
            const submitButton = document.getElementById('form-submit-button');

            // Processing the click event of the submit button
            submitButton.addEventListener('click', async (e)=>{
                   e.preventDefault();

                    // Setting Dom Elements to variables
                    const imageInput = document.getElementById('image');
                    
                   
                    if (imageInput.files.length === 0){
                        return alert("Please select a file first, please.")
                    }

                    let ImageFile = imageInput.files[0]; 
                    let formData = new FormData();
                    formData.append('image' , ImageFile);



                    // Operation asyncronous request
                    try{

                        let response = await fetch('upload.php', {
                            method: 'POST',
                            body: formData });

                        if(response.ok){
                            let result = await response.json();
                            alert('The file has been uploaded successfully : ', result);
                            document.body.insertAdjacentHTML('beforeend', `<img src='${result.imagePath}' alt='Image' width='300px' /> <br><br>`);
                        } else {
                            alert("There were some problem uploading the image.")
                        }   
                        
                    } catch(e){
                        alert('Form Submission Error: ', e.message);
                    }
                    
            })



        </script>


</body>
</html>