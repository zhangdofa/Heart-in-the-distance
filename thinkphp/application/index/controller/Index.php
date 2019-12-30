<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Cookie;
use think\Response;
use think\Session;

class Index extends Controller{
    /*public function index(){
       $request = Request::instance();

       $member=Db::name('member')->limit(3)->select();
       dump($member);
       $data=['id'=>'50','truename'=>'老李','mobile'=>'122222222'];
       Db::name('member')->insert($data);
       //$name=['name'];

       $param=$request->param('name');
       dump($param);
       //获取域名
       echo 'domain: ' . $request->domain() . '<br/>';
       // 获取当前入口文件
       echo 'file: ' . $request->baseFile() . '<br/>';
       // 获取当前URL地址 不含域名
       echo 'url: ' . $request->url() . '<br/>';
       // 获取包含域名的完整URL地址
       echo 'url with domain: ' . $request->url(true) . '<br/>';
       // 获取当前URL地址 不含QUERY_STRING
       echo 'url without query: ' . $request->baseUrl() . '<br/>';
       // 获取URL访问的ROOT地址
       echo 'root:' . $request->root() . '<br/>';
       // 获取URL访问的ROOT地址
       echo 'root with domain: ' . $request->root(true) . '<br/>';
       // 获取URL地址中的PATH_INFO信息
       echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
       // 获取URL地址中的PATH_INFO信息 不含后缀
       echo 'pathinfo: ' . $request->path() . '<br/>';
       // 获取URL地址中的后缀信息
       echo 'ext: ' . $request->ext() . '<br/>';
       exit;
       $a=url('blog/read', 'name=thinkphp');
       echo $a;
       $this->assign('name',$name);
       return $this->fetch();
       $this->assign('mem',$member);
       return $this->fetch();
    }*/
    public function index()
    {
        $data = ['name'=>'thinkphp','url'=>'thinkphp.cn'];
        return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
    }
    public function swiper(){
      return $this->fetch();
    }
    //首页
    public function home(){
      if(isset($_COOKIE['username'])){
        $username=Cookie::get('username');
       $page=Request::instance()->post('page');
       $member=Db::name('goods')->limit(4)->select();
       /*echo json_encode($member1);*/
      /* echo $member1[0]['id'];*/
       $this->assign('aaa',$member);
       return $this->fetch();
      }else{
      $username=Session::get('username');
       $page=Request::instance()->post('page');
       $member=Db::name('goods')->limit(4)->select();
       /*echo json_encode($member1);*/
      /* echo $member1[0]['id'];*/
       $this->assign('aaa',$member);
       return $this->fetch();
      }
    }
    //加载更多
    public function home_ajax(){
      $page=Request::instance()->post('page');
      $page1=($page-1)*6;
      $member1=Db::name('goods')->limit($page1,6)->select();
      echo json_encode($member1);
    }
    //登录
    public function login(){
      $username=Request::instance()->post('username');
      $password=Request::instance()->post('password');
      $checkbox=Request::instance()->post('checkbox');

      //判断是否存在cookie
      if(isset($_COOKIE['username'])){
        $this->redirect(url('/Index/personal'));
      }
      /*//判断是否存在cookie
      if(isset($_COOKIE['password'])){
       $this->assign('password',$_COOKIE['password']);
        return $this->fetch();
      }*/
      $member1=Db::table('user')->where('username',$username)->find();
      if ($member1) {
            # code...
            $m= Db::table('user')->where('username',$username)->value('password');
            if ($password==$m) {
                  # code...
                        # code...
                       # code...
              if ($checkbox=='true') {
                # code...
                 Cookie::set('username',$username,3600);
                      Cookie::set('password',$m,3600);
                       echo "ok";
              }
              if ($checkbox=='false') {
                # code...
                Session::set('username',$username);
                echo "ok";
              }
                     
            }else{
                  echo "no";
            }
      }else{
      }
      $this->assign('bbb',$member1);
      return $this->fetch();

    }

