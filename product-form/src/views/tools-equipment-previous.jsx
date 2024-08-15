import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import ToolsEquipmentPreviousForm from "../product-form/tools-equipment-previous-form";
import { useToolsEquipmentPrevious } from "../contexts/tools-equipment-previous-data-context";

export default function ToolsEquipmentPrevious() {
    const { toolsEquipmentPreviousData } = useToolsEquipmentPrevious();
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (toolsEquipmentPreviousData) {
            setIsLoading(false);
        }
    }, [toolsEquipmentPreviousData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <ToolsEquipmentPreviousForm />
                )}
            </div>
        </div>
    );
}
