<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $table = 'metadata';

    public function Certificate()
    {
        return $this->hasMany(Certificate::class, 'media_id');
    }

    public function QuoteComparison()
    {
        return $this->belongsToMany(QuoteComparison::class, 'quoatation_comparison_media_table', 'metadata_id', 'quote_comparison_id');
    }

    public function PaymentCharged()
    {
        return $this->belongsToMany(PaymentCharged::class, 'payment_charged_media_table', 'metadata_id', 'payment_charged_id');
    }

    public function ProductMedia()
    {
        return $this->belongsToMany(ProductMedia::class, 'product_media_table', 'metadata_id', 'quotation_product_id');
    }

    public function PolicyDetail()
    {
        return $this->hasOne(PolicyDetail::class, 'media_id');
    }

    public function lead()
    {
        return $this->belongsToMany(Lead::class, 'lead_media_table', 'metadata_id', 'lead_id');
    }

    public function auditInformation()
    {
        return $this->hasOne(AuditInformation::class, 'audit_letter_id');
    }

    public function auditRequiredFile()
    {
        return $this->belongsToMany(AuditInformation::class, 'audit_required_file', 'media_id', 'audit_information_id');
    }

    public function reaccuringMedia()
    {
        return $this->belongsToMany(FinancingAgreement::class, 'recurring_ach_media', 'media_id', 'financing_aggreement_id');
    }

    // PDF User Files
    public function pdfUserFiles()
    {
        return $this->belongsToMany(Metadata::class, 'pdffiller_users_files_table', 'media_id', 'user_profile_id');
    }

    // PDF Template Files
    public function pdfTemplateFiles() {
        return $this->hasOne(Metadata::class, 'media_id');
    }
}