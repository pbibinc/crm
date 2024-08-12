import { ToolsEquipmentContext } from "../contexts/tools-equipment-context";
import ToolsEquipmentData from "../data/tools-equipment-data";

const ToolsEquipmentDataProvider = ({ children }) => {
    const { toolsEquipmentData } = ToolsEquipmentData();

    return (
        <ToolsEquipmentContext.Provider value={{ toolsEquipmentData }}>
            {children}
        </ToolsEquipmentContext.Provider>
    );
};

export default ToolsEquipmentDataProvider;
