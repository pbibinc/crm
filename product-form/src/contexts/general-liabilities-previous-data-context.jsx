import { createContext, useContext } from "react";

export const GeneralLiabilitiesPreviousDataContext = createContext();

export const useGeneralLiabilitiesPrevious = () =>
    useContext(GeneralLiabilitiesPreviousDataContext);
