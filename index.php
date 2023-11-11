<table>
    <tr>
        <th>mã danh mục </th>
        <th> tên danh mục </th>
        <th> trạng thái </th>
    </tr>
<?php
    require("config.php");
    // lấy và hiển thị dữ liệu 
    $sql = "select * from tbl_category";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $st="";
            if($row["status"]==0){
                $st = "<p style='color:red'>ẩn</p>";
            }
            else{
               $st =" <p style='color:blue'>hiện</p>"; 
            }
            
        echo"<tr>";
        echo"<td>".$row["cate_id"]."</td>";
        echo"<td>".$row["cate_name"]."</td>";
        echo"<td>".$st."</td>";
        echo"</tr>";
        }
    }
    else
    {
        echo "bạn không đủ dữ liệu ";
    }
?>
</table>