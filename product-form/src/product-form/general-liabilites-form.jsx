import React, { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Select from "react-select";

import Form from "react-bootstrap/Form";

import InputGroup from "react-bootstrap/InputGroup";
import State from "../data/state";
// import { event } from "jquery";
import RecreationalFacilities from "../data/recreational-facilities-data";
import DateMonth from "../element/date-month";
// //import { set } from "lodash";
import DateDay from "../element/date-day";

//import { set } from "lodash";
import axios from "axios";
import SaveIcon from "@mui/icons-material/Save";
import SaveAsIcon from "@mui/icons-material/SaveAs";

import DatePicker from "react-datepicker";
import ClassCodeMain from "../classcode-forms/classcode_main";
import { ContextData } from "../contexts/context-data-provider";
import { NumericFormat } from "react-number-format";
import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";
import Button from "react-bootstrap/Button";
import { useGeneralLiabilities } from "../contexts/general-liabilities-context";
// import { FidgetSpinner } from "react-loader-spinner";

// import Col from "react-bootstrap/esm/Col";
const GeneralLiabilitiesForm = () => {
    const { classCodeArray, lead } = useContext(ContextData);
    const { generalLiabilitiesData } = useGeneralLiabilities() || {};
    const [isDataReady, setIsDataReady] = useState(false);

    const [isLoading, setIsLoading] = useState(false);
    const getLeadStoredData = () => {
        const storedData = JSON.parse(sessionStorage.getItem("lead") || "{}");
        return storedData;
    };
    const getGeneralLiabilitiesStoredData = () => {
        const storedData = JSON.parse(
            sessionStorage.getItem("generalLiabilitiesStoredData") || "{}"
        );
        return generalLiabilitiesData ? generalLiabilitiesData[0] : storedData;
    };

    const [classCodePercentages, setClassCodePercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.classcode_percentage || [0]
    );

    const [selectedClassCode, setSelectedClassCode] = useState(
        () => getGeneralLiabilitiesStoredData()?.classCode || []
    );
    const [selectedClassCodeObject, setSelectedClassCodeObject] = useState(
        () => getGeneralLiabilitiesStoredData()?.classcCodeObject || []
    );

    const [multipleStatePercentage, setMultipleStatePercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.multiple_percentage || [0]
    );
    const [selectedStates, setSelectedStates] = useState(
        () => getGeneralLiabilitiesStoredData()?.multiple_states || []
    );
    const [multistateSelectedObject, setMultistateSelectedObject] = useState(
        () => getGeneralLiabilitiesStoredData()?.multistateSelectedObject || []
    );
    const [isMultipleStateChecked, setIsMultipleStateChecked] = useState(
        () => getGeneralLiabilitiesStoredData()?.isMultipleStateChecked || false
    );

    //have loss variable
    const [isHaveLossesChecked, setIsHaveLossesChecked] = useState(false);
    const [dateOptionsValue, setDateOptionsValue] = useState(1);
    const [dateOfClaim, setDateOfClaim] = useState(null);
    const [amount, setAmount] = useState("");
    const [haveLossAmount, setHaveLossAmount] = useState("");

    //states for setting value for coverage limits in general liabilities
    const [selectedLimit, setSelectedLimit] = useState(
        getGeneralLiabilitiesStoredData()?.limit || null
    );
    const [selectedMedical, setSelectedMedical] = useState(
        () => getGeneralLiabilitiesStoredData()?.medical || ""
    );
    const [selectedFireDamage, setSelectedFireDamage] = useState(
        () => getGeneralLiabilitiesStoredData()?.fire_damage || ""
    );
    const [selectedDeductible, setSelectedDeductible] = useState(
        () => getGeneralLiabilitiesStoredData()?.deductible || ""
    );

    //states for setting value for general liabilities common questionare
    const [leadId, setLeadId] = useState(() => {
        const leads_item_value = JSON.parse(sessionStorage.getItem("lead"));
        return leads_item_value ? leads_item_value.data.id : "";
    });
    const [userProfileId, setUserProfileId] = useState(() => {
        var userProfileId = getLeadStoredData()?.data?.userProfileId;
        return userProfileId;
    });

    // useEffect(() => {
    //     setLeadId(leadDetailsInstance?.data?.id);
    // }, [leadDetailsInstance]);

    const [bussinessDescription, setBussinessDescription] = useState(
        () => getGeneralLiabilitiesStoredData()?.business_description || ""
    );
    const [residentialPercentage, setResidentialPercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.residential_percentage || 50
    );
    const [commercialPercentage, setCommercialPercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.commercial_percentage || 50
    );
    const [constructionPercentage, setConstructionPercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.construction_percentage || 50
    );
    const [repairRemodelPercentage, setRepairRemodelPercentage] = useState(
        () => getGeneralLiabilitiesStoredData()?.repair_remodel_percentage || 50
    );

    const [selfPerformingRoofing, setSelfPerformingRoofing] = useState(
        () =>
            getGeneralLiabilitiesStoredData()?.self_performing_roofing || false
    );
    const [concreteFoundationWork, setConcreteFoundationWork] = useState(
        () =>
            getGeneralLiabilitiesStoredData()?.concrete_foundation_work || false
    );
    const [perfromTractWork, setPerfromTractWork] = useState(
        () => getGeneralLiabilitiesStoredData()?.perform_tract_work || false
    );
    const [workOnCondominium, setWorkOnCondominium] = useState(
        () => getGeneralLiabilitiesStoredData()?.work_on_condominium || false
    );

    const [
        performRemodellingWorkCheckSwitch,
        setPerformRemodellingWorkCheckSwitch,
    ] = useState(
        () =>
            getGeneralLiabilitiesStoredData()?.perform_remodelling_work || false
    );

    const [selectedBusinessEntity, setSelectedBusinessEntity] = useState(
        () => getGeneralLiabilitiesStoredData()?.business_entity || ""
    );

    const [yearsInBusiness, setYearsInBusiness] = useState(
        () => getGeneralLiabilitiesStoredData()?.years_in_business || ""
    );
    const [yearsInProfession, setYearsInProfession] = useState(
        () => getGeneralLiabilitiesStoredData()?.years_in_profession || ""
    );

    const [largestProject, setLargestProject] = useState(
        () => getGeneralLiabilitiesStoredData()?.largest_project || ""
    );
    const [largestProjectAmount, setLargestProjectAmount] = useState(
        () => getGeneralLiabilitiesStoredData()?.largest_project_amount || ""
    );

    const [contactLicense, setContactLicense] = useState(
        () => getGeneralLiabilitiesStoredData()?.contact_license || ""
    );
    const [contactLicenseName, setContactLicenseName] = useState(
        () => getGeneralLiabilitiesStoredData()?.contact_license_name || ""
    );

    const [policyPremium, setPolicyPremium] = useState(
        () => getGeneralLiabilitiesStoredData()?.policy_premium || ""
    );

    const [selectedCrossSell, setSelectedCrossSell] = useState("");
    const [expirationGeneralLiability, setExpirationGeneralLiability] =
        useState(null);

    const [blastingOperation, setBlastingOperation] = useState(
        getGeneralLiabilitiesStoredData()?.blasting_operation || false
    );
    const [hazardousWaste, setHazardousWaste] = useState(
        getGeneralLiabilitiesStoredData()?.hazardous_waste || false
    );
    const [asbestosMold, setAsbestosMold] = useState(
        getGeneralLiabilitiesStoredData()?.asbestos_mold || false
    );
    const [tallBuilding, setTallBuilding] = useState(
        getGeneralLiabilitiesStoredData()?.tall_building || false
    );

    const [selectedRecreationalFacilities, setSelectedRecreationalFacilities] =
        useState(
            () =>
                getGeneralLiabilitiesStoredData()?.recreational_facilities || []
        );

    const [isOfficeHome, setIsOfficeHome] = useState(
        () => getGeneralLiabilitiesStoredData()?.is_office_home || false
    );

    const [isEditing, setIsEditing] = useState(() =>
        getGeneralLiabilitiesStoredData()?.isUpdate == true ? false : true
    );

    const [isUpdate, SetIsUpdate] = useState(
        () => getGeneralLiabilitiesStoredData()?.isUpdate || false
    );

    // const [classCodes, SetClassCodes] = useState([]);

    // const [classCodeFormData, setClassCodeFormData] = useState([]);
    // const [clasCodeDescription, setClassCodeDescription] = useState([]);

    // const [classCodeFormData, setClassCodeFormData] = useState([]);
    // const [clasCodeDescription, setClasCodeDescription] = useState([]);
    // const [classCodeIdData, setClassCodeIdData] = useState([]);

    let classCodeFormData = [];
    let clasCodeDescription = [];
    let classCodeIdData = [];

    // Handle Residential Percentage Change
    const handleResidentialChange = (e) => {
        const value = e.target.value;
        const newResidentialPercentage =
            value === "" ? "" : parseInt(value, 10);
        const newCommercialPercentage =
            value === ""
                ? ""
                : isNaN(newResidentialPercentage)
                ? 0
                : 100 - newResidentialPercentage;
        setResidentialPercentage(newResidentialPercentage);
        setCommercialPercentage(newCommercialPercentage);
    };

    // Handle Commercial Percentage Change
    const handleCommercialChange = (e) => {
        const value = e.target.value;
        const newCommercialPercentage = value === "" ? "" : parseInt(value, 10);
        const newResidentialPercentage =
            value === ""
                ? ""
                : isNaN(newCommercialPercentage)
                ? 0
                : 100 - newCommercialPercentage;
        setCommercialPercentage(newCommercialPercentage);
        setResidentialPercentage(newResidentialPercentage);
    };

    // Handle New Construction Percentage Change
    const handleNewContructionChange = (e) => {
        const value = e.target.value;
        const newConstructionPercentage =
            value === "" ? "" : parseInt(value, 10);
        const newRepairRemodelPercentage =
            value === ""
                ? ""
                : isNaN(newConstructionPercentage)
                ? 0
                : 100 - newConstructionPercentage;
        setConstructionPercentage(newConstructionPercentage);
        setRepairRemodelPercentage(newRepairRemodelPercentage);
    };

    // Handle Repair Remodel Percentage Change
    const handleRepairRemodelChange = (e) => {
        const value = e.target.value;
        const newRepairRemodelPercentage =
            value === "" ? "" : parseInt(value, 10);
        const newConstructionPercentage =
            value === ""
                ? ""
                : isNaN(newRepairRemodelPercentage)
                ? 0
                : 100 - newRepairRemodelPercentage;
        setRepairRemodelPercentage(newRepairRemodelPercentage);
        setConstructionPercentage(newConstructionPercentage);
    };

    // Total percentage for classcode
    const totalPercentage = classCodePercentages.reduce(
        (sum, percentage) => sum + percentage,
        0
    );

    // Hande Amount change for Material Cost
    const handleAmountChange = (event) => {
        const numbericValue = event.target.value.replace(/[^0-9]/g, "");
        const formattedValue = numbericValue.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ","
        );
        setAmount(numbericValue);
        setHaveLossAmount(numbericValue);
    };

    //handle event for changing the classcode dropdown
    const handleClassCodeChange = (index, event) => {
        const value = parseInt(event.value);
        const label = event.label;

        const updatedClassCode = [...selectedClassCode];
        updatedClassCode[index] = isNaN(value) ? 0 : value;
        setSelectedClassCode(updatedClassCode);

        const updatedLabelClassCode = [...selectedClassCodeObject];
        updatedLabelClassCode[index] = {
            value: isNaN(value) ? 0 : value,
            label: label || "",
        };
        setSelectedClassCodeObject(updatedLabelClassCode);
    };

    // Variable for adding new batch
    const addNewBatch = () => {
        setClassCodePercentage([...classCodePercentages, 0]);
    };

    // Function to remove a specific batch's percentage
    const removeBatch = (index) => {
        const updatedPercentages = [...classCodePercentages];
        updatedPercentages.splice(index, 1);
        setClassCodePercentage(updatedPercentages);
    };

    // Function to update a specific batch's percentage
    const updateClassCodePercentage = (index, value) => {
        const updatePercentage = [...classCodePercentages];
        updatePercentage[index] = value;
        setClassCodePercentage(updatePercentage);
    };

    // Handler for percentage input change
    const handlePercentageChange = (index, event) => {
        const percentage = parseInt(event.target.value);
        const updateClassCodePercentage = [...classCodePercentages];
        updateClassCodePercentage[index] = isNaN(percentage) ? 0 : percentage;
        setClassCodePercentage(updateClassCodePercentage);

        if (totalPercentage > 100) {
            const remainingPercentage = 100 - totalPercentage + percentage;
            setClassCodePercentage([
                ...updateClassCodePercentage,
                remainingPercentage,
            ]);
        }
    };

    // Handler for onBlur event for percentage classcode input
    const handleInputBlur = () => {
        // Append a new row if the last row's percentage is not 100 and it's the last row
        if (totalPercentage < 100 && totalPercentage > 0) {
            addNewBatch();
        }
    };

    // Total percentage for multiple state
    const totalMultipleStatePercentage = multipleStatePercentage.reduce(
        (sum, percentage) => sum + percentage,
        0
    );

    // Handle multiple state percentage change
    const addNewMultipleState = () => {
        setMultipleStatePercentage([...multipleStatePercentage, 0]);
    };

    //function to remove specific multiplepercentage
    const removeMultipleState = (index) => {
        const updatedMultiplePercentage = [...multipleStatePercentage];
        updatedMultiplePercentage.splice(index, 1);
        setMultipleStatePercentage(updatedMultiplePercentage);
    };

    //function to update specific multiplepercentage
    const updateMultipleStatePercentage = (index, value) => {
        const updatedMultiplePercentage = [...multipleStatePercentage];
        updatedMultiplePercentage[index] = value;
        setMultipleStatePercentage(updatedMultiplePercentage);
    };

    //handle multiple state percentage change
    const handleMultipleStateChange = (index, event) => {
        const percentage = parseInt(event.target.value);
        const updatedMultiplePercentage = [...multipleStatePercentage];
        updatedMultiplePercentage[index] = isNaN(percentage) ? 0 : percentage;
        setMultipleStatePercentage(updatedMultiplePercentage);
        if (totalMultipleStatePercentage > 100) {
            const remainingPercentage =
                100 - totalMultipleStatePercentage + percentage;
            setMultipleStatePercentage([
                ...updatedMultiplePercentage,
                remainingPercentage,
            ]);
        }
    };

    //handle the state for state dropdown
    const handleStateMultipleChange = (index, event) => {
        const { value } = event;
        const updatedSelectedStates = [...selectedStates];
        updatedSelectedStates[index] = value;
        setSelectedStates(updatedSelectedStates);
        const updatedSelectedStatesObject = updatedSelectedStates.map((e) => {
            return { value: e, label: e };
        });
        setMultistateSelectedObject(updatedSelectedStatesObject);
    };

    //handel multiple state blur
    const handleMultipleStateBlur = () => {
        // Append a new row if the last row's percentage is not 100 and it's the last row
        if (
            totalMultipleStatePercentage < 100 &&
            totalMultipleStatePercentage > 0
        ) {
            addNewMultipleState();
        }
    };

    //handle the calsscodequestionare change
    const handleClassCodeData = (index, data) => {
        clasCodeDescription[index] = data.description;
        classCodeIdData[index] = data.classcodeId;
        classCodeFormData[index] = data.value;
    };

    //script for defining classcode data dropdown
    const classCodeData = classCodeArray;

    let classCodeArr = [];
    if (Array.isArray(classCodeData)) {
        classCodeArr = classCodeData;
    } else {
        classCodeArr = [classCodeArr];
    }
    let classCodeOptions = classCodeArr.map((code) => {
        if (code === null) {
            return null;
        }
        return {
            value: code.id,
            label: code.name,
        };
    });

    //script for defining state data dropdown
    const state = State();
    let stateOptions = state.map((state) => {
        if (state === null) {
            return null;
        }
        return {
            value: state,
            label: state,
        };
    });

    //function to handle multiple state switch
    const handleMultipleStateSwitch = (event) => {
        setIsMultipleStateChecked(event.target.checked);
    };

    //getting the value for recreational facilities
    const recreationalFacilities = RecreationalFacilities();
    let recreationalFacilitiesArray = [];
    if (Array.isArray(recreationalFacilities)) {
        recreationalFacilitiesArray = recreationalFacilities;
    } else {
        recreationalFacilitiesArray = [recreationalFacilities];
    }

    // Map the recreationalFacilitiesArray and the inner arrays to create options for the Select component
    let recreationalFacilitiesOptions = recreationalFacilitiesArray.map(
        (data) => {
            if (data === null) {
                return null;
            }

            return {
                value: data.id,
                label: data.name,
            };
        }
    );

    //script for business entity dropdwown
    let businessEntityArray = [
        { value: "Corporation", label: "Corporation" },
        {
            value: "Individual/Sole Proprietor",
            label: "Individual/Sole Proprietor",
        },
        {
            value: "Limited Liability Company(LLC)",
            label: "Limited Liability Company(LLC)",
        },
        { value: "Partnership", label: "Partnership" },
        { value: "S-Corp", label: "S-Corp" },
    ];
    let businessEntityOptions = businessEntityArray.map(({ value, label }) => ({
        value,
        label,
    }));

    //function to handle multiple state switch
    const handleHaveLossesSwitch = (event) => {
        setIsHaveLossesChecked(event.target.checked);
    };

    //function to handle date options dropdown
    let dateOptionsArray = [
        { value: 1, label: "DD/MM/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];
    let dateOptions = dateOptionsArray.map(({ value, label }) => ({
        value,
        label,
    }));

    //script for handle date options change
    const handleDateOptionsChange = (selectedOption) => {
        setDateOptionsValue(selectedOption.value);
    };

    //handeling limit dropdown data
    let limitArray = [
        { value: "1M/1M/1M", label: "1M/1M/1M" },
        { value: "1M/2M/1M", label: "1M/2M/1M" },
        { value: "1M/2M/2m", label: "1M/2M/2m" },
    ];
    let generalLiabilitiesLimitOptions = limitArray.map(({ value, label }) => ({
        value,
        label,
    }));

    //handeling medial drodown data
    let medicalArray = [
        { value: "$5,000", label: "$5,000" },
        { value: "$10,000", label: "$10,000" },
    ];
    let medicalLimitOptions = medicalArray.map(({ value, label }) => ({
        value,
        label,
    }));

    let fireDamageArray = [
        { value: "$50,000", label: "$50,000" },
        { value: "$100,000", label: "$100,000" },
    ];

    let deductibleArray = [
        { value: "0", label: "0" },
        { value: "250", label: "250" },
        { value: "500", label: "500" },
        { value: "1,000", label: "1,000" },
        { value: "2,500", label: "2,500" },
        { value: "10,000", label: "10,000" },
    ];

    //handeling cross sell drodown data
    let crossSellArray = [
        { value: "Workers Compensation", label: "Workers Compensation" },
        { value: "Commercial Auto", label: "Commercial Auto" },
        { value: "Commercial Property", label: "Commercial Property" },
        { value: "Excess Liability", label: "Excess Liability" },
        { value: "Tools and Equipment", label: "Tools and Equipment" },
        { value: "Builders Risk", label: "Builders Risk" },
        { value: "Business Owner Policy", label: "Business Owner Policy" },
    ];
    let generalLiabilitiesCrossSellOptions = crossSellArray.map(
        ({ value, label }) => ({
            value,
            label,
        })
    );

    const generalLiabilitiesFormData = {
        //objects for coverage limit table
        limit: selectedLimit?.value,
        medical: selectedMedical?.value,
        fire_damage: selectedFireDamage?.value,
        deductible: selectedDeductible?.value,

        //objects for general liabilities common questionare
        leadId: getLeadStoredData()?.data?.id,
        business_description: bussinessDescription,
        residential_percentage: residentialPercentage,
        commercial_percentage: commercialPercentage,
        construction_percentage: constructionPercentage,
        repair_remodel_percentage: repairRemodelPercentage,
        self_performing_roofing: selfPerformingRoofing,
        concrete_foundation_work: concreteFoundationWork,
        perform_tract_work: perfromTractWork,
        work_on_condominium: workOnCondominium,
        perform_remodelling_work: performRemodellingWorkCheckSwitch,
        business_entity: selectedBusinessEntity?.value,
        years_in_business: yearsInBusiness,
        years_in_profession: yearsInProfession,
        largest_project: largestProject,
        largest_project_amount: largestProjectAmount,
        contact_license: contactLicense,
        contact_license_name: contactLicenseName,
        is_office_home: isOfficeHome,
        expiration_general_liability: expirationGeneralLiability,
        policy_premium: policyPremium,
        cross_sell: selectedCrossSell,

        //object for mutilple classcode
        isMultipleStateChecked: isMultipleStateChecked,
        multiple_percentage: multipleStatePercentage,
        multiple_states: selectedStates,

        //object for classcode woodworking
        classCodeAnswer: classCodeFormData,
        classCodeQuestion: clasCodeDescription,
        classCodeid: classCodeIdData,

        //object for classcode percentage
        classcode_percentage: classCodePercentages,
        classcCode: selectedClassCode,

        //object for general liabilities subcontract questionare
        blasting_operation: blastingOperation,
        hazardous_waste: hazardousWaste,
        asbestos_mold: asbestosMold,
        tall_building: tallBuilding,

        //have loss object
        isHaveLossesChecked: isHaveLossesChecked,
        dateOfClaim: dateOfClaim,
        haveLossAmount: haveLossAmount,

        isUpdate: isUpdate,
        isEditing: isEditing,

        //object for general liabilities recreational facilities
        recreational_facilities: selectedRecreationalFacilities.map((e) => {
            return e.value;
        }),

        userProfileId: userProfileId,
    };

    const generalLiabilitiesStoredFormData = {
        //objects for coverage limit table
        limit: { value: selectedLimit?.value, label: selectedLimit?.label },
        medical: {
            value: selectedMedical?.value,
            label: selectedMedical?.label,
        },
        fire_damage: {
            value: selectedFireDamage?.value,
            label: selectedFireDamage?.label,
        },
        deductible: {
            value: selectedDeductible?.value,
            label: selectedDeductible?.label,
        },

        //objects for general liabilities common questionare
        leadId: leadId,
        business_description: bussinessDescription,
        residential_percentage: residentialPercentage,
        commercial_percentage: commercialPercentage,
        construction_percentage: constructionPercentage,
        repair_remodel_percentage: repairRemodelPercentage,
        self_performing_roofing: selfPerformingRoofing,
        concrete_foundation_work: concreteFoundationWork,
        perform_tract_work: perfromTractWork,
        work_on_condominium: workOnCondominium,
        perform_remodelling_work: performRemodellingWorkCheckSwitch,
        business_entity: {
            value: selectedBusinessEntity?.value,
            label: selectedBusinessEntity.label,
        },
        years_in_business: yearsInBusiness,
        years_in_profession: yearsInProfession,
        largest_project: largestProject,
        largest_project_amount: largestProjectAmount,
        contact_license: contactLicense,
        contact_license_name: contactLicenseName,
        is_office_home: isOfficeHome,
        expiration_general_liability: expirationGeneralLiability,
        policy_premium: policyPremium,
        cross_sell: selectedCrossSell,

        //object for mutilple state
        isMultipleStateChecked: isMultipleStateChecked,
        multiple_percentage: multipleStatePercentage,
        multiple_states: selectedStates,
        multistateSelectedObject: multistateSelectedObject,

        //object for classcode woodworking
        classCodeAnswer: classCodeFormData,
        classCodeQuestion: clasCodeDescription,
        classCodeid: classCodeIdData,

        //object for classcode percentage
        classcode_percentage: classCodePercentages,
        classcCodeObject: selectedClassCodeObject,
        classCode: selectedClassCode,

        //object for general liabilities subcontract questionare
        blasting_operation: blastingOperation,
        hazardous_waste: hazardousWaste,
        asbestos_mold: asbestosMold,
        tall_building: tallBuilding,

        isUpdate: isUpdate,
        isEditing: isEditing,
        userProfileId: userProfileId,
        //object for general liabilities recreational facilities
        recreational_facilities: selectedRecreationalFacilities.map((e) => {
            return { value: e.value, label: e.label };
        }),
    };

    sessionStorage.setItem(
        "generalLiabilitiesStoredData",
        JSON.stringify(generalLiabilitiesStoredFormData)
    );

    function submitGeneralLiabilitiesForm() {
        const leadIdTobeUpdates = getLeadStoredData()?.data?.id;

        const url = isUpdate
            ? `/api/general-liabilities-data/${leadIdTobeUpdates}`
            : "/api/general-liabilities-data";

        const method = isUpdate ? "put" : "post";
        axiosClient[method](url, generalLiabilitiesFormData)
            .then((response) => {
                setIsEditing(false);
                SetIsUpdate(true);
                setIsLoading(true);
                if (method == "post") {
                    setIsLoading(false);
                    Swal.fire({
                        icon: "success",
                        title: "General Liabilities  has been saved",
                    });
                } else {
                    setIsLoading(false);
                    Swal.fire({
                        icon: "success",
                        title: "General Liabilities has been successfully updated",
                    });
                }
            })
            .catch((error) => {
                if (error.response.status == 409) {
                    Swal.fire({
                        icon: "warning",
                        title: `${error.response.data.error}`,
                    });
                } else {
                    console.log("Error::", error);
                    Swal.fire({
                        icon: "warning",
                        title: `Error:: kindly call your IT and Refer to them this error ${error.response.data.error}`,
                    });
                }
            });
    }

    useEffect(() => {
        if (generalLiabilitiesData) {
            const storedData = generalLiabilitiesData[0] || {};

            //objects for coverage limit table
            setSelectedLimit(storedData.limit || null);
            setSelectedMedical(storedData.medical || "");
            setSelectedFireDamage(storedData.fire_damage || "");
            setSelectedDeductible(storedData.deductible || "");

            // //objects for general liabilities common questionare
            setLeadId(storedData.leadId || "");
            setBussinessDescription(storedData.business_description || "");
            setResidentialPercentage(storedData.residential_percentage || 50);
            setCommercialPercentage(storedData.commercial_percentage || 50);
            setConstructionPercentage(storedData.construction_percentage || 50);
            setRepairRemodelPercentage(
                storedData.repair_remodel_percentage || 50
            );
            setSelfPerformingRoofing(
                storedData.self_performing_roofing || false
            );
            setPerfromTractWork(storedData.perform_tract_work || false);
            setWorkOnCondominium(storedData.work_on_condominium || false);
            setPerformRemodellingWorkCheckSwitch(
                storedData.perform_remodelling_work || false
            );
            setSelectedBusinessEntity(storedData.business_entity || "");
            setYearsInBusiness(storedData.years_in_business || "");
            setYearsInProfession(storedData.years_in_profession || "");
            setLargestProject(storedData.largest_project || "");
            setLargestProjectAmount(storedData.largest_project_amount || "");
            setContactLicense(storedData.contact_license || "");
            setContactLicenseName(storedData.contact_license_name || "");
            setPolicyPremium(storedData.policy_premium || "");
            setSelectedCrossSell(storedData.selectedCrossSell || "");

            //object for mutilple state
            setIsMultipleStateChecked(
                storedData.isMultipleStateChecked || false
            );
            setMultistateSelectedObject(
                storedData.multistateSelectedObject || []
            );
            setMultipleStatePercentage(storedData.multiple_percentage || [0]);
            setSelectedStates(storedData.multiple_states || []);

            //object for classcode woodworking

            setSelectedClassCode(storedData.classCode || []);
            setSelectedClassCodeObject(storedData.classcCodeObject || []);
            setIsHaveLossesChecked(storedData.isHaveLossesChecked || false);
            setDateOptionsValue(storedData.dateOptionsValue || 1);
            setDateOfClaim(storedData.dateOfClaim || null);
            setAmount(storedData.amount || "");
            setHaveLossAmount(storedData.haveLossAmount || "");

            setUserProfileId(
                lead?.data?.userProfileId
                    ? lead?.data?.userProfileId
                    : storedData.userProfileId
            );

            setConcreteFoundationWork(
                storedData.concrete_foundation_work || false
            );

            setClassCodePercentage(storedData.classcode_percentage || [0]);
            setExpirationGeneralLiability(
                storedData.expirationGeneralLiability || null
            );

            setBlastingOperation(storedData.blasting_operation || false);
            setHazardousWaste(storedData.hazardous_waste || false);
            setAsbestosMold(storedData.asbestos_mold || false);
            setTallBuilding(storedData.tall_building || false);
            setSelectedRecreationalFacilities(
                storedData.recreational_facilities || []
            );
            setIsOfficeHome(storedData.is_office_home || false);
            setIsEditing(storedData.isUpdate !== true);
            SetIsUpdate(storedData.isUpdate || false);

            setIsDataReady(true);
        }
    }, [generalLiabilitiesData]);

    // if (!isDataReady) {
    //     return <div>Loading...</div>;
    // }

    return (
        <>
            {classCodePercentages.map((percentage, index) => (
                <React.Fragment key={`fragment-${index}`}>
                    <Row
                        key={`multipleClassCode${index}`}
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="classCodeLabelColumn"
                                classValue="col-2"
                                colContent={<Label labelContent="Class Code" />}
                            />,
                            <Column
                                key="classCodeColumn"
                                classValue="col-7"
                                colContent={
                                    <Select
                                        className="basic=single"
                                        classNamePrefix="select"
                                        isDisabled={!isEditing}
                                        options={classCodeOptions}
                                        value={selectedClassCodeObject[index]}
                                        onChange={(event) =>
                                            handleClassCodeChange(index, event)
                                        }
                                    />
                                }
                            />,
                            <Column
                                key={`inputPercentageColumn${index}`}
                                classValue="col-2"
                                colContent={
                                    <InputGroup className="mb-3">
                                        <Form.Control
                                            key={index}
                                            type="text"
                                            value={percentage}
                                            disabled={!isEditing}
                                            onChange={(event) =>
                                                handlePercentageChange(
                                                    index,
                                                    event
                                                )
                                            }
                                            onBlur={handleInputBlur}
                                        />
                                        <InputGroup.Text>%</InputGroup.Text>
                                    </InputGroup>
                                }
                            />,

                            index > 0 && (
                                <Column
                                    key={`removeButtonColumn${index}`}
                                    classValue="col-1"
                                    colContent={
                                        <Button
                                            onClick={() => removeBatch(index)}
                                            className="btn btn-danger"
                                            disabled={!isEditing}
                                        >
                                            -
                                        </Button>
                                    }
                                />
                            ),
                        ]}
                    />
                    <Row
                        key={`classCodeMainRow${index}`}
                        rowContent={
                            <ClassCodeMain
                                classCodeIdData={selectedClassCode[index]}
                                setClassCodeFormData={(data) =>
                                    handleClassCodeData(index, data)
                                }
                                disabled={!isEditing}
                            />
                        }
                    />
                </React.Fragment>
            ))}

            <Row
                classValue="mb-4"
                rowContent={
                    <Column
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Business Description" />
                                <Form.Control
                                    as="textarea"
                                    rows={6}
                                    value={bussinessDescription}
                                    onChange={(event) =>
                                        setBussinessDescription(
                                            event.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />
                }
            />

            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="residentialLabelColumn"
                        classValue="col-2"
                        colContent={<Label labelContent="Residential" />}
                    />,
                    <Column
                        key="residentialInputColumn"
                        classValue="col-4"
                        colContent={
                            <InputGroup className="mb-3">
                                <Form.Control
                                    aria-label="Amount (to the nearest dollar)"
                                    id="residentialInput"
                                    value={residentialPercentage}
                                    onChange={handleResidentialChange}
                                    disabled={!isEditing}
                                />
                                <InputGroup.Text>%</InputGroup.Text>
                            </InputGroup>
                        }
                    />,
                    <Column
                        key="commercialLabelColumn"
                        classValue="col-2"
                        colContent={<Label labelContent="Commercial" />}
                    />,
                    <Column
                        key="commercialInputColumn"
                        classValue="col-4"
                        colContent={
                            <InputGroup className="mb-3">
                                <Form.Control
                                    aria-label="Amount (to the nearest dollar)"
                                    id="commercialInput"
                                    value={commercialPercentage}
                                    onChange={handleCommercialChange}
                                    disabled={!isEditing}
                                />
                                <InputGroup.Text>%</InputGroup.Text>
                            </InputGroup>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="newConstructionLabelColumn"
                        classValue="col-2"
                        colContent={<Label labelContent="New Construction" />}
                    />,
                    <Column
                        key="newContstructionInputColumn"
                        classValue="col-4"
                        colContent={
                            <InputGroup className="mb-3">
                                <Form.Control
                                    aria-label="Amount (to the nearest dollar)"
                                    id="newContructionInput"
                                    value={constructionPercentage}
                                    onChange={handleNewContructionChange}
                                    disabled={!isEditing}
                                />
                                <InputGroup.Text>%</InputGroup.Text>
                            </InputGroup>
                        }
                    />,
                    <Column
                        key="repairRemodelLabelColumn"
                        classValue="col-2"
                        colContent={<Label labelContent="Repair/Remodel" />}
                    />,
                    <Column
                        key="repairRemodelInputColumn"
                        classValue="col-4"
                        colContent={
                            <InputGroup className="mb-3">
                                <Form.Control
                                    aria-label="Amount (to the nearest dollar)"
                                    id="repairRemodelInput"
                                    value={repairRemodelPercentage}
                                    onChange={handleRepairRemodelChange}
                                    disabled={!isEditing}
                                />
                                <InputGroup.Text>%</InputGroup.Text>
                            </InputGroup>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={
                    <>
                        <Column
                            classValue="col-4"
                            colContent={
                                <>
                                    <Label labelContent="Are you working on multiple state?" />
                                    <Form.Check
                                        type="switch"
                                        id="multipleStateCheckSwitch"
                                        checked={isMultipleStateChecked}
                                        onChange={handleMultipleStateSwitch}
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />
                        {!isMultipleStateChecked && (
                            <Column
                                key="selfPerformingRoofing"
                                classValue="col-4"
                                colContent={
                                    <>
                                        <Label labelContent="Self Performing Roofing" />
                                        <Form.Check
                                            type="switch"
                                            id="selfPerformingCheckSwitch"
                                            checked={selfPerformingRoofing}
                                            onChange={(e) => {
                                                setSelfPerformingRoofing(
                                                    e.target.checked
                                                );
                                            }}
                                            disabled={!isEditing}
                                        />
                                    </>
                                }
                            />
                        )}
                        {!isMultipleStateChecked && (
                            <Column
                                key="concreteFoundationWork"
                                classValue="col-3"
                                colContent={
                                    <>
                                        <Label labelContent="Concrete Foundation Work" />
                                        <Form.Check
                                            type="switch"
                                            id="concreteFoundationWorkCheckSwitch"
                                            checked={concreteFoundationWork}
                                            onChange={(e) => {
                                                setConcreteFoundationWork(
                                                    e.target.checked
                                                );
                                            }}
                                            disabled={!isEditing}
                                        />
                                    </>
                                }
                            />
                        )}
                    </>
                }
            />
            {isMultipleStateChecked &&
                multipleStatePercentage.map((percentage, index) => (
                    <Row
                        key={index}
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="multipleStateWorkLabelColumn"
                                classValue="col-3"
                                colContent={
                                    <Label labelContent="Multiple State" />
                                }
                            />,
                            <Column
                                key="multipleStateWorkInputSelectColumn"
                                classValue="col-6"
                                colContent={
                                    <Select
                                        className="basic=single"
                                        classNamePrefix="select"
                                        id="multipleStateWorkDropdown"
                                        name="multipleState"
                                        options={stateOptions}
                                        value={multistateSelectedObject[index]}
                                        onChange={(event) =>
                                            handleStateMultipleChange(
                                                index,
                                                event
                                            )
                                        }
                                        isDisabled={!isEditing}
                                    />
                                }
                            />,
                            <Column
                                key={`multipleStatePercentageColumn${index}`}
                                classValue="col-2"
                                colContent={
                                    <InputGroup className="mb-3">
                                        <Form.Control
                                            type="text"
                                            key={index}
                                            aria-label="Amount (to the nearest dollar)"
                                            id="multipleStatePercentageInput"
                                            value={percentage}
                                            onChange={(event) =>
                                                handleMultipleStateChange(
                                                    index,
                                                    event
                                                )
                                            }
                                            onBlur={handleMultipleStateBlur}
                                            disabled={!isEditing}
                                        />
                                        <InputGroup.Text>%</InputGroup.Text>
                                    </InputGroup>
                                }
                            />,

                            index > 0 && (
                                <Column
                                    key={`removeButtonColumn${index}`}
                                    classValue="col-1"
                                    colContent={
                                        <Button
                                            onClick={() =>
                                                removeMultipleState(index)
                                            }
                                            className="btn btn-danger"
                                            disabled={!isEditing}
                                        >
                                            -
                                        </Button>
                                    }
                                />
                            ),
                        ]}
                    />
                ))}
            {isMultipleStateChecked && (
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="selfPerformingRoofing"
                            classValue="col-4"
                            colContent={
                                <>
                                    <Label labelContent="Self Performing Roofing" />
                                    <Form.Check
                                        type="switch"
                                        id="selfPerformingCheckSwitch"
                                        onChange={(e) => {
                                            setSelfPerformingRoofing(
                                                e.target.checked
                                            );
                                        }}
                                        checked={selfPerformingRoofing}
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="concreteFoundationWork"
                            classValue="col-3"
                            colContent={
                                <>
                                    <Label labelContent="Concrete Foundation Work" />
                                    <Form.Check
                                        type="switch"
                                        id="concreteFoundationWorkCheckSwitch"
                                        onChange={(e) => {
                                            setConcreteFoundationWork(
                                                e.target.checked
                                            );
                                        }}
                                        checked={concreteFoundationWork}
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                    ]}
                />
            )}
            <Row
                classValue=""
                rowContent={[
                    <Column
                        key="perfromTractWork"
                        classValue="col-4"
                        colContent={
                            <>
                                <Label labelContent="Do you Perform Tract Work?" />
                            </>
                        }
                    />,
                    <Column
                        key="workOnCondominium"
                        classValue="col-4"
                        colContent={
                            <>
                                <Label labelContent="Do you do work for condominium" />
                            </>
                        }
                    />,
                    <Column
                        key="perfromRemodellingWork"
                        classValue="col-4"
                        colContent={
                            <>
                                <Label labelContent="Will you perform any new remodeling work in multi-dwelling residences?" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-5"
                rowContent={[
                    <Column
                        key="perfromTractWork"
                        classValue="col-4"
                        colContent={
                            <>
                                <Form.Check
                                    type="switch"
                                    id="perfromTractWorkCheckSwitch"
                                    onChange={(e) =>
                                        setPerfromTractWork(e.target.checked)
                                    }
                                    checked={perfromTractWork}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="workOnCondominium"
                        classValue="col-4"
                        colContent={
                            <>
                                <Form.Check
                                    type="switch"
                                    id="workForCondominiumCheckSwitch"
                                    onChange={(e) =>
                                        setWorkOnCondominium(e.target.checked)
                                    }
                                    checked={workOnCondominium}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="perfromRemodellingWork"
                        classValue="col-4"
                        colContent={
                            <>
                                <Form.Check
                                    type="switch"
                                    id="performRemodellingWorkCheckSwitch"
                                    onChange={(e) =>
                                        setPerformRemodellingWorkCheckSwitch(
                                            e.target.checked
                                        )
                                    }
                                    checked={performRemodellingWorkCheckSwitch}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue=""
                rowContent={
                    <label>
                        <h6>
                            Would you perform or subcontract work involving:
                        </h6>
                    </label>
                }
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="blastingOperationColumng"
                        classValue="col-3"
                        colContent={
                            <>
                                <Label labelContent="Blasting Operation" />
                                <Form.Check
                                    type="switch"
                                    id="blastingOperationCheckSwitch"
                                    onChange={(e) =>
                                        setBlastingOperation(e.target.checked)
                                    }
                                    checked={blastingOperation}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="hazardousWasteColumn"
                        classValue="col-3"
                        colContent={
                            <>
                                <Label labelContent="Hazardous Waste" />
                                <Form.Check
                                    type="switch"
                                    id="hazardousWasteCheckSwitch"
                                    onChange={(e) =>
                                        setHazardousWaste(e.target.checked)
                                    }
                                    checked={hazardousWaste}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="asbestorMoldColumn"
                        classValue="col-3"
                        colContent={
                            <>
                                <Label labelContent="Asbestos Mold" />
                                <Form.Check
                                    type="switch"
                                    id="asbestorMoldCheckSwitch"
                                    onChange={(e) =>
                                        setAsbestosMold(e.target.checked)
                                    }
                                    checked={asbestosMold}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="exceedingHeightColumn"
                        classValue="col-3"
                        colContent={
                            <>
                                <Label labelContent="Exceeding 3 stories in height" />
                                <Form.Check
                                    type="switch"
                                    id="exceedingHeightCheckSwitch"
                                    onChange={(e) =>
                                        setTallBuilding(e.target.checked)
                                    }
                                    checked={tallBuilding}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="recreationalFacilitiesDropdownColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Any Recreational Facilities" />
                                <Select
                                    closeMenuOnSelect={false}
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="recreationalFacilitiesDropdown"
                                    name="recreationalFacilitiesDropdown"
                                    isMulti
                                    options={recreationalFacilitiesOptions}
                                    value={selectedRecreationalFacilities}
                                    onChange={(e) =>
                                        setSelectedRecreationalFacilities(e)
                                    }
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="businessEntityDropdownColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Business Entity" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="businessEntityDropdown"
                                    name="businessEntityDropdown"
                                    options={businessEntityOptions}
                                    value={selectedBusinessEntity}
                                    onChange={(e) => {
                                        setSelectedBusinessEntity(e);
                                    }}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="yearsInBusinessInputColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Years in Business" />
                                <Form.Control
                                    type="number"
                                    id="yearsInBusinessInput"
                                    value={yearsInBusiness}
                                    onChange={(e) => {
                                        setYearsInBusiness(e.target.value);
                                    }}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="yearsInProfessionInputColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Years in Profession" />
                                <Form.Control
                                    type="number"
                                    id="yearsInProfessionInput"
                                    value={yearsInProfession}
                                    onChange={(e) => {
                                        setYearsInProfession(e.target.value);
                                    }}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="largesProjectDescriptionColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Largest Project" />
                                <Form.Control
                                    as="textarea"
                                    rows={6}
                                    value={largestProject}
                                    onChange={(e) => {
                                        setLargestProject(e.target.value);
                                    }}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,

                    <Column
                        key="largestProjectAmountColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Amount" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    value={largestProjectAmount}
                                    onChange={(e) =>
                                        setLargestProjectAmount(e.target.value)
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="contactLicenseInputColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Contractor License" />
                                <Form.Control
                                    type="text"
                                    id="contactLicenseInput"
                                    value={contactLicense}
                                    onChange={(e) => {
                                        setContactLicense(e.target.value);
                                    }}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="nameCompanyNameInputColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Name/Company Name" />
                                <Form.Control
                                    type="text"
                                    id="companyNameInput"
                                    value={contactLicenseName}
                                    onChange={(e) => {
                                        setContactLicenseName(e.target.value);
                                    }}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="haveLossesColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Have Losses" />
                                <Form.Check
                                    type="switch"
                                    id="haveLossesCheckSwitch"
                                    onChange={handleHaveLossesSwitch}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="officeHomeColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="is your office home" />
                                <Form.Check
                                    type="switch"
                                    id="officeHometCheckSwitch"
                                    onChange={(e) =>
                                        setIsOfficeHome(e.target.checked)
                                    }
                                    checked={isOfficeHome}
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            {isHaveLossesChecked && (
                <Row
                    classValue="mb-4"
                    rowContent={
                        <Column
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Choose Format" />
                                    <Select
                                        className="basic=single"
                                        classNamePrefix="select"
                                        id="dateOptionsDropdown"
                                        name="dateOptionsDropdown"
                                        options={dateOptions}
                                        value={dateOptionsValue}
                                        onChange={handleDateOptionsChange}
                                        isDisabled={!isEditing}
                                    />
                                </>
                            }
                        />
                    }
                />
            )}
            {isHaveLossesChecked && (
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="dateofLossColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Row
                                        classValue="mb-1"
                                        rowContent={
                                            <Label labelContent="Date of Claim" />
                                        }
                                    />
                                    {dateOptionsValue === 1 && (
                                        <Row
                                            rowContent={
                                                <DateDay
                                                    disabled={!isEditing}
                                                    onChange={(date) =>
                                                        setDateOfClaim(date)
                                                    }
                                                />
                                            }
                                        />
                                    )}
                                    {dateOptionsValue === 2 && (
                                        <Row
                                            rowContent={
                                                <DateMonth
                                                    disabled={!isEditing}
                                                    onChange={(date) =>
                                                        setDateOfClaim(date)
                                                    }
                                                />
                                            }
                                        />
                                    )}
                                </>
                            }
                        />,
                        <Column
                            key="lossAmountColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Amount of Claim" />
                                    <Form.Control
                                        type="text"
                                        id="materialCost"
                                        value={`$${amount}`}
                                        onChange={handleAmountChange}
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                    ]}
                />
            )}
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="expirationOfGlColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Row
                                    classValue="mb-1"
                                    rowContent={
                                        <Label labelContent="Expiration of GL" />
                                    }
                                />
                                <Row
                                    rowContent={
                                        <DatePicker
                                            selected={
                                                expirationGeneralLiability
                                            }
                                            onChange={(date) =>
                                                setExpirationGeneralLiability(
                                                    date
                                                )
                                            }
                                            showMonthDropdown
                                            showYearDropdown
                                            className="custom-datepicker-input"
                                            disabled={!isEditing}
                                        />
                                    }
                                />
                            </>
                        }
                    />,
                    <Column
                        key="priorCarrierColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Policy Premium" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    value={policyPremium}
                                    onChange={(e) =>
                                        setPolicyPremium(e.target.value)
                                    }
                                    disabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="glLimitColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Limit" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="limitDropdown"
                                    name="limitDropdown"
                                    value={selectedLimit}
                                    options={generalLiabilitiesLimitOptions}
                                    onChange={(e) => setSelectedLimit(e)}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="medicalLimit"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Medical" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="medicalDropdown"
                                    name="medicalDropdown"
                                    options={medicalLimitOptions}
                                    value={selectedMedical}
                                    onChange={(e) => setSelectedMedical(e)}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="fireDamageColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Fire Damage" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="medicalDropdown"
                                    name="medicalDropdown"
                                    options={fireDamageArray}
                                    value={selectedFireDamage}
                                    onChange={(e) => setSelectedFireDamage(e)}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="deductibleColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Deductible" />
                                <Select
                                    className="basic=single"
                                    classNamePrefix="select"
                                    id="medicalDropdown"
                                    name="medicalDropdown"
                                    options={deductibleArray}
                                    value={selectedDeductible}
                                    onChange={(e) => setSelectedDeductible(e)}
                                    isDisabled={!isEditing}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="generalLiabilitiesEditButtonColumn"
                        classValue="col-12 d-flex justify-content-center align-items-center"
                        colContent={
                            <>
                                <button
                                    size="lg"
                                    onClick={submitGeneralLiabilitiesForm}
                                    disabled={!isEditing}
                                    className="mx-2 form-button"
                                >
                                    <SaveIcon />
                                    <span className="ms-2">Save</span>
                                </button>
                                <button
                                    size="lg"
                                    disabled={isEditing}
                                    onClick={() => setIsEditing(true)}
                                    className="mx-2 form-button-edit"
                                >
                                    <SaveAsIcon />
                                    <span className="ms-2">Edit</span>
                                </button>
                            </>
                        }
                    />,
                ]}
            />
        </>
    );
};
export default GeneralLiabilitiesForm;
