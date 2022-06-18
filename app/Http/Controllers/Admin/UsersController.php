<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

    //direct user list
    public function userList() {
        $userData = User::where( 'role', 'user' )->paginate( 7 );
        return view( 'admin.user.userList' )->with( array( 'user' => $userData ) );
    }

    //search user list data
    public function userSearch( Request $request ) {
        $searchUserData = $this->search( $request, 'user' );
        return view( 'admin.user.userList' )->with( array( 'user' => $searchUserData ) );
    }

    //delete user data
    public function deleteUserAndAdmin( $id ) {
        User::where( 'id', $id )->delete();
        return back()->with( array( 'deleteSuccess' => 'Data delete success...' ) );
    }

    //direct admin list
    public function adminList() {
        $adminData = User::where( 'role', 'admin' )->paginate( 7 );
        return view( 'admin.user.adminList' )->with( array( 'admin' => $adminData ) );
    }

    public function adminSearch( Request $request ) {
        $searchAdminData = $this->search( $request, 'admin' );
        return view( 'admin.user.adminList' )->with( array( 'admin' => $searchAdminData ) );
    }

    //search data
    private function search( $request, $role ) {
        $searchData = User::where( 'role', $role )
            ->where( function ( $query ) use ( $request ) {
                $query->orwhere( 'name', 'like', '%' . $request->searchData . '%' )
                    ->orwhere( 'email', 'like', '%' . $request->searchData . '%' )
                    ->orwhere( 'phone', 'like', '%' . $request->searchData . '%' )
                    ->orwhere( 'address', 'like', '%' . $request->searchData . '%' );
            } )
            ->paginate( 7 );
        $searchData->appends( $request->all() );
        return $searchData;
    }

}
