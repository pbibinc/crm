import { createContext, useContext } from "react";

export const GeneralInformationContext = createContext();

export const useGeneralInformation = () =>
    useContext(GeneralInformationContext);
