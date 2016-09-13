/**
 * Created by Administrator on 2016/9/12.
 * flyxz@126.com
 * 乐器品牌是由音乐老师模板修改而来，故主体js继承音乐老师的，此处为乐器品牌自有的js
 */
$(function() {
    var iList=8;
    // 瀑布流下拉显示·············································
    //

// 显示前N个结束-----------------------------------------------------------

    $(window).scroll(function(event) {
        if ($(document).scrollTop() + $(window).height() > $(document).height() - 150) {

            for (var i = iList; i < iList+4; i++) {
                $('.liebiaoShow').children('li').eq(i).show();
            };
            iList=iList+4;
        };
    });



// 阻止原form的默认提交
// -----------------------------------------------------------------------
    $('.citySelect').submit(function(event) {
        return false
    });
//------------------------------------------------------------
    $('.tijiao input').click(function(event) {
        // 提交城市新信息切换列表内容····················································
        // subCity1代表省级值，subCity2代表市级值，subCity3代表县级值，
        var subCity1;
        var subCity2;
        var subCity3;
        var cityInfo;
        var city1="2222";
        subCity1=$('#sfdq_tj').val();
        subCity2=$('#csdq_tj').val();
        subCity3=$('#qydq_tj').val();
        if (subCity1==""||subCity1=="选择省份") {
            alert("请选择省份再提交");
        } else{
            // 点下按钮之后加载css动画
            $('.liebiaoShow').empty().append('<div class="loaders"><div class="loader"><div class="loader-inner line-scale"><div></div><div></div><div></div><div></div><div></div></div></div></div>');
            $('.loaders').fadeIn(200);
            // console.log({'city1': subCity1,'city2':subCity2,'city3':subCity3});
            $.ajax({
                url: '/jiaoshi/indexs.php',
                type: 'post',
                dataType: 'text',
                // data:{'city1': subCity1,'city2':subCity2,'city3':subCity3},
                data:{'city1': subCity1,'city2':subCity2,'city3':subCity3},
                // data:city1,
                success:function(msg) {
                    // console.log(msg);
                    // console.log(typeof(msg));
                    // 清空liebiaoShow并插入li
                    if (msg=='') {
                        $('.liebiaoShow').empty().append('<p style="font-size:16px;color:#cb7047;text-algin:center;">没有找到琴行，快来加入好琴声吧！</p>');
                    } else {
                        $('.liebiaoFuck').eq(0).hide();
                        $('.liebiaoShow').empty().append(msg);
                        $('.toutiao01').append('推荐');
                        $('.di_zhi').append('地址：');
                        $('.telephone_one').append('咨询电话：');
                    }
                }
            })
                .done(function() {
                    // console.log("success");
                    // ````````````````````````````````````````````````````````````````````````````````````````````

                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });
            // `````````````````````````````````````````````````````````````````````````````````````````````````````````
        };

    });
// ---------------------------------------------------------------------------------------------------------

    // 教室输入名字查询
    var jiaoshiName;
    $('.searchSub').click(function(event) {
        jiaoshiName=$('.searchSelect').val();
        // console.log(jiaoshiName);
        if (jiaoshiName=="") {
            alert('输入的教室名字不能为空');
        } else{
            // 点下按钮之后加载css动画
            $('.liebiaoShow').empty().append('<div class="loaders"><div class="loader"><div class="loader-inner line-scale"><div></div><div></div><div></div><div></div><div></div></div></div></div>');
            $('.loaders').fadeIn(200);
            // console.log(jiaoshiName);
            $.ajax({
                url: '/jiaoshi/index.name.php',
                type: 'post',
                dataType: 'text',
                data: {'jiaoshi1': jiaoshiName},
                success:function(msg){
                    // console.log(msg);
                    // 清空liebiaoShow并插入li
                    // console.log(msg);
                    if (msg=='') {
                        $('.liebiaoShow').empty().append('<p style="font-size:16px;color:#cb7047;text-algin:center;">没有找到琴行，请重新搜索</p>');
                    } else {
                        $('.liebiaoFuck').eq(0).hide();
                        $('.liebiaoShow').empty().append(msg);
                        $('.toutiao01').append('推荐');
                        $('.di_zhi').append('地址：');
                        $('.telephone_one').append('咨询电话：');
                    }

                }
            })
                .done(function() {
                    // console.log("success");
                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });
        };


    });

// ---------------------------------------------------------------------------------------------------------

    // 教室输入排序类型查询
    var paixuName;
    $('#paixuSelect').change(function(event) {
        paixuName=$('#paixuSelect').val();
        // console.log(paixuName);
        if (paixuName==0) {
            alert('请选择排序类型');
        } else{
            // 点下按钮之后加载css动画
            $('.liebiaoShow').empty().append('<div class="loaders"><div class="loader"><div class="loader-inner line-scale"><div></div><div></div><div></div><div></div><div></div></div></div></div>');
            $('.loaders').fadeIn(200);
            // console.log(paixuName);
            $.ajax({
                url: '/jiaoshi/index.type.php',
                type: 'post',
                dataType: 'text',
                data: {'num': paixuName},
                success:function(msg){
                    // console.log(msg);
                    // 清空liebiaoShow并插入li
                    // console.log(msg);
                    $('.liebiaoFuck').eq(0).hide();
                    $('.liebiaoShow').empty().append(msg);
                    $('.toutiao01').append('推荐');
                    $('.di_zhi').append('地址：');
                    $('.telephone_one').append('咨询电话：');
                }
            })
                .done(function() {
                    // console.log("success");
                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });
        };


    });

// ``````````````````````````````````````````````````````````````````````````````````````
//首先封装页面加载获取当前所在城市信息的函数
    function getCurrentCity(){
        var subCity1;
        // 第一步,向高德API发送请求并获得访问者所在省份
        $.ajax({
            type: "get",
            url: "http://webapi.amap.com/maps/ipLocation?key=4a84cf8078fb847fd4072da2dbc9b6b7",//自己申请的高德key，2000次每天
            dataType: 'text',
            // contentType:'application/x-www-form-urlencoded;charset=UTF-8',
            success: function(data) {
                //转换为JSON对象
                var jsonObj = eval("(" + data.replace('(','').replace(')','').replace(';','') + ")");
                //当前城市
                // $("#shenfen>p").html('当前:'+jsonObj.province);
                subCity1=jsonObj.province;
                subCity1=subCity1.substring(0,subCity1.length-1);//拼接字符串，减去最后一位子副
                console.log(subCity1);
                // 第二步，向好琴声后台发送当前地址并接受返回的信息
                $.ajax({
                    url: '/jiaoshi/indexs.ip.php',
                    type: 'post',
                    dataType: 'text',
                    data:{'city_ip': subCity1},
                    success:function(msg) {
                        // 清空liebiaoShow并插入li
                        $('.liebiaoFuck').eq(0).hide();
                        $('.liebiaoShow').empty().append(msg);
                        $('.toutiao01').append('推荐');
                        $('.di_zhi').append('地址：');
                        $('.telephone_one').append('咨询电话：');
                    }
                });
                // 第二步end，向好琴声后台发送当前地址并接受返回的信息
            }
        });
        // 自定义函数结束
    }
    //页面加载时调用自己封装的函数来获取当前所在城市信息
    // $(document).ready(function(){
    //     getCurrentCity();
    // });
    //页面加载完毕调用自己封装的函数来获取当前所在城市信息
    window.onload=function(){
        getCurrentCity();
    }









// ``````````````````````````````````````````````````````````````````````````````````````
    $('.fenleiFuck li').on('click', function(event) {
        // 点下按钮之后加载css动画
        $('.liebiaoShow').empty().append('<div class="loaders"><div class="loader"><div class="loader-inner line-scale"><div></div><div></div><div></div><div></div><div></div></div></div></div>');
        $('.loaders').fadeIn(200);
        getCurrentCity();
    });
    getCurrentCity(

});



