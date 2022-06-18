<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    //user pizza index
    public function index() {

        $data = Pizza::where( 'publish_status', 1 )->paginate( 9 );

        $category = Category::get();

        return view( 'user.home' )->with( array( 'pizza' => $data, 'category' => $category ) );
    }

    //pizza details
    public function pizzaDetails( $id ) {

        $data = Pizza::select( 'pizzas.*', 'categories.category_name' )
            ->join( 'categories', 'categories.category_id', 'pizzas.category_id' )
            ->where( 'pizza_id', $id )
            ->first();

        Session::put( 'PIZZA_ORDER', $data );

        return view( 'user.pizzaDetails' )->with( array( 'pizzaDetails' => $data ) );
    }

    //pizza category
    public function pizzaCategory( $id ) {

        $data = Pizza::where( 'category_id', $id )
            ->where( function ( $query ) {
                $query->where( 'publish_status', 1 );
            } )
            ->paginate( 9 );

        $category = Category::get();

        return view( 'user.home' )->with( array( 'pizza' => $data, 'category' => $category ) );
    }

    //pizza category search
    public function pizzaSearh( Request $request ) {
        $searchData = Pizza::where( 'pizza_name', 'like', '%' . $request->searchItem . '%' )
            ->paginate( 9 );
        $searchData->appends( $request->all() );

        $category = Category::get();

        return view( 'user.home' )->with( array( 'pizza' => $searchData, 'category' => $category ) );
    }

    //search pizza with price and date
    public function pizzaItemSearch( Request $request ) {
        $min = $request->miniPrice;
        $max = $request->maxPrice;
        $start = $request->startDate;
        $end = $request->endDate;

        $query = Pizza::select( '*' );

        if ( !is_null( $start ) && is_null( $end ) ) {
            $query = $query->whereDate( 'created_at', '>=', $start );

        } elseif ( is_null( $start ) && !is_null( $end ) ) {
            $query = $query->whereDate( 'created_at', '<=', $end );

        } elseif ( !is_null( $start ) && !is_null( $end ) ) {
            $query = $query->whereDate( 'created_at', '>=', $start )
                ->whereDate( 'created_at', '<=', $end );
        }

        if ( !is_null( $min ) && is_null( $max ) ) {
            $query = $query->where( 'price', '>=', $min );

        } elseif ( is_null( $min ) && !is_null( $max ) ) {
            $query = $query->where( 'price', '<=', $max );

        } elseif ( !is_null( $min ) && !is_null( $max ) ) {
            $query = $query->where( 'price', '>=', $min )
                ->where( 'price', '<=', $max );
        }

        $query = $query->paginate( 9 );
        $query->appends( $request->all() );

        $category = Category::get();

        return view( 'user.home' )->with( array( 'pizza' => $query, 'category' => $category ) );
    }

    public function order() {

        $orderData = Session::get( 'PIZZA_ORDER' );

        return view( 'user.pizzaOrder' )->with( array( 'order' => $orderData ) );
    }

    public function placeOrder( Request $request ) {

        $validator = Validator::make( $request->all(), array(
            'pizzaQty'    => 'required',
            'paymentType' => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $orderData = Session::get( 'PIZZA_ORDER' );
        $userId = auth()->user()->id;
        $totalTime = $orderData['waiting_time'] * $request->pizzaQty;
        $totalPrice = ( $orderData['price'] - $orderData['discount_price'] ) * $request->pizzaQty;

        $placeOrder = $this->requestOrderData( $request, $orderData, $userId );

        for ( $i = 0; $i < $request->pizzaQty; $i++ ) {
            Order::create( $placeOrder );
        }

        return back()->with( array( 'waitingTime' => $totalTime, 'totalPrice' => $totalPrice ) );

    }

    private function requestOrderData( $request, $orderData, $userId ) {
        return array(
            'customer_id'    => $userId,
            'pizza_id'       => $orderData['pizza_id'],
            'carrier_id'     => 0,
            'payment_status' => $request->paymentType,
            'order_time'     => Carbon::now()->format( 'Y-m-d H:i:s' ),
            'count'          => 0,
            'total_price'    => 0,
        );
    }

}
