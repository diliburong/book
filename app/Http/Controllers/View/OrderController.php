<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderItem;


class OrderController extends Controller
{
   
	public function toOrderCommit(Request $request)
	{
		$product_ids=$request->input('product_ids','');

		$product_ids_arr=($product_ids!=''?explode(',',$product_ids):array());
		$member=$request->session()->get('member','');
		$cart_items=CartItem::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->get();
		
		$cart_items_arr=array();
		$total_price=0;
		foreach ($cart_items as $cart_item) {
			$cart_item->product=Product::find($cart_item->product_id);  //临时增加的变量
			if ($cart_item->product!=null) {   //查找是否存在商品，防止因误删除出现的异常
				$total_price+=$cart_item->product->price*$cart_item->count;
				array_push($cart_items_arr, $cart_item);
			}
		}

		return view('order_commit')->with('cart_items',$cart_items_arr)
		->with('total_price',$total_price);
	}

	public function toOrderList(Request $request)
	{

		$member=$request->session()->get('member','');
		$orders=Order::where('member_id',$member->id)->get();
		foreach ($orders as $order) {
			$order_items=OrderItem::where('order_id',$order->id)->get();
			$order->order_items=$order_items; //作为属性放入order中

			foreach ($order_items as $order_item) {
				$order_item->product=Product::find($order_item->product_id);
			}

		}
		
		return view('order_list')->with('orders',$orders);
	}


}	

