<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFillerTemplateFiles extends Model
{
    use HasFactory;
    protected $table = "pdffiller_templates_files_table";
    protected $guarded = [];

    public function media() {
        return $this->belongsTo(Metadata::class, 'media_id');
    }

    public function uploadedBy() {
        return $this->belongsTo(UserProfile::class, 'uploaded_by');
    }
}
