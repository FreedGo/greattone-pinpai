<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//--------------- 界面参数 ---------------
$addr=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid=$userid limit 1");
$userpic=$addr['userpic']?$addr['userpic']:$public_r[newsurl].'e/data/images/nouserpic.gif';
$teacher_type=$addr['teacher_type'];
$putong_shenfen=$addr['putong_shenfen'];
$music_star=$addr['music_star'];
$jiaoshi=$addr['jiaoshi'];
$aihao=$addr['aihao'];
$renzheng=$addr['renzheng'];
$sex=$addr['sex'];
$chusheng=$addr['chusheng'];
$address=$addr['address'];
$address1=$addr['address1'];
$address2=$addr['address2'];
$addres=$addr['addres'];
$telephone=$addr['telephone'];
$fuzeren=$addr['fuzeren'];
//---------------------------------------
$addr=$empire->fetch1("select * from {$dbtbpre}enewsmember where userid=$userid limit 1");
$userfen=$addr['userfen'];
$groupid=$addr['groupid'];
$userid=$addr['userid'];
$email=$addr['email'];
$cked=$addr['cked'];
//公告
$spacegg='';
if($addur['spacegg'])
{
	$spacegg=$addur['spacegg'];
}
//导航菜单
$wznum=0; //文章总数
$dhmenu='';
$modsql=$empire->query("select mid,qmname,tbname from {$dbtbpre}enewsmod where usemod=0 and showmod=0 and qenter<>'' order by myorder,mid");
while($modr=$empire->fetch($modsql))
{
	$num=$empire->num("select id from {$dbtbpre}ecms_$modr[tbname] where userid='$userid'");
	$wznum=$wznum+$num;
	$dhmenu.='<li><a href="/e/space/list.php?userid='.$userid.'&mid='.$modr[mid].'">'.$modr[qmname].'</a></li>';
}
//会员信息
$tmgetuserid=$userid;	//用户ID
$tmgetusername=RepPostVar($username);	//用户名
$tmgetgroupid=$groupid;	//用户组ID
$getuserid=(int)getcvar('mluserid');//当前登陆会员ID
$getusername =getcvar('mlusername');//当前登陆会员名
//会员组名称
if($tmgetgroupid)
{
	$tmgetgroupname=$level_r[$tmgetgroupid]['groupname'];
	if(!$tmgetgroupname)
	{
		include_once(ECMS_PATH.'e/data/dbcache/MemberLevel.php');
		$tmgetgroupname=$level_r[$tmgetgroupid]['groupname'];
	}
}
$follow=$empire->fetch1("select * from {$dbtbpre}enewsmemberadd where userid=$userid");
$feeduserid=explode("::::::",$follow['feeduserid']);
$Diybg=$follow['Diybg']?$follow['Diybg']:$public_r[newsurl].'yecha/blogbg.jpg';
if ($follow['lockBgImg']){
	$lockbg=" fixed";
}
if ($follow['bgsize']){
	$bgsize="background-size:100% 100%;";
}
$bgcolor=$follow['bgcolor']?$follow['bgcolor']:'#b7e3c1';
$Bgalign=$follow['Bgalign']?$follow['Bgalign']:'center';
$repeatBg=$follow['repeatBg']?$follow['repeatBg']:'repeat';
$feedusernum=count($feeduserid)-1; //该会员的关注数
$fsnum=0; //该会员的粉丝数
$fl=$empire->query("select feeduserid from {$dbtbpre}enewsmemberadd order by userid"); 
while($n=$empire->fetch($fl))
{
	$flid=explode("::::::",$n['feeduserid']);
	if (in_array($userid,$flid)){
		$fsnum=$fsnum+1;
	}
}
//增加会员访问记录
if ($getuserid && $getuserid<>$userid){
	$r=$empire->fetch1("select zuijin from {$dbtbpre}enewsmemberadd where userid='$userid' limit 1");
	if (empty($r['zuijin'])){
		$empire->query("update {$dbtbpre}enewsmemberadd set zuijin='$getuserid::::::' where userid='$userid'");
		} else {
		$zuijin=explode("::::::",$r['zuijin']);
		if (in_array($getuserid,$zuijin))
    	{
			$newzuijin=$getuserid."::::::".str_replace($getuserid."::::::","",$r['zuijin']);
			$empire->query("update {$dbtbpre}enewsmemberadd set zuijin='$newzuijin' where userid='$userid'");
    	} else{
			$empire->query("update {$dbtbpre}enewsmemberadd set zuijin='$getuserid::::::$r[zuijin]' where userid='$userid'");
		}
	}
}
//我还是他还是她
	if ($getuserid==$userid){
		$me="我";
	} else{
		if ($addur[sex]=="男"){
			$me="他";
		} elseif ($addur[sex]=="女"){
			$me="她";
		} else {
			$me="Ta";	
		}
	}
//我的幸运物
	$xingyun=$follow[xingyun]?$follow[xingyun]:"";
?>
<!DOCTYPE html>
<html lang="zh-CN" >
<head>
<meta charset="utf-8" />
<title><?=$spacename?></title>
<meta name="keywords" content="<?=$spacename?>" />
<meta name="description" content="<?=$spacename?>" />
<script>
function ChangeMenuBg(doobj,dofont){
	doobj.style.cursor="hand";
	doobj.style.background='url(template/default/images/nav_a_bg3.gif)';
	dofont.style.color='#000000';
}
function ChangeMenuBg2(doobj,dofont){
	doobj.style.background='';
	dofont.style.color='#ffffff';
}
</script>
<script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/xin_base.css">
<!--<link rel="stylesheet" type="text/css" href="/css/haixuan.css">-->
<link rel="stylesheet" type="text/css" href="/css/xin_yueqipinpai.css">
<!-- <link href="/yecha/Common.css" rel="stylesheet" type="text/css" /> -->
<!--<link href="/yecha/hycenter.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/yecha/button.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/yecha/user/visuallightbox.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript">var actid;</script>
<script type="text/javascript" src="/js/xin_haixuan.js" ></script>
<!--<script type="text/javascript" src="/js/area.js"></script>-->
<!--<link href="/yecha/Common.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/yecha/hycenter.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/yecha/button.css" rel="stylesheet" type="text/css" />-->
<!--<link href="/yecha/user/visuallightbox.css" rel="stylesheet" type="text/css" />-->
<!--<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript" src="/js/jquery.timeago.js"></script>
<!--<script type="text/javascript" src="/js/jNotify.jquery.min.js"></script>-->
<!--<script type="text/javascript" src="/js/artDialog.js"></script>-->
<!--<script type="text/javascript" src="/js/iframeTools.js"></script>-->
<!--<script type="text/javascript" src="/js/visuallightbox.js"></script>-->
<!--<script type="text/javascript" src="/js/52img.js"></script>-->
<script language="javascript" src="/js/language.js"></script>

<script type="text/javascript">
jQuery(document).ready(
function(){window.Lightbox = new jQuery().visualLightbox({autoPlay:false,borderSize:12,classNames:'lightbox',closeLocation:'top',descSliding:true,enableRightClick:false,enableSlideshow:true,prefix:'vlb1',resizeSpeed:7,slideTime:4,startZoom:true});
var a=jQuery;a("#feedlist .lightbox").mouseenter(function(){var b=a("div.vlb_zoom",this);if(!b.length){b=a('<div class="vlb_zoom" style="position:absolute">').hide().appendTo(this);a("img:first",b).detach()}b.fadeIn("fast")}).mouseleave(function(){a("div",this).fadeOut("fast")})
});
</script>
</head>
<body>


<div class="headerWrap">
	<!-- 顶部结构······················································ -->
		<div class="head clearfix">
        <div class="huanying">
        	<script>
				document.write('<script src="<?=$public_r['newsurl']?>e/member/login/headjs.php?t='+Math.random()+'"><'+'/script>');
			</script>
			</div>
			<div class="h1">
				<a href="<?=$public_r['newsurl']?>">
					<h1>好琴声</h1>
				</a>
			</div>
			<div class="fanti">
				<a href="javascript:zh_tran('s');" class="zh_click jianti" id="zh_click_s">简体</a>
				<a href="javascript:zh_tran('t');" class="zh_click fanti1" id="zh_click_t">繁體</a>
			</div>
			<div class="erWeiMa">
				<!-- <div class="erWeiMaImg">
					<img src="<?=$public_r['newsurl']?>images/foot_app.jpg" alt="">
				</div>
				<h2>扫一扫下载APP</h2> -->
				<a class="fatieBtn2" id="fatieBtn2" href="/e/fatie/ListInfo.php?mid=10"></a>
			</div>
			<div class="denglu clearfix">
				<div class="dengLeft">
					<ul class="clearfix">
					<script>
					document.write('<script src="<?=$public_r['newsurl']?>e/member/login/headjs_1.php?t='+Math.random()+'"><'+'/script>');
					</script>
					</ul>
				</div>
				<div class="dengRight">
					<a href="javascript:;">
						<img src="<?=$public_r['newsurl']?>images/ad1.jpg" height="70" width="150" alt="">
					</a>
				</div>
			</div>
		</div>
	<!-- 顶部结构结束······················································ -->

	<!-- 导航结构···························································· -->
		<div class="navwrap">
			<div class="nav">
				<ul class="clearfix">
					<li><a href="<?=$public_r['newsurl']?>guangchang">音乐广场</a></li>
					<li><a href="<?=$public_r['newsurl']?>news">音乐资讯</a></li>
					<li><a href="<?=$public_r['newsurl']?>haixuan">网络海选</a></li>
<!--					<li><a href="--><?//=$public_r['newsurl']?><!--mingren">音乐名人</a></li>-->
					<li><a href="<?=$public_r['newsurl']?>laoshi">音乐老师</a></li>
					<li><a href="<?=$public_r['newsurl']?>jiaoshi">音乐教室</a></li>
					<!--<li><a href="<?=$public_r['newsurl']?>yuetuan">音乐乐团</a></li>-->
					<li><a href="<?=$public_r['newsurl']?>zhibo">直播课堂</a></li>
					<li><a href="<?=$public_r['newsurl']?>yuepu">乐谱中心</a></li>
<!--					<li><a href="--><?//=$public_r['newsurl']?><!--haixuan">网络海选</a></li>-->
					<!--<li><a href="<?=$public_r['newsurl']?>yuepu">音乐乐谱</a></li>-->
					<!--<li><a href="<?=$public_r['newsurl']?>baike">音乐百科</a></li>-->
					<!--<li><a href="<?=$public_r['newsurl']?>diantai">音乐电台</a></li>-->
					<li><a href="<?=$public_r['newsurl']?>bbs">声粉论坛</a></li>
				</ul>
			</div>
		</div>
	<!-- 导航结构···························································· -->
	</div>

	<!-- 登录结构 -->
		<div class="loginQian">
			<i class="close iconfont">&#xe631;</i>
			<h3>登录好琴声</h3>
			<form name=login method=post action="/e/member/doaction.php">
				<input type=hidden name=enews value=login>
				<input type=hidden name=ecmsfrom value=9>
				<ul>
					<li class="loginName">
						<label for="username">用户名：</label>
						<input type="username" id="username" name="username" placeholder="请输入用户名" required>
					</li>
					<li class="loginWord">
						<label for="password">密　码：</label>
						<input type="password" id="password" name="password" placeholder="请输入密码" required>
						
					</li>
					<!--<li class="yanzhengma">
						<label for="yanzheng">验证码：</label>
						<input type="text" id="yanzheng" required placeholder="请输入验证码">
						<img src="/images/yanzhengma.gif"  alt="">
					</li>-->
					<li class="loginRadio" id="loginRadio1">
						<input type="radio" id="jizhuwo">
						<label for="onlyYou">记住账号</label>
					</li>
					<li class="loginSub"><input type="submit" id="submit" name="Submit" value=""><label for="submit">登　录</label></li>
				</ul>
			</form>
			<div class="register">
				<span>没有账号?</span>
				<a href="<?=$public_r['newsurl']?>e/member/register/">立即注册</a>
				<a class="forget" href="<?=$public_r['newsurl']?>e/member/register/">忘记密码？</a>
			</div>
		</div>	
		<div class="loginDown"></div>
	<!-- 主页点击登陆···························································· -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('#loginBtn').eq(0).click(function(event) {
				$('.loginQian').stop(true).fadeIn('400');
				$('.loginDown').stop(true).fadeIn('400');
			});
			$('.close').click(function(event) {
				$('.loginQian').stop(true).fadeOut('400');
				$('.loginDown').stop(true).fadeOut('400');
			});
		});
	</script>
