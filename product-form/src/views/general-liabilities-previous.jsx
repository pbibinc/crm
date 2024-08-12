import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesPreviousForm from "../product-form/general-liabilities-previous-form";

export default function GeneralLiabilitiesPrevious() {
    const { generalLiabilityPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (generalLiabilityPreviousData) {
            setIsLoading(false);
        }
    }, [generalLiabilityPreviousData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <GeneralLiabilitiesPreviousForm />
                )}
            </div>
        </div>
    );
}
