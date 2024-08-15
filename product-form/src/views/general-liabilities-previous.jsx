import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesPreviousForm from "../product-form/general-liabilities-previous-form";
import { useGeneralLiabilities } from "../contexts/general-liabilities-context";
import { useGeneralLiabilitiesPrevious } from "../contexts/general-liabilities-previous-data-context";

export default function GeneralLiabilitiesPrevious() {
    const { generalLiabilityPreviousData } = useGeneralLiabilitiesPrevious();
    const [isLoading, setIsLoading] = useState(true);

    // const context = useContext(ContextData);
    // console.log(context);
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
