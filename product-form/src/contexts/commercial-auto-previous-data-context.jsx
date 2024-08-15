import { createContext, useContext } from "react";

export const CommercialAutoPreviousDataContext = createContext();

export const useCommercialAutoPrevious = () =>
    useContext(CommercialAutoPreviousDataContext);
