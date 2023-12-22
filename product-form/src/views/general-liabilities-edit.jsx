import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";

export default function GeneralLiabilitiesFormEdit() {
    const { generalLiabilitiesData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (generalLiabilitiesData) {
            setIsLoading(false);
        }
    }, [generalLiabilitiesData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <GeneralLiabilitiesForm />}
            </div>
        </div>
    );
}
