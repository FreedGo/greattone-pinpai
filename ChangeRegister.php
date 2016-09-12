<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='注册会员';
$url="<a href=../../../>首页</a>&nbsp;>&nbsp;<a href=../cp/>会员中心</a>&nbsp;>&nbsp;选择注册会员类型";
require(ECMS_PATH.'e/template/incfile/header_1.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/luntanIndex.css">
	<link rel="stylesheet" type="text/css" href="/css/xin_base.css">
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
<script language="javascript" src="/js/language.js"></script>
</head>
<body>
<!-- ····························中间结构·································· -->
<div class="bodyWrap">
        <!--register-->
        <div style="height:15px;"></div>
        <div class="hl_reg w1200">
            <ul class="clearfix">
                <li><b></b>
                    <div class="pic"><i class="i_01"></i></div>
                    <h2>普通会员</h2>
                    <div class="wz">适合学生，家长， 喜欢音乐的朋友申请。</div>
                    <a href="/e/member/register/index.php?tobind=0&groupid=1&button=%E4%B8%8B%E4%B8%80%E6%AD%A5">立即注册</a>
                </li>
<!--                <li><b></b>-->
<!--                    <div class="pic"><i class="i_02"></i></div>-->
<!--                    <h2>音乐名人</h2>-->
<!--                    <div class="wz">适合各乐器项目表现优异或获奖选手。</div>-->
<!--                    <a href="/e/member/register/index.php?tobind=0&groupid=2&button=%E4%B8%8B%E4%B8%80%E6%AD%A5">立即注册</a>-->
<!--                </li>-->
                <li><b></b>
                    <div class="pic"><i class="i_03"></i></div>
                    <h2>音乐老师</h2>
                    <div class="wz">适合全职或兼职的从事音乐教育的人士申请。</div>
                    <a href="/e/member/register/index.php?tobind=0&groupid=3&button=%E4%B8%8B%E4%B8%80%E6%AD%A5">立即注册</a>
                </li>
                <li><b></b>
                    <div class="pic"><i class="i_04"></i></div>
                    <h2>音乐教室</h2>
                    <div class="wz">适合培训中心， 琴行申请。</div>
                    <a href="/e/member/register/index.php?tobind=0&groupid=4&button=%E4%B8%8B%E4%B8%80%E6%AD%A5">立即注册</a>
                </li>
<!--                乐器品牌-->
                <li><b></b>
                    <div class="pic"><i class="i_05"></i></div>
                    <h2>乐器品牌</h2>
                    <div class="wz">提供乐器制造商展示平台。</div>
                    <a href="/e/member/register/index.php?tobind=0&groupid=5&button=%E4%B8%8B%E4%B8%80%E6%AD%A5">立即注册</a>
                </li>
            </ul>
        </div>
</div>

</body>
</html>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>