<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
  <title>@yield('title')</title>
  <link rel="stylesheet" type="text/css" href="/css/weui.css">
  <link rel="stylesheet" type="text/css" href="/css/book.css">

</head>
<body>
<div class="bk_title_bar">
  <img class="bk_back" src="/image/back.png" alt="" onclick="history.go(-1)">
  <p class="bk_title_content"></p>
  <img class="bk_menu" src="/image/menu.png" alt="" onclick="onMenuClick()">
</div>

<div class="page">
  @yield('content')
</div>

<!-- tooltips -->
<div class="bk_toptips"><span></span></div>

<div id="global_menu" onclick="onMenuClick();">
  <div></div>
</div>

<!--BEGIN actionSheet-->
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">主页</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">书籍类别</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">购物车</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">订单列表</div>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>

</body>
<script src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
function hideActionSheet(weuiActionsheet, mask) {
    weuiActionsheet.removeClass('weui_actionsheet_toggle');
    mask.removeClass('weui_fade_toggle');
    weuiActionsheet.on('transitionend', function () {
        mask.hide();
    }).on('webkitTransitionEnd', function () {
        mask.hide();
    })
}

function onMenuClick () {
    var mask = $('#mask');
    var weuiActionsheet = $('#weui_actionsheet');
    weuiActionsheet.addClass('weui_actionsheet_toggle');
    mask.show().addClass('weui_fade_toggle').click(function () {
        hideActionSheet(weuiActionsheet, mask);
    });
    $('#actionsheet_cancel').click(function () {
        hideActionSheet(weuiActionsheet, mask);
    });
    weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
}

function onMenuItemClick(index) {
  var mask = $('#mask');
  var weuiActionsheet = $('#weui_actionsheet');
  hideActionSheet(weuiActionsheet, mask);
  if(index == 1) {
    $('.bk_toptips').show();
    $('.bk_toptips span').html("敬请期待!");
    setTimeout(function() {$('.bk_toptips').hide();}, 2000);      

  } else if(index == 2) {
    location.href='/category';
  } else if(index == 3){
    location.href='/cart';
  } else if(index==4){
      location.href='/order_list';
  }
}

//将标题与标题栏保持一致
$('.bk_title_content').html(document.title);
</script>

@yield('my-js')
</html>
