import React, { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider"; // Import the context object
import Header from "../partials-form/header";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";
import WorkersCompensationForm from "../product-form/workers-compensation_form";
import { useWorkersCompensation } from "../contexts/workers-compensation-context";

export default function WorkersCompensationFormEdit() {
    const { workersCompensationData } = useWorkersCompensation();

    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (workersCompensationData) {
            setIsLoading(false);
        }
    }, [workersCompensationData]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? (
                    <div>Loading...</div>
                ) : (
                    <WorkersCompensationForm />
                )}
            </div>
        </div>
    );
}
