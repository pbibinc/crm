import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import WorkersCompensationPreviousForm from "../product-form/workers-compensation-previous-form";

export default function WorkersCompensationPrevious() {
    const { workersCompensationPreviousData } = useContext(ContextData);

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (workersCompensationPreviousData) {
            setIsLoading(false);
        }
    }, [workersCompensationPreviousData]);
    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <WorkersCompensationPreviousForm />
                )}
            </div>
        </div>
    );
}
