<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers {
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create( array $input ) {
        Validator::make( $input, array(
            'name'     => array( 'required', 'string', 'max:255' ),
            'email'    => array( 'required', 'string', 'email', 'max:255', 'unique:users' ),
            'address'  => array( 'required' ),
            'phone'    => array( 'required', 'max:20' ),
            'password' => $this->passwordRules(),
            'terms'    => Jetstream::hasTermsAndPrivacyPolicyFeature() ? array( 'required', 'accepted' ) : '',
        ) )->validate();

        return User::create( array(
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make( $input['password'] ),
            'address'  => $input['address'],
            'phone'    => $input['phone'],
        ) );
    }
}
