import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const RoofingNewResidential = ({ setClassCodeFormData, disabled }) => {
    const [checked, setChecked] = useState(false);
    const questionare =
        "Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO, waterproofing, waterproof decks?";
    const handleWoodWorkingSwitch = (event) => {
        setChecked(event.target.checked);
    };

    useEffect(() => {
        setClassCodeFormData({
            value: checked,
            description: questionare,
            classcodeId: 253,
        });
    }, [checked, questionare, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="questionareHotWorkLableColumn"
                        classValue="col-8"
                        colContent={<Label labelContent={questionare} />}
                    />,
                    <Column
                        key="questionareHotWorkCheckboxColumn"
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

export default RoofingNewResidential;
