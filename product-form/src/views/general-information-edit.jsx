import { useContext, useEffect, useState } from "react";
import { ContextData } from "../contexts/context-data-provider";
import Header from "../partials-form/header";
import GeneralInformationForm from "../product-form/general-information-form";
import { useGeneralInformation } from "../contexts/general-information-context";

export default function GeneralInformationEdit() {
    const { generalInformation } = useGeneralInformation();
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
