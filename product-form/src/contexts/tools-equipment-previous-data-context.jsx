import { createContext, useContext } from "react";

export const ToolsEquipmentPreviousDataContext = createContext();

export const useToolsEquipmentPrevious = () =>
    useContext(ToolsEquipmentPreviousDataContext);
