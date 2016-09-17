/**
 * Created by Administrator on 2016/9/12.
 *  flyxz@126.com
 *  本js只针对于空间的讨论区的异步加载，提高加载速度
 */
// 0.增加下拉刷新提示
// $(function() {
//     $('.quanzhandongtai').append('<li class="loaderMsg">下拉查看更多的帖子↓</li>')
// });
// 点击讨论区的时候执行下面函数，讨论区帖子列表动态加载
/**
 * 封装ajax调用
 * @param userid {number}
 * @returns doneData{string}
 */
function ajaxDisArea(userid) {
    var doneData;
    $.ajax({
        url:'/e/ajax/jiaoliu.ajax.php',
        type:'post',
        data:{'$tmgetuserid':userid}
    })
    .done(function (msg) {
        console.log(msg);
        doneData = msg ;
    })
    .fail(function (msg) {
        console.log(msg);
        doneData = "<h2>网络错误，请重新加载！</h2>"
    });
    return doneData;
}
$(function () {
    $('.discuss-area-btn').on('click',function () {

        var disArea = ajaxDisArea(currentUserid);
        console.log(disArea)
        if ( disArea != "" || disArea != null) {
            $('.dis-area-content').append(disArea);
        };
    })
})

$(function () {
    $.ajax({

    })
})









// $(function() {
//     var iList       = 1,            //标记请求内容的次数
//         scrollTimer = null,   //动态设置定时器，减少执行次数
//         iload       = 0,            //标记返回值为空的次数，提醒用户已经没有帖子，不用再下啦了
//     $(window).scroll(function(event) {
//         if (scrollTimer) {
//             clearTimeout(scrollTimer);//清除定时器
//         }
//         scrollTimer=setTimeout(function() {
//             //如果离底部小于150像素，就发送请求
//             if ($(document).scrollTop() + $(window).height() > $(document).height() -360) {
//                 $('.loaders').show();
//                 $.ajax({
//                     url: '/guangchang/guangchang.ajax.php',
//                     type: 'post',
//                     dataType: 'html',
//                     data: {'number': iList}
//                 })
//                     .done(function(msg) {
//                         // console.log(msg);
//                         // console.log(typeof(msg));
//                         if (msg=="") {
//
//                             iload++;
//                             if (iload===1) {
//                                 $('.loaderMsg').empty().html('已经是最后一条了...');
//                             }
//                             else if(iload===2) {
//                                 $('.loaderMsg').empty().html('别再下拉了，真的没有了，赶紧去个人中心发帖吧...');
//                             }
//                             else{
//                                 $('.loaderMsg').empty().html('真的没有了，程序猿哥哥也不是万能的，赶紧去个人中心发帖吧...');
//                             }
//                             $('.leftWrap>ul').slideDown(1000);
//                         } else {
//                             $('.loaderMsg').remove();
//                             $('.quanzhandongtai').append(msg);//服务器返回内容插到当前元素内部后面
//                             $('.quanzhandongtai').append('<li class="loaderMsg">下拉刷新帖子↓</li>');
//                             $('.leftWrap>ul').slideDown(1000);
//                         }
//
//                     })
//                     .fail(function() {
//                         console.log("error");
//                         $('.loaderMsg').empty().html('网络错误，加载失败...');
//                         $('.leftWrap>ul').slideDown(1000);
//                         // $('.leftWrap>ul').slideDown(1000);
//                     });
//                 iList++;//每发送一次请求数字++
//             };
//         }, 500);
//
//
//
//     });
// });
