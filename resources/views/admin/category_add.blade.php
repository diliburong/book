@extends('admin.layitem')





@section('content')

<article class="cl pd-20">
	<form action="" method="post" class="form form-horizontal" id="form-category-add">
		{{ csrf_field() }}

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-xs-5 col-sm-7">
				<input type="text" class="input-text" value="" placeholder="" id="name" name="name">
			</div>
			<div class="col-4"> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>序号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="number" class="input-text" value="0" placeholder="" name="category_no"  datatype="*" nullmsg="序号不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">父类别：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width:150px;">
					<select class="select" name="parent_id" size="1">
						<option value="">无</option>
						@foreach($categories as $category)
						<option value="{{$category->id}}">{{$category->name}}</option>
						@endforeach
					</select>
				</span>
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>浏览图</label>
			<div class="formControls col-xs-5 col-sm-7">
				<img id="preview_id" src="/admin/static/h-ui.admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
				<input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
			</div>
			<div class="col-4"> </div>
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
		$("#form-category-add").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				maxlength:16
			},
		
			category_no:{
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
				url:'/admin/service/category/add',
				dataType:'json',
				data:{
					name:$('input[name=name]').val(),
					category_no:$('input[name=category_no]').val(),
					parent_id:$('select[name=parent_id] option:selected').val(),
					preview: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
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
