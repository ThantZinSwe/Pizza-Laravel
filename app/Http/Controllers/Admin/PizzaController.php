<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller {

    //direct pizza list page
    public function pizzaList() {

        if ( Session::has( 'PIZZA_SEARCH' ) ) {
            Session::forget( 'PIZZA_SEARCH' );
        }

        $data = Pizza::paginate( 5 );

        if ( count( $data ) == 0 ) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }

        return view( 'admin.pizza.list' )->with( array( 'pizza' => $data, 'status' => $emptyStatus ) );
    }

    //direct create pizza page
    public function createPizza() {
        $data = Category::get();
        return view( 'admin.pizza.createPizza' )->with( array( 'category' => $data ) );
    }

    //insert pizza
    public function insertPizza( Request $request ) {

        $validator = Validator::make( $request->all(), array(
            'name'          => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'publishStatus' => 'required',
            'categoryId'    => 'required',
            'discount'      => 'required',
            'buyOneGetOne'  => 'required',
            'waitingTime'   => 'required',
            'description'   => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $file = $request->file( 'image' );
        $flieName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move( public_path() . '/uploads/', $flieName );

        $data = $this->pizzaData( $request, $flieName );
        Pizza::Create( $data );
        return redirect()->route( 'admin#pizzaList' )->with( array( 'insertSuccess' => 'One new Pizza added...' ) );
    }

    //delete pizza
    public function deletePizza( $id ) {
        $deleteItem = Pizza::select( 'pizza_name', 'image' )->where( 'pizza_id', $id )->first();
        $flieName = $deleteItem->image;
        Pizza::where( 'pizza_id', $id )->delete();

        if ( File::exists( public_path() . '/uploads/' . $flieName ) ) {
            File::delete( public_path() . '/uploads/' . $flieName );
        }

        return back()->with( array( 'deleteSuccess1' => $deleteItem->pizza_name, 'deleteSuccess2' => ' deletes success...' ) );
    }

    //pizza information page
    public function infoPizza( $id ) {
        $data = Pizza::select( 'pizzas.*', 'categories.category_name' )
            ->join( 'categories', 'categories.category_id', 'pizzas.category_id' )
            ->where( 'pizza_id', $id )
            ->first();
        return view( 'admin.pizza.infoPizza' )->with( array( 'pizza' => $data ) );
    }

    public function editPizza( $id ) {
        $category = Category::get();
        $data = Pizza::select( 'pizzas.*', 'categories.category_name' )
            ->join( 'categories', 'pizzas.category_id', 'categories.category_id' )
            ->where( 'pizza_id', $id )
            ->first();
        return view( 'admin.pizza.editPizza' )->with( array( 'pizza' => $data, 'category' => $category ) );
    }

    //update pizza data and image
    public function updatePizza( $id, Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name'          => 'required',
            'price'         => 'required',
            'publishStatus' => 'required',
            'categoryId'    => 'required',
            'discount'      => 'required',
            'buyOneGetOne'  => 'required',
            'waitingTime'   => 'required',
            'description'   => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $updateData = $this->requestUpdatePizzaData( $request );

        if ( isset( $updateData['image'] ) ) {

            //request old image at database
            $deleteItem = Pizza::select( 'image' )->where( 'pizza_id', $id )->first();
            $flieName = $deleteItem->image;

// delete old image at uploads folder
            if ( File::exists( public_path() . '/uploads/' . $flieName ) ) {
                File::delete( public_path() . '/uploads/' . $flieName );
            }

            //add new image at uploads folder
            $file = $request->file( 'image' );
            $flieNames = uniqid() . '_' . $file->getClientOriginalName();
            $file->move( public_path() . '/uploads/', $flieNames );

            //only file name store for database(make override)!important
            $updateData['image'] = $flieNames;
        }

        Pizza::where( 'pizza_id', $id )->update( $updateData );
        return redirect()->route( 'admin#pizzaList' )->with( array( 'updateSuccess' => "Pizza update Success..." ) );

    }

    //search data
    public function searchData( Request $request ) {
        $searchData = Pizza::orWhere( 'pizza_name', 'like', '%' . $request->tableSearch . '%' )
            ->orWhere( 'price', $request->tableSearch )
            ->paginate( 5 );
        $searchData->appends( $request->all() );

        Session::put( 'PIZZA_SEARCH', $request->tableSearch );

        if ( count( $searchData ) == 0 ) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }

        return view( 'admin.pizza.list' )->with( array( 'pizza' => $searchData, 'status' => $emptyStatus ) );
    }

    public function downloadPizzaList() {

        if ( Session::has( 'PIZZA_SEARCH' ) ) {

            $pizzas = Pizza::select( 'pizzas.*', 'categories.category_name' )
                ->join( 'categories', 'categories.category_id', 'pizzas.category_id' )
                ->orWhere( 'pizza_name', 'like', '%' . Session::get( 'PIZZA_SEARCH' ) . '%' )
                ->orWhere( 'price', Session::get( 'PIZZA_SEARCH' ) )
                ->get();

        } else {
            $pizzas = Pizza::select( 'pizzas.*', 'categories.category_name' )
                ->join( 'categories', 'categories.category_id', 'pizzas.category_id' )
                ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach( function ( $pizza ) {
            $pizza->created_at = Carbon::parse( $pizza->created_at )->format( 'Y-m-d H:i:s' );
            $pizza->updated_at = Carbon::parse( $pizza->updated_at )->format( 'Y-m-d H:i:s' );
            $pizza->price = $pizza->price . " Kyats";

            if ( $pizza->publish_status == 1 ) {
                $pizza->publish_status = "Publish";
            } else {
                $pizza->publish_status = "Unpublish";
            }

            if ( $pizza->buy_one_get_one_status == 1 ) {
                $pizza->buy_one_get_one_status = "Yes";
            } else {
                $pizza->buy_one_get_one_status = "No";
            }

        } );

        $csvExporter->build( $pizzas, array(
            'pizza_id'               => 'ID',
            'pizza_name'             => 'Pizza Name',
            'category_name'          => 'Category Name',
            'price'                  => 'Price',
            'publish_status'         => 'Publish Status',
            'buy_one_get_one_status' => 'Buy 1 Get 1',
            'created_at'             => 'Created at',
            'updated_at'             => 'Updated at',
        ) );

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM( \League\Csv\Reader::BOM_UTF8 );

        $filename = 'PizzaList.csv';

        return response( (string) $csvReader )
            ->header( 'Content-Type', 'text/csv; charset=UTF-8' )
            ->header( 'Content-Disposition', 'attachment; filename="' . $filename . '"' );

    }

    //get data for update data
    private function requestUpdatePizzaData( $request ) {
        $data = array(
            'pizza_name'             => $request->name,
            'price'                  => $request->price,
            'publish_status'         => $request->publishStatus,
            'category_id'            => $request->categoryId,
            'discount_price'         => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time'           => $request->waitingTime,
            'description'            => $request->description,
        );

        if ( isset( $request->image ) ) {
            $data['image'] = $request->image;
        }

        return $data;

    }

    //user pizza data store database
    private function pizzaData( $request, $flieName ) {
        return array(
            'pizza_name'             => $request->name,
            'image'                  => $flieName,
            'price'                  => $request->price,
            'publish_status'         => $request->publishStatus,
            'category_id'            => $request->categoryId,
            'discount_price'         => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time'           => $request->waitingTime,
            'description'            => $request->description,
        );
    }

}
