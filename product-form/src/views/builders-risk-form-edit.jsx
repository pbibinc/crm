import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import BuilderRiskForm from "../product-form/builder-risk_form";
import { useBuildersRisk } from "../contexts/builders-risk-context";

export default function BuildersRiskFormEdit() {
    const { buildersRiskData } = useBuildersRisk();
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (buildersRiskData) {
            setIsLoading(false);
        }
    }, [buildersRiskData]);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <BuilderRiskForm />}
            </div>
        </div>
    );
}
