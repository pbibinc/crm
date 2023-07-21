import React from "react";
import Card from "../element/card-element";
import GeneralInformationForm from "../product-form/general-information-form";
import Footer from "../partials-form/footer";
import ProductAccordion from "./product-accordion";

class GeneralInformation extends React.Component {
    render() {
        return (
            <>
                <Card
                    headerContent="General Information"
                    bodyContent={<GeneralInformationForm />}
                />
                <ProductAccordion />
                <Footer />
            </>
        );
    }
}

export default GeneralInformation;
