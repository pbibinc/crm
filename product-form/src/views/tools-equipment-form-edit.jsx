import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import ToolsEquipmentForm from "../product-form/tools-equipment-form";
import { useToolsEquipment } from "../contexts/tools-equipment-context";

export default function ToolsEquipmentFormEdit() {
    const { toolsEquipmentData } = useToolsEquipment();

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (toolsEquipmentData) {
            setIsLoading(false);
        }
    }, [toolsEquipmentData]);
    console.log(toolsEquipmentData);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <ToolsEquipmentForm />}
            </div>
        </div>
    );
}
