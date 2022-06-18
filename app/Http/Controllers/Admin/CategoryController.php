<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {

    //direct category page
    public function category() {

        if ( Session::has( 'CATEGORY_SEARCH' ) ) {
            Session::forget( 'CATEGORY_SEARCH' );
        }

        $data = Category::select( DB::raw( 'count(pizzas.category_id) as counts' ), 'categories.category_id', 'categories.category_name', )
            ->leftJoin( 'pizzas', 'pizzas.category_id', 'categories.category_id' )
            ->groupBy( 'categories.category_id', 'categories.category_name', )
            ->paginate( 3 );

        return view( 'admin.category.list' )->with( array( 'category' => $data ) );
    }

    //direct add category page
    public function addCategory() {
        return view( 'admin.category.addCategory' );
    }

    //crate and add to database category list
    public function createCategory( Request $request ) {

        $validator = Validator::make( $request->all(), array(
            'categoryName' => 'required',
        ), array(
            'categoryName.required' => 'Need to fills Category Name',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $data = array(
            'category_name' => $request->categoryName,
        );

        Category::create( $data );
        return redirect()->route( 'admin#category' )->with( array( 'add' => 'Category Added..' ) );
    }

    //category data delete
    public function deleteCategory( $id ) {
        $name = Category::where( 'category_id', $id )->first();
        Category::where( 'category_id', $id )->delete();
        return back()->with( array( 'deleteSuccess' => $name->category_name . ' is deleted!' ) );
    }

    //direct category edit page
    public function editCategory( $id ) {
        $data = Category::where( 'category_id', $id )->first();
        return view( 'admin.category.editCategory' )->with( array( 'category' => $data ) );
    }

    //update category data
    public function updateCategory( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'categoryName' => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $oldname = Category::where( 'category_id', $request->id )->first();

        $updateData = array(
            'category_name' => $request->categoryName,
        );

        Category::where( 'category_id', $request->id )->update( $updateData );
        return redirect()->route( 'admin#category' )->with( array( 'updateSuccess1' => $oldname->category_name, 'updateSuccess2' => ' is updated to ', 'updateSuccess3' => $request->categoryName ) );
    }

    //search data
    public function searchData( Request $request ) {
        $data = Category::select( DB::raw( 'count(pizzas.category_id) as counts' ), 'categories.category_id', 'categories.category_name', )
            ->leftJoin( 'pizzas', 'pizzas.category_id', 'categories.category_id' )
            ->groupBy( 'categories.category_id', 'categories.category_name', )
            ->where( 'category_name', 'like', '%' . $request->searchData . '%' )->paginate( 3 );
        $data->appends( $request->all() );

        Session::put( 'CATEGORY_SEARCH', $request->searchData );

        if ( $data->count() >= 1 ) {
            return view( 'admin.category.list' )->with( array( 'category' => $data ) );
        } else {
            return view( 'admin.category.list' )->with( array( 'category' => $data ) )
                ->withErrors( array( 'errorMessage' => 'Your Search Category does not exist' ) );
        }

    }

    //category count item list
    public function categroyItem( $id ) {

        $data = Pizza::select( 'pizzas.*', 'categories.category_name' )
            ->join( 'categories', 'categories.category_id', 'pizzas.category_id' )
            ->where( 'pizzas.category_id', $id )
            ->paginate( 5 );

        return view( 'admin.category.categoryItem' )->with( array( 'categoryItem' => $data ) );
    }

    public function downloadCategory() {

        if ( Session::has( 'CATEGORY_SEARCH' ) ) {
            $categorys = Category::select( DB::raw( 'count(pizzas.category_id) as counts' ), 'categories.category_id', 'categories.category_name', )
                ->leftJoin( 'pizzas', 'pizzas.category_id', 'categories.category_id' )
                ->groupBy( 'categories.category_id', 'categories.category_name', )
                ->where( 'category_name', 'like', '%' . Session::get( 'CATEGORY_SEARCH' ) . '%' )
                ->get();
        } else {
            $categorys = Category::select( DB::raw( 'count(pizzas.category_id) as counts' ), 'categories.category_id', 'categories.category_name', )
                ->leftJoin( 'pizzas', 'pizzas.category_id', 'categories.category_id' )
                ->groupBy( 'categories.category_id', 'categories.category_name', )
                ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach( function ( $category ) {
            $category->created_at = Carbon::parse( $category->created_at )->format( 'Y-m-d H:i:s' );
            $category->updated_at = Carbon::parse( $category->updated_at )->format( 'Y-m-d H:i:s' );
        } );

        $csvExporter->build( $categorys, array(
            'category_id'   => 'ID',
            'category_name' => 'Category Name',
            'counts'        => 'Category Count',
            'created_at'    => 'Created at',
            'updated_at'    => 'Updated at',
        ) );

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM( \League\Csv\Reader::BOM_UTF8 );

        $filename = 'categoryList.csv';

        return response( (string) $csvReader )
            ->header( 'Content-Type', 'text/csv; charset=UTF-8' )
            ->header( 'Content-Disposition', 'attachment; filename="' . $filename . '"' );
    }

}
