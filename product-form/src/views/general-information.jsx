import React from "react";
import Card from "../element/card-element";
import GeneralInformationForm from "../product-form/general-information-form";

class GeneralInformation extends React.Component {
    render() {
        return (
            <>
                <Card
                    headerContent="General Information"
                    bodyContent={<GeneralInformationForm />}
                />
            </>
        );
    }
}

export default GeneralInformation;
