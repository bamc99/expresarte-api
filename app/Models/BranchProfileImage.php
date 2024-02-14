<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'attachment_id',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
