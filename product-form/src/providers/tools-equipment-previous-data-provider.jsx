import { ToolsEquipmentPreviousDataContext } from "../contexts/tools-equipment-previous-data-context";
import ToolsEquipmentPreviousData from "../data/tools-equipment-previous-data";

const ToolsEquipmentPreviousDataProvider = ({ children }) => {
    const { toolsEquipmentPreviousData } = ToolsEquipmentPreviousData();

    return (
        <ToolsEquipmentPreviousDataContext.Provider
            value={{ toolsEquipmentPreviousData }}
        >
            {children}
        </ToolsEquipmentPreviousDataContext.Provider>
    );
};

export default ToolsEquipmentPreviousDataProvider;
