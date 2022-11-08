<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Crud;

class Post extends Model
{
    protected $table = 'posts';

    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 
        'body', 
        'user_id'
    ];

    /**
     * Relation to User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Relation to User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
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
