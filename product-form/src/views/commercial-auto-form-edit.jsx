import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import CommercialAutoForm from "../product-form/commercial-auto_form";
import { useCommercialAuto } from "../contexts/commercial-auto-context";

export default function CommercialAutoFormEdit() {
    const { commercialAutoData } = useCommercialAuto();

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