    //忘记密码
    public function updatepwd(){
      $username=Request::instance()->post('username');
      $mail=Request::instance()->post('mail');
      $member=Db::name('user')->where('username',$username)->select();
      if ($member) {
        # code...
        $member1=Db::name('user')->where('username',$username)->value('mail');
        if ($mail==$member1) {
          # code...
          echo "ok";
        }else{
          echo "no";
        }
      }else{
        echo "none";
      }
    }
    //修改密码
    public function updatepwd1(){
      $username=Request::instance()->post('username');
      $pwd=Request::instance()->post('pwd');
      $member=Db::name('user')->where('username',$username)->update(['password'=>$pwd]);
      if ($member) {
          echo "ok";
      }else{
        echo "no";
      }
    }
    //注册
    public function register(){
      $username=Request::instance()->post('username');
      $password=Request::instance()->post('password');
      $mail=Request::instance()->post('mail');
      $member=Db::name('user')->where('username',$username)->find();
      if($member){
            echo "no";
      }else{
        if ($mail) {
          # code...
            $data['username']=$username;
            $data['password']=$password;
            $data['mail']=$mail;
            $a=Db::name('user')->insert($data);
            if($a){
                  echo "ok";
            }else{
                  echo "none";
            }     
        }else{
          echo "no1";
        }
            
      }
      }
      //个人中心
      public function personal(){
        if (isset($_COOKIE['username'])) {
          # code...
           $username=Cookie::get('username');
           $password=Cookie::get('password');
           $member=Db::name('user')->where('username',$username)->select();
           $this->assign('ddd',$member);
           return $this->fetch();
        }else{
           $username=Session::get('username');
           if ($username) {
             # code...
              $member=Db::name('user')->where('username',$username)->select();
              $this->assign('ddd',$member);
              return $this->fetch();
           }else{

               return $this->fetch();
           }
           
          /*}*/
      }
    }

