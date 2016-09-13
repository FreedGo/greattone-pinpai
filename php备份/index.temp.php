<?php
if (!defined('InEmpireCMS')) {
    exit();
}
//会员信息
$tmgetuserid = $userid;    //用户ID
$tmgetusername = RepPostVar($username);    //用户名
$tmgetgroupid = $groupid;    //用户组ID
$getuserid = (int)getcvar('mluserid');//当前登陆会员ID
$getusername = getcvar('mlusername');//当前登陆会员名
//位置
$url = "$spacename &gt; 首页";
include("header.temp.php");
$registertime = eReturnMemberRegtime($ur['registertime'], "Y-m-d H:i:s");
//oicq
if ($addur['oicq']) {
    $addur['oicq'] = "<a href='http://wpa.qq.com/msgrd?V=1&amp;Uin=" . $addur['oicq'] . "&amp;Site=" . $public_r['sitename'] . "&amp;Menu=yes' target='_blank'><img src='http://wpa.qq.com/pa?p=1:" . $addur['oicq'] . ":4'  border='0' alt='QQ' />" . $addur['oicq'] . "</a>";
}
//简介
$usersay = $addur['saytext'] ? $addur['saytext'] : '暂无简介';
$usersay = RepFieldtextNbsp(stripSlashes($usersay));
?>

<?

//获取我的关注	
$feeduserid = $empire->fetch1("select feeduserid from {$dbtbpre}enewsmemberadd where userid='$tmgetuserid'");
$feeduser_result = explode("::::::", $feeduserid['feeduserid']);
$guanzhu = array();
if ($feeduser_result && !empty($feeduser_result)) {
    unset($feeduser_result[count($feeduser_result) - 1]);
    foreach ($feeduser_result as $key => $val) {
        $sql = "SELECT feeduserid FROM {$dbtbpre}enewsmemberadd WHERE userid=" . $val;
        $result = $empire->fetch1($sql);
        if (!empty($result)) {
            $friend_userid = explode("::::::", $result['feeduserid']);
            if (!empty($friend_userid)) {
                unset($friend_userid[count($friend_userid) - 1]);
                if (!empty($friend_userid)) {
                    foreach ($friend_userid as $k => $v) {
                        if ($v == $tmgetuserid) {
                            array_push($guanzhu, $val);

                        }
                    }
                }
            }
        }
    }
}

//获取老师和学生id
//$userid;//被访问的id
$dangid = getcvar('mluserid');     //当前id
$dangidfu = $dangid;
if (empty($dangid)) {
    $dangid = 0;
}
if ($dangid != 0) {

    $kb = $empire->fetch1("select yaoqing from phome_enewsmemberadd where userid=$userid limit 1");
    $frid = explode("::::::", $kb[yaoqing]);
    foreach ($frid as $key => $val) {
        //echo $frid[$key]."<br>";

        if ($frid[$key] == $dangidfu) { //该老师或教室邀请过我
            //查询我是否加入该老师或教室
            $feeb = $empire->fetch1("select yaoqing from phome_enewsmemberadd where userid=$dangidfu limit 1");
            $frid_w = explode("::::::", $feeb[yaoqing]);
            foreach ($frid_w as $key => $val) {
                if ($frid_w[$key] == $userid) {
                    $zjj = 11;
                }
            }

        }
    }
}
?>
    <script>
//        控制点击头像弹出四张图片的一系列事件
        $(function () {
            $('.jiaoshi_shows_down').hide();
            $('.focusBox').hide();

            $('.jiaoshiImg').on('click', function (event) {
                // event.preventDefault();
                $('.jiaoshi_shows_down').fadeIn(100);
                $('.focusBox').fadeIn(100);
            });
            $('.shutUp').click(function (event) {
                $('.jiaoshi_shows_down').fadeOut(100);
                $('.focusBox').fadeOut(100);
            });
            $('.jiaoshi_shows_down').click(function (event) {
                $('.focusBox').click(function (event) {
                    return false;
                });
                $(this).fadeOut();
                $('.focusBox').fadeOut(100);
            });

        });
    </script>
    <div class="bodyWrap clearfix">
        <link rel="stylesheet" type="text/css" href="/css/xin_yinyueguangchang.css">
        <!-- 左边二级导航列···················································· -->
        <div class="leftWrap jiaoshiRight">
            <div class="login_Hou">
                <a href="<?= $public_r['newsurl'] ?>e/space/?userid=<?= $userid ?>">
                    <div class="touxiang"><img src="<?= $userpic ?>"></div>
                </a>
                <div class="uesrID"><?= $username ?>
                    <?
                    if ($cked == 1) {
                        echo "<i class='iconfont hongse'>&#xe657;</i>";
                    }
                    ?>
                </div>
                <div class="qianyue"><?= $jiaoshi ?></div>
                <div class="shenfen1"><em>类型：</em><span><?
                        if ($groupid == 1) {
                            echo $putong_shenfen;//普通会员默认爱乐人
                        } elseif ($groupid == 2) {
                            echo $music_star;//音乐之星
                        } elseif ($groupid == 3) {
                            echo $teacher_type;//音乐老师
                        } elseif ($groupid == 4) {
                            echo "音乐教室";
                        }
                        ?></span></div>
                <div class="dengji"><em>等级：</em><span>
                					<?
                                    if ($userfen <= 100) {
                                        echo "一级";
                                    } elseif ($userfen <= 300) {
                                        echo "二级";
                                    } elseif ($userfen <= 800) {
                                        echo "三级";
                                    } elseif ($userfen <= 2000) {
                                        echo "四级";
                                    } elseif ($userfen <= 5000) {
                                        echo "五级";
                                    } elseif ($userfen <= 15000) {
                                        echo "六级";
                                    } elseif ($userfen <= 50000) {
                                        echo "七级";
                                    } elseif ($userfen >= 100000) {
                                        echo "八级";
                                    }
                                    ?>
                </span></div>

                <div class="guanzhu clearfix">
                    <?
                    $s = $empire->fetch1("select follownum,feednum from {$dbtbpre}enewsmemberadd where userid='$userid'");
                    ?>
                    <div class="inguanzhu"><em>关注</em><span><?= $s[feednum] ?></span></div>
                    <div class="fensi"><em>粉丝</em><span><?= $s[follownum] ?></span></div>
                </div>
            </div>
        </div>
        <!-- 左边二级导航列结束················································ -->

        <!-- 中间内容部分······················································ -->
        <div class="rightWrap jiaoshiLeft clearfix">
            <div class="rightBan">
                <div class="mianbaoNav">
                </div>
                <div class="saishiMsg">
                    <img class="jiaoshiImg" src="<?= $userpic ?>">
                    <div class="inMsg">
                        <ul>
                            <li class="jiaoshiming clearfix"><a class="jiacu"
                                                                href="<?= $public_r['newsurl'] ?>e/space/?userid=<?= $userid ?>"><?= $username ?></a>
                                <?
                                if ($cked == 1) {
                                    echo "<img src='/images/yirenzheng.png'>";
                                } else {
                                    echo "<img src='/images/weirenzheng.png'>";
                                }
                                ?>

                            </li>
                            <li><i class="star"></i><i class="star"></i><i class="star"></i><i class="star"></i><i
                                    class="star"></i></li>
                            <li><span>粉丝数(<?= $s[follownum] ?>)</span>
                                <!-- <span>学生数(80)</span>-->
                                <span>发帖数(
                                    <?php
                                    $count = mysql_query("select count(*) from  phome_ecms_photo where userid='$userid'");
                                    while ($tmp = mysql_fetch_row($count)) {
                                        print $tmp[0];
                                    }
                                    ?>
                                    )</span>
                                <span>评论数(
                                    <?php
                                    $count = mysql_query("select count(*) from phome_enewspl_1 where userid='$userid'");
                                    while ($tmp = mysql_fetch_row($count)) {
                                        print $tmp[0];
                                    }
                                    ?>
                                    )</span></li>
                            <li><span><?
                                    if ($groupid == 3) {
                                        echo "老师类型：";
                                    } elseif ($groupid == 4) {
                                        echo "机构电话：";
                                    }
                                    ?>
                    </span><span>
						<?
                        if ($groupid == 1) {
                            echo $putong_shenfen;//普通会员默认爱乐人
                        } elseif ($groupid == 2) {
                            echo $music_star;//音乐之星
                        } elseif ($groupid == 3) {
                            echo $teacher_type;//音乐老师
                        } elseif ($groupid == 4) {
                            echo $telephone;
                        }
                        ?>
                        </span></li>
                            <li><span>地址：</span><i><?= $address ?><?= $address1 ?><?= $address2 ?><?= $addres ?></i>
                            </li>
                            <li><span>空间：</span><!-- <span><?= $userid ?></span> -->

                                <span><a class="tadekongjian" href="/e/space/template/kongjian/?userid=<?= $userid ?>"
                                         class="jiacu"><?= $username ?>的空间</a></span></li>
                        </ul>
                    </div>
                    <div class="canyu">
                        <ul><?= $r[feeduserid] ?>
                            <li class="baomingrenshu">

                                <?php
                                if ($getuserid != $userid) {
                                    $f = $empire->fetch1("select feeduserid from {$dbtbpre}enewsmemberadd where userid='$getuserid'");
                                    $fduserid = explode("::::::", $f['feeduserid']);
                                    if (in_array($userid, $fduserid)) {
                                        $follow = '<a href="javascript:void()" onclick="follow(' . $userid . ')" class="button blue small orange" id="follow' . $userid . '" title="取消关注">取消关注</a>';
                                    } else {
                                        $follow = '<a href="javascript:void()" onclick="follow(' . $userid . ')" class="button blue small" id="follow' . $userid . '">关注</a>';
                                    }

                                } else {
                                    $follow = '<a href="/e/member/EditInfo/" class="button blue small">修改资料</a>';
                                }
                                ?>
                                <?= $follow ?>

                                <a href="/e/QA/ListInfo.php?mid=10&username=<?= $username ?>&userid=<?= $userid ?>"
                                   class="button blue small ">提问</a>
                            <li class="clearfix">
                                <!-- <a href="javascript:;"><i class="iconfont">&#xe647;</i><span>收藏</span></a>-->
                                <span>分享：</span>
                                <div class="bdsharebuttonbox"><a href="#" class="bds_weixin" data-cmd="weixin"
                                                                 title="分享到微信"></a><a href="#" class="bds_tsina"
                                                                                      data-cmd="tsina"
                                                                                      title="分享到新浪微博"></a><a href="#"
                                                                                                             class="bds_qzone"
                                                                                                             data-cmd="qzone"
                                                                                                             title="分享到QQ空间"></a><a
                                        href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#"
                                                                                                       class="bds_fbook"
                                                                                                       data-cmd="fbook"
                                                                                                       title="分享到Facebook"></a><a
                                        href="#" class="bds_more" data-cmd="more"></a></div>
                                <script>
                                    // 百度分享代码	·········································
                                    window._bd_share_config = {
                                        "common": {
                                            "bdSnsKey": {},
                                            "bdText": "",
                                            "bdMini": "2",
                                            "bdMiniList": false,
                                            "bdPic": "",
                                            "bdStyle": "1",
                                            "bdSize": "24"
                                        }, "share": {}
                                    };
                                    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
                                    // 百度分享代码	·········································

                                </script>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 第一.全站动态部分············································· -->
            <div class="rightMiddle ">


                <!-- 内容··························· -->
                <div class="qzdtContent">

                    <!-- 第一，当前海选部分····························· -->

                    <div class="yinyuemingren">
                        <!-- 分类行····································· -->
                        <div class="fenlei teacher-space borTop">
                            <ul class="clearfix fenleiFuck">
                                <li class="current"><a href="javascript:;">
                                        <?php
                                        if ($groupid == 4) {
                                            echo "琴行介绍";
                                        } else {
                                            echo "老师介绍";
                                        }
                                        ?>
                                    </a><span></span></li>
                                <li><a href="javascript:;">推荐视频</a><span></span></li>
                                <li><a href="javascript:;">课程中心</a><span></span></li>
                                <?php
                                if ($groupid == 4) {
                                    ?>
                                    <li><a href="javascript:;">琴房租赁</a><span></span></li>
                                    <?php
                                    if ($zjj == 11) {
                                        ?>
                                        <li><a href="javascript:;">音乐老师</a><span></span></li>
                                        <?
                                    }
                                }
                                ?>

                                <?php
                                if ($zjj == 11) {
                                    ?>
                                    <li><a href="javascript:;">全部学员</a><span></span></li>
                                    <?
                                } ?>
                                <li><a href="javascript:;">活动公告</a><span></span></li>
                                <li><a href="javascript:;">在线直播</a><span></span></li>
                                <?php
                                if ($zjj == 11) {
                                    ?>
                                    <li><a href="javascript:;">讨论区</a><span></span></li>
                                    <?
                                } ?>


                            </ul>
                        </div>
                        <!-- 分类行结束································· -->
                        <!-- 排序行····································· -->

                        <!-- 列表内容区域······························· -->
                        <div class="liebiao">
                            <!-- 介绍评论············································································· -->
                            <?= $id ?>
                            <ul class="liebiaoFuck liebiaoShow clearfix">
                                <div class="jiaoshijieshao">
                                    <?php
                                    $r = $empire->fetch1("select saytext from phome_enewsmemberadd where userid='$userid'");
                                    echo $r[saytext];
                                    ?>
                                </div>
                                <!--评论-->
                                <style type="text/css">
                                    .readyStar {
                                        background-color: #eee;
                                        overflow: hidden;
                                        zoom: 1;
                                        height: 40px;
                                        padding: 25px 0 0 25px;
                                    }

                                    .totalStar {
                                        float: left;
                                    }

                                    .totalStar > div {
                                        float: left;
                                    }

                                    .ratystar {
                                        overflow: hidden;
                                        zoom: 1;
                                        width: 144px !important;
                                    }

                                    .ratystar > img, .ratystar > input {
                                        float: left;
                                    }

                                    .stuDiscuss {
                                        border-top: 1px solid #ddd;
                                        margin-top: 15px;
                                    }

                                    .stuDiscuss > h2 {
                                        font-size: 18px;
                                        line-height: 40px;
                                    }

                                    .getStar {
                                        background-color: #fff;
                                        padding-left: 0;

                                    }

                                    .stuDisCon {
                                        width: 936px;
                                        max-width: 936px;
                                        padding: 5px;
                                        border: 1px solid #ddd;
                                        outline: none;
                                        min-height: 50px;
                                    }

                                    .subDis {
                                        height: 40px;
                                        padding-top: 15px;

                                    }

                                    .subDis > input {
                                        float: right;
                                        padding: 10px 30px;
                                        background-color: #cb7047;
                                        border: none;
                                        color: #FFF;
                                        font-size: 14px;
                                    }

                                    .disLeft {
                                        width: 100px;
                                        float: left;
                                    }

                                    .disRight {
                                        overflow: hidden;
                                        padding-left: 10px;
                                    }

                                    .disLeft > a > img {
                                        width: 100px;
                                        height: 100px;
                                    }

                                    .disLeft > a > h2 {
                                        width: 100%;
                                        overflow: hidden;
                                        -ms-text-overflow: ellipsis;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;
                                        font-size: 14px;
                                        color: #333;
                                    }

                                    .aleadyDis > ol > li {
                                        padding: 15px 0;
                                        border-bottom: #ccc solid 1px;
                                    }

                                    .disTime {
                                        padding-bottom: 5px;
                                    }
                                </style>
                                <script type="text/javascript" src="/js/jquery.raty.min.js"></script>
                                <?
                                //计算打分
                                $num = $empire->fetch1("select num_score,num_quality,num_ambient,num_service from phome_enewsmemberadd where userid='$userid'");

                                if (!empty($num[num_score])) {

                                    $num_score = explode("::::::", $num[num_score]);
                                    $result = count($num_score) - 1;
                                    for ($i = 0; $i <= $result; $i++) {
                                        $numsco = $numsco . num + $num_score[$i];
                                    }
                                    $num_1 = $numsco / $result;
                                    $num_1 = round($num_1);

                                    /**********************/
                                    $num_quality = explode("::::::", $num[num_quality]);
                                    $result1 = count($num_quality) - 1;
                                    for ($i = 0; $i <= $result1; $i++) {
                                        $numsco2 = $numsco2 . num + $num_quality[$i];
                                    }
                                    $num_2 = $numsco2 / $result1;
                                    $num_2 = round($num_2);
                                    /**********************/
                                    $num_ambient = explode("::::::", $num[num_ambient]);
                                    $result3 = count($num_ambient) - 1;
                                    for ($i = 0; $i <= $result3; $i++) {
                                        $numsco3 = $numsco3 . num + $num_ambient[$i];
                                    }
                                    $num_3 = $numsco3 / $result3;
                                    $num_3 = round($num_3);
                                    /**********************/
                                    $num_service = explode("::::::", $num[num_service]);
                                    $result4 = count($num_service) - 1;
                                    for ($i = 0; $i <= $result4; $i++) {
                                        $numsco4 = $numsco4 . num + $num_service[$i];
                                    }
                                    $num_4 = $numsco4 / $result4;
                                    $num_4 = round($num_4);
                                } else {
                                    //新号
                                    $num_1 = 5;
                                    $num_2 = 5;
                                    $num_3 = 5;
                                    $num_4 = 5;
                                }
                                ?>
                                <script type="text/javascript">
                                    // $(function() {
                                    // 	$('#number-callback-demo').raty({
                                    //         number: function() {
                                    //           return $(this).attr('data-number');
                                    //         }
                                    //       });
                                    // });
                                    $(function () {
                                        // 调用评分插件
                                        $.fn.raty.defaults.path = '/images/';
                                        // 当前用户已经获得的评级
                                        // 1.总分
                                        $.fn.raty.defaults.scoreName = 'allStar1';//打分的input的name值，可修改
                                        $('#star1').raty({score: <?=$num_1?>, readOnly: true});//score是回掉的分数
                                        //2.教学质量
                                        $.fn.raty.defaults.scoreName = 'techStar1';
                                        $('#star2').raty({score: <?=$num_2?>, readOnly: true});
                                        //3.环境
                                        $.fn.raty.defaults.scoreName = 'soundStar1';
                                        $('#star3').raty({score: <?=$num_3?> , readOnly: true});
                                        //4.服务
                                        $.fn.raty.defaults.scoreName = 'serverStar1';
                                        $('#star4').raty({score: <?=$num_4?>, readOnly: true});

                                        // 打分的调用
                                        // 1.总分
                                        $.fn.raty.defaults.scoreName = 'allStar2';//打分的input的name值，可修改
                                        $('#star5').raty({score: 5});//score是回掉的分数
                                        //2.教学质量
                                        $.fn.raty.defaults.scoreName = 'techStar2';
                                        $('#star6').raty({score: 5});
                                        //3.环境
                                        $.fn.raty.defaults.scoreName = 'soundStar2';
                                        $('#star7').raty({score: 5});
                                        //4.服务
                                        $.fn.raty.defaults.scoreName = 'serverStar2';
                                        $('#star8').raty({score: 5});
                                    });
                                </script>
                                <div class="jiaoshipinglun">
                                    <!-- 当前用户已有评分调用 -->
                                    <div class="readyStar">
                                        <div class="totalStar">
                                            <div>总评分：</div>
                                            <div class="ratystar" id="star1"></div>
                                        </div>
                                        <div class="totalStar">
                                            <div>教学质量：</div>
                                            <div class="ratystar" id="star2"></div>
                                        </div>
                                        <?php
                                        if ($groupid == 4) {
                                            ?>
                                            <div class="totalStar">
                                                <div>教学环境：</div>
                                                <div class="ratystar" id="star3"></div>
                                            </div>
                                            <?
                                        }
                                        ?>

                                        <div class="totalStar">
                                            <div>服务：</div>
                                            <div class="ratystar" id="star4"></div>
                                        </div>

                                    </div>
                                    <!--结束 当前用户已有评分调用 -->
                                    <!-- 学生评论开始 --><? $mid = getcvar('mluserid'); ?>


                                    <?
                                    //判断是否为内部学生和老师
                                    if (!empty($whe)) {
                                        $whe = explode(",", $whe);
                                        $num_whe = count($whe) - 1;
                                        for ($i = 0; $i <= $num_whe; $i++) {
                                            if ($whe[$i] == $mid) {
                                                ?>
                                                <div class="stuDiscuss">
                                                    <h2>我要评价</h2>
                                                    <form action="/e/space/template/jiaoshi/pi.php" method=post
                                                          id="sdtDisStar">
                                                        <input type="hidden" name="uid" value="<?= $userid ?>"/>
                                                        <input type="hidden" name="mid" value="<?= $mid ?>"/>
                                                        <input type="hidden" name="uname" value="<?= $username ?>"/>
                                                        <input type="hidden" name="mname"
                                                               value="<?= $mname = getcvar('mlusername'); ?>"/>
                                                        <!-- 评分 -->
                                                        <div class="readyStar getStar">
                                                            <!--<div class="totalStar">
                                                                <div>总评分：</div>
                                                                <div class="ratystar" id="star5"></div>
                                                            </div>-->
                                                            <div class="totalStar">
                                                                <div>教学质量：</div>
                                                                <div class="ratystar" id="star6"></div>
                                                            </div>
                                                            <?php
                                                            if ($groupid == 4) {
                                                                ?>
                                                                <div class="totalStar">
                                                                    <div>教学环境：</div>
                                                                    <div class="ratystar" id="star7"></div>
                                                                </div>
                                                                <?
                                                            }
                                                            ?>

                                                            <div class="totalStar">
                                                                <div>服务：</div>
                                                                <div class="ratystar" id="star8"></div>
                                                            </div>

                                                        </div>
                                                        <!-- 评论 -->
                                                        <textarea name="stuDisContent" required class="stuDisCon"
                                                                  placeholder="请认真评论"></textarea>
                                                        <div class="subDis">
                                                            <input type="submit" value="提交">
                                                        </div>
                                                    </form>
                                                </div>
                                                <?
                                            }
                                        }
                                    }
                                    if (!empty($xue)) {
                                        $xue = explode(",", $xue);
                                        $num_xue = count($xue) - 1;
                                        for ($i = 0; $i <= $num_xue; $i++) {
                                            if ($xue[$i] == $mid) {
                                                ?>
                                                <div class="stuDiscuss">
                                                    <h2>我要评价</h2>
                                                    <form action="/e/space/template/jiaoshi/pi.php" method=post
                                                          id="sdtDisStar">
                                                        <input type="hidden" name="uid" value="<?= $userid ?>"/>
                                                        <input type="hidden" name="mid" value="<?= $mid ?>"/>
                                                        <input type="hidden" name="uname" value="<?= $username ?>"/>
                                                        <input type="hidden" name="mname"
                                                               value="<?= $mname = getcvar('mlusername'); ?>"/>
                                                        <!-- 评分 -->
                                                        <div class="readyStar getStar">
                                                            <!--<div class="totalStar">
                                                                <div>总评分：</div>
                                                                <div class="ratystar" id="star5"></div>
                                                            </div>-->
                                                            <div class="totalStar">
                                                                <div>教学质量：</div>
                                                                <div class="ratystar" id="star6"></div>
                                                            </div>
                                                            <?php
                                                            if ($groupid == 4) {
                                                                ?>
                                                                <div class="totalStar">
                                                                    <div>教学环境：</div>
                                                                    <div class="ratystar" id="star7"></div>
                                                                </div>
                                                                <?
                                                            }
                                                            ?>
                                                            <div class="totalStar">
                                                                <div>服务：</div>
                                                                <div class="ratystar" id="star8"></div>
                                                            </div>

                                                        </div>
                                                        <!-- 评论 -->
                                                        <textarea name="stuDisContent" required class="stuDisCon"
                                                                  placeholder="请认真评论"></textarea>
                                                        <div class="subDis">
                                                            <input type="submit" value="提交">
                                                        </div>
                                                    </form>
                                                </div>
                                                <?
                                            }
                                        }

                                    }
                                    ?>
                                    <!-- 结束。。学生评论开始 -->
                                    <div class="aleadyDis">
                                        <ol>
                                            <?
                                            $sql = $empire->query("select * from phome_enews_feed where uid='$userid' order by time desc limit 15");
                                            while ($no = $empire->fetch($sql)) {
                                                $pi = $empire->fetch1("select userpic from phome_enewsmemberadd where userid='$no[mid]'");
                                                ?>
                                                <li class="clearfix">
                                                    <div class="disLeft">
                                                        <a href="/e/space/?userid=<?= $no[mid] ?>">
                                                            <img src="<?= $pi[userpic] ?>" alt="<?= $no[mname] ?>">
                                                            <h2 class="disName"><?= $no[mname] ?></h2>
                                                        </a>
                                                    </div>
                                                    <div class="disRight">
                                                        <p class="disTime"><?= $no[time] ?></p>
                                                        <p class="disCon"><?= $no[content] ?></p>
                                                    </div>
                                                </li>
                                                <?
                                            }
                                            ?>
                                        </ol>
                                    </div>
                                </div>
                            </ul>

                            <!-- 推荐视频··············································································· -->
                            <ul class="liebiaoFuck liebiaoShow current jiaoshiVideo clearfix">

                                <?
                                //相互邀请
                                $yaoqing = $empire->fetch1("select yaoqing,tuijian_shi from {$dbtbpre}enewsmemberadd where userid='$tmgetuserid'");
                                $feeduser_result = explode("::::::", $yaoqing['yaoqing']);
                                $guanzhu = array();
                                if ($feeduser_result && !empty($feeduser_result)) {
                                    unset($feeduser_result[count($feeduser_result) - 1]);
                                    foreach ($feeduser_result as $key => $val) {
                                        $sql = "SELECT yaoqing FROM {$dbtbpre}enewsmemberadd WHERE userid=" . $val;
                                        $result = $empire->fetch1($sql);
                                        if (!empty($result)) {
                                            $friend_userid = explode("::::::", $result['yaoqing']);
                                            if (!empty($friend_userid)) {
                                                unset($friend_userid[count($friend_userid) - 1]);
                                                if (!empty($friend_userid)) {
                                                    foreach ($friend_userid as $k => $v) {
                                                        if ($v == $tmgetuserid) {
                                                            array_push($guanzhu, $val);
                                                            /*print_r($guanzhu);*/
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $whe = join(",", $guanzhu); //内部的老师
                                if (empty($whe)) {
                                    $whe = 0;
                                }

                                $newstrone = substr($yaoqing['tuijian_shi'], 0, strlen($yaoqing['tuijian_shi']) - 1);
                                $newstrone = explode("::::::", $yaoqing['tuijian_shi']); //打散为数组
                                $wheyao = join(",", $newstrone);
                                $tui = substr($wheyao, 0, strlen($wheyao) - 1);
                                if (empty($tui)) {
                                    $tui = 0;
                                }
                                $friend_sql = "select * from {$dbtbpre}ecms_photo a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid left join {$dbtbpre}enewsmember c on a.userid=c.userid  WHERE a.id IN ($tui) and a.classid=11  order by a.id desc";
                                $list = $empire->query($friend_sql);
                                while ($r = $empire->fetch($list)) {
                                    ?>
                                    <li>
                                        <a href="<?= $r['titleurl'] ?>">
                                            <i class="iconfont">&#xe63b;</i>
                                            <img src="<?= $r['titlepic'] ?>">
                                            <div class="xingming biaoti">
                                                <span><?= $r['title'] ?></span>
                                            </div>
                                        </a>

                                        <div class="guanzhu xingming clearfix">
                                            <span>点击:</span><em><?= $r[onclick] ?></em>

                                            <!-- <a href="/e/member/fava/add/?classid=<?= $r['classid'] ?>&amp;id=<?= $r['id'] ?>"><i class="iconfont po1">&#xe647;</i><span class="po4">收藏</span></a>
										<div class="bdsharebuttonbox po2"><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a><a href="#" class="bds_more" data-cmd="more"></a></div>
										<span class="po3">分享</span> -->
                                        </div>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <!-- 课程中心·············································································· -->
                            <ul class="liebiaoFuck liebiaoShow  jiaoshiVideo clearfix">
                                <?
                                $friend_sql = "select * from {$dbtbpre}ecms_shop a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid where a.classid=58 and a.userid='$userid' order by a.userid desc limit 50";
                                $list = $empire->query($friend_sql);
                                while ($r = $empire->fetch($list)) {
                                    ?>
                                    <li>
                                        <a href="<?= $r[titleurl] ?>">
                                            <img src="<?= $r[titlepic] ?>">
                                            <div class="xingming biaoti">
                                                <span><?= $r[title] ?></span>
                                            </div>
                                        </a>
                                        <div class="guanzhu xingming clearfix">
                                            <span class="hongse">¥:<?= $r[price] ?></span>
                                            <del>¥:<?= $r[tprice] ?></del>
                                        </div>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <?php
                            if ($groupid == 4) {
                                ?>
                                <!-- 琴房租赁```````````````````````````````````````````````````````````````````````````` -->
                                <ul class="liebiaoFuck liebiaoShow jiaoshiVideo clearfix">
                                    <?
                                    $friend_sql = "select * from {$dbtbpre}ecms_shop a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid where a.classid=59 and a.userid='$userid' order by a.userid desc limit 50";
                                    $list = $empire->query($friend_sql);
                                    while ($r = $empire->fetch($list)) {
                                        ?>
                                        <li>
                                            <a href="<?= $r[titleurl] ?>">
                                                <img src="<?= $r[titlepic] ?>">
                                                <div class="xingming">

                                                    <strong class="noname1"><?= $r[title] ?></strong>
                                                </div>
                                            </a>
                                            <div class="shenfen xingming">
                                                <span>价格：</span><span class="hongse">¥<?= $r[price] ?>元</span>
                                            </div>

                                            <div class="guanzhu xingming clearfix">
                                                <!-- <a href="/e/member/fava/add/?classid=<?= $classid ?>&amp;id=<?= $id ?>"><i class="iconfont ">&#xe647;</i><span >收藏</span></a> -->
                                            </div>
                                            <span class="dianjichakan irent"><a
                                                    href="<?= $r[titleurl] ?>">我要租</a></span>
                                        </li>
                                        <?
                                    }
                                    ?>
                                </ul>
                                <!-- 音乐老师············································································· -->
                                <?
//相互邀请
                                $yaoqing = $empire->fetch1("select yaoqing from {$dbtbpre}enewsmemberadd where userid='$tmgetuserid'");
                                $feeduser_result = explode("::::::", $yaoqing['yaoqing']);
                                $guanzhu = array();
                                if ($feeduser_result && !empty($feeduser_result)) {
                                    unset($feeduser_result[count($feeduser_result) - 1]);
                                    foreach ($feeduser_result as $key => $val) {
                                        $sql = "SELECT yaoqing FROM {$dbtbpre}enewsmemberadd WHERE userid=" . $val;
                                        $result = $empire->fetch1($sql);
                                        if (!empty($result)) {
                                            $friend_userid = explode("::::::", $result['yaoqing']);
                                            if (!empty($friend_userid)) {
                                                unset($friend_userid[count($friend_userid) - 1]);
                                                if (!empty($friend_userid)) {
                                                    foreach ($friend_userid as $k => $v) {
                                                        if ($v == $tmgetuserid) {
                                                            array_push($guanzhu, $val);
                                                            /*print_r($guanzhu);*/
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                $whe = join(",", $guanzhu); //内部的老师
                                if (empty($whe)) {
                                    $whe = 0;
                                }
                                ?>
                                <?php
                                if ($zjj == 11) {
                                    ?>
                                    <ul class="liebiaoFuck liebiaoShow jiaoshiVideo clearfix">
                                        <?
                                        if (empty($whe)) {
                                            echo "您还没有内部老师";
                                        } else {
                                            $friend_sql = "select * from {$dbtbpre}enewsmember a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid WHERE a.userid IN ($whe) and a.groupid=3 order by a.userid desc";
                                            $list = $empire->query($friend_sql);
                                            while ($r = $empire->fetch($list)) {
                                                ?>
                                                <li>
                                                    <a href="/e/space/?userid=<?= $r[userid] ?>">
                                                        <img src="<?= $r[userpic] ?>">
                                                        <div class="xingming">
                                                            <strong class="noname1"><?= $r[username] ?></strong>
                                                        </div>
                                                    </a>
                                                    <div class="shenfen xingming">
                                                        <span>身份：</span><span><?= $r[teacher_type] ?></span>
                                                    </div>
                                                </li>
                                                <?
                                            }
                                        }
                                        ?>

                                    </ul>
                                    <?
                                }
                            }
                            ?>
                            <!-- 全部学员··············································································-->
                            <?php
                            if ($zjj == 11) {
                                ?>
                                <ul class="liebiaoFuck liebiaoShow jiaoshiVideo all-student clearfix">

                                    <?
                                    if (empty($whe)) {
                                        echo "您还没有内部学生";
                                    } else {
                                        $friend_sql = "select * from {$dbtbpre}enewsmember a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid WHERE a.userid IN ($whe) and a.groupid in(1,2) order by a.userid desc";
                                        $list = $empire->query($friend_sql);
                                        while ($r = $empire->fetch($list)) {
                                            ?>
                                            <li>
                                                <a href="/e/space/?userid=<?= $r[userid] ?>">
                                                    <img src="<?= $r[userpic] ?>">
                                                    <div class="xingming">
                                                        <strong class="noname1"><?= $r[username] ?></strong>
                                                    </div>
                                                </a>
                                                <div class="shenfen xingming">
                                                    <span>身份：</span><span>
											 <?
                                             if ($r[groupid] == 1) {
                                                 echo $r[putong_shenfen];//普通会员默认爱乐人
                                             } elseif ($r[groupid] == 2) {
                                                 echo $r[music_star];//音乐之星
                                             }
                                             ?>
                                        </span>
                                                </div>
                                            </li>
                                            <?
                                        }
                                    }
                                    ?>

                                </ul>
                                <?
                            }
                            ?>
                            <!-- 活动公告·············································································· -->
                            <ul class="liebiaoFuck liebiaoShow notice clearfix">
                                <?
                                $friend_sql = "select * from {$dbtbpre}ecms_shop a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid where a.classid=62 and a.userid='$userid' order by a.truetime desc limit 10";
                                $list = $empire->query($friend_sql);
                                while ($r = $empire->fetch($list)) {
                                    ?>
                                    <li class="clearfix">
                                        <a href="<?= $r[titleurl] ?>">
                                            <span class="iconfont hongse">&#xe65e;</span>
                                            <?= $r[title] ?>

                                        </a>
                                        <span><?= date('Y-m-d', $r[newstime]) ?></span>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <!-- 在线直播·································································· -->
                            <ul class="liebiaoFuck liebiaoShow current jiaoshiVideo clearfix">
                                <li>
                                    <a href="<?= $r['titleurl'] ?>">
                                        <i class="iconfont">&#xe63b;</i>
                                        <img src="<?= $r['titlepic'] ?>">
                                        <div class="xingming biaoti">
                                            <span><?= $r['title'] ?></span>
                                        </div>
                                    </a>

                                    <div class="guanzhu xingming clearfix">
                                        <span>时间:</span><em>5-30 19:00-5-30 21:00</em>
                                    </div>
                                </li>
                            </ul>
                            <!-- 讨论区··············································································-->
                            <?php
                            if ($zjj == 11) {
                                ?>
                                <ul class="liebiaoFuck liebiaoShow discuss-area clearfix">
                                    <!-- 第一.全站动态部分············································· -->
                                    <div class="rightMiddle qzdtList">
                                        <!-- 搜索框························· -->
                                        <div class="searchWrap clearfix">
                                            <div class="search">
                                                <script type="text/javascript" src="/skin/default/js/tabs.js"></script>
                                                <form id="searchform">
                                                    <input type="hidden" name="show" value="title"/>
                                                    <input type="hidden" name="tempid" value="1"/>
                                                    <select name="tbname" id="xuanze">
                                                        <option value="0">全部</option>
                                                        <option value="1">会员名</option>
                                                        <option value="2">视频</option>
                                                        <option value="3">音乐</option>
                                                        <option value="4">图片</option>
                                                    </select>
                                                    <input type="input" id="searchValue">
                                                </form>
                                                <i class="iconfont searchInputSub">&#xe658;</i>
                                            </div>
                                            <div class="guangchangfatie">
                                                <a href="/e/fatie/ListInfo.php?mid=10">&nbsp;&nbsp;我要发帖</a>
                                            </div>
                                        </div>
                                        <!-- 搜索框结束····················· -->


                                        <!-- 内容··························· -->

                                        <div class="qzdtContent">
                                            <ul class="quanzhandongtai">


                                                <?php
                                                //相互邀请
                                                $yaoqing = $empire->fetch1("select yaoqing from {$dbtbpre}enewsmemberadd where userid='$tmgetuserid'");
                                                $feeduser_result = explode("::::::", $yaoqing['yaoqing']);
                                                $guanzhu = array();
                                                if ($feeduser_result && !empty($feeduser_result)) {
                                                    unset($feeduser_result[count($feeduser_result) - 1]);
                                                    foreach ($feeduser_result as $key => $val) {
                                                        $sql = "SELECT yaoqing FROM {$dbtbpre}enewsmemberadd WHERE userid=" . $val;
                                                        $result = $empire->fetch1($sql);
                                                        if (!empty($result)) {
                                                            $friend_userid = explode("::::::", $result['yaoqing']);
                                                            if (!empty($friend_userid)) {
                                                                unset($friend_userid[count($friend_userid) - 1]);
                                                                if (!empty($friend_userid)) {
                                                                    foreach ($friend_userid as $k => $v) {
                                                                        if ($v == $tmgetuserid) {
                                                                            array_push($guanzhu, $val);
                                                                            /*print_r($guanzhu);*/
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                $whe = join(",", $guanzhu); //内部的老师
                                                if (empty($whe)) {
                                                    $whe = 0;
                                                }
                                                $friend_sql = "select * from {$dbtbpre}ecms_photo a left join {$dbtbpre}enewsmemberadd b on a.userid=b.userid left join {$dbtbpre}enewsmember c on a.userid=c.userid  WHERE c.userid IN ($whe) and classid in(11,12,13) order by a.id desc";
                                                $list = $empire->query($friend_sql);
                                                while ($r = $empire->fetch($list)) {
                                                    ?>


                                                    <?
                                                    if ($r[classid] == 11 && $r[open] == 1) {
                                                        ?>
                                                        <!--------视频开始-------->
                                                        <li class="clearfix dongtaiLi">
                                                            <?= $userinfo ?>
                                                            <!-- list左侧，包含头像姓名······················ -->
                                                            <div class="listLeft">
                                                                <a href="/e/space/?userid=<?= $r[userid] ?>">
                                                                    <img src="<?= $r[userpic] ?>">
                                                                    <h3><?= $r[username] ?>&nbsp;
                                                                        <?
                                                                        if ($r[cked] == 1) {
                                                                            echo "<i class='iconfont'>&#xe657;</i>";
                                                                        }
                                                                        ?>
                                                                    </h3>
                                                                    <p class="fromCity"><?= $r[address] ?></p>
                                                                    <p><em>
                                                                            <?
                                                                            if ($r[groupid] == 1) {
                                                                                echo $r[putong_shenfen];//普通会员默认爱乐人
                                                                            } elseif ($r[groupid] == 2) {
                                                                                echo $r[music_star];//音乐之星
                                                                            } elseif ($r[groupid] == 3) {
                                                                                echo $r[teacher_type];//音乐老师
                                                                            } elseif ($r[groupid] == 4) {
                                                                                echo "音乐教室";
                                                                            }
                                                                            ?>
                                                                        </em>
                                                                        <span>
            <?php
            if ($userfen <= 100) {
                echo "一级";
            } elseif ($userfen <= 300) {
                echo "二级";
            } elseif ($userfen <= 800) {
                echo "三级";
            } elseif ($userfen <= 2000) {
                echo "四级";
            } elseif ($userfen <= 5000) {
                echo "五级";
            } elseif ($userfen <= 15000) {
                echo "六级";
            } elseif ($userfen <= 50000) {
                echo "七级";
            } elseif ($userfen <= 100000) {
                echo "八级";
            } else {
                echo "八级";
            }
            ?>
            
        </span></p>
                                                                </a>
                                                            </div>
                                                            <!-- list右侧，内容区域·························· -->
                                                            <div class="listRight">
                                                                <a href="<?= $r['titleurl'] ?>">
                                                                    <h3><?= esub($r[title], 30) ?></h3></a>
                                                                <p><?= esub($r[smalltext], 100) ?></p>
                                                                <div class="chatu">
                                                                    <a href="<?= $r['titleurl'] ?>">
                                                                        <img src="<?= $r[titlepic] ?>">
                                                                        <i class="iconfont">&#xe63b;</i>
                                                                    </a>
                                                                </div>
                                                                <div class="time clearfix">
                                                                    <span><?= date('Y-m-d', $r[newstime]) ?></span>
                                                                    <div class="timeRight">
                                                                        <ol class="clearfix">
                                                                            <li><a title="点击量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe644;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>></script>
                                                                            </li>
                                                                            <li><a title="点赞量"
                                                                                   href="JavaScript:makeRequest('/e/public/digg/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&dotop=1&doajax=1&ajaxarea=diggnum','EchoReturnedText','GET','');"><i
                                                                                        class="iconfont">
                                                                                        &#xe629;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=5></script>
                                                                            </li>
                                                                            <li><a title="评论量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64e;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=2></script>
                                                                            </li>
                                                                            <li class="bigsize"><a title="转载量"
                                                                                                   href="javascript:;"
                                                                                                   target="_self"><i
                                                                                        class="iconfont">
                                                                                        &#xe623;</i></a></li>
                                                                            <li>34</li>
                                                                            <li class="bigsize"><a title="加入收藏"
                                                                                                   href="/e/member/fava/add/?classid=<?= $r['classid'] ?>&amp;id=<?= $r['id'] ?>"><i
                                                                                        class="iconfont">
                                                                                        &#xe647;</i></a></li>
                                                                            <li></li>
                                                                            <li><a title="点击分享" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64b;</i></a></li>
                                                                        </ol>
                                                                        <div class="bdsharebuttonbox">
                                                                            <a href="#" class="bds_more"
                                                                               data-cmd="more"></a><a href="#"
                                                                                                      class="bds_qzone"
                                                                                                      data-cmd="qzone"
                                                                                                      title="分享到QQ空间"></a><a
                                                                                href="#" class="bds_tsina"
                                                                                data-cmd="tsina" title="分享到新浪微博"></a><a
                                                                                href="#" class="bds_tqq" data-cmd="tqq"
                                                                                title="分享到腾讯微博"></a><a href="#"
                                                                                                       class="bds_fbook"
                                                                                                       data-cmd="fbook"
                                                                                                       title="分享到Facebook"></a><a
                                                                                href="#" class="bds_weixin"
                                                                                data-cmd="weixin" title="分享到微信"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- list右侧，内容区域结束······················ -->
                                                        </li>
                                                        <!--------视频结束-------->
                                                        <?
                                                    } elseif ($r[classid] == 12 && $r[open] == 1) {
                                                        ?>
                                                        <!--------图片开始-------->
                                                        <li class="clearfix" id="userImg<?= $r[id] ?>">
                                                            <?= $userinfo ?>
                                                            <!-- list左侧，包含头像姓名······················ -->
                                                            <div class="listLeft">
                                                                <a href="/e/space/?userid=<?= $r[userid] ?>">
                                                                    <img src="<?= $r[userpic] ?>">
                                                                    <input type="hidden" name="titid" class="tit_id"
                                                                           value="<?= $r[id] ?>"/>
                                                                    <h3><?= $r[username] ?>&nbsp;
                                                                        <?
                                                                        if ($r[cked] == 1) {
                                                                            echo "<i class='iconfont'>&#xe657;</i>";
                                                                        }
                                                                        ?>
                                                                    </h3>
                                                                    <p class="fromCity"><?= $r[address] ?></p>
                                                                    <p><em>
                                                                            <?
                                                                            if ($r[groupid] == 1) {
                                                                                echo $r[putong_shenfen];//普通会员默认爱乐人
                                                                            } elseif ($r[groupid] == 2) {
                                                                                echo $r[music_star];//音乐之星
                                                                            } elseif ($r[groupid] == 3) {
                                                                                echo $r[teacher_type];//音乐老师
                                                                            } elseif ($r[groupid] == 4) {
                                                                                echo "音乐教室";
                                                                            }
                                                                            ?>
                                                                        </em>
                                                                        <span>
            <?php
            if ($userfen <= 100) {
                echo "一级";
            } elseif ($userfen <= 300) {
                echo "二级";
            } elseif ($userfen <= 800) {
                echo "三级";
            } elseif ($userfen <= 2000) {
                echo "四级";
            } elseif ($userfen <= 5000) {
                echo "五级";
            } elseif ($userfen <= 15000) {
                echo "六级";
            } elseif ($userfen <= 50000) {
                echo "七级";
            } elseif ($userfen <= 100000) {
                echo "八级";
            } else {
                echo "八级";
            }
            ?>
            
        </span></p>
                                                                </a>
                                                            </div>
                                                            <!-- list右侧，内容区域·························· -->
                                                            <div class="listRight">
                                                                <script type="text/javascript">
                                                                    $(function () {
                                                                        var imgUserMsg = "<?=$r[id]?>";

                                                                        $.ajax({
                                                                            url: '/guangchang/index.photo.php',
                                                                            type: 'post',
                                                                            dataType: 'text',
                                                                            data: {'tit_id': imgUserMsg},
                                                                        })
                                                                            .done(function (msg) {

                                                                                var UserImgInfo = msg;
                                                                                var userSelect = "userImg" + imgUserMsg;

                                                                                // $('userSelect').children('chatu a').append('msg');
                                                                                $('#' + userSelect).find('.chatu a').append(msg);
                                                                            })
                                                                            .fail(function () {
                                                                                console.log("error");
                                                                            });


                                                                    });

                                                                </script>
                                                                <a href="<?= $r['titleurl'] ?>">
                                                                    <h3><?= esub($r[title], 30) ?></h3></a>
                                                                <p><?= esub($r[smalltext], 100) ?></p>
                                                                <div class="chatu">
                                                                    <a href="<?= $r['titleurl'] ?>">

                                                                        <!--<img src="<?= $r[titlepic] ?>">-->
                                                                    </a>
                                                                </div>
                                                                <div class="time clearfix">
                                                                    <span><?= date('Y-m-d', $r[newstime]) ?></span>
                                                                    <div class="timeRight">
                                                                        <ol class="clearfix">
                                                                            <li><a title="点击量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe644;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>></script>
                                                                            </li>
                                                                            <li><a title="点赞量"
                                                                                   href="JavaScript:makeRequest('/e/public/digg/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&dotop=1&doajax=1&ajaxarea=diggnum','EchoReturnedText','GET','');"><i
                                                                                        class="iconfont">
                                                                                        &#xe629;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=5></script>
                                                                            </li>
                                                                            <li><a title="评论量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64e;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=2></script>
                                                                            </li>
                                                                            <li class="bigsize"><a title="转载量"
                                                                                                   href="javascript:;"
                                                                                                   target="_self"><i
                                                                                        class="iconfont">
                                                                                        &#xe623;</i></a></li>
                                                                            <li>34</li>
                                                                            <li class="bigsize"><a title="加入收藏"
                                                                                                   href="/e/member/fava/add/?classid=<?= $r['classid'] ?>&amp;id=<?= $r['id'] ?>"><i
                                                                                        class="iconfont">
                                                                                        &#xe647;</i></a></li>
                                                                            <li></li>
                                                                            <li><a title="点击分享" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64b;</i></a></li>
                                                                        </ol>
                                                                        <div class="bdsharebuttonbox">
                                                                            <a href="#" class="bds_more"
                                                                               data-cmd="more"></a><a href="#"
                                                                                                      class="bds_qzone"
                                                                                                      data-cmd="qzone"
                                                                                                      title="分享到QQ空间"></a><a
                                                                                href="#" class="bds_tsina"
                                                                                data-cmd="tsina" title="分享到新浪微博"></a><a
                                                                                href="#" class="bds_tqq" data-cmd="tqq"
                                                                                title="分享到腾讯微博"></a><a href="#"
                                                                                                       class="bds_fbook"
                                                                                                       data-cmd="fbook"
                                                                                                       title="分享到Facebook"></a><a
                                                                                href="#" class="bds_weixin"
                                                                                data-cmd="weixin" title="分享到微信"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- list右侧，内容区域结束······················ -->
                                                        </li>
                                                        <!--------图片结束-------->
                                                        <?
                                                    } elseif ($r[classid] == 13 && $r[open] == 1) {
                                                        ?>
                                                        <!--------音乐开始-------->
                                                        <li class="clearfix">
                                                            <?= $userinfo ?>
                                                            <!-- list左侧，包含头像姓名······················ -->
                                                            <div class="listLeft">
                                                                <a href="/e/space/?userid=<?= $r[userid] ?>">
                                                                    <img src="<?= $r[userpic] ?>">
                                                                    <h3><?= $r[username] ?>&nbsp;
                                                                        <?
                                                                        if ($r[cked] == 1) {
                                                                            echo "<i class='iconfont'>&#xe657;</i>";
                                                                        }
                                                                        ?>
                                                                    </h3>
                                                                    <p class="fromCity"><?= $r[address] ?></p>
                                                                    <p><em>
                                                                            <?
                                                                            if ($r[groupid] == 1) {
                                                                                echo $r[putong_shenfen];//普通会员默认爱乐人
                                                                            } elseif ($r[groupid] == 2) {
                                                                                echo $r[music_star];//音乐之星
                                                                            } elseif ($r[groupid] == 3) {
                                                                                echo $r[teacher_type];//音乐老师
                                                                            } elseif ($r[groupid] == 4) {
                                                                                echo "音乐教室";
                                                                            }
                                                                            ?>
                                                                        </em>
                                                                        <span>
            <?php
            if ($userfen <= 100) {
                echo "一级";
            } elseif ($userfen <= 300) {
                echo "二级";
            } elseif ($userfen <= 800) {
                echo "三级";
            } elseif ($userfen <= 2000) {
                echo "四级";
            } elseif ($userfen <= 5000) {
                echo "五级";
            } elseif ($userfen <= 15000) {
                echo "六级";
            } elseif ($userfen <= 50000) {
                echo "七级";
            } elseif ($userfen <= 100000) {
                echo "八级";
            } else {
                echo "八级";
            }
            ?>
            
        </span></p>
                                                                </a>
                                                            </div>
                                                            <!-- list右侧，内容区域·························· -->
                                                            <div class="listRight">
                                                                <a href="<?= $r['titleurl'] ?>">
                                                                    <h3><?= esub($r[title], 30) ?></h3></a>
                                                                <p><?= esub($r[smalltext], 100) ?></p>
                                                                <div class="chatu">
                                                                    <a href="<?= $r['titleurl'] ?>">


                                                                        <img src="<?= $r[titlepic] ?>">
                                                                        <i class="iconfont">&#xe63e;</i>
                                                                    </a>
                                                                </div>
                                                                <div class="time clearfix">
                                                                    <span><?= date('Y-m-d', $r[newstime]) ?></span>
                                                                    <div class="timeRight">
                                                                        <ol class="clearfix">
                                                                            <li><a title="点击量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe644;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>></script>
                                                                            </li>
                                                                            <li><a title="点赞量"
                                                                                   href="JavaScript:makeRequest('/e/public/digg/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&dotop=1&doajax=1&ajaxarea=diggnum','EchoReturnedText','GET','');"><i
                                                                                        class="iconfont">
                                                                                        &#xe629;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=5></script>
                                                                            </li>
                                                                            <li><a title="评论量" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64e;</i></a></li>
                                                                            <li>
                                                                                <script
                                                                                    src=/e/public/ViewClick/?classid=<?= $r['classid'] ?>&id=<?= $r['id'] ?>&down=2></script>
                                                                            </li>
                                                                            <li class="bigsize"><a title="转载量"
                                                                                                   href="javascript:;"
                                                                                                   target="_self"><i
                                                                                        class="iconfont">
                                                                                        &#xe623;</i></a></li>
                                                                            <li>34</li>
                                                                            <li class="bigsize"><a title="加入收藏"
                                                                                                   href="/e/member/fava/add/?classid=<?= $r['classid'] ?>&amp;id=<?= $r['id'] ?>"><i
                                                                                        class="iconfont">
                                                                                        &#xe647;</i></a></li>
                                                                            <li></li>
                                                                            <li><a title="点击分享" href="javascript:;"
                                                                                   target="_self"><i class="iconfont">
                                                                                        &#xe64b;</i></a></li>
                                                                        </ol>
                                                                        <div class="bdsharebuttonbox">
                                                                            <a href="#" class="bds_more"
                                                                               data-cmd="more"></a><a href="#"
                                                                                                      class="bds_qzone"
                                                                                                      data-cmd="qzone"
                                                                                                      title="分享到QQ空间"></a><a
                                                                                href="#" class="bds_tsina"
                                                                                data-cmd="tsina" title="分享到新浪微博"></a><a
                                                                                href="#" class="bds_tqq" data-cmd="tqq"
                                                                                title="分享到腾讯微博"></a><a href="#"
                                                                                                       class="bds_fbook"
                                                                                                       data-cmd="fbook"
                                                                                                       title="分享到Facebook"></a><a
                                                                                href="#" class="bds_weixin"
                                                                                data-cmd="weixin" title="分享到微信"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- list右侧，内容区域结束······················ -->
                                                        </li>
                                                        <!--------音乐结束-------->
                                                        <?
                                                    }
                                                }
                                                ?>


                                            </ul>
                                        </div>


                                </ul>
                                <?
                            }
                            ?>
                            <!-- 讨论区结束··········································································· -->
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('.liebiaoFuck:gt(0)').hide();
                            })

                        </script>
                        <!-- 列表内容区域结束··························· -->
                    </div>
                </div>
            </div>
        </div>
        <!-- 教室多图片展示············································································· -->
        <div class="jiaoshi_shows_down"></div>
        <div class="focusBox" style="margin:0 auto">

            <ul class="pic">

                <?
                $pop = $empire->fetch1("select photo,userpic from phome_enewsmemberadd where userid='$userid'");
                echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$pop[userpic]'/></a></li>";
                $photo = explode("::::::", $pop['photo']);
                //print_r($photo);
                $length = count($photo) - 1;
                if ($length == 1) {
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[0]'/></a></li>";
                } elseif ($length == 2) {
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[0]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[1]'/></a></li>";
                } elseif ($length == 3) {
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[0]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[1]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[2]'/></a></li>";
                } elseif ($length == 4) {
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[0]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[1]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[2]'/></a></li>";
                    echo "<li><a target='_blank'><i class='shutUp'>×</i><img src='$photo[3]'/></a></li>";
                }

                ?>
            </ul>
            <a class="prev" href="javascript:void(0)"></a>
            <a class="next" href="javascript:void(0)"></a>
            <ul class="hd">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>
        <script type="text/javascript">
            $(function () {
                // 教室多图展示
                jQuery(".focusBox").hover(function () {
                    jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.2)
                }, function () {
                    jQuery(this).find(".prev,.next").fadeOut()
                });
                /*SuperSlide图片切换*/
                jQuery(".focusBox").slide({
                    mainCell: ".pic",
                    effect: "fold",
                    autoPlay: false,
                    delayTime: 600,
                    trigger: "click"
                });
            });



        </script>
        <!-- 教室图片展示··················································································· -->
    </div>
<?php
include("footer.temp.php");
?>