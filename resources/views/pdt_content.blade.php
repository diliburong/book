@extends('master')

@section('title',$product->name)

@section('content')
<link rel="stylesheet" href="/css/swiper.min.css">

<div class="page">
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
			
				{!!$pdt_content->content!!}				
			
		</div>
	</div>
</div>	

<div class="bk_fix_bottom">
	<div class="bk_half_area">
		<button class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</button>
	</div>
	<div class="bk_half_area">
		<button class="weui_btn weui_btn_dafault" style="color:black">结算(<span id="cart_num" class="m3_price"></span>)</button>
	</div>
</div>
    
@endsection

@section('my-js')
<script type="text/javascript" src="/js/swiper.min.js" charset="utf-8"></script>
<script>

 var mySwiper = new Swiper(".swiper-container",{  
        
        // loop:true,形成环路（即：可以从最后一张图跳转到第一张图  
        pagination:".swiper-pagination",/*分页器*/
        paginationClickable :true,
        paginationType : 'bullets',  
        // prevButton:".swiper-button-prev",/*前进按钮*/  
        // nextButton:".swiper-button-next",/*后退按钮*/  
        autoplay:3000/*每隔3秒自动播放*/ ,
        touchRatio : 1
    })  
	

 </script>


@endsection