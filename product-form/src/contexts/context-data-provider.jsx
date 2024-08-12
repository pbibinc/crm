import { createContext, useEffect, useState } from "react";
import LeadDetails from "../data/lead-details";
import LeadZipcode from "../data/lead-zipcode";
import LeadCity from "../data/lead-city";
import LeadZipCodeCities from "../data/lead-city-zipcode";
import ClassCodeData from "../data/classcode-data";
import GeneralLiabilitiesData from "../data/general-liabilities-data";
import getAuthToken from "../data/auth-token-data";
import userData from "../data/user-data";
import WorkersCompensationData from "../data/workers-compensation-data";
import GeneralInformationData from "../data/general-information-data";
import CommercialAutoData from "../data/commercial-auto-data";
import CommercialAutoPreviousData from "../data/commercial-auto-previous-data";
import GeneralLiabilitiPreviousData from "../data/general-liabilities-previous-data";
import WorkersCompensationPreviousData from "../data/workers-compensation-previous-data";
import ExcessLiabilityData from "../data/excess-liability-data";
import ExcessLiabilityPreviousData from "../data/excess-liability-previous-data";
import ToolsEquipmentData from "../data/tools-equipment-data";
import ToolsEquipmentPreviousData from "../data/tools-equipment-previous-data";
import BuildersRiskData from "../data/builders-risk-data";
import BuildersRiskPreviousData from "../data/builders-risk-previous-data";
import BusinessOwnersPolicyData from "../data/business-owners-policy-data";
import BusinessOwnersPolicyPreviousData from "../data/business-owners-policy-previous-data";

export const ContextData = createContext();

const ContextDataProvider = ({ children }) => {
    const { lead, loading } = LeadDetails();
    const { zipcodes, ziploading } = LeadZipcode();
    const { cities, cityLoading } = LeadCity();
    const { zipCity } = LeadZipCodeCities();
    const { classCodeArray } = ClassCodeData();
    // const { generalInformation } = GeneralInformationData();
    // const { generalLiabilitiesData } = GeneralLiabilitiesData();
    // const { generalLiabilityPreviousData } = GeneralLiabilitiPreviousData();
    // const { workersCompensationData } = WorkersCompensationData();
    // const { workersCompensationPreviousData } =
    //     WorkersCompensationPreviousData();
    // const { commercialAutoData } = CommercialAutoData();
    // const { commercialAutoPreviousData } = CommercialAutoPreviousData();
    // const { excessLiabilityData } = ExcessLiabilityData();
    // const { excessLiabilityPreviousData } = ExcessLiabilityPreviousData();
    // const { toolsEquipmentData } = ToolsEquipmentData();
    // const { toolsEquipmentPreviousData } = ToolsEquipmentPreviousData();
    // const { buildersRiskData } = BuildersRiskData();
    // const { buildersRiskPreviousData } = BuildersRiskPreviousData();
    // const { businessOwnersPolicyData } = BusinessOwnersPolicyData();
    // const { businessOwnersPolicyPreviousData } =
    //     BusinessOwnersPolicyPreviousData();
    // const { authToken } = getAuthToken();
    // const { user } = userData();

    return (
        <ContextData.Provider
            value={{
                lead,
                loading,
                zipcodes,
                ziploading,
                cities,
                cityLoading,
                zipCity,
                classCodeArray,
                // generalInformation,
                // generalLiabilitiesData,
                // workersCompensationData,
                // workersCompensationPreviousData,
                // commercialAutoData,
                // commercialAutoPreviousData,
                // excessLiabilityData,
                // excessLiabilityPreviousData,
                // toolsEquipmentData,
                // toolsEquipmentPreviousData,
                // buildersRiskData,
                // buildersRiskPreviousData,
                // businessOwnersPolicyData,
                // businessOwnersPolicyPreviousData,
                // generalLiabilityPreviousData,
                // authToken,
                // user,
            }}
        >
            {children}
        </ContextData.Provider>
    );
};

export default ContextDataProvider;
