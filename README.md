# PHPsay的接口
  
  本来想用nodejs的，但是考虑到有很多草根站长的虚拟主机可能不支持nodejs
  
  
  
##关于安全

  除了登陆以外，所有的接口都采用了一次性Oauth效验，暂且不说穷举之类的，普通商业完全足够用了
  
  
  
##关于效验

  每次登陆都将重新生成Oauth_token和oauth_token_secret，退出以后该数据被清空
  
  有效的解决了你登陆以后，其他设备或client登陆的情况
   
  有效的解决了你退出以后被其他人穷举发帖
  
  
  
##关于接口

  接口入口文件只api/api.php内，在官方的控制器目录下新增了一个类，该类写的比较简单，主要是MVC的方法实现后期的更大扩展和备用
  
  
  
##接口进度

  接口核心完成
  
  登陆完成
  
  内容列表完成
  
  其他的功能会很快完善，毕竟麻烦的在核心和方面。
  
  
  
##用途

  用于业余时间写一个轻客户端，开源是为了其他人也可以使用
  
  
  
#关于本接口

  本接口来自第三方，不代表官方立场。若需要商用，请先购买PHPsay版权以后在获得我的授权，全靠自觉^ ^  