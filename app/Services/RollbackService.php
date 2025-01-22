<?php
namespace App\Services;

use App\Models\Lead;
use App\Models\GeneralInformation;
use App\Models\GeneralLiabilities;
use App\Models\LeadNotes;
use App\Models\QuotationProduct;
use App\Models\QuoteComparison;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RollbackService
{
    public function rollback($data)
    {
        try {
            switch ($data['rollback-api']) {
                case 'general-information':
                    $this->rollbackGeneralInformation($data['lead_id']);
                    break;
                case 'general-liabilities':
                    $this->rollbackGeneralLiabilities($data['lead_id']);
                    break;
                case 'quote-comparison':
                    $this->rollbackQuote($data['lead_id']);
                    break;
                case 'note-log':
                    $this->rollbackQuote($data['lead_id']);
                    break;
                default:
                    throw new Exception('Unknown rollback API type');
            }
            return ['success' => true, 'message' => 'Database commit successfully',
                ];
        } catch (Exception $e) {

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function rollbackGeneralInformation($leadId)
    {

        $lead = Lead::find($leadId);
        if ($lead) {
            $lead->delete();
        }
    }

    protected function rollbackGeneralLiabilities($leadId)
    {
        $lead = Lead::find($leadId);
        if ($lead) {
            $generalInformation = GeneralInformation::where('leads_id', $lead->id)->first();
            if ($lead->quoteLead && $lead->quoteLead->QuoteInformation) {
                $lead->quoteLead->QuoteInformation->delete();
            }
            if ($lead->quoteLead) {
                $lead->quoteLead->delete();
            }
            if ($generalInformation) {
                $generalInformation->delete();
            }
            $lead->delete();
        }
    }

    protected function rollbackQuote($leadId)
    {
        $lead = Lead::find($leadId);
        if ($lead) {
            $quotationProducts = QuotationProduct::where('quote_information_id', $lead->quoteLead->QuoteInformation->id)->get();
            if($quotationProducts){
                foreach($quotationProducts as $product){
                    $product->QuoteComparison()->delete();
                    $quoteComparisons = QuoteComparison::whecre('quotation_product_id', $product->id)->get();
                    if($quoteComparisons){
                        foreach($quoteComparisons as $comparison){
                            $comparison->media()->detach();
                            $comparison->delete();
                        }
                    }
                    if($product->product == 'General Liability'){
                        $generalLiab = GeneralLiabilities::where('general_information_id', $lead->GeneralInformation->id)->first();
                        if($generalLiab){
                            $generalLiab->delete();
                        }
                    }
                }
                $lead->quoteLead->QuoteInformation->QuotationProduct()->delete();
            }
            if ($lead->quoteLead && $lead->quoteLead->QuoteInformation) {
                $lead->quoteLead->QuoteInformation->delete();
            }
            if ($lead->quoteLead) {
                $lead->quoteLead->delete();
            }

            $lead->GeneralInformation->delete();
            $lead->delete();
        }
    }

}
?>