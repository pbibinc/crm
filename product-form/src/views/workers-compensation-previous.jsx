import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import WorkersCompensationPreviousForm from "../product-form/workers-compensation-previous-form";
import { useWorkersCompensationPrevious } from "../contexts/workers-compensation-previous-data-context";

export default function WorkersCompensationPrevious() {
    const { workersCompensationPreviousData } =
        useWorkersCompensationPrevious();
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
