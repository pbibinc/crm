import { createContext, useContext } from "react";

export const BuildersRiskPreviousDataContext = createContext();

export const useBuildersRiskPrevious = () =>
    useContext(BuildersRiskPreviousDataContext);
