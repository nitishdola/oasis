<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\softDeletes;
class Videos extends Model
{
    use HasFactory;
    use Uuids;
    protected $guarded=['id','token'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function episode(){
        return $this->belongsTo("App\Models\Master\Episode");
    }
}
