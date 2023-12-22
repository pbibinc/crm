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

export const ContextData = createContext();

const ContextDataProvider = ({ children }) => {
    const { lead, loading } = LeadDetails();
    const { zipcodes, ziploading } = LeadZipcode();
    const { cities, cityLoading } = LeadCity();
    const { zipCity } = LeadZipCodeCities();
    const { classCodeArray } = ClassCodeData();
    const { generalLiabilitiesData } = GeneralLiabilitiesData();
    const { workersCompensationData } = WorkersCompensationData();
    const { authToken } = getAuthToken();
    const { user } = userData();
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
                generalLiabilitiesData,
                workersCompensationData,
                authToken,
                user,
            }}
        >
            {children}
        </ContextData.Provider>
    );
};

export default ContextDataProvider;
