import { createContext, useContext } from "react";

export const BusinessOwnersPolicyPreviousDataContext = createContext();

export const useBusinessOwnersPolicyPrevious = () =>
    useContext(BusinessOwnersPolicyPreviousDataContext);
