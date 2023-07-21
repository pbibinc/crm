import React from "react";
import Accordion from "react-bootstrap/Accordion";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";

function ProductAccordion() {
    return (
        <Accordion defaultActiveKey="0">
            <Accordion.Item eventKey="0">
                <Accordion.Header className="info">
                    General Liabilites Questionare
                </Accordion.Header>
                <Accordion.Body>
                    <GeneralLiabilitiesForm />
                </Accordion.Body>
            </Accordion.Item>

            <Accordion.Item eventKey="1">
                <Accordion.Header className="info">
                    Excess Liability Questionare
                </Accordion.Header>
                <Accordion.Body>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </Accordion.Body>
            </Accordion.Item>
        </Accordion>
    );
}

export default ProductAccordion;
