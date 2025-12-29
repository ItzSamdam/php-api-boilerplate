<?php

require_once __DIR__ . '/../models/BaseModel.php';

class User extends BaseModel
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'token_version'];

    // Custom finder: by email
    public function findByEmail($email)
    {
        return $this->where('email', '=', $email)->first();
    }

    // // Example relationship: User has many Orders
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'user_id');
    // }
}
