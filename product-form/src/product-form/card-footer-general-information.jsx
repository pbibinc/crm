import React from "react";

import Button from "react-bootstrap/Button";
import SaveAsiCon from "@mui/icons-material/SaveAs";
<link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
/>;

const GeneralInformationCardFooter = () => {
    return (
        <>
            <div className="d-flex justify-content-end">
                <Button variant="success" style={{ marginRight: "10px" }}>
                    <SaveAsiCon />
                </Button>
                <Button variant="danger">Clear</Button>
            </div>
        </>
    );
};

export default GeneralInformationCardFooter;
