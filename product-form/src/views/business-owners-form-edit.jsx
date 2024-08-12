import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import BuilderRiskForm from "../product-form/builder-risk_form";
import BusinessOwnersPolicyForm from "../product-form/business-owners-policy_form";
import { useBusinessOwnersPolicy } from "../contexts/business-owners-policy-context";

export default function BusinessOwnersPolicyFormEdit() {
    const { businessOwnersPolicyData } = useBusinessOwnersPolicy();
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (businessOwnersPolicyData) {
            setIsLoading(false);
        }
    }, [businessOwnersPolicyData]);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <BusinessOwnersPolicyForm />
                )}
            </div>
        </div>
    );
}
