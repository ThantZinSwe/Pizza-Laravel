<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {

    //Order List Page
    public function orderList() {

        $data = Order::select( 'orders.customer_id', 'orders.pizza_id', 'orders.order_time', 'orders.order_id', 'users.name as customer_name', 'pizzas.pizza_name', DB::raw( 'count(orders.pizza_id)as count' ) )
            ->join( 'users', 'users.id', 'orders.customer_id' )
            ->join( 'pizzas', 'pizzas.pizza_id', 'orders.pizza_id' )
            ->groupBy( 'orders.customer_id', 'orders.pizza_id', 'orders.order_time' )
            ->paginate( 5 );
        return view( 'admin.order.list' )->with( array( 'order' => $data ) );

    }

    //Order Search
    public function orderSearch( Request $request ) {

        $searchData = Order::select( 'orders.customer_id', 'orders.pizza_id', 'orders.order_time', 'orders.order_id', 'users.name as customer_name', 'pizzas.pizza_name', DB::raw( 'count(orders.pizza_id)as count' ) )
            ->join( 'users', 'users.id', 'orders.customer_id' )
            ->join( 'pizzas', 'pizzas.pizza_id', 'orders.pizza_id' )
            ->orwhere( 'users.name', 'like', '%' . $request->searchData . '%' )
            ->orwhere( 'pizzas.pizza_name', 'like', '%' . $request->searchData . '%' )
            ->groupBy( 'orders.customer_id', 'orders.pizza_id', 'orders.order_time' )
            ->paginate( 5 );

        return view( 'admin.order.list' )->with( array( 'order' => $searchData ) );
    }
}
