<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function files(){
        return $this->hasMany('App\File', 'owner');
    }

    public function sharedFiles(){
        return $this->hasMany('App\Share', 'idUser');
    }

    public function groupMemberships(){
        return $this->hasMany('App\Member', 'idMember');
    }

    public function ownedGroups(){
        return $this->hasMany('App\Group', 'idOwner');
    }

    public function sharedWithMe(){


        $fileArray = $this->sharedWithUser($this);
        
        foreach ( $this->groupMemberships()->get() as $membership ) {
            $user = $membership->group()->first()->representativeUser()->first();
            $fileArray = array_merge ( $fileArray, $this->sharedWithUser($user) );
        }

        $filtered = [];
        $count = count($fileArray);

        for($i = 0; $i < $count; $i++){

            $found = false;

            for($j = $i + 1; $j < $count; $j++ ){
                if($fileArray[$i]->id == $fileArray[$j]->id){
                    $found = true;
                    break;
                }
            }

            if(!$found){
                array_push($filtered, $fileArray[$i]);
            }

        }

        return $filtered;
    }

    private function sharedWithUser($user){

        $sharedWithMe = Share::where('idUser', $user->id)->where( function($query){ 
            $query->where('dueDate', null)->orWhere('dueDate', '>', Carbon::now() );
        } )->get();
        
        $fileArray = [];

        foreach ($sharedWithMe as $currentShare) {
            $file = $currentShare->file()->first();

            if($file)
                array_push($fileArray, $file);
        }

        return $fileArray;
    }


}