      public function personal_ajax(){
            $username=Session::get('username');
            $member=Db::name('user')->where('username',$username)->select();
            echo json_encode($member);
      }
    //退出登录
      public function info(){
           Cookie::delete('username');
           Cookie::delete('password');
           Session::delete('username');
           echo "退出成功";
      }
      //个人信息
      public function out(){
        if (isset($_COOKIE['username'])) {
          # code...
           $username=Cookie::get('username');
           $member=Db::name('user')->where('username',$username)->select();
           $this->assign('ddd',$member);
           return $this->fetch();
        }else{
          $username=Session::get('username');
          $member=Db::name('user')->where('username',$username)->select();
           $this->assign('ddd',$member);
           return $this->fetch();
      }
    }
    //购物车
      public function buycar(){
        if (isset($_COOKIE['username'])) {
          # code...
           $username=Cookie::get('username');
           $member=Db::name('user')->where('username',$username)->value('id');
           $member1=Db::name('buycar')->where('id',$member)->select();
           $this->assign('eee',$member1);
           return $this->fetch();
        }else{
            $username=Session::get('username');
            if ($username) {
              # code...
             $member=Db::name('user')->where('username',$username)->value('id');
             $member1=Db::name('buycar')->where('userid',$member)->select();
             $this->assign('eee',$member1);
             return $this->fetch();
            }else{
              $member1='';
              $this->assign('eee',$member1);
              return $this->fetch();
            }
            
         /* }*/
          
      }
        }
        //添加购物车
        public function addcar(){
            $username=Session::get('username');
            if ($username) {
              # code...
               $img=Request::instance()->post('img');
               $title=Request::instance()->post('title');
               $price=Request::instance()->post('price');
               $id=Db::name('user')->where('username',$username)->value('id');
               $data=['userid'=>$id,'img'=>$img,'title'=>$title,'price'=>$price];
               $member=Db::name('buycar')->where('userid',$id)->insert($data);
            }else{
               echo 'no';
            }
           
        }
        //上传图片
       public function upload(){
        $username=Session::get('username');
       // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
           $info = $file->move(ROOT_PATH .  'public/img','');
           if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 

            $img=$info->getFilename();
            $member=Db::name('user')->where('username',$username)->update(['img' => $img]);
            if ($member) {
              # code...
              echo "ok";
            }else{
              echo "no";
            }
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
            return $this->fetch();
  }    
        //分类
        public function classify(){         
          $member=Db::name('jrkj_item_cate')->where('pid',0)->select();
          foreach ($member as $key => $value) {
             $son=Db::name('jrkj_item_cate')->where('pid',$value['id'])->select();
             $member[$key]['son']=$son;
          }
          $this->assign('fff',$member);
          return $this->fetch();
        }
        //分页
        public function page(){
          $page=Request::instance()->post('page');
          if ($page) {
            # code...
            if ($page==1) {
            # code...
           $member= Db::name('goods')->order('price desc')->paginate(6);
            echo json_encode($member);
          }else{
             $member= Db::name('goods')->order('price asc')->paginate(6);
            echo json_encode($member);
          }
          }else{
            $member=Db::name('goods')->paginate(6);
            $this->assign('aaa',$member);
            return $this->fetch();
          }
     }
        //排序
        public function page_ajax(){
          $page=Request::instance()->post('page');
          if ($page==1) {
            # code...
           $member= Db::name('goods')->order(['price' => 'desc'])->paginate(6);
            echo json_encode($member);
          }else{
            $member= Db::name('goods')->order('price asc')->select();
            $member1=$member->paginate(6);
            echo json_encode($member);
          }
      }
        //设置
        public function setting(){
          return $this->fetch();
        }
        public function setting_ajax(){
          $username=Session::get('username');
          $mail=Request::instance()->post('mail');
          $member=Db::name('user')->where('username',$username)->value('mail');
          if ($member==$mail) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
        //忘记密码
        public function update(){
          return $this->fetch();
        }
        //修改登录密码
        public function update_ajax(){
          $username=Session::get('username');
          $pwd=Request::instance()->post('pwd');
          $password=Db::table('user')->where('username', $username)->update(['password' => $pwd]);
          if ($password) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
         public function update1(){
          return $this->fetch();
        }
        //设置支付密码
         public function update1_ajax(){
          $username=Session::get('username');
          $pwd=Request::instance()->post('pwd');
          $length=Db::table('user')->where('username', $username)->select();
          if ($length) {
            # code...
            echo 'exists';
          }else{
            $password=Db::table('user')->where('username', $username)->update(['paypwd' => $pwd]);
            if ($password) {
            # code...
               echo "ok";
            }else{
               echo "no";
          }
          }
        }
        public function update2(){
          return $this->fetch();
        }
        //修改支付密码
        public function update2_ajax(){
          $username=Session::get('username');
          $pwd=Request::instance()->post('pwd');
          $password=Db::table('user')->where('username', $username)->update(['paypwd' => $pwd]);
          if ($password) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
        //显示我的收货地址
        public function adress(){
          $username=Session::get('username');
          $member=Db::name('user')->where('username',$username)->value('id');
          $member1=Db::name('jrkj_address')->where('member_id',$member)->select();
          $this->assign('aaa',$member1);
          return $this->fetch();
        }
        //删除收获地址
        public function delete(){
          $id=Request::instance()->post('id');
          $member1=Db::name('jrkj_address')->where('id',$id)->delete();
          if ($member1) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
        //新增收货地址
        public function addadress(){
          $username=Session::get('username');
          $username1=Request::instance()->post('username');
          $tel=Request::instance()->post('tel');
          $province=Request::instance()->post('province');
          $city=Request::instance()->post('city');
          $county=Request::instance()->post('county');
          $address=Request::instance()->post('address');
          $is_default=Request::instance()->post('radio');
          $id=Db::name('user')->where('username',$username)->value('id');
            $data['consignee']=$username1;
            $data['tel']=$tel;
            $data['province']=$province;
            $data['city']=$city;
            $data['county']=$county;
            $data['address']=$address;
            $data['member_id']=$id;
            $data['is_default']=$is_default;
          $member=Db::name('jrkj_address')->insert($data);
          if ($member) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
        //显示修改收货地址页面
        public function editor(){
          $id=Request::instance()->param('id');
          $member=Db::name('jrkj_address')->where('id',$id)->select();
          $this->assign('aaa',$member);
          return $this->fetch();
        }
        //修改收货地址
        public function upadress(){
          $id=Request::instance()->post('id');
          $username=Session::get('username');
          $username1=Request::instance()->post('username');
          $tel=Request::instance()->post('tel');
          $province=Request::instance()->post('province');
          $city=Request::instance()->post('city');
          $county=Request::instance()->post('county');
          $address=Request::instance()->post('address');
          $is_default=Request::instance()->post('radio');
          $id1=Db::name('user')->where('username',$username)->value('id');
            $data['consignee']=$username1;
            $data['tel']=$tel;
            $data['province']=$province;
            $data['city']=$city;
            $data['county']=$county;
            $data['address']=$address;
            $data['member_id']=$id1;
            $data['is_default']=$is_default;
          $member=Db::name('jrkj_address')->where('id',$id)->update($data);
          if ($member) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
        //设置默认地址
        public function radio(){
          $id=Request::instance()->post('id');
          $username=Session::get('username');
          $id1=Db::name('user')->where('username',$username)->value('id');
          $member=Db::name('jrkj_address')->where('member_id',$id1)->update(['is_default'=>2]);
          $member=Db::name('jrkj_address')->where('id',$id)->update(['is_default'=>1]);
        }
        //保存数量
        public function savenum(){
          $num=Request::instance()->post('num');
          $id=Request::instance()->post('id');
          $member=Db::name('buycar')->where('id',$id)->update(['num'=>$num]);
          dump($member);
        }
        //保存数量
        public function savenum1(){
          $num=Request::instance()->post('num');
          $id=Request::instance()->post('id');
          echo $num;
          echo $id;
          $member=Db::name('buycar')->where('id',$id)->update(['num'=>$num]);
          dump($member);
        }
        //确认订单信息
        public function order(){
         $id=$_POST['id'];
         $num=$_POST['sum'];
         $nums=implode(',', $num);
         $radio=$_POST['radio'];
         $ids=implode(',',$radio);//把商品id由数组变为逗号隔开
         $member1=Db::name('buycar')->where('id in ($ids)')->update();
          $member=Db::name('buycar')->where("id in ($ids)")->select();
         $this->assign('aaa',$member);
          return $this->fetch();
        }
        //显示默认收货地址
        public function show_address(){
          $username=Session::get('username');
          $member=Db::name('user')->where('username',$username)->value('id');
          $where['member_id']=$member;
          $where['is_default'] = 1;
          $member1=Db::name('jrkj_address')->where($where)->select();
          echo json_encode($member1);
        }
        //确认订单显示收货地址
        public function show_address1(){
          $username=Session::get('username');
          $member=Db::name('user')->where('username',$username)->value('id');
          $member1=Db::name('jrkj_address')->where('member_id',$member)->select();
          echo json_encode($member1);
        }
        //选择收货地址
        public function show_address2(){
          $id=Request::instance()->post('id');
          $member=Db::name('jrkj_address')->where('id',$id)->select();
          echo json_encode($member);
        }
        //生成订单
        public function order_ajax(){
          $id1=$_POST['id'];
          $ids=implode(',',$id1);
          $img=$_POST['img'];
          $imgs=implode('#', $img);
          $title=$_POST['title'];
          $titles=implode('#', $title);
          $price=$_POST['price'];
          $prices=implode('#', $price);
          $num=$_POST['num'];
          $nums=implode('#', $num);
          $consignee=$_POST['consignee'];
          $consignees=implode('#', $consignee);
          $tell=$_POST['tel'];
          $tells=implode('#', $tell);
          $address=$_POST['address'];
          $addresss=implode('#', $address);
          $amount=$_POST['sum'];
          $amounts=implode('#', $amount);
          // dump($id);
          // dump($img);
          // dump($title);
          // dump($price);
          // dump($num);
          // dump($consignee);
          // dump($tel);
          // dump($address);
          // dump($sum[0]);
          $username=Session::get('username');
          $order_id=date('YmdHis').rand(100000, 999999);
          // $amount=Request::instance()->post('amount');
          $id=Db::name('user')->where('username',$username)->value('id');
          $data['consignee']=$consignees;
          $data['tel']=$tells;
          $data['address']=$addresss;
          $data['order_id']=$order_id;
          $data['member_id']=$id;
          $data['amount']=$amount[0];
          $data['img']=$imgs;
          $data['title']=$titles;
          $data['price']=$prices;
          $data['num']=$nums;
          $member=Db::name('order')->insertGetId($data);
          $data1['img']=$img;
          $data1['title']=$title;
          $data1['price']=$price;
          $data1['num']=$num;
          $length=count($img);
          $data2=array(); 
          for($i=0; $i<$length; $i++){ //循环
           $data2[$i]['img']=$img[$i];
           $data2[$i]['title']=$title[$i];
           $data2[$i]['price']=$price[$i];
           $data2[$i]['num']=$num[$i];
           $data2[$i]['orderid']=$member;
          }
          $member1=Db::name('order_sku')->insertAll($data2);
          if ($member) {
            # code...
            $this->redirect('/Index/aplay', array('id' =>$member ,'ids'=>$ids), 302, ['data' => 'hello']);
          }else{
            $this->redirect(url('/Index/order'));
          }
        }
        //支付页面
        public function aplay(){
          $id=Request::instance()->param('id');
          //生成订单删除购物车的商品
          $ids=Request::instance()->param('ids');
          $ids1=explode(',', $ids);
          $maps["id"] = array("in",$ids1); 
          Db::name('buycar')->where($maps)->delete();
          if (empty($id)) {
            # code...
            $order_id=Request::instance()->param('order_id');
            $member=Db::name('order')->where('order_id',$order_id)->select();
            $this->assign('aaa',$member);
            return $this->fetch();
          }else{
          $member=Db::name('order')->where('id',$id)->select();
          $this->assign('aaa',$member);
          return $this->fetch();
         }
        }
        //确认支付密码
        public function paypwd(){
          $username=Session::get('username');
          $id=Db::name('user')->where('username',$username)->value('id');
          $paypwd=Request::instance()->post('paypwd');
          $id1=Request::instance()->post('id');
          $member=Db::name('user')->where('id',$id)->value('paypwd');
          if ($paypwd==$member) {
            # code...
            $member1=Db::name('order')->where('id',$id1)->update(['status'=>2]);
            echo "ok";
          }else{
            echo "no";
          }
        }
        //待付款订单
        public function orderstatus(){
          $username=Session::get('username');
          $id=Db::name('user')->where('username',$username)->value('id');
          $where['member_id']=$id;
          $where['status']=1;
          $info = Db::table('order')->alias('a')->join('order_sku w','a.id = w.orderid')
                  ->where($where)->select();
          $orderInfo=array();
          foreach($info as $key=>$val){
          $orderInfo[$val['order_id']][]=$val;
        }
          $this->assign('aaa',$orderInfo);
          return $this->fetch();
        }
        //删除订单
        public function delete_order(){
          $order_id=Request::instance()->post('order_id');
          $id=Db::table('order')->where('order_id',$order_id)->value('id');
          $info = Db::table('order')->where('order_id',$order_id)->delete();
          $member = Db::table('order_sku')->where('orderid',$id)->delete();
        }
        //待发货
        public function orderstatus1(){
          $username=Session::get('username');
          $id=Db::name('user')->where('username',$username)->value('id');
          $where['member_id']=$id;
          $where['status']=2;
          $info = Db::table('order')->alias('a')->join('order_sku w','a.id = w.orderid')
                  ->where($where)->select();
          $orderInfo=array();
          foreach($info as $key=>$val){
          $orderInfo[$val['order_id']][]=$val;
        }
         echo json_encode($orderInfo);
        }
        //确认收货
        public function query(){
          $order_id=Request::instance()->post('order_id');
          $member=Db::name('order')->where('order_id',$order_id)->update(['status'=>3]);
          if ($member) {
            # code...
            echo "ok";
          }else{
            echo "false";
          }
        }
        //待评价
        public function orderstatus2(){
          $username=Session::get('username');
          $id=Db::name('user')->where('username',$username)->value('id');
          $where['member_id']=$id;
          $where['status']=3;
          $where['defaule']=1;
          $info = Db::table('order')->alias('a')->join('order_sku w','a.id = w.orderid')
                  ->where($where)->select();
         echo json_encode($info);
        }
        //评价的商品
        public function orderstatus3(){
          $order_id=Request::instance()->post('order_id');
          $member=Db::table('order')->alias('a')->join('order_sku w','a.id = w.orderid')
                  ->where('order_id',$order_id)->select();
          echo json_encode($member);
        }
        //评价
        public function evaluate(){
          $radio=Request::instance()->post('radio');
          $text=Request::instance()->post('text');
          $evaluate=$radio.'#'.$text;
          $id=Request::instance()->post('id');
          $data['evaluate']=$evaluate;
          $data['defaule']=2;
          $member=Db::name('order_sku')->where('id',$id)->update($data);
          if ($member) {
            # code...
            echo "ok";
          }else{
            echo "no";
          }
        }
}
