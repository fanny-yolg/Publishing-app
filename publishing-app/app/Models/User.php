<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Helpers\Crud;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Post::class, 'id', 'user_id');
    }

    public function findOne($id)
    {
        return Crud::findOne($this, 'id', $id);
    }

    public function store(Array $data)
    {        
        return Crud::save($this, $data);
    }
     
    public function patch(Array $data, $id)
    {
        return Crud::update($this, $data, 'id', $id);
    }

    public function remove($id)
    {
        return Crud::deleteOne($this, 'id', $id);
    }

}
