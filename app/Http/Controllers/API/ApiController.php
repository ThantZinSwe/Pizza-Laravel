<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class ApiController extends Controller {

    public function categoryList() {

        $category = Category::get();

        return Response::json( array( 'status' => 200, 'message' => 'success', 'data' => $category ) );

    }

    public function categoryCreate( Request $request ) {

        $data = array(
            'category_name' => $request->categoryName,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        );

        Category::create( $data );

        return Response::json( array( 'status' => 200, 'message' => 'success' ) );
    }

    public function categoryDetails( Request $request ) {

        $data = Category::where( 'category_id', $request->id )->first();

        if ( empty( $data ) ) {
            return Response::json( array( 'status' => 200, 'message' => 'fail', 'data' => $data ) );
        }

        return Response::json( array( 'status' => 200, 'message' => 'success', 'data' => $data ) );

    }

    public function categoryDelete( $id ) {

        $data = Category::where( 'category_id', $id )->first();

        if ( empty( $data ) ) {
            return Response::json( array( 'status' => 200, 'message' => 'data not found' ) );
        }

        Category::where( 'category_id', $id )->delete();
        return Response::json( array( 'status' => 200, 'message' => 'delete success' ) );

    }

    public function categoryUpdate( Request $request ) {

        $updateData = array(
            'category_id'   => $request->id,
            'category_name' => $request->categoryName,
        );

        $data = Category::where( 'category_id', $request->id )->first();

        if ( empty( $data ) ) {
            return Response::json( array( 'status' => 200, 'message' => 'data not found' ) );
        }

        Category::where( 'category_id', $request->id )->update( $updateData );
        return Response::json( array( 'status' => 200, 'message' => 'update success' ) );

    }

}
