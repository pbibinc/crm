import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";

const HvacForm = ({ setClassCodeFormData, disabled }) => {
    const [checked, setChecked] = useState(false);
    const questionare =
        "Do you install or repair LPG work or fire suppression system?";
    const [heatingQuestionare, setHeatingQuestionare] = useState(false);
    const heatingQuestionareText =
        "Are you using any heating devices when performing your work?";

    const handleSwitch = (event) => {
        setChecked(event.target.checked);
    };

    const handleHeatingQuestionare = (event) => {
        setHeatingQuestionare(event.target.checked);
    };

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    useEffect(() => {
        setQuestionareArray([questionare, heatingQuestionareText]);
    }, [setQuestionareArray]);
    useEffect(() => {
        setValueArray([checked, heatingQuestionare]);
    }, [setValueArray, checked, heatingQuestionare]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [115, 115],
        });
    }, [setClassCodeFormData, valueArray, questionareArray]);

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
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="heatingLabelColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={heatingQuestionareText} />
                        }
                    />,
                    <Column
                        key="HeatingCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleHeatingQuestionare}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default HvacForm;
