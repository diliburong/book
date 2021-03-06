@extends('admin.master')

@section('title','分类')



@section('content')
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 类别管理 <span class="c-gray en">&gt;</span> 产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
			<div class="text-c"> 日期范围：
				<input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;">
				<input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;">
				<input type="text" name="" id="" placeholder=" 图片名称" style="width:250px" class="input-text">
				<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜类别</button>
			</div>
			<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> 
			<a class="btn btn-primary radius" onclick="category_add('添加类别','category_add','','510')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加类别</a></span> 
			<span class="r">共有数据：<strong>54</strong> 条</span> </div>
			<div class="mt-20">
				<table class="table table-border table-bordered table-bg table-hover table-sort">
					<thead>
						<tr class="text-c">
							<th width="40"><input name="" type="checkbox" value=""></th>
							<th width="80">ID</th>
							<th width="100">名称</th>
							<th width="100">编号</th>
							<th width="100">父类别</th>
							<th width="50">预览图</th>
							<th width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categories as $category)
						<tr class="text-c">
							<td><input name="" type="checkbox" value=""></td>
							<td>{{$category->id}}</td>
							<td>{{$category->name}}</td>
							<td>{{$category->category_no}}</td>
							<td>@if($category->parent!=null)
								{{$category->parent->name}}
								@endif</td>
							<td>@if($category->preview != null)
						<img src="{{$category->preview}}" alt="" style="width: 50px; height: 50px;">
								@endif</td>
						<td class="td-manage">
							<a style="text-decoration:none" class="ml-5" onClick="category_add('修改类别','category_edit?id={{$category->id}}','','510')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> 
							<a style="text-decoration:none" class="ml-5" onClick="category_del('{{$category->name}}',{{$category->id}})" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</article>
	</div>
</section>

@endsection

@section('my-js')
<script>
//参数解释
//title 标题
//url请求的url
//w 弹出层宽度 缺省调默认值
//h 高度 同上
//id 需要操作的数据id

function category_add(title,url,w,h){
	layer_show(title,url,w,h);
}


function category_edit(title,url,w,h){
	layer_show(title,url,w,h);
}


function category_del(name,id){
	layer.confirm('确认要删除+['+name+']？',function(index){

				$.ajax({
				type:'post',
				url:'/admin/service/category/del',
				dataType:'json',
				data:{
					id:id,
					_token:"{{csrf_token()}}" 
				},
				success:function(data){
					if (data==null) {
						layer.msg('服务端错误',{icon:2,time:2000});
						return;
					}
					if (data.status!=0) {
						layer.msg(data.message,{icon:2,time:2000});
						return;				
					}
					layer.msg(data.message,{icon:1,time:2000});
					location.replace(location.href);  
				},
				error:function(xhr,status,error){
					console.log(xhr);
					console.log(status);
					console.log(error);
					layer.msg('ajax error',{icon:2,time:2000});
				},
				beforeSend:function(xhr){
					layer.load(0,{shade:false});
				}


			});

	});	
				return false;
}

</script>



@endsection


