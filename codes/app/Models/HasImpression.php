<?php
namespace App\Models;
trait HasImpression {
    public function users(){
        return $this->belongsToMany(User::class, 'user_product_impressions');
    }
    public function ifHasUser($user_id){
        return $this->users->contains(User::find($user_id));
    }

    public function attachUser($user_id){
        if(!$this->ifHasUser($user_id)){
            return $this->users()->attach($user_id);
        }
    }

    public function detachUser($user_id){
        if($this->ifHasUser($user_id)){
            return $this->users()->detach($user_id);
        }
    }
}