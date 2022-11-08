<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Crud;

class Comment extends Model
{
    protected $table = 'comments';

    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'user_id', 
        'post_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
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
