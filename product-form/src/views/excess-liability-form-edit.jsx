import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import ExcessLiabilitiesForm from "../product-form/excess_liability_form";
import { useExcessLiability } from "../contexts/excess-liability-context";

export default function ExcessLiabilityFormEdit() {
    const { excessLiabilityData } = useExcessLiability();

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (excessLiabilityData) {
            setIsLoading(false);
        }
    }, [excessLiabilityData]);
    console.log(excessLiabilityData);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <ExcessLiabilitiesForm />}
            </div>
        </div>
    );
}
