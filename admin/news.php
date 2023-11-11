<?php
    require("../config.php");
    if(isset($_POST["btn_insert"])){
        //lay ra gia tri duoc nhap vao text
        $cate_id = $_POST["cate"];
        $title = $_POST["txt_news"];
        $content = $_POST["txt_content"];
        $author = $_POST["txt_author"];
        $post_date = $_POST["txt_date"];
        $status = $_POST["txt_status"];

        //upload intro img
        $target_dir = "upload_tintuc";
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
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                $sql_insert = "insert into tbl_news(cate_id,title,content,intro_img,author,post_date,status) values(".$cate_id.",N'".$title."',N'".$content."','".$target_file."',N'".$author."','".$post_date."',".$status.")";
                if (mysqli_query($conn, $sql_insert)) {
                    header("location:news.php");
                    //echo "New record created successfully";
                } 
                else {
                    echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
                }
            } 
            else {
                echo "Sorry, there was an error uploading your file.";
            }
          }

        
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <title>Trang Quan tri tin tuc</title>
    </head>
    <body style="background-color: #ffffcc;">
        <div class="container">
            <h1 style="text-align: center;">Trang Quản Trị Tin Tức</h1>
            <div class="row">
                <div class="col-6">
                    <form action="news.php" method="post" enctype="multipart/form-data">
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
                        Nhập tiêu đề:
                        <input class="form-control" type="text" name="txt_news" id="">
                        Nhập nội dung tin tức:
                        <!-- <div id="editor" name="txt_content">This is some sample content.</div> -->
                        <textarea name="txt_content" id="editor"></textarea>
                        <script>
                                ClassicEditor
                                        .create( document.querySelector( '#editor' ) )
                                        .then( editor => {
                                                console.log( editor );
                                        } )
                                        .catch( error => {
                                                console.error( error );
                                        } );
                        </script>
                        Chọn ảnh đại diện:
                        <input class="form-control" type="file" name="upload_file" id="">
                        Người đăng:
                        <input class="form-control" type="text" name="txt_author" id="">
                        Ngày đăng:
                        <input class="form-control" type="date" name="txt_date" id="">
                        Nhập trạng thái tin tức:
                        <input class="form-control" type="text" name="txt_status" id="">
                        <br>
                        <input class="btn btn-primary" name="btn_insert" type="submit" value="Thêm mới">
                    </form>
                </div>
            </div>
            <div class="row">
                
                <div class="col-6">
                    <form action="#" method="post">
                        
                            <input placeholder="tim kiem theo tieu de tin ..." class="form-control" type="text" name="txt_search" id="">
                            <br>
                            <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-stripped">
                        <tr>
                            <th>Mã Tin Tức</th>
                            <th>Tên Danh Mục</th>
                            <th>Tiêu Đề Tin</th>
                            <th>Nội Dung Tin</th>
                            <th>Ảnh Đại Diện</th>
                            <th>Người Đăng</th>
                            <th>Ngày Đăng</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                        <?php

                            $sql = " ";
                            if(isset($_POST["txt_search"])){
                                $title = $_POST["txt_search"];
                                $sql = "select * from tbl_news where title like '%".$title."%'";
                            }
                            else
                            $sql = "select * from tbl_news order by news_id DESC";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $s = "";
                                    if($row["status"]==0){
                                        $s = "<p style='color:red'>An</p>";
                                    }
                                    else{
                                        $s = "<p style='color:green'>Hien</p>";
                                    }
                                    echo "<tr>";
                                    echo "<td>". $row["news_id"] . "</td>";
                                    echo "<td>". $row["cate_id"] . "</td>";
                                    echo "<td>". $row["title"] . "</td>";
                                    echo "<td>". $row["content"] . "</td>";
                                    echo "<td><img src='". $row["intro_img"] . "'width='100' height='80'></td>";
                                    echo "<td>". $row["author"] . "</td>";
                                    echo "<td>". $row["post_date"] . "</td>";
                                    echo "<td>".$s."</td>";
                                    echo "<td>";
                                        echo "<a class='btn btn-warning' href='update_news.php?task=update&id=".$row["news_id"]."'>Sửa</a>";
                                        echo "<a class='btn btn-danger' href='delete.php?task=delete&id=".$row["news_id"]."'>Xóa</a>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<input type='checkbox' name='news[]' value='".$row["news_id"]."' class='form-check-input'>";
                                    echo "</td>";
                                    echo "</tr>";
                                    //echo $row["cate_id"] . " , " . $row["cate_name"] . "<br>";
                                }
                            }
                            else{
                                echo "Bảng không chứa dữ liệu";
                            }
                        ?>
                        
                    </table>
                </div>
            </div>
        </div>

    </body>
</html>