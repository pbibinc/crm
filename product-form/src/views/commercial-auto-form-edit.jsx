import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";
import WorkersCompensationForm from "../product-form/workers-compensation_form";
import CommercialAutoForm from "../product-form/commercial-auto_form";

export default function CommercialAutoFormEdit() {
    const { commercialAutoData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (commercialAutoData) {
            setIsLoading(false);
        }
    }, [commercialAutoData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <CommercialAutoForm />}
            </div>
        </div>
    );
}
