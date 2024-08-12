import { createContext, useContext } from "react";

export const CommercialAutoContext = createContext();

export const useCommercialAuto = () => useContext(CommercialAutoContext);
