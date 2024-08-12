import { createContext, useContext } from "react";

export const BuildersRiskContext = createContext();

export const useBuildersRisk = () => useContext(BuildersRiskContext);
