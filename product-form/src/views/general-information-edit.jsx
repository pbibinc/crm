import { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider";
import Header from "../partials-form/header";
import GeneralInformationForm from "../product-form/general-information-form";

export default function GeneralInformationEdit() {
    const { generalInformation } = useContext(ContextData);
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        if (generalInformation) {
            setIsLoading(false);
        }
    }, [generalInformation]);

    return (
        <div>
            <Header />
            <div className="page-content">
                {isLoading ? <div>Loading...</div> : <GeneralInformationForm />}
            </div>
        </div>
    );
}
