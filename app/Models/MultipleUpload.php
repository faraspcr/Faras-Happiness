<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MultipleUpload extends Model
{
    use HasFactory;


    protected $table = 'multipleuploads';
    protected $primaryKey = 'id';


    protected $fillable = [
        'filename',
        'original_name',
        'ref_table',
        'ref_id',
        'created_at',
        'updated_at'
    ];


    // Relationship ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ref_id', 'pelanggan_id')
                    ->where('ref_table', 'pelanggan');
    }
}



