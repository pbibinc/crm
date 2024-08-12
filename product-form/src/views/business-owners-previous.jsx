import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import BusinessOwnersPolicyPreviousForm from "../product-form/business-owners-policy-previous-form";

export default function BusinessOwnersPolicyPrevious() {
    const { businessOwnersPolicyPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (businessOwnersPolicyPreviousData) {
            setIsLoading(false);
        }
    }, [businessOwnersPolicyPreviousData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <BusinessOwnersPolicyPreviousForm />
                )}
            </div>
        </div>
    );
}
