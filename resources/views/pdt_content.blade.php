@extends('master')

@section('title',$product->name)

@section('content')
<link rel="stylesheet" href="/css/swiper.min.css">

<div class="page" style="top: 0;">
	<div class="swiper-container"style="width: 100%;"><!--swiper容器[可以随意更改该容器的样式-->  
	    <div class="swiper-wrapper"> 
			@foreach($pdt_images as $pdt_image)
	    	<div class="swiper-slide">
	    		<img class="img-responsive" src="{{$pdt_image->image_path}}" alt="">
	    	</div>
			@endforeach
	    </div>  
	     <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets" ></div>
	</div>  





    <div class="weui_cells_title">
        <span class="bk_title">{{$product->name}}</span>
        <span class="bk_price" style="float:right;">￥{{$product->price}}</span>
    </div>
    <div class="weui_cells">
        <div class="weui_cell">
            <p class="bk_summary">{{$product->summary}}</p>
        </div>
    </div>  

    <div class="weui_cells_title">详细介绍</div>
	<div class="weui_cells">
		<div class="weui_cell">
			@if($pdt_content!=null)
      {
				{!!$pdt_content->content!!}			
      }
      
      @else

      @endif
			
		</div>
	</div>
</div>	

<div class="bk_fix_bottom">
	<div class="bk_half_area">
		<button class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</button>
	</div>
	<div class="bk_half_area">
		<button class="weui_btn weui_btn_dafault" style="color:black" onclick="_toCart()">结算(<span id="cart_num" class="m3_price">{{$count}}</span>)</button>
	</div>
</div>
    
@endsection

@section('my-js')
<script type="text/javascript" src="/js/swiper.min.js" charset="utf-8"></script>
<script>

 var mySwiper = new Swiper(".swiper-container",{  
        
        pagination:".swiper-pagination",/*分页器*/
        paginationClickable :true,
        paginationType : 'bullets',    
        autoplay:3000/*每隔3秒自动播放*/ ,
        touchRatio : 0.7
    })  
	
 function _addCart(){

 	var product_id="{{$product->id}}"
 	$.ajax({
 		type: "GET",
 		url: '/service/cart/add/'+product_id,
 		dataType: 'json',
 		cache: false,
        success: function(data) {  //返回的data是一个json对象
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

      	$('.bk_toptips').show();
      	$('.bk_toptips span').html('添加成功');
      	setTimeout(function() {$('.bk_toptips').hide();}, 2000);


      	var num=$('#cart_num').html();
      	if (num=='') num=0;
      	$('#cart_num').html(Number(num)+1);

      },
      error: function(xhr, status, error) {
      	console.log(xhr);
      	console.log(status);
      	console.log(error);
      }
  });
 }


function _toCart(){

  location.href='/cart';
}
 </script>



@endsection