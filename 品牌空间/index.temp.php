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
    <link rel="stylesheet" href="/css/xin_yueqipinpai.css">
    <script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript">
        $(function () {
        //1. 教室多图展示
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
// 隐藏图片
            $('.jiaoshi_shows_down').hide();
            $('.focusBox').hide();
//                控制相册显示与隐藏
            $('.jiaoshiImg').on('click', function (event) {
                // event.preventDefault();
                $('.jiaoshi_shows_down').show().css('opacity',1);
                $('.focusBox').show().css('opacity',1);
            });
            $('.shutUp').click(function (event) {
                $('.jiaoshi_shows_down').hide().css('opacity',0);
                $('.focusBox').hide().css('opacity',0);
            });
            $('.jiaoshi_shows_down').click(function (event) {
                $('.focusBox').click(function (event) {
                    return false;
                });
                $(this).hide().css('opacity',0);
                $('.focusBox').hide().css('opacity',0);
            });
//        2.分类标题与内容的隐藏和显示
            var comIndex = 0;
            $('.common-space-head>li').on('click',function () {
                comIndex = $(this).index();
                $(this).addClass('current').siblings().removeClass('current');
                $('.common-space-list').eq(comIndex).addClass('current').siblings().removeClass('current');
            })
        });
    </script>
    <div class="bodyWrap clearfix">
        <!-- 左边二级导航列···················································· -->
        <div class="leftWrap jiaoshiRight">