</div>
<!-- 头部结构结束······························································ -->
<!-- ····························中间结构·································· --><!--
    	<div class="hytopmenu yh f14">
        	<div class="hymenu">
        	<span><?=$me?>的:</span>
        	<ul>
        		<li><a href="<?=$spaceurl?>">主页</a></li>
                <?=$dhmenu?>
                <li><a href="/e/space/fans.php?userid=<?=$userid?>">粉丝</a></li>
                <li><a href="/e/space/gbook.php?userid=<?=$userid?>">留言</a></li>
        	</ul>
            </div>
        </div>
        <div class="hy_avator">
        	<div class="avator_bg">
        	<img src="<?=$userpic?>" />
            </div>
            <div class="my_left">
            	<ul>
                    	<li><a href="javascript:void()" onclick="follow(<?=$userid?>)">关注<br /><strong><?=$feedusernum?></strong></a></li>
                        <li><a href="/e/space/fans.php?userid=<?=$userid?>">粉丝<br /><strong><?=$fsnum?></strong></a></li>
                        <li><a href="/e/space/list.php?userid=<?=$userid?>&mid=10">文章<br /><strong><?=$wznum?></strong></a></li>
                        <div class="clearfix"></div>
                </ul>
                <div class="renzheng clearfix"><span class="button green small">好琴声—<?=$tmgetgroupname?></span></div>
            </div>
        </div>
        <div class="hyhead">
        	<div class="fl w230"></div>
            <div class="fl hyxx">
            	<h3><a href="<?=$spaceurl?>" class="yh"><?=$spacename?></a></h3>
                <span class="hyurl"><a href="<?=$spaceurl?>"><?=$spaceurl?></a><br /><?=$addur[juzhu]?> | <?=$addur[job]?> | <?=$addur[sex]?></span>
                <span class="rzxx"><?=$addur[renzheng]?></span>
                <div class="hyhudong">
                <?php				
                        	if ($getuserid!=$userid){
								$f=$empire->fetch1("select feeduserid from {$dbtbpre}enewsmemberadd where userid='$getuserid'");
								$fduserid=explode("::::::",$f['feeduserid']);
								if (in_array($userid,$fduserid)){
								$follow='<a href="javascript:void()" onclick="follow('.$userid.')" class="button blue small orange" id="follow'.$userid.'" title="取消关注">取消关注</a>';
								} else{
								$follow='<a href="javascript:void()" onclick="follow('.$userid.')" class="button blue small" id="follow'.$userid.'">关注</a>';	
								}
								
								} else {
								$follow='<a href="/e/member/EditInfo/" class="button blue small">修改资料</a>';
							}
				?>
                <?=$follow?><a href="/e/member/msg/AddMsg/?enews=AddMsg&username=<?=$username?>" target="_blank" class="button gray small ml10">发站内信</a></div>
            </div>
            <div class="fr hygg yh">
<?=$spacegg?>
				<?php
                if ($getuserid==$userid){
					echo '<a href="/e/member/mspace/SetSpace.php" class="editgg">修改公告</a>';
					}
				?>
				<div class="hyggxx">公告牌</div>
            </div>
        </div>
-->
