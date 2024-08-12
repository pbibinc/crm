import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import ExcessLiabilitiesPreviousForm from "../product-form/excess-liability-previous-form";

export default function ExcessLiabilityPrevious() {
    const { excessLiabilityPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (excessLiabilityPreviousData) {
            setIsLoading(false);
        }
    }, [excessLiabilityPreviousData]);

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
