@extends('master')

@section('title','购物车')

@section('content')
 <div class="page bk_content" style="top: 0;">
    <div class="weui_cells weui_cells_checkbox">
        @foreach($cart_items as $cart_item)
        <label class="weui_cell weui_check_label" for="{{$cart_item->product->id}}">
            <div class="weui_cell_hd" style="width: 23px;">
                <input type="checkbox" class="weui_check" name="cart_item" id="{{$cart_item->product->id}}" checked="checked">
                <i class="weui_icon_checked"></i>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
              <div style="position: relative;">
                <img class="bk_preview" src="{{$cart_item->product->preview}}" class="m3_preview" onclick="_toProduct({{$cart_item->product->id}});"/>
                <div style="position: absolute; left: 100px; right: 0; top: 0">
                  <p>{{$cart_item->product->name}}</p>
                  <p class="bk_time" style="margin-top: 15px;">数量: <span class="bk_summary">x{{$cart_item->count}}</span></p>
                  <p class="bk_time">总计: <span class="bk_price">￥{{$cart_item->product->price * $cart_item->count}}</span></p>
                </div>
              </div>
            </div>
        </label>
        @endforeach
    </div>
  </div>
  <form action="/order_commit" id="order_commit" method="post">
  	{{csrf_field()}}
  	<input type="hidden" name="product_ids" value="">
  </form>

  <div class="bk_fix_bottom">
    <div class="bk_half_area">
      <button class="weui_btn weui_btn_primary" onclick="_toCharge();">结算</button>
    </div>
    <div class="bk_half_area">
      <button class="weui_btn weui_btn_default" onclick="_onDelete();">删除</button>
    </div>
  </div>
@endsection

@section('my-js')
<script>
	$('input:checkbox[name=cart_item]').click(function(event) {
    var checked = $(this).attr('checked');
    if(checked == 'checked') {
      $(this).attr('checked', false);
      $(this).next().removeClass('weui_icon_checked');
      $(this).next().addClass('weui_icon_unchecked');
    } else {
      $(this).attr('checked', 'checked');
      $(this).next().removeClass('weui_icon_unchecked');
      $(this).next().addClass('weui_icon_checked');
    }
  });

	function _toCharge(){
		var product_ids_arr=[];
		$('input:checkbox[name=cart_item]').each(function(index,el){
			if ($(this).attr('checked')=='checked') {
				product_ids_arr.push($(this).attr('id'));
			}
		});

		if(product_ids_arr.length == 0) {
			$('.bk_toptips').show();
			$('.bk_toptips span').html('请选择提交项');
			setTimeout(function() {$('.bk_toptips').hide();}, 2000);
			return;
		}
	
		//location.href='/order_commit/'+product_ids_arr;
		//使用post方式提交表单提交产品ID
		$('input[name=product_ids]').val(product_ids_arr+'');
		$('#order_commit').submit();
	}

	function _onDelete(){
		var product_ids_arr=[];
		$('input:checkbox[name=cart_item]').each(function(index,el){
			if ($(this).attr('checked')=='checked') {
				product_ids_arr.push($(this).attr('id'));
			}
		});

		if(product_ids_arr.length == 0) {
			$('.bk_toptips').show();
			$('.bk_toptips span').html('请选择删除项');
			setTimeout(function() {$('.bk_toptips').hide();}, 2000);
			return;
		}

		$.ajax({
			type: "GET",
			url: '/service/cart/delete',
			dataType: 'json',
			cache: false,
			data: {product_ids: product_ids_arr+''},
			success: function(data) {
				if(data == null) {
					$('.bk_toptips').show();
					$('.bk_toptips span').html('服务端错误');
					setTimeout(function() {$('.bk_toptips').hide();}, 2000);
					return;
				}
				if(data.status != 0) {
					$('.bk_toptips').show();
					$('.bk_toptips span').html(data.message);
					setTimeout(function() {$('.bk_toptips').hide();}, 2000);
					return;
				}
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			}
		}).done(function(){
			location.reload(true);
		});


		
	}

</script>

@endsection