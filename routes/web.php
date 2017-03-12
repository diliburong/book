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



Route::group(['prefix'=>'service'],function(){
	Route::get('validate_code/create','Service\ValidateCodeController@create');
	Route::post('validate_phone/send','Service\ValidateCodeController@sendSMS');
	Route::any('validate_email','Service\ValidateCodeController@validateEmail');

	Route::post('register','Service\MemberController@register');
	Route::post('login','Service\MemberController@login');

	Route::get('category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');

});