<?php
    $username=$_POST['username'];
    $password=$_POST['password'];
   $conn=mysqli_connect("localhost","root","zhangdofa");
    if($conn){
        mysqli_select_db($conn,"test");
        $sql="select username from user where username='$username'";
        $res=mysqli_query($conn,$sql);
        while ($row =mysqli_fetch_assoc($res)) {
            # code...
            $a =$row['username'];
        }
        if ($a) {
        # code...
            echo "no";
        }else{
            $sql ="insert into user values('$username','$password','')";
            mysqli_query($conn,$sql);
            echo "ok";
        }
        mysqli_close($conn);
    }else{
        die('Could not connect: ' . mysql_error());  
    }
                    

?>