import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import BuilderRiskPreviousForm from "../product-form/builders-risk-previous-form";

export default function BuildersRiskPrevious() {
    const { buildersRiskPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (buildersRiskPreviousData) {
            setIsLoading(false);
        }
    }, [buildersRiskPreviousData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <BuilderRiskPreviousForm />
                )}
            </div>
        </div>
    );
}
