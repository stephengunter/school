<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;


class CheckAdmin
{
    protected $user;

    public function getAdmin() {
        return   $this->user->admin;
    }
    public function currentUser() {
        return   $this->user;
    }
   

    public function handle($request, Closure $next)
    {
        $user=request()->user();
        if(!$user){
           throw new AuthenticationException();
        }  
        if(!$user->isAdmin()){
            throw new AuthenticationException();
        }
        // if(!$user->email_confirmed){
        //     $email=$user->email;
        //     auth()->logout();
        //     throw new EmailUnconfirmed($email);
        // }

        // $user->admin->centers;
        $this->user=$user;
       
        return $next($request);
    }

    
}
