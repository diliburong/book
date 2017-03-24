@extends('admin.layitem')
@section('content')
<article class="cl pd-20">
	<form action="" method="post" class="form form-horizontal" id="form-category-add">
		{{ csrf_field() }}
	

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-xs-5 col-sm-7">
				<input type="text" class="input-text" value="{{$product->name}}" placeholder="" id="name" name="name">
			</div>
			<div class="col-4"> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$product->summary}}" placeholder="" name="summary"  datatype="*" nullmsg="简介不能为空">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="number" class="input-text" value="{{$product->price}}" placeholder="" name="price"  datatype="*" nullmsg="价格不能为空">
			</div>
			<div class="col-4"> </div>
		</div>



		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类别：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width:150px;">
					<select class="select" name="parent_id" size="1">
						<option value="">无</option>
						@foreach($categories as $temp)
						@if($product->category_id==$temp->id)
						<option selected value="{{$temp->id}}">{{$temp->name}}</option>
						@else
						<option value="{{$temp->id}}">{{$temp->name}}</option>
						@endif
						@endforeach

					</select>
				</span>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>浏览图</label>
			<div class="formControls col-xs-5 col-sm-7">
				@if($product->preview != null)
				<img id="preview_id" src="{{$product->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
				@else
				<img id="preview_id" src="/admin/static/h-ui.admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
				@endif
				<input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
				
			</div>
			<div class="col-4"> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">详细内容：</label>
			<div class="formControls col-xs-5 col-sm-7">
				<script id="editor" type="text/plain" style="width:100%; height:400px;"></script>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">产品图片：</label>
			<div class="formControls col-xs-5 col-sm-7">
			
			@foreach($pdt_images as $key=>$pdt_image)
				<img id="preview_id{{$key+1}}" src="{{$pdt_image->image_path}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
				<input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','images', 'preview_id1');" />
				
			@endforeach

				<img id="preview_id1" src="/admin/static/h-ui.admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id1').click()" />
				<input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','images', 'preview_id1');" />
			</div>
		</div>



		
		<div class="row cl">
			<div class="col-9 col-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

@endsection

@section('my-js')

<script>
$()


var ue = UE.getEditor('editor');
  ue.execCommand( "getlocaldata" );
  ue.setContent="$pdt_content->content";

		$("#form-category-add").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				maxlength:16
			},
		
			price:{
				required:true,
				isNumber:true,
			},	
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type:'post',
				url:'/admin/service/product/add',
				dataType:'json',
				data:{
					name:$('input[name=name]').val(),
					category_no:$('input[name=category_no]').val(),
					parent_id:$('select[name=parent_id] option:selected').val(),
					preview: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
					content: ue.getContent(),
					preview1: ($('#preview_id1').attr('src')!='/admin/images/icon-add.png'?$('#preview_id1').attr('src'):''),
					preview2: ($('#preview_id2').attr('src')!='/admin/images/icon-add.png'?$('#preview_id2').attr('src'):''),
					preview3: ($('#preview_id3').attr('src')!='/admin/images/icon-add.png'?$('#preview_id3').attr('src'):''),
					preview4: ($('#preview_id4').attr('src')!='/admin/images/icon-add.png'?$('#preview_id4').attr('src'):''),
					preview5: ($('#preview_id5').attr('src')!='/admin/images/icon-add.png'?$('#preview_id5').attr('src'):''),
					_token:"{{csrf_token( )}}" 
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
					parent.location.reload();  //刷新父页面
				},
				error:function(xhr,status,error){
					console.log(xhr);
					console.log(status);
					console.log(error);
					layer.msg('ajax error',{icon:2,time:2000});
				},
				beforeSend:function(xhr){
					layer.load(0,{shade:false});

				},
			});
			// var index = parent.layer.getFrameIndex(window.name);
			// parent.$('.btn-refresh').click();
			// parent.layer.close(index);
			
				return false;
		}
	});
</script>
@endsection