<!--            右侧的登录之后-->
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
                                    } elseif ($groupid == 5) {
                                        echo "品牌电话：";
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
                        }elseif ($groupid == 5) {
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
                            <li class="baomingrenshu clearfix">
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
<!--                                <a href="/e/QA/ListInfo.php?mid=10&username=--><?//= $username ?><!--&userid=--><?//= $userid ?><!--"-->
<!--                                   class="button blue small ">提问</a>-->
                            <li class="clearfix">
                                <!-- <a href="javascript:;"><i class="iconfont">&#xe647;</i><span>收藏</span></a>-->
                                <span>分享：</span>
                                <!-- JiaThis Button BEGIN -->
                                <div class="jiathis_style_32x32">
                                    <a class="jiathis_button_weixin"></a>
                                    <a class="jiathis_button_tsina"></a>
                                    <a class="jiathis_button_qzone"></a>
                                    <a class="jiathis_button_tqq"></a>
                                    <a class="jiathis_button_fb"></a>
                                    <a href="http://www.jiathis.com/share?uid=2111445" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
                                    <a class="jiathis_counter_style"></a>
                                </div>
                                <script type="text/javascript" >
                                    var jiathis_config={
                                        data_track_clickback:true,
//                                        summary:"摘要",//摘要
//                                        title:"标题",//标题
                                        pic:"<?= $userpic ?>",//图片
                                        //	url:"url",//url
                                        shortUrl:false,
                                        hideMore:false
                                    }
                                </script>
                                <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=2111445" charset="utf-8"></script>
                                <!-- JiaThis Button END -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 第一.全站动态部分············································· -->
            <div class="rightMiddle ">
                <!-- 内容··························· -->
                <div class="qzdtContent">
                    <div class="yinyuemingren">
                        <!-- 分类行····································· -->
                        <div class="fenlei borTop">
                            <ul class="clearfix common-space-head">
                                <li class="current"><a href="javascript:;">品牌介绍</a><span></span></li>
                                <li><a href="javascript:;">产品中心</a><span></span></li>
                                <li><a href="javascript:;">公司新闻</a><span></span></li>
                                <li><a href="javascript:;">销售渠道</a><span></span></li>
                                <li><a href="javascript:;">留言板</a><span></span></li>
                                <li><a href="javascript:;">联系我们</a><span></span></li>
                            </ul>
                        </div>
                        <!-- 分类行结束································· -->
                        <!-- 列表内容区域······························· -->
                        <div class="liebiao common-space-content">
                            <!-- 品牌介绍············································································· -->
                            <?= $id ?>
                            <ul class="common-space-list list1 current clearfix">
                                <div class="jiaoshijieshao">
                                    <?php
                                    $r = $empire->fetch1("select saytext from phome_enewsmemberadd where userid='$userid'");
                                    echo $r[saytext];
                                    ?>
                                </div>
                            </ul>
                            <!-- 产品中心··············································································· -->
                            <ul class="common-space-list list2 clearfix">
                                <!-- 产品中心最多可以分三类产品-->
                                <!--  产品系列，可以循环-start-->
                                <dl class="product-center series clearfix">
                                    <!-- 产品系列标题-->
                                    <dd class="series-head">立式钢琴</dd>
                                    <!--单个产品，可以循环-->
                                    <dt class="series-lists cell f-l-l">
                                        <a href="">
                                            <div class="cell-img">
                                                <img src="/images/img.png" alt="雅马哈钢琴116C">
                                            </div>
                                            <div class="cell-title">雅马哈钢琴116C</div>
                                            <div class="cell-price">价格：¥19000元</div>
                                        </a>
                                    </dt>
                                    <!--单个产品，循环--end-->
                                </dl>
                                <!--  产品系列，可以循环-end-->
                                <!--  产品系列，可以循环-start-->
                                <dl class="product-center series clearfix">
                                    <!-- 产品系列标题-->
                                    <dd class="series-head">立式钢琴</dd>
                                    <!--单个产品，可以循环-->
                                    <dt class="series-lists cell f-l-l">
                                        <a href="">
                                            <div class="cell-img">
                                                <img src="/images/img.png" alt="雅马哈钢琴116C">
                                            </div>
                                            <div class="cell-title">雅马哈钢琴116C</div>
                                            <div class="cell-price">价格：¥19000元</div>
                                        </a>
                                    </dt>
                                    <!--单个产品，循环--end-->
                                </dl>
                                <!--  产品系列，可以循环-end-->
                                <!--  产品系列，可以循环-start-->
                                <dl class="product-center series clearfix">
                                    <!-- 产品系列标题-->
                                    <dd class="series-head">立式钢琴</dd>
                                    <!--单个产品，可以循环-->
                                    <dt class="series-lists cell f-l-l">
                                        <a href="">
                                            <div class="cell-img">
                                                <img src="/images/img.png" alt="雅马哈钢琴116C">
                                            </div>
                                            <div class="cell-title">雅马哈钢琴116C</div>
                                            <div class="cell-price">价格：¥19000元</div>
                                        </a>
                                    </dt>
                                    <!--单个产品，循环--end-->
                                </dl>
                                <!--  产品系列，可以循环-end-->

                            </ul>
                            <!-- 公司新闻·············································································· -->
                            <ul class="common-space-list list3 clearfix">
                                <!--新闻列表-->
                                <dl class="product-news ">
                                    <!--单个新闻，循环开始-->
                                    <dt class="news-lists news-item">
                                        <a href="" class="clearfix">
                                            <div class="news-item-img f-l-l">
                                                <img src="/images/img.png" alt="雅马哈钢琴116C">
                                            </div>
                                            <div class="news-item-body f-l-l">
                                                <div class="news-item-title">雅马哈乐器爱心捐赠行动——养老院爱心捐赠活动</div>
                                                <div class="news-item-smalltext">
                                                    <p>为回馈广大中国消费者十余年来的支持与厚爱，在去年9月9日，雅马哈首次走进上海市
                                                        众仁花苑后，2016年7月13日，雅马哈再次走进养老院。由雅马哈乐器音响（中国）投
                                                        资有限公司主办，上海市慈善基金会协办的雅马哈爱心捐赠行动——暨养老院爱心音乐
                                                        会在位于嘉定区的上海市众仁乐园礼堂举行。</p>
                                                </div>
                                                <div class="news-item-time">2016-01-46 20:58</div>
                                            </div>
                                        </a>
                                    </dt>
                                    <!--单个新闻，循环结束-->
                                    <!--单个新闻，循环开始-->
                                    <dt class="news-lists news-item">
                                        <a href="" class="clearfix">
                                            <div class="news-item-img f-l-l">
                                                <img src="/images/img.png" alt="雅马哈钢琴116C">
                                            </div>
                                            <div class="news-item-body f-l-l">
                                                <div class="news-item-title">雅马哈乐器爱心捐赠行动——养老院爱心捐赠活动</div>
                                                <div class="news-item-smalltext">
                                                    <p>为回馈广大中国消费者十余年来的支持与厚爱，在去年9月9日，雅马哈首次走进上海市
                                                        众仁花苑后，2016年7月13日，雅马哈再次走进养老院。由雅马哈乐器音响（中国）投
                                                        资有限公司主办，上海市慈善基金会协办的雅马哈爱心捐赠行动——暨养老院爱心音乐
                                                        会在位于嘉定区的上海市众仁乐园礼堂举行。</p>
                                                </div>
                                                <div class="news-item-time">2016-01-46 20:58</div>
                                            </div>
                                        </a>
                                    </dt>
                                    <!--单个新闻，循环结束-->
                                </dl>
                            </ul>
                            <!-- 销售渠道·············································································· -->
                            <ul class="common-space-list list4 clearfix">
                                <!--搜索与筛选-->
                                <!-- 搜索框························· -->
                                <div class="searchWrap clearfix">
                                    <div class="dizhi">
                                        <div id="sjld" class="clearfix" >
                                            <div class="m_zlxg" id="shenfen">
                                                <p title="">地区</p>
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
                                                <p title="">城市</p>
                                                <div class="m_zlxg2">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                            <div class="m_zlxg" id="quyu">
                                                <p title="">区县</p>
                                                <div class="m_zlxg2">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                            <input id="sfdq_num" type="hidden" value="" />
                                            <input id="csdq_num" type="hidden" value="" />
                                            <input id="sfdq_tj" type="hidden" value="" />
                                            <input id="csdq_tj" type="hidden" value="" />
                                            <input id="qydq_tj" type="hidden" value="" />
                                        </div>
                                        <script type="text/javascript" src="/js/adress.js"></script>
                                        <script type="text/javascript">
                                            $(function(){
                                                $("#sjld").sjld("#shenfen","#chengshi","#quyu");
                                            });
                                        </script>
                                        <div class="tijiao">
                                            <input type="submit" value="查询">
                                        </div>
                                    </div>
                                    <div class="search">
                                        <input type="search" class="searchSelect" placeholder="请输入内容" required>
                                        <i class="iconfont searchSub">&#xe658;</i>
                                    </div>
                                </div>
                                <!-- 搜索框结束····················· -->
                                <!--销售渠道列表-->
                                <dl class="product-news ">
                                    <!--单个渠道，循环开始-->
                                    <dt class="seller-lists seller-item">
                                        <div class="seller-title">上海艾维乐器</div>
                                        <div class="seller-tellnumber">联系方式：021-58881234</div>
                                        <div class="seller-address">地址：上海莲花南路1987号2号楼2020</div>
                                        <div class="seller-products">经销产品：
                                            <span class="licensed-product">钢琴</span>
                                            <span class="licensed-product">提琴</span>
                                        </div>
                                    </dt>
                                    <!--单个渠道，循环结束-->
                                    <!--单个渠道，循环开始-->
                                    <dt class="seller-lists seller-item">
                                        <div class="seller-title">上海艾维乐器</div>
                                        <div class="seller-tellnumber">联系方式：021-58881234</div>
                                        <div class="seller-address">地址：上海莲花南路1987号2号楼2020</div>
                                        <div class="seller-products">经销产品：
                                            <span class="licensed-product">钢琴</span>
                                            <span class="licensed-product">提琴</span>
                                        </div>
                                    </dt>
                                    <!--单个渠道，循环结束-->
                                    <!--单个渠道，循环开始-->
                                    <dt class="seller-lists seller-item">
                                        <div class="seller-title">上海艾维乐器</div>
                                        <div class="seller-tellnumber">联系方式：021-58881234</div>
                                        <div class="seller-address">地址：上海莲花南路1987号2号楼2020</div>
                                        <div class="seller-products">经销产品：
                                            <span class="licensed-product">钢琴</span>
                                            <span class="licensed-product">提琴</span>
                                        </div>
                                    </dt>
                                    <!--单个渠道，循环结束-->
                                </dl>
                            </ul>
                            <!-- 留言板·································································· -->
                            <ul class="common-space-list list5 clearfix">
                                <!--写留言板-->
                                <div class="write-message-board">
                                    <form action="">
                                        <dl class="write-message-lists">
                                            <dt class="write-lists-item clearfix">
                                                <span class="common-dec f-l-l">留言主题：</span>
                                                <input class="commom-write-input f-l-l" type="text" maxlength="40" placeholder="请填写留言主题" required>
                                            </dt>
                                            <dt class="write-lists-item clearfix">
                                                <span class="common-dec f-l-l">姓名：</span>
                                                <input class="commom-write-input f-l-l" type="text" maxlength="40" placeholder="请填写姓名" required>
                                            </dt>
                                            <dt class="write-lists-item clearfix ">
                                                <span class="common-dec f-l-l">联系方式：</span>
                                                <input class="commom-write-input f-l-l" type="text" maxlength="40" placeholder="请填写联系方式，固话手机号码均可" required>
                                            </dt>
                                            <dt class="write-lists-item clearfix">
                                                <span class="common-dec f-l-l">电子邮箱：</span>
                                                <input class="commom-write-input f-l-l" type="text" maxlength="40" placeholder="请填写电子邮箱" required>
                                            </dt>
                                            <dt class="write-lists-item clearfix">
                                                <span class="common-dec f-l-l">留言内容：</span>
                                                <textarea class="commom-write-textarea f-l-l" name="" id="" maxlength="200"></textarea>
                                            </dt>
                                        </dl>
                                    </form>
                                </div>
                                <!--写留言板--end -->
                                <!--留言列表外框-->
                                <div class="messages-board-lists-warp">
                                    <div class="h2">留言反馈</div>
                                    <!--留言列表-->
                                    <dl class="messages-board-lists">
                                        <!--单挑留言内容，可以循环-->
                                        <dt class="show-messages-list-item">
                                            <div class="cell-message-title clearfix">
                                                <span class="commom-list-dec f-l-l">留言主题：</span>
                                                <h3 class="commom-list-text f-l-l">主题主题主题</h3>
                                            </div>
                                            <div class="cell-message-name clearfix">
                                                <span class="commom-list-dec f-l-l">留言人：</span>
                                                <h3 class="commom-list-text f-l-l">留言人姓名</h3>
                                            </div>
                                            <div class="cell-message-body clearfix">
                                                <span class="commom-list-dec f-l-l">留言内容：</span>
                                                <p class="commom-list-text f-l-l">留言内容留言内容留言内容留言内容留言内容</p>
                                            </div>
                                            <div class="cell-message-reply clearfix">
                                                <span class="commom-list-dec f-l-l">回复内容：</span>
                                                <p class="commom-list-text f-l-l">回复内容回复内容回复内容回复内容回复内容</p>
                                            </div>
                                        </dt>
                                        <!--单挑留言内容，循环结束-->
                                        <!--单挑留言内容，可以循环-->
                                        <dt class="show-messages-list-item">
                                            <div class="cell-message-title clearfix">
                                                <span class="commom-list-dec f-l-l">留言主题：</span>
                                                <h3 class="commom-list-text f-l-l">主题主题主题</h3>
                                            </div>
                                            <div class="cell-message-name clearfix">
                                                <span class="commom-list-dec f-l-l">留言人：</span>
                                                <h3 class="commom-list-text f-l-l">留言人姓名</h3>
                                            </div>
                                            <div class="cell-message-body clearfix">
                                                <span class="commom-list-dec f-l-l">留言内容：</span>
                                                <p class="commom-list-text f-l-l">留言内容留言内容留言内容留言内容留言内容</p>
                                            </div>
                                            <div class="cell-message-reply clearfix">
                                                <span class="commom-list-dec f-l-l">回复内容：</span>
                                                <p class="commom-list-text f-l-l">回复内容回复内容回复内容回复内容回复内容</p>
                                            </div>
                                        </dt>
                                        <!--单挑留言内容，循环结束-->
                                    </dl>

                                </div>
                            </ul>
                            <!-- 联系我们·································································· -->
                            <ul class="common-space-list list6 clearfix">
                                <dd class="contact-us-warp">
                                    <!--主要机构-->
                                    <div class="contact-us-main">
                                        <div class="seller-title">总部</div>
                                        <!--地图-->
                                        <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=cf19db6adadd29933f75fd2095b92a3e&plugin=AMap.Geocoder"></script>
                                        <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
                                        <div class="map-warp">
                                            <div id="container"></div>
                                            <div id="tip">
                                                <span id="result"></span>
                                            </div>
                                            <script type="text/javascript">
                                            var map = new AMap.Map("container", {
                                                zoom:10,
                                                resizeEnable: true
                                            });
                                            geocoder();
                                            function geocoder() {
                                                var geocoder = new AMap.Geocoder({
                                                    city: "", //城市，默认：“全国”
                                                    radius: 500//范围，默认：500

                                                });
                                                //地理编码,返回地理编码结果
                                                geocoder.getLocation("上海市金山区枫湾路", function(status, result) {
                                                    console.log(status);
                                                    console.log(result);
                                                    if (status === 'complete' && result.info === 'OK') {
                                                        geocoder_CallBack(result);
                                                    }
                                                });
                                            }
                                            function addMarker(i, d) {
                                                var marker = new AMap.Marker({
                                                    map: map,
                                                    position: [ d.location.getLng(),  d.location.getLat()]
                                                });
                                                var infoWindow = new AMap.InfoWindow({
                                                    content: d.formattedAddress,
                                                    offset: {x: 0, y: -30}
                                                });
                                                marker.on("mouseover", function(e) {
                                                    infoWindow.open(map, marker.getPosition());
                                                });
                                            }
                                            //地理编码返回结果展示
                                            function geocoder_CallBack(data) {
                                                var resultStr = "";
                                                //地理编码结果数组
                                                var geocode = data.geocodes;
                                                for (var i = 0; i < geocode.length; i++) {
                                                    //拼接输出html
                                                    //resultStr += "<span style=\"font-size: 12px;padding:0px 0 4px 2px; border-bottom:1px solid #C1FFC1;\">" + "<b>地址</b>：" + geocode[i].formattedAddress + "" + "&nbsp;&nbsp;<b>的地理编码结果是:</b><b>&nbsp;&nbsp;&nbsp;&nbsp;坐标</b>：" + geocode[i].location.getLng() + ", " + geocode[i].location.getLat() + "" + "<b>&nbsp;&nbsp;&nbsp;&nbsp;匹配级别</b>：" + geocode[i].level + "</span>";
                                                    addMarker(i, geocode[i]);
                                                }
                                                map.setFitView();
                                                document.getElementById("result").innerHTML = resultStr;
                                            }
                                        </script>
                                        </div>
                                        <div class="main-name">雅马哈中国投资有限公司</div>
                                        <div class="seller-tellnumber">联系方式：021-58881234</div>
                                        <div class="seller-products">邮编：2015851</div>
                                        <div class="seller-address">地址：上海莲花南路1987号2号楼2020</div>
                                    </div>
                                    <dl class="contact-us-branch">
                                        <dd class="seller-title">分支机构</dd>
                                        <dt class="branch-item">
                                            <div class="main-name">雅马哈中国投资有限公司</div>
                                            <div class="seller-tellnumber">联系方式：021-58881234</div>
                                            <div class="seller-products">邮编：2015851</div>
                                            <div class="seller-address">地址：上海莲花南路1987号2号楼2020</div>
                                        </dt>
                                    </dl>
                                </div>
                            </ul>

                        </div>
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
        <!-- 教室图片展示··················································································· -->
    </div>
<?php
include("footer.temp.php");
?>