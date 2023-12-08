import { createContext, useEffect, useState } from "react";
import LeadDetails from "../data/lead-details";
import LeadZipcode from "../data/lead-zipcode";
import LeadCity from "../data/lead-city";
import LeadZipCodeCities from "../data/lead-city-zipcode";
import ClassCodeData from "../data/classcode-data";
import GeneralLiabilitiesData from "../data/general-liabilities-data";
import getAuthToken from "../data/auth-token-data";
import userData from "../data/user-data";

export const ContextData = createContext();

const ContextDataProvider = ({ children }) => {
    const { lead, loading } = LeadDetails();
    const { zipcodes, ziploading } = LeadZipcode();
    const { cities, cityLoading } = LeadCity();
    const { zipCity } = LeadZipCodeCities();
    const { classCodeArray } = ClassCodeData();
    const { generalLiabilitiesData } = GeneralLiabilitiesData();
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
                authToken,
                user,
            }}
        >
            {children}
        </ContextData.Provider>
    );
};

export default ContextDataProvider;
