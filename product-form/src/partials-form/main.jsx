import React from "react";
import Header from "./header.jsx";
import Card from "../element/card-element.jsx";
import GeneralInformation from "../views/general-information.jsx";
import Footer from "./footer.jsx";

class Main extends React.Component {
    render() {
        return (
            <div>
                <Header />

                <div className="page-content">
                    <GeneralInformation />
                </div>
            </div>
        );
    }
}

export default Main;
