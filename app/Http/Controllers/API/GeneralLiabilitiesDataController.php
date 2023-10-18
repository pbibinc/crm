<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CarpentryWoodworking;
use App\Models\ClassCodePercentage;
use App\Models\ClassCodeQuestionare;
use App\Models\CoverageLimit;
use App\Models\GeneralInformation;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesRecreationalFacilities;
use App\Models\MultipleState;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\Subcontractor;
use Carbon\Carbon;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneralLiabilitiesDataController extends BaseController
{

    public function saveGeneralLiabilities(Request $request)
    {
        $data = $request->all();
        try{


              //Saving general liabilities coverage limit
              $coverageLimit = new CoverageLimit();
              $coverageLimit->limit = $data['limit'];
              $coverageLimit->medical = $data['medical'];
              $coverageLimit->fire_damage = $data['fire_damage'];
              $coverageLimit->deductible = $data['deductible'];
              $coverageLimit->save();

              $coverageLimitId = $coverageLimit->id;


              //

               $generalInformationId = GeneralInformation::where('leads_id', $data['leadId'])->value('id');
               $expirationOfGeneralLiabilitiesRaw =  Carbon::parse($data['expiration_general_liability'])->toDateString();


              //saving general liabilities common data
               $generalLiabilities = new GeneralLiabilities();
               $generalLiabilities->general_information_id = $generalInformationId;
               $generalLiabilities->business_description = $data['business_description'];
               $generalLiabilities->residential = $data['residential_percentage'];
               $generalLiabilities->commercial = $data['commercial_percentage'];
               $generalLiabilities->new_construction = $data['construction_percentage'];
               $generalLiabilities->repair = $data['repair_remodel_percentage'];
               $generalLiabilities->self_perform_roofing = $data['self_performing_roofing'];
               $generalLiabilities->concrete_foundation_work = $data['concrete_foundation_work'];
               $generalLiabilities->perform_track_work = $data['perform_tract_work'];
               $generalLiabilities->is_condo_townhouse = $data['work_on_condominium'];
               $generalLiabilities->perform_multi_dwelling = $data['perform_remodelling_work'];
               $generalLiabilities->business_entity = $data['business_entity'];
               $generalLiabilities->years_in_business = $data['years_in_business'];
               $generalLiabilities->years_in_professional = $data['years_in_profession'];
               $generalLiabilities->largest_project = $data['largest_project'];
               $generalLiabilities->largest_project_amount = $data['largest_project_amount'];
               $generalLiabilities->contract_license = $data['contact_license'];
               $generalLiabilities->contract_license_name = $data['contact_license_name'];
               $generalLiabilities->is_office_home = $data['is_office_home'];
               $generalLiabilities->expiration_of_general_liabilities = $expirationOfGeneralLiabilitiesRaw;
               $generalLiabilities->policy_premium = $data['policy_premium'];
               $generalLiabilities->coverage_limit_id = $coverageLimitId;
               $generalLiabilities->cross_sell = $data['cross_sell'];
               $generalLiabilities->save();

               $generalLiabilitiId = $generalLiabilities->id;

               $quoteProduct = new QuotationProduct();
               $leadId = $data['leadId'];
               $quoteInformation = QuoteInformation::getInformationByLeadId($leadId);
               if($quoteInformation){
                   $quoteProduct->quote_information_id = $quoteInformation->id;
               }
               $quoteProduct->product = 'General Liabilities';
               $quoteProduct->status = 2;
               $quoteProduct->save();

               //saving general liabilities subcontract
               $subcontractor = new Subcontractor();
               $subcontractor->general_liabilities_id = $generalLiabilitiId;
               $subcontractor->blasting_operation = $data['blasting_operation'];
               $subcontractor->hazardous_waste = $data['hazardous_waste'];
               $subcontractor->asbestos_mold = $data['asbestos_mold'];
               $subcontractor->three_stories_height = $data['tall_building'];
               $subcontractor->save();

            //saving general liabilities recreational facilities
            foreach($data['recreational_facilities'] as $recreationalFacility){
                $recreationalFacilitiesGeneralLiabilities = new GeneralLiabilitiesRecreationalFacilities();
                $recreationalFacilitiesGeneralLiabilities->general_liabilities_id = $generalLiabilitiId;
                $recreationalFacilitiesGeneralLiabilities->recreational_facilities_id = $recreationalFacility;
                $recreationalFacilitiesGeneralLiabilities->save();
            }
            //saving multiple ClassCode
            $mergedMultipleClassCode = array_map(function ($classCode, $percentage) {
                return['classCode' => $classCode, 'percentage' => $percentage];
            }, $data['classcCode'], $data['classcode_percentage']);

            foreach($mergedMultipleClassCode as $multipleClassCode){
                $classCodePercentage = new ClassCodePercentage();
                $classCodePercentage->general_liabilities_id = $generalLiabilitiId;
                $classCodePercentage->classcode_id = (int)$multipleClassCode['classCode'];
                $classCodePercentage->percentage = (int)$multipleClassCode['percentage'];
                $classCodePercentage->save();
            }

            //saving for Classcode questionare
            $classCodeAnswers = $data['classCodeAnswer']; // Assuming this is an array
            $classCodeQuestions = $data['classCodeQuestion']; // Assuming this is an array

            $flattenedAnswers = collect($classCodeAnswers)->flatten()->all();
            $flattenedQuestions = collect($classCodeQuestions)->flatten()->all();
            $flattenClassCodeQuestionareId = collect($data['classCodeid'])->flatten()->all();

            $mergedClassCodeQuestionareData = array_map(function ($answer, $questionare, $classcodeQuestionareId) {
                return ['answer' => $answer, 'questionare' => $questionare, 'classcodeQuestionareId' => $classcodeQuestionareId];
            }, $flattenedAnswers, $flattenedQuestions, $flattenClassCodeQuestionareId);

            foreach($mergedClassCodeQuestionareData as $flattenItem){
                $ClassCodeQuesionare = new ClassCodeQuestionare();
                $ClassCodeQuesionare->lead_id = $data['leadId'];
                $ClassCodeQuesionare->classcode_id = $flattenItem['classcodeQuestionareId'];
                $ClassCodeQuesionare->question = $flattenItem['questionare'];
                $ClassCodeQuesionare->answer = $flattenItem['answer'];
                $ClassCodeQuesionare->save();
            }

             //saving multiple state
            $mergedData = array_map(function ($state, $percentage) {
            return ['state' => $state, 'percentage' => $percentage];
            }, $data['multiple_states'], $data['multiple_percentage']);

            foreach($mergedData as $data){
             $multipleState = new MultipleState();
             $multipleState->general_liabilities_id = $generalLiabilitiId;
             $multipleState->state = $data['state'];
             $multipleState->percentage = (int)$data['percentage'];
             $multipleState->save();
            }



        }catch(\Exception $e){
            Log::error('Error saving general liabilities data: '.$e->getMessage());
            // Log::error($mergedClassCodeQuestionareData);
            return response()->json(['error' => 'Failed to save data.'], 500);
        }

    }

    public function updateGeneralLiabilities(Request $request, $id)
    {
        $data = $request->all();

        try{
            $generalInformationId = GeneralInformation::where('leads_id', $id)->value('id');
            $generalLiabilitiesId = GeneralLiabilities::where('general_information_id', $generalInformationId)->value('id');
            $generalLiabilities = GeneralLiabilities::where('id', $generalLiabilitiesId)->first();

            if($generalLiabilities){

                //updating the general liabilities information
                $generalLiabilities->business_description = $data['business_description'];
                $generalLiabilities->residential = $data['residential_percentage'];
                $generalLiabilities->commercial = $data['commercial_percentage'];
                $generalLiabilities->new_construction = $data['construction_percentage'];
                $generalLiabilities->repair = $data['repair_remodel_percentage'];
                $generalLiabilities->self_perform_roofing = $data['self_performing_roofing'];
                $generalLiabilities->concrete_foundation_work = $data['concrete_foundation_work'];
                $generalLiabilities->perform_track_work = $data['perform_tract_work'];
                $generalLiabilities->is_condo_townhouse = $data['work_on_condominium'];
                $generalLiabilities->perform_multi_dwelling = $data['perform_remodelling_work'];
                $generalLiabilities->business_entity = $data['business_entity'];
                $generalLiabilities->years_in_business = $data['years_in_business'];
                $generalLiabilities->years_in_professional = $data['years_in_profession'];
                $generalLiabilities->largest_project = $data['largest_project'];
                $generalLiabilities->largest_project_amount = $data['largest_project_amount'];
                $generalLiabilities->contract_license = $data['contact_license'];
                $generalLiabilities->contract_license_name = $data['contact_license_name'];
                $generalLiabilities->is_office_home = $data['is_office_home'];
                $generalLiabilities->policy_premium = $data['policy_premium'];
                $generalLiabilities->cross_sell = $data['cross_sell'];
                $generalLiabilities->save();

                //updating the subcontractor general liabilities data
                $subContractor = Subcontractor::where('general_liabilities_id', $generalLiabilitiesId)->first();
                $subContractor->blasting_operation = $data['blasting_operation'];
                $subContractor->hazardous_waste = $data['hazardous_waste'];
                $subContractor->asbestos_mold = $data['asbestos_mold'];
                $subContractor->three_stories_height = $data['tall_building'];
                $subContractor->save();

                //updating the coverage limit data
                $coverageLimit = CoverageLimit::where('id', $generalLiabilities->coverage_limit_id)->first();
                $coverageLimit->limit = $data['limit'];
                $coverageLimit->medical = $data['medical'];
                $coverageLimit->fire_damage = $data['fire_damage'];
                $coverageLimit->deductible = $data['deductible'];
                $coverageLimit->save();



                //updating the classcode percentage data
                $classCodePercentage = ClassCodePercentage::where('general_liabilities_id', $generalLiabilitiesId)->get();
                $classCodePercentageDelete = $classCodePercentage->each->delete();
                if($classCodePercentageDelete){
                    $mergedMultipleClassCode = array_map(function ($classCode, $percentage) {
                        return['classCode' => $classCode, 'percentage' => $percentage];
                    }, $data['classcCode'], $data['classcode_percentage']);

                    foreach($mergedMultipleClassCode as $multipleClassCode){
                        $classCodePercentage = new ClassCodePercentage();
                        $classCodePercentage->general_liabilities_id = $generalLiabilitiesId;
                        $classCodePercentage->classcode_id = (int)$multipleClassCode['classCode'];
                        $classCodePercentage->percentage = (int)$multipleClassCode['percentage'];
                        $classCodePercentage->save();
                    }
                }

                //updating the classcode questionare data
                $classCodeAnswers = $data['classCodeAnswer']; // Assuming this is an array
                $classCodeQuestions = $data['classCodeQuestion']; // Assuming this is an array

                $flattenedAnswers = collect($classCodeAnswers)->flatten()->all();
                $flattenedQuestions = collect($classCodeQuestions)->flatten()->all();
                $flattenClassCodeQuestionareId = collect($data['classCodeid'])->flatten()->all();

                $mergedClassCodeQuestionareData = array_map(function ($answer, $questionare, $classcodeQuestionareId) {
                    return ['answer' => $answer, 'questionare' => $questionare, 'classcodeQuestionareId' => $classcodeQuestionareId];
                }, $flattenedAnswers, $flattenedQuestions, $flattenClassCodeQuestionareId);

                $classCodeQuestionare = ClassCodeQuestionare::where('lead_id', $id)->get();
                $classCodeQuestionareDelete = $classCodeQuestionare->each->delete();

                if($classCodeQuestionareDelete){
                    foreach($mergedClassCodeQuestionareData as $flattenItem){
                        $ClassCodeQuesionare = new ClassCodeQuestionare();
                        $ClassCodeQuesionare->lead_id = $data['leadId'];
                        $ClassCodeQuesionare->classcode_id = $flattenItem['classcodeQuestionareId'];
                        $ClassCodeQuesionare->question = $flattenItem['questionare'];
                        $ClassCodeQuesionare->answer = $flattenItem['answer'];
                        $ClassCodeQuesionare->save();
                    }
                }

                //updating the recreational facilities data
                $recreationalFacilities = GeneralLiabilitiesRecreationalFacilities::where('general_liabilities_id', $generalLiabilitiesId)->get();
                $recreationalFacilitiesDelete = $recreationalFacilities->each->delete();
                if($recreationalFacilitiesDelete){
                    foreach($data['recreational_facilities'] as $recreationalFacility){
                        $recreationalFacilitiesGeneralLiabilities = new GeneralLiabilitiesRecreationalFacilities();
                        $recreationalFacilitiesGeneralLiabilities->general_liabilities_id = $generalLiabilitiesId;
                        $recreationalFacilitiesGeneralLiabilities->recreational_facilities_id = $recreationalFacility;
                        $recreationalFacilitiesGeneralLiabilities->save();
                    }
                }

                    //updating the multiple state data
                    $multipleState = MultipleState::where('general_liabilities_id', $generalLiabilitiesId)->get();
                    $multipleStateDelete = $multipleState->each->delete();
                    if($multipleStateDelete){
                        $mergedData = array_map(function ($state, $percentage) {
                            return ['state' => $state, 'percentage' => $percentage];
                        }, $data['multiple_states'], $data['multiple_percentage']);

                        foreach($mergedData as $data){
                         $multipleState = new MultipleState();
                         $multipleState->general_liabilities_id = $generalLiabilitiesId;
                         $multipleState->state = $data['state'];
                         $multipleState->percentage = (int)$data['percentage'];
                         $multipleState->save();
                        }
                    }



            }

        }catch(\Exception $e){
            Log::error('Error updating general liabilities data: '.$e->getMessage());
            return response()->json(['error' => 'Failed to update data.'], 500);
        }




    }

}

?>
