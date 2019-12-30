<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Cookie;
use think\Response;
use think\Session;

class Index extends Controller{
      public function index(){
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
}
