<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Entity\Member;
//尽量不要在路由里去写function ，将方法放在Controller里面
Route::get('/', function () {
   // return view('welcome');
  //return Member::all();
  return view('login');
  
});

Route::get('/login', 'View\MemberController@toLogin');
Route::get('/register','View\MemberController@toRegister');


Route::get('/category','View\BookController@toCategory');
Route::get('/product/category_id/{category_id}','View\BookController@toProduct');
Route::get('/product/{product_id}','View\BookController@toPdtContent');

Route::get('/cart','View\CartController@toCart');


Route::group(['prefix'=>'service'],function(){
	Route::get('validate_code/create','Service\ValidateCodeController@create');
	Route::post('validate_phone/send','Service\ValidateCodeController@sendSMS');
	Route::any('validate_email','Service\ValidateCodeController@validateEmail');

	Route::post('register','Service\MemberController@register');
	Route::post('login','Service\MemberController@login');

	Route::get('category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');
	Route::get('cart/add/{product_id}','Service\CartController@addCart');
	Route::get('cart/delete','Service\CartController@deleteCart');

	Route::post('upload/{type}', 'Service\UploadController@uploadFile');

});

Route::group(['middleware'=>'check.login'],function(){   //中间件，判断是否登陆

	Route::post('/order_commit','View\OrderController@toOrderCommit');
	Route::get('/order_list','View\OrderController@toOrderList');

});


Route::group(['prefix'=>'admin'],function(){
Route::group(['prefix'=>'service'],function(){
	Route::post('login','Admin\IndexController@login');
	
	Route::post('product/add','Admin\ProductController@productAdd');
	Route::post('product/del','Admin\ProductController@productDel');
	Route::post('product/edit','Admin\ProductController@productEdit');



});
	
	Route::get('index','Admin\IndexController@toIndex');
	Route::get('index','Admin\IndexController@toIndex');
	Route::get('login','Admin\IndexController@toLogin');
	
	Route::get('category','Admin\CategoryController@toCategory');
	Route::get('category_add','Admin\CategoryController@toCategoryAdd');
	Route::get('category_edit','Admin\CategoryController@toCategoryEdit');

	Route::get('product','Admin\ProductController@toProduct');
	Route::get('product_info','Admin\ProductController@toProductInfo');
	Route::get('product_add','Admin\ProductController@toProductAdd');
	Route::get('product_edit','Admin\ProductController@toProductEdit');


});

