import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import ExcessLiabilitiesPreviousForm from "../product-form/excess-liability-previous-form";
import { useExcessLiabilityPrevious } from "../contexts/excess-liability-previous-data-context";

export default function ExcessLiabilityPrevious() {
    const { excessLiabilityPreviousData } = useExcessLiabilityPrevious();
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (excessLiabilityPreviousData) {
            setIsLoading(false);
        }
    }, [excessLiabilityPreviousData]);
    console.log("ExcessLiabilityPreviousData", excessLiabilityPreviousData);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <ExcessLiabilitiesPreviousForm />
                )}
            </div>
        </div>
    );
}
