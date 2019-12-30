<?php 
   $username=$_POST['username'];
   $password=$_POST['password'];
   $conn=mysqli_connect("localhost","root","zhangdofa");
    if($conn){
        mysqli_select_db($conn,"test");
        $sql="select username,password from user where username='$username'";
        $res=mysqli_query($conn,$sql);
        while ($row =mysqli_fetch_assoc($res)) {
            # code...
            $a =$row['username'];
            $b =$row['password'];
        }
        if ($a) {
        # code...
         if($b == $password) {
            # code...
            echo "ok";
        }else{
            echo "no";
        }
       }else{
        echo "none";
    }
        /*$arr=array();//定义空数组
        while($row =mysqli_fetch_array($res)){
            //var_dump($row);
                //array_push(要存入的数组，要存的值)
            array_push($arr,$row);
        }
        var_dump($arr);
        print_r($arr);
        foreach ($arr as $key => $value) {
        	# code...
           echo	$key;
          echo $arr[$key]['id']."<br>";
        }*/
        //4.关闭连接
        mysqli_close($conn);
    }else{
        die('Could not connect: ' . mysql_error());  
    }
    /*if ($conn) {
    	# code...
    	mysqli_select_db($conn,"php");
    	$sql="INSERT INTO `jrkj_member` VALUES ('48', 'shesebe', '', '张三', 'c6f4b02c1aa65a08af09cb8423c53c07', '15070994142', '627636297@qq.com', '1', '34', '', '0', '117.44.170.9', '1479112056', '1476955175', '1477040268', '0', '81912.00', '0.00', '0', '0', '0.00', '0.00', '0', '', '0', '1610/25/1477385703.jpeg', '0', null, '女', null, null, null, null, '10000', '3', '1', 'dsadsad', '南昌市徐家坊', 'c6f4b02c1aa65a08af09cb8423c53c07')";
    	mysqli_query($conn,$sql);
    	echo "ok";
    	//4.关闭连接
        mysqli_close($conn);
    }else{
    	die('Could not connect: ' . mysql_error());
    }
    //更新数据*/
    
    /*if ($conn) {
    	# code...
    	mysqli_select_db($conn,"php");
    	$sql="update jrkj_member set mobile='15779033833' where id=48";
    	mysqli_query($conn,$sql);
    	echo "ok";
    	//4.关闭连接
        mysqli_close($conn);
    }else{
    	die('Could not connect: ' . mysql_error());
    }*/
 ?>