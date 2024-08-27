import { createContext, useEffect, useState } from "react";
import LeadDetails from "../data/lead-details";
import LeadZipcode from "../data/lead-zipcode";
import LeadCity from "../data/lead-city";
import LeadZipCodeCities from "../data/lead-city-zipcode";
import ClassCodeData from "../data/classcode-data";
import GeneralLiabilitiesData from "../data/general-liabilities-data";
import GeneralLiabilitiPreviousData from "../data/general-liabilities-previous-data";
import WorkersCompensationData from "../data/workers-compensation-data";
import WorkersCompensationPreviousData from "../data/workers-compensation-previous-data";
import CommercialAutoData from "../data/commercial-auto-data";
import CommercialAutoPreviousData from "../data/commercial-auto-previous-data";
import ExcessLiabilityData from "../data/excess-liability-data";
import ExcessLiabilityPreviousData from "../data/excess-liability-previous-data";
import ToolsEquipmentData from "../data/tools-equipment-data";
import ToolsEquipmentPreviousData from "../data/tools-equipment-previous-data";
import BuildersRiskData from "../data/builders-risk-data";
import BuildersRiskPreviousData from "../data/builders-risk-previous-data";
import BusinessOwnersPolicyData from "../data/business-owners-policy-data";
import BusinessOwnersPolicyPreviousData from "../data/business-owners-policy-previous-data";
import GeneralInformationData from "../data/general-information-data";
// import getAuthToken from "../data/auth-token-data";
// import userData from "../data/user-data";

export const ContextData = createContext();

const ContextDataProvider = ({ children }) => {
    const { lead, loading } = LeadDetails();
    const { zipcodes } = LeadZipcode();
    const { cities } = LeadCity();
    const { zipCity } = LeadZipCodeCities();
    const { classCodeArray } = ClassCodeData();
    // const [additionalData, setAdditionalData] = useState(null);

    // useEffect(() => {
    //     if (lead && !loading) {
    //         const loadAdditionalData = async () => {
    //             const [
    //                 zipcodes,
    //                 cities,
    //                 zipCity,
    //                 classCodeArray,
    //                 generalInformation,
    //                 generalLiabilitiesData,
    //                 generalLiabilityPreviousData,
    //                 workersCompensationData,
    //                 workersCompensationPreviousData,
    //                 commercialAutoData,
    //                 commercialAutoPreviousData,
    //                 excessLiabilityData,
    //                 excessLiabilityPreviousData,
    //                 toolsEquipmentData,
    //                 toolsEquipmentPreviousData,
    //                 buildersRiskData,
    //                 buildersRiskPreviousData,
    //                 businessOwnersPolicyData,
    //                 businessOwnersPolicyPreviousData,
    //             ] = await Promise.all([
    //                 LeadZipcode(),
    //                 LeadCity(),
    //                 LeadZipCodeCities(),
    //                 ClassCodeData(),
    //                 GeneralInformationData(),
    //                 GeneralLiabilitiesData(),
    //                 GeneralLiabilitiPreviousData(),
    //                 WorkersCompensationData(),
    //                 WorkersCompensationPreviousData(),
    //                 CommercialAutoData(),
    //                 CommercialAutoPreviousData(),
    //                 ExcessLiabilityData(),
    //                 ExcessLiabilityPreviousData(),
    //                 ToolsEquipmentData(),
    //                 ToolsEquipmentPreviousData(),
    //                 BuildersRiskData(),
    //                 BuildersRiskPreviousData(),
    //                 BusinessOwnersPolicyData(),
    //                 BusinessOwnersPolicyPreviousData(),
    //             ]);

    //             setAdditionalData({
    //                 zipcodes,
    //                 cities,
    //                 zipCity,
    //                 classCodeArray,
    //                 generalInformation,
    //                 generalLiabilitiesData,
    //                 generalLiabilityPreviousData,
    //                 workersCompensationData,
    //                 workersCompensationPreviousData,
    //                 commercialAutoData,
    //                 commercialAutoPreviousData,
    //                 excessLiabilityData,
    //                 excessLiabilityPreviousData,
    //                 toolsEquipmentData,
    //                 toolsEquipmentPreviousData,
    //                 buildersRiskData,
    //                 buildersRiskPreviousData,
    //                 businessOwnersPolicyData,
    //                 businessOwnersPolicyPreviousData,
    //             });
    //         };

    //         loadAdditionalData();
    //     }
    // }, [lead, loading]); // Depend on `lead` and `loading`
    return (
        <ContextData.Provider
            value={{ lead, loading, zipcodes, cities, zipCity, classCodeArray }}
        >
            {children}
        </ContextData.Provider>
    );
};

export default ContextDataProvider;
