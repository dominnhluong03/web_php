<?php
    require("../config.php");
    
    $this_id = $_GET['id'];
   

    $sql = "SELECT *FROM tbl_news WHERE news_id ='$this_id' ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    //khi nhaasn nuts luu lai

    if(isset($_POST['update'])){

        $cate_id = $_POST["cate"];
        $title = $_POST["txt_news"];
        $content = $_POST["txt_content"];
        $author = $_POST["txt_author"];
        $post_date = $_POST["txt_date"];
        $status = $_POST["txt_status"];

        //anhr
        
       $target_dir = "upload_tintuc/";
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        //kiem tra dinh dang file anh
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
       
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } 
          else {
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)){



        $sql = "UPDATE tbl_news SET  cate_id = '$cate_id', title='$title',content='$content',intro_img='$target_file',author='$author',post_date='$post_date',status='$status' 
        WHERE news_id =".$this_id;
        
        mysqli_query($conn, $sql);
        header('location: news.php');



    }
    }
    }



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>



<body  style="background-color: #ffffcc; ">
    <div class="container">
        <div class="row">
            <h1>Trang sửa tin tức</h1>      
            <form method="POST" enctype = "multipart/form-data">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                    Chọn danh mục:
                        <select class="form-control" name="cate" id="">
                            <?php
                                $sql = "select * from tbl_category order by cate_id DESC";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        echo "<option value='".$row["cate_id"]."'>".$row["cate_name"]."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Nhập tiêu đề:
                        <input type="text" name="txt_news" id="" class="form-control">
                    </div>
                    Nhập nội dung tin:
                    <!--<div id="editor">This is some sample content.</div> -->
                    <textarea name="txt_content" id="editor"></textarea>
                    <script>
                        ClassicEditor
                            .create(document.querySelector('#editor'))
                            .then(editor => {
                                console.log(editor);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    </script>
                    <div class="form-control">
                        Chọn ảnh đại điện:
                        <input type="file" name="upload_file" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        Người đăng:
                        <input type="text" name="txt_author" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        Ngày đăng:
                        <input type="date" name="txt_date" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        Nhập trạng thái tin tức:
                        <input type="text" name="txt_status" id="" class="form-control">
                    </div>
                    <br>
                    <input type="submit" value="Lưu lại" name="update" class="btn btn-primary">
                        </form>
                </div>
            </div>