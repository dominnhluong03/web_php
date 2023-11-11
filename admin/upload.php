<?php
    if(isset($_POST["upload"])){
        $target_dir = "uplot";
        $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
        }
        else{
            if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
               echo "<img src='".$target_file."'>";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } 
    }
?>
<html>
    <head>

    </head>
    <body>
        <h1>Trang Upload file</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file_upload">
            <input type="submit" value="Upload" name="upload">
        </form>
    </body>
</html>