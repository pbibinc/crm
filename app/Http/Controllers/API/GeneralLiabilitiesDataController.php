<?php

namespace App\Http\Controllers\API;

use App\Events\UpdateGeneralInformationEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CarpentryWoodworking;
use App\Models\ClassCodePercentage;
use App\Models\ClassCodeQuestionare;
use App\Models\CoverageLimit;
use App\Models\GeneralInformation;
use App\Models\GeneralLiabilities;
use App\Models\GeneralLiabilitiesHaveLoss;
use App\Models\GeneralLiabilitiesRecreationalFacilities;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\MultipleState;
use App\Models\QuotationProduct;
use App\Models\QuoteInformation;
use App\Models\Subcontractor;
use Carbon\Carbon;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
class GeneralLiabilitiesDataController extends BaseController
{

    public function saveGeneralLiabilities(Request $request)
    {
        $data = $request->all();
        Log::info($data);
        $dataGeneralInformationId = GeneralInformation::where('leads_id', $data['leadId'])->value('id');

        if (empty($dataGeneralInformationId)) {
            return response()->json(['error' => 'General Information Data is not yet saved.'], 409);
        }
        if(GeneralLiabilities::where('general_information_id', $dataGeneralInformationId)->exists()){
            return response()->json(['error' => 'General Liability Data has been already saved.'], 409);
        }
        try{
            $token = $request->input('token');
            if(Cache::has($token)){
                return response()->json([
                    'message' => 'Duplicate submission, please try again'
                ],422);
            }
            $token = Str::random(10);
            Cache::put($token, true, 10);
            DB::beginTransaction();
              //Saving general liabilities coverage limit
              $coverageLimit = new CoverageLimit();
              $coverageLimit->limit = $data['limit'];
              $coverageLimit->medical = $data['medical'];
              $coverageLimit->fire_damage = $data['fire_damage'];
              $coverageLimit->deductible = $data['deductible'];
              $coverageLimit->save();

              $coverageLimitId = $coverageLimit->id;

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
               $quoteProduct->product = 'General Liability';
               $quoteProduct->status = 7;
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


             //saving of have loss general liabilities table
             if($data['isHaveLossesChecked'] !== false){
                $generalLiabilitiesHaveLoss = new GeneralLiabilitiesHaveLoss();
                $generalLiabilitiesHaveLoss->general_liabilities_id = $generalLiabilitiId;
                $generalLiabilitiesHaveLoss->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateString();
                $generalLiabilitiesHaveLoss->loss_amount = $data['haveLossAmount'];
                $generalLiabilitiesHaveLoss->save();
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
             if($data['isMultipleStateChecked'] !== false){
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
             }
            DB::commit();
            Cache::forget($token);
            return response()->json(['message' => 'General Liability Data saved successfully'], 200);
        }catch(\Exception $e){
            Log::error('Error saving general liabilities data: '.$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateGeneralLiabilities(Request $request, $id)
    {
        $data = $request->all();

        try{
            DB::beginTransaction();
            $leads = Lead::find($id);
            $generalInformationId = GeneralInformation::where('leads_id', $id)->value('id');
            $generalLiabilitiesId = GeneralLiabilities::where('general_information_id', $generalInformationId)->value('id');
            $generalLiabilities = GeneralLiabilities::where('id', $generalLiabilitiesId)->first();
            $oldGeneralLiabilities = $generalLiabilities;
            $userProfleId = $data['userProfileId'];

            $oldMultipleState = $generalLiabilities->multiStates;
            $oldMultipleStatePercentage = [];
            $oldMultipleStatesData = [];
            $oldMultiplestateSelectedObject = [];
            if($oldMultipleState != null){
                foreach($oldMultipleState as $multipleState){
                    $oldMultipleStatePercentage [] = $multipleState->percentage;
                    $oldMultipleStatesData [] = $multipleState->state;
                    $oldMultiplestateSelectedObject [] = [
                        'value' => $multipleState->state,
                        'label' => $multipleState->state
                    ];
                }
            }

            $oldClassCodeQuestionare = $leads->classcodeQuestionare;
            $oldClassCodeAnswer = [];
            $oldClassCodeQuestion = [];
            $oldClassCodeId = [];
            if($oldClassCodeQuestionare != null){
                foreach($oldClassCodeQuestionare as $classCode){
                    $oldClassCodeAnswer [] = $classCode->answer;
                    $oldClassCodeQuestion [] = $classCode->question;
                    $oldClassCodeId [] = $classCode->classcode_id;
                }
            }

            $oldClassCodeQuestionare = $generalLiabilities->classCodePercentage;
            $oldClassCodePercentages = [];
            $oldSelectedClassCodeObject = [];
            $oldSelectedClassCode = [];
            if($oldClassCodeQuestionare != null){
                foreach($oldClassCodeQuestionare as $classCode){
                    $oldClassCodePercentages [] = $classCode->pivot->percentage;
                    $oldSelectedClassCodeObject [] = [
                        'value' => $classCode->id,
                        'label' => $classCode->name,
                    ];
                    $oldSelectedClassCode [] = $classCode->id;
                }
            }

            $oldRecreationalFacilities = $generalLiabilities->recreationalFacilities;
            $oldRecreationalFacilitiesData = [];
            if($oldRecreationalFacilities != null){
                foreach($oldRecreationalFacilities as $recreationalFacility){
                    $oldRecreationalFacilitiesData [] = [
                        'value' => $recreationalFacility->id,
                        'label' => $recreationalFacility->name,
                    ];
                }
            }

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
                  //updating the have loss data
                  if($data['isHaveLossesChecked'] !== false){
                    $generalLiabilitiesHaveLoss = GeneralLiabilitiesHaveLoss::where('general_liabilities_id', $generalLiabilitiesId)->first();
                    if($generalLiabilitiesHaveLoss){
                        $generalLiabilitiesHaveLoss = $generalLiabilitiesHaveLoss->delete();
                        if($generalLiabilitiesHaveLoss){
                            $generalLiabilitiesHaveLoss = new GeneralLiabilitiesHaveLoss();
                            $generalLiabilitiesHaveLoss->general_liabilities_id = $generalLiabilitiesId;
                            $generalLiabilitiesHaveLoss->date_of_claim = Carbon::parse($data['dateOfClaim'])->toDateString();
                            $generalLiabilitiesHaveLoss->loss_amount = $data['haveLossAmount'];
                            $generalLiabilitiesHaveLoss->save();
                        }
                    }
                }else{
                    $generalLiabilitiesHaveLoss = GeneralLiabilitiesHaveLoss::where('general_liabilities_id', $generalLiabilitiesId)->first();
                    if($generalLiabilitiesHaveLoss){
                        $generalLiabilitiesHaveLoss->delete();
                    }
                }

                    //updating the multiple state data
                    if($data['isMultipleStateChecked'] !== false){
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
                        }else{
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
                    }else{
                        $multipleState = MultipleState::where('general_liabilities_id', $generalLiabilitiesId)->get();
                        $multipleStateDelete = $multipleState->each->delete();
                    }

                $changes = [
                    //general liabilities common data
                    'business_description' => $oldGeneralLiabilities->business_description,
                    'residential_percentage' => $oldGeneralLiabilities->residential,
                    'commercial_percentage' => $oldGeneralLiabilities->commercial,
                    'construction_percentage' => $oldGeneralLiabilities->new_construction,
                    'repair_remodel_percentage' => $oldGeneralLiabilities->repair,
                    'self_performing_roofing' => $oldGeneralLiabilities->self_perform_roofing == 1 ? true : false,
                    'concrete_foundation_work' => $oldGeneralLiabilities->concrete_foundation_work == 1 ? true : false,
                    'perform_tract_work' => $oldGeneralLiabilities->perform_track_work == 1 ? true : false,
                    'work_on_condominium' => $oldGeneralLiabilities->is_condo_townhouse == 1 ? true : false,
                    'perform_remodelling_work' => $oldGeneralLiabilities->perform_multi_dwelling == 1 ? true : false,
                    'business_entity' => [
                        'value' => $oldGeneralLiabilities->business_entity,
                        'label' => $oldGeneralLiabilities->business_entity
                    ],
                    'years_in_business' => $oldGeneralLiabilities->years_in_business,
                    'years_in_profession' => $oldGeneralLiabilities->years_in_professional,
                    'largest_project' => $oldGeneralLiabilities->largest_project,
                    'largest_project_amount' => $oldGeneralLiabilities->largest_project_amount,
                    'contact_license' => $oldGeneralLiabilities->contract_license,
                    'contact_license_name' => $oldGeneralLiabilities->contract_license_name,
                    'is_office_home' => $oldGeneralLiabilities->is_office_home == 1 ? true : false,
                    'expiration_general_liability' => $oldGeneralLiabilities->expiration_of_general_liabilities,
                    'policy_premium' => $oldGeneralLiabilities->policy_premium,
                    'cross_sell' => $oldGeneralLiabilities->cross_sell,

                    //objecty for multiple state
                    'isMultipleStateChecked' => $oldMultipleState->count() > 0 ? true : false,
                    'multiple_percentage' => $oldMultipleStatePercentage,
                    'multiple_states' => $oldMultipleStatesData,
                    'multistateSelectedObject' => $oldMultiplestateSelectedObject,

                    //object for classcode questionare
                    'classCodeAnswer' => $oldClassCodeAnswer,
                    'classCodeQuestion' => $oldClassCodeQuestion,
                    'classCodeid' => $oldClassCodeId,

                    //object for classcode percentage
                    'classcode_percentage' => $oldClassCodePercentages,
                    'classcCodeObject' => $oldSelectedClassCodeObject,
                    'classCode' => $oldSelectedClassCode,


                    //object for general liabilities subccontract questionare
                   'blasting_operation' => $oldGeneralLiabilities->subcontractor->blasting_operation == 1 ? true : false,
                   'hazardous_waste' => $oldGeneralLiabilities->subcontractor->hazardous_waste == 1 ? true : false,
                   'asbestos_mold' => $oldGeneralLiabilities->subcontractor->asbestos_mold == 1 ? true : false,
                   'tall_building' => $oldGeneralLiabilities->subcontractor->three_stories_height == 1 ? true : false,

                    //mode
                   'isUpdate' => true,
                   'isEditing' => false,

                   //recreational facilities data
                  'recreational_facilities' => $oldRecreationalFacilitiesData,

                   //coverage limit data
                  'limit' => [
                      'value' => $generalLiabilities->coverageLimit->limit,
                      'label' => $generalLiabilities->coverageLimit->limit
                    ],
                   'medical' => [
                       'value' => $generalLiabilities->coverageLimit->medical,
                       'label' => $generalLiabilities->coverageLimit->medical
                    ],
                 'fire_damage' => [
                      'value' => $generalLiabilities->coverageLimit->fire_damage,
                      'label' => $generalLiabilities->coverageLimit->fire_damage
                    ],
                 'deductible' => [
                      'value' => $generalLiabilities->coverageLimit->deductible,
                      'label' => $generalLiabilities->coverageLimit->deductible
                    ],
                ];

                if(count($changes) > 0){
                    event(new UpdateGeneralInformationEvent($id, $userProfleId, $changes, now(), 'general-liabilities-update'));
                }
                DB::commit();
            }

        }catch(\Exception $e){
            Log::error('Error updating General Liability data: '.$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {

        $leads = Lead::find($id);
        if(is_null($leads)){
            return $this->sendError('General Liability not found.');
        }
        $generalLiabilities = $leads->generalInformation->generalLiabilities;
        $multipleStates = $generalLiabilities->multiStates;
        $multipleStatePercentage = [];
        $multipleStatesData = [];
        $multiplestateSelectedObject = [];
        if($multipleStates != null){
            foreach($multipleStates as $multipleState){
                $multipleStatePercentage [] = $multipleState->percentage;
                $multipleStatesData [] = $multipleState->state;
                $multiplestateSelectedObject [] = [
                    'value' => $multipleState->state,
                    'label' => $multipleState->state
                ];
            }
        }
        $classCodeQuestionare = $leads->classcodeQuestionare;
        $classCodeAnswer = [];
        $classCodeQuestion = [];
        $classCodeId = [];
        if($classCodeQuestionare != null){
            foreach($classCodeQuestionare as $classCode){
                $classCodeAnswer [] = $classCode->answer;
                $classCodeQuestion [] = $classCode->question;
                $classCodeId [] = $classCode->classcode_id;
            }
        }
        $classCodeQuestionare = $generalLiabilities->classCodePercentage;
        $classCodePercentages = [];
        $selectedClassCodeObject = [];
        $selectedClassCode = [];
        if($classCodeQuestionare != null){
            foreach($classCodeQuestionare as $classCode){
                $classCodePercentages [] = $classCode->pivot->percentage;
                $selectedClassCodeObject [] = [
                    'value' => $classCode->id,
                    'label' => $classCode->name,
                ];
                $selectedClassCode [] = $classCode->id;
            }
        }
        $recreationalFacilities = $generalLiabilities->recreationalFacilities;
        $recreationalFacilitiesData = [];
        if($recreationalFacilities != null){
            foreach($recreationalFacilities as $recreationalFacility){
                $recreationalFacilitiesData [] = [
                    'value' => $recreationalFacility->id,
                    'label' => $recreationalFacility->name,
                ];
            }
        }

        $generalLiabilitiesFormData = [
            //general liabilities common data
            'business_description' => $generalLiabilities->business_description,
            'residential_percentage' => $generalLiabilities->residential,
            'commercial_percentage' => $generalLiabilities->commercial,
            'construction_percentage' => $generalLiabilities->new_construction,
            'repair_remodel_percentage' => $generalLiabilities->repair,
            'self_performing_roofing' => $generalLiabilities->self_perform_roofing == 1 ? true : false,
            'concrete_foundation_work' => $generalLiabilities->concrete_foundation_work == 1 ? true : false,
            'perform_tract_work' => $generalLiabilities->perform_track_work == 1 ? true : false,
            'work_on_condominium' => $generalLiabilities->is_condo_townhouse == 1 ? true : false,
            'perform_remodelling_work' => $generalLiabilities->perform_multi_dwelling == 1 ? true : false,
            'business_entity' => [
                'value' => $generalLiabilities->business_entity,
                'label' => $generalLiabilities->business_entity
            ],
            'years_in_business' => $generalLiabilities->years_in_business,
            'years_in_profession' => $generalLiabilities->years_in_professional,
            'largest_project' => $generalLiabilities->largest_project,
            'largest_project_amount' => $generalLiabilities->largest_project_amount,
            'contact_license' => $generalLiabilities->contract_license,
            'contact_license_name' => $generalLiabilities->contract_license_name,
            'is_office_home' => $generalLiabilities->is_office_home == 1 ? true : false,
            'expiration_general_liability' => $generalLiabilities->expiration_of_general_liabilities,
            'policy_premium' => $generalLiabilities->policy_premium,
            'cross_sell' => $generalLiabilities->cross_sell,

            //object for multiple state
            'isMultipleStateChecked' => $multipleStates->count() > 0 ? true : false,
            'multiple_percentage' => $multipleStatePercentage,
            'multiple_states' => $multipleStatesData,
            'multistateSelectedObject' => $multiplestateSelectedObject,

            //object for classcode questionare
            'classCodeAnswer' => $classCodeAnswer,
            'classCodeQuestion' => $classCodeQuestion,
            'classCodeid' => $classCodeId,

            //object for classcode percentage
            'classcode_percentage' => $classCodePercentages,
            'classcCodeObject' => $selectedClassCodeObject,
            'classCode' => $selectedClassCode,

            //object for general liabilities subccontract questionare
            'blasting_operation' => $generalLiabilities->subcontractor->blasting_operation == 1 ? true : false,
            'hazardous_waste' => $generalLiabilities->subcontractor->hazardous_waste == 1 ? true : false,
            'asbestos_mold' => $generalLiabilities->subcontractor->asbestos_mold == 1 ? true : false,
            'tall_building' => $generalLiabilities->subcontractor->three_stories_height == 1 ? true : false,

            //mode
            'isUpdate' => true,
            'isEditing' => false,

            //recreational facilities data
            'recreational_facilities' => $recreationalFacilitiesData,

            //coverage limit data
            'limit' => [
                'value' => $generalLiabilities->coverageLimit->limit,
                'label' => $generalLiabilities->coverageLimit->limit
            ],
            'medical' => [
                'value' => $generalLiabilities->coverageLimit->medical,
                'label' => $generalLiabilities->coverageLimit->medical
            ],
            'fire_damage' => [
                'value' => $generalLiabilities->coverageLimit->fire_damage,
                'label' => $generalLiabilities->coverageLimit->fire_damage
            ],
            'deductible' => [
                'value' => $generalLiabilities->coverageLimit->deductible,
                'label' => $generalLiabilities->coverageLimit->deductible
            ],
        ];
        return response()->json([$generalLiabilitiesFormData, 'Lead retrieved successfully.']);
    }

    public function getPreviousGeneralLiabilities($id)
    {
        $leadHistory = LeadHistory::find($id);
        $changes = json_decode($leadHistory->changes, true);
        return response()->json(['data' => $changes, 'Lead retrieved successfully.']);
    }

}


?>