import { createContext, useContext } from "react";

export const GeneralLiabilitiesContext = createContext();

export const useGeneralLiabilities = () =>
    useContext(GeneralLiabilitiesContext);
