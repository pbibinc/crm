import React from "react";
import Card from "../element/card-element";
import GeneralInformationForm from "../product-form/general-information-form";
import Footer from "../partials-form/footer";
import ProductAccordion from "./product-accordion";
import GeneralInformationCardFooter from "../product-form/card-footer-general-information";
import ContextDataProvider from "../contexts/context-data-provider";
// import LeadDetailsProvider from "../data/lead-details";

const GeneralInformation = () => {
    return (
        <>
            <Card
                headerContent="General Information"
                bodyContent={
                    <ContextDataProvider>
                        <GeneralInformationForm />
                    </ContextDataProvider>
                }
            />
            <ProductAccordion />
            <Footer />
        </>
    );
};

export default GeneralInformation;