import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";

const DeckingInstallation = ({ setClassCodeFormData, disabled }) => {
    const [checked, setChecked] = useState(false);
    const questionare =
        "Do you perform or install hurricane shutters, spray on siding or roof flashings?";

    const handleSwitch = (event) => {
        setChecked(event.target.checked);
    };

    useEffect(() => {
        setClassCodeFormData({
            value: checked,
            description: questionare,
            classcodeId: 132,
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

export default DeckingInstallation;
