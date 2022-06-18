<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    //driect admin profile page
    public function profile() {
        $id = auth()->user()->id;
        $userData = User::where( 'id', $id )->get();
        return view( 'admin.profile.index' )->with( array( 'user' => $userData ) );
    }

    public function updateAdminProfile( $id, Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name'    => 'required',
            'email'   => 'required',
            'address' => 'required',
            'phone'   => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $updateData = $this->userData( $request );
        User::where( 'id', $id )->update( $updateData );
        return back()->with( array( 'updateSuccess' => 'Data Update Success!' ) );

    }

    public function changePasswordPage() {
        return view( 'admin.profile.changePassword' );
    }

    public function changePassword( $id, Request $request ) {

        $validator = Validator::make( $request->all(), array(
            'currentPassword' => array( 'required', function ( $attribute, $value, $fail ) {

                if ( !Hash::check( $value, Auth()->user()->password ) ) {
                    $fail( 'Your current password is wrong...Try again!' );
                }

            },
            ),
            'newPassword'     => 'required|min:8|max:30',
            'confirmPassword' => 'required|min:8|max:30|same:newPassword',
        ), array(
            'currentPassword.required' => 'Enter current password',
            'currentPassword.min'      => 'Current password must have at least 8 characters',
            'currentPassword.max'      => 'Current password must not have greater than 30 characters',
            'newPassword.required'     => 'Enter new password',
            'newPassword.min'          => 'New password must have at least 8 characters',
            'newPassword.max'          => 'New password must not have greater than 30 characters',
            'confirmPassword.required' => 'Enter confirm password',
            'confirmPassword.min'      => 'Confirm password must have at least 8 characters',
            'confirmPassword.max'      => 'Confirm password must not have greater than 30 characters',
            'confirmPassword.same'     => 'Confirm password must be same new password',

        ) );

        if ( $validator->fails() ) {
            return redirect()->back()
                ->withErrors( $validator )
                ->withInput();
        } else {
            User::where( 'id', $id )->update( array( 'password' => Hash::make( $request->newPassword ) ) );
            return redirect()->back()->with( array( 'success' => 'Password change success...' ) );
        }

    }

    private function userData( $request ) {
        return array(
            'name'    => $request->name,
            'email'   => $request->email,
            'address' => $request->address,
            'phone'   => $request->phone,
        );
    }

}
