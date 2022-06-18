<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller {

    //create contact
    public function createContact( Request $request ) {

        $validator = Validator::make( $request->all(), array(
            'name'    => 'required',
            'email'   => 'required',
            'message' => 'required',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $data = $this->userData( $request );
        Contact::create( $data );

        return back()->with( array( 'createSuccess' => 'Message send success...' ) );
    }

    //admin dashboard contact list view
    public function contactList() {

        $data = Contact::orderBy( 'contact_id', 'desc' )
            ->paginate( 5 );

        if ( count( $data ) == 0 ) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }

        return view( 'admin.contact.list' )->with( array( 'contact' => $data, 'status' => $emptyStatus ) );
    }

    public function contactSearch( Request $request ) {
        $searchData = Contact::orderBy( 'contact_id', 'desc' )
            ->where( 'contact_id', 'like', '%' . $request->searchData . '%' )
            ->orwhere( 'name', 'like', '%' . $request->searchData . '%' )
            ->orwhere( 'email', 'like', '%' . $request->searchData . '%' )
            ->orwhere( 'message', 'like', '%' . $request->searchData . '%' )
            ->paginate( 5 );

        $searchData->appends( $request->all() );

        if ( count( $searchData ) == 0 ) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }

        return view( 'admin.contact.list' )->with( array( 'contact' => $searchData, 'status' => $emptyStatus ) );
    }

    //request user data
    private function userData( $request ) {
        return array(
            'user_id' => auth()->user()->id,
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        );
    }

}
