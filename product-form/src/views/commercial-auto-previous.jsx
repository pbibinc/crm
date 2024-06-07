import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";
import WorkersCompensationForm from "../product-form/workers-compensation_form";
import CommercialAutoForm from "../product-form/commercial-auto_form";
import CommercialAutoFormEdit from "./commercial-auto-form-edit";
import CommercialAutoPreviousForm from "../product-form/commercial-auto-previous-form";

export default function CommercialAutoPrevious() {
    const { commercialAutoPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (commercialAutoPreviousData) {
            setIsLoading(false);
        }
    }, [commercialAutoPreviousData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <CommercialAutoPreviousForm />
                )}
            </div>
        </div>
    );
}
