<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Emadadly\LaravelUuid\Uuids;
class Episode extends Model
{
    use HasFactory;
    use softDeletes;
    use Uuids;
    protected $guarded=['id','token'];

    public function category(){
        return $this->belongsTo("App\Models\Master\Category","category_id");
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
