<?php  
    $page=($_POST['page']-1)*6;
    $pagenum=6;
    $conn=mysqli_connect("localhost","root","zhangdofa");
    if($conn){
        mysqli_select_db($conn,"test");
        $sql="select * from goods limit $page,$pagenum";
        $res=mysqli_query($conn,$sql);
        $arr=array();//定义空数组
        while($row =mysqli_fetch_array($res)){
            //var_dump($row);
                //array_push(要存入的数组，要存的值)
            array_push($arr,$row);
        }
        echo json_encode($arr);
     }else{
        die('Could not connect: ' . mysql_error());  
    }
    

 ?>