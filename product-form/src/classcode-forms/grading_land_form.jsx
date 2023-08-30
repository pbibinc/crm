import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";

const GradingLandForm = ({ setClassCodeFormData, disabled }) => {
    const [checked, setChecked] = useState(false);
    const questionare =
        "Do you perfrom work on Public street, road, bridge, highway or overpass work?";

    const handleSwitch = (event) => {
        setChecked(event.target.checked);
    };

    useEffect(() => {
        setClassCodeFormData({
            value: checked,
            description: questionare,
            classcodeId: 36,
        });
    }, [setClassCodeFormData, checked, questionare]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="LableColumn"
                        classValue="col-8"
                        colContent={<Label labelContent={questionare} />}
                    />,
                    <Column
                        key="CheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default GradingLandForm;
