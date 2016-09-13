<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='注册会员';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>&nbsp;>&nbsp;注册会员";
require(ECMS_PATH.'e/template/incfile/header_1.php');
?>
	<link rel="stylesheet" type="text/css" href="/css/laydate.css">
	<link rel="stylesheet" type="text/css" href="/css/zhuce.css">
	<link rel="stylesheet" type="text/css" href="/css/vali.css">
	<script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/js/laydate.js"></script> 
    <script type="text/javascript" src="/scripts/swfobject.js"></script>
    <script type="text/javascript" src="/scripts/fullAvatarEditor.js"></script>
    <script type="text/javascript" src="/js/adress.js"></script>
    <script type="text/javascript" src="/js/language.js"></script>
    <script type="text/javascript" src="/js/vali.min.js"></script>
    <script type="text/javascript" src="/js/register.yanzheng2.js"></script>
  
    
<table class="mainForm" width='1200' border='0' align='center' cellpadding='3' cellspacing='0' class="tableborder">
<form class="register-form" id="user_info_sub" name=userinfoform method=post enctype="multipart/form-data" action=../doaction.php class="newMember">
    <input type=hidden name=enews value=register>
    <tr class="header"> 
      <td  colspan="2">好琴声 音乐人的交流平台！<?=$tobind?' (绑定账号)':''?></td>
    </tr>
    
        <input name="groupid" type="hidden" id="groupid" value="<?=$groupid?>">
    <tr> 
      <td width='15%' height="25" bgcolor="#FFFFFF"> <div align='left'>
      <?
      	if($groupid==4){
			echo "机构名称";
		}elseif($groupid==1){
			echo "用户名：";
		}elseif($groupid==5){
			echo "品牌名：";
		}else{
			echo "真实姓名：";
		}
	  ?>
      </div></td>
      <td width='75%' height="25" bgcolor="#FFFFFF" class="chongfumima" > <input name='username' style="float:left;" type='text' id='username' class="yonghuming" maxlength='20' required>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF" > <div align='left'>密码：</div></td>
      <td height="25" bgcolor="#FFFFFF" class="chongfumima"> <input name='password' style="float:left;" class="password1" type='password' id='password' maxlength='20' required>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align='left'>重复密码：</div></td>
      <td height="25" bgcolor="#FFFFFF" class="chongfumima"> <input name='repassword' style="float:left;" type='password' id='repassword' maxlength='20' required>
        </td>
    </tr>
<!--    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align='left'>邮箱：</div></td>
      <td height="25" bgcolor="#FFFFFF"> <input name='email' type='text' id='email' maxlength='50'></td>
    </tr>-->
    
    <tr> 
      	<td height="25" colspan="2" bgcolor="#FFFFFF"> 
   
		<table width='100%' align='center' cellpadding=3 cellspacing=0 bgcolor='#DBEAF5'>

		<td width='15%' height=25 bgcolor='ffffff'>手机:</td>
		<td width='75%' bgcolor='ffffff' class="chongfumima">
			<select name="" id="" class="celltype">
				<option value="+86" title="中国">大陆</option>
				<option value="+886" title="台湾">台湾</option>
				<option value="+852" title="香港">香港</option>
				<option value="+853" title="澳门">澳门</option>
				<option value="+65" title="新加坡">新加坡</option>
				<option value="+1" title="美国">美国</option>
			</select><span class="receiveNum">+86</span>
			<!-- 区号提交 -->
			<input class="quxiao" type="hidden" value="+86">
			<input name='phone' type='text' id='photo' style="float:left;" class="iphoneNum" phone="t" vali maxlength='11' required>
			
		</td>
	</tr>

<tr>
<td width='15%' height=25 bgcolor='ffffff'>验证码：</td>
<td bgcolor='ffffff'><input type="text" class="yanzheng" required /><span class="yifasong" style="font-size:12px"></span><input class="yanzheng-pre" type="button" value="获取验证码" /></td>

</tr>
<tr><td width='15%' height=25 bgcolor='ffffff'>城市:</td>
<td bgcolor='ffffff'>
	<div id="sjld" class="clearix" >

	<div class="m_zlxg" id="shenfen">

		<p title="">选择地区</p>

		<div class="m_zlxg2 m_zlxg1">

			<ul>
				
				<li class="aa a1">北京</li>
				<li class="ss s1">上海</li>
				<li class="tt t1">天津</li>
				<li class="bb a8">重庆</li>
				<li class="tt t2">四川</li>
				<li class="aa a4">贵州</li>
				<li class="tt t3">云南</li>
				<li class="tt t4">西藏</li>
				<li class="hh hh1">河南</li>
				<li class="hh h4">湖北</li>
				<li class="hh h3">湖南</li>
				<li class="bb a5">广东</li>
				<li class="bb a6">广西</li>
				<li class="ll s8">陕西</li>
				<li class="bb a7">甘肃</li>
				<li class="ll s5">青海</li>
				<li class="ll s6">宁夏</li>
				<li class="zz t5">新疆</li>
				<li class="hh h2">河北</li>
				<li class="ss s3">山西</li>
				<li class="ss s4">内蒙古</li>
				<li class="ii h5">江苏</li>
				<li class="zz t6">浙江</li>
				<li class="aa a2">安徽</li>
				<li class="aa a3">福建</li>
				<li class="ii h8">江西</li>
				<li class="ss s2">山东</li>
				<li class="ll s7">辽宁</li>
				<li class="ii h7">吉林</li>
				<li class="ii h6">黑龙江</li>
				<li class="jj h9">海南</li>
				<li class="zz t7">台湾</li>
				<li class="zz t8">香港</li>
				<li class="yy t9">澳门</li>
				</ul>

		</div>

	</div>

	<div class="m_zlxg" id="chengshi">

		<p title="">选择城市</p>

		<div class="m_zlxg2">

			<ul></ul>

		</div>

	</div>

	<div class="m_zlxg" id="quyu">

		<p title="">选择区域</p>

		<div class="m_zlxg2">

			<ul></ul>

		</div>

	</div>

	<input id="sfdq_num" type="hidden" value="" />

	<input id="csdq_num" type="hidden" value="" />

	<input id="sfdq_tj" type="hidden" value="" name="address" />

	<input id="csdq_tj" type="hidden" value="" name="address1"/>

	<input id="qydq_tj" type="hidden" value="" name="address2"/>

</div>


</td></tr>




<tr>
           

<td width='175' height=25 bgcolor='ffffff'>
	<?
    	if($groupid==1){
			echo "会员头像";
		}elseif($groupid==2){
			echo "名人头像";
		}elseif($groupid==3){
			echo "老师头像";
		}elseif($groupid==4){
			echo "机构照片";
		}
	?>
</td>
<td bgcolor='ffffff'class="touxiangObj"><div class="touxiangcaijian"  style="width:500px;margin: 0 auto;">
			
          <div style="width:530px;margin: 0 auto;">
			
			<div>
				<p id="swfContainer">
                    本组件需要安装Flash Player后才可使用，请从<a href="http://www.adobe.com/go/getflashplayer">这里</a>下载安装。
				</p>
			</div>
			
        </div>
		<script type="text/javascript">
            swfobject.addDomLoadEvent(function () {
                var swf = new fullAvatarEditor("swfContainer", {
					    id: 'swf',
						upload_url: '/shang/upload.php',
						src_upload:0,
						src_size:'5MB',
						browse_tip:'仅支持JPG、JPEG、GIF、PNG格式的图片文件\n文件不能大于5MB',
						avatar_box_border_width : 0,
						avatar_sizes : '200*200',
						avatar_scale : 2,//图片缩放系数，裁剪为200，保存为其2倍大小
						tab_visible:false,
						avatar_sizes_desc : '400*400像素',
						height:400,
					}, function (msg) {
						switch(msg.code)
						{
							
							// case 2 : alert("已成功加载默认指定的图片到编辑面板。");break;
							// case 3 :
							// 	if(msg.type == 0)
							// 	{
							// 		alert("摄像头已准备就绪且用户已允许使用。");
							// 	}
							// 	else if(msg.type == 1)
							// 	{
							// 		alert("摄像头已准备就绪但用户未允许使用！");
							// 	}
							// 	else
							// 	{
							// 		alert("摄像头被占用！");
							// 	}
							// break;
							case 5 : 
								if(msg.type == 0)
								{
									if(msg.content.sourceUrl)
									{
										// alert("原图已成功保存至服务器，url为：\n" +　msg.content.sourceUrl);
									}
									// alert("头像已成功保存至服务器，url为：\n" + msg.content.avatarUrls.join("\n"));
									$('#headImg').val("http://www.greattone.net/shang"+msg.content.avatarUrls.join("\n"));
									console.log($('#headImg').val());
								}
							break;
						}
					}
				);
				document.getElementById("upload").onclick=function(){
					swf.call("upload");
				};
            });
        </script>
        <input type="hidden" id="headImg" name="userpic" required>
          </td></tr>
</table>
<input name='aihao' type='hidden' id='aihao' maxlength='20' value="无">
<?
	if($groupid==4){
		?>
<input name='classroom_type' type='hidden' id='classroom_type' maxlength='20' value="音乐教室">
		<?
	}elseif($groupid==3){
		?>
<input name='teacher_type' type='hidden' id='teacher_type' maxlength='20' value="音乐老师">
		<?
	}elseif($groupid==2){
		?>
<input name='music_star' type='hidden' id='music_star' maxlength='20' value="音乐之星">
		<?
	}else{
		?>
<input name='putong_shenfen' type='hidden' id='putong_shenfen' maxlength='20' value="爱乐人">
		<?
	}
?>
	<?php /*?><?php
	@include($formfile);
	?><?php */?>
	<br>
    <tr>
    	<td></td>
    	<td>
    		<label class="user_agree_wrap" for="user_agreement">
    			<input class="user_agree" id="user_agreement" type="checkbox" checked>我已经认真阅读<a href="">《网站会员注册协议》</a>， 并完全同意所有条款。
    		</label>
    	</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input class="tijiao" type='submit' name='Submit' value='马上注册'> 
        &nbsp;&nbsp;</td>
    </tr>
  </form>
</table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>