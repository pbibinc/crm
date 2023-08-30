import { createContext, useEffect, useState } from "react";
import LeadDetails from "../data/lead-details";
import LeadZipcode from "../data/lead-zipcode";
import LeadCity from "../data/lead-city";
import LeadZipCodeCities from "../data/lead-city-zipcode";
import ClassCodeData from "../data/classcode-data";



export const ContextData = createContext();

const ContextDataProvider = ({ children }) => {
    const { lead, loading } = LeadDetails();
    const { zipcodes, ziploading } = LeadZipcode();
    const { cities, cityLoading } = LeadCity();
    const { zipCity } = LeadZipCodeCities();
    const {classCodeArray} = ClassCodeData();

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
                classCodeArray
            }}
        >
            {children}
        </ContextData.Provider>
    );
};

export default ContextDataProvider;
