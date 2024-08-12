import { createContext, useContext } from "react";

export const ToolsEquipmentContext = createContext();

export const useToolsEquipment = () => useContext(ToolsEquipmentContext);
