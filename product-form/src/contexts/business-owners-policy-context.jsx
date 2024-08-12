import { createContext, useContext } from "react";

export const BusinessOwnersPolicyContext = createContext();

export const useBusinessOwnersPolicy = () =>
    useContext(BusinessOwnersPolicyContext);
