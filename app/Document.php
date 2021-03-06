<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'type', 'original_name', 'description', 'created_at'
    ];

    public function getMovement()
    {
        return Movement::where('document_id', $this->id)->firstOrFail();
    }

    public $timestamps = false;
}
