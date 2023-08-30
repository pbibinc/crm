import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";

const PlasteringForm = ({ setClassCodeFormData, disabled }) => {
    const [checked, setChecked] = useState(false);
    const questionare =
        "Do you perfrom any of the following work:EIFS, work on pools, spa or ponds?";

    const handleWoodWorkingSwitch = (event) => {
        setChecked(event.target.checked);
    };

    useEffect(() => {
        setClassCodeFormData({
            value: checked,
            description: questionare,
            classcodeId: 196,
        });
    }, [setClassCodeFormData, checked, questionare]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="woodwoorkingLableColumn"
                        classValue="col-8"
                        colContent={<Label labelContent={questionare} />}
                    />,
                    <Column
                        key="woodWoorkingCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleWoodWorkingSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default PlasteringForm;
