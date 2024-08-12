import { createContext, useContext } from "react";

export const ExcessLiabilityContext = createContext();

export const useExcessLiability = () => useContext(ExcessLiabilityContext);
