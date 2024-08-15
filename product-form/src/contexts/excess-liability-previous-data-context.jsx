import { createContext, useContext } from "react";

export const ExcessLiabilityPreviousDataContext = createContext();

export const useExcessLiabilityPrevious = () =>
    useContext(ExcessLiabilityPreviousDataContext);
