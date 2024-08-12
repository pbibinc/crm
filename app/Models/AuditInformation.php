<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditInformation extends Model
{
    use HasFactory;

    protected $table = 'audit_information_table';

    protected $fillable = [
        'policy_details-id',
        'audit_letter_id',
        'processed_by',
        'status'
    ];

    public function policyDetail()
    {
        return $this->belongsTo(PolicyDetail::class, 'policy_details_id');
    }

    public function media()
    {
        return $this->belongsTo(Metadata::class, 'audit_letter_id');
    }

    public function requiredFiles()
    {
        return $this->belongsToMany(Metadata::class, 'audit_required_file', 'audit_information_id', 'media_id');
    }

    public function UserProfile()
    {
        return $this->belongsTo(UserProfile::class, 'processed_by');
    }

    public static function getAuditInformationByLeadId($leadId)
    {
        $policyDetail = new PolicyDetail();
        $policies = $policyDetail->getPolicyDetailByLeadId($leadId);
        $auditInformation = [];
        foreach ($policies as $policy) {
            $auditInfo = self::where('policy_details_id', $policy->id)->first();
            if ($auditInfo) {
                $auditInformation[] = $auditInfo;
            }
        }
        return $auditInformation;
    }

}
