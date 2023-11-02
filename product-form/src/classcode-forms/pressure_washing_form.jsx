import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const PressureWashingForm = ({ setClassCodeFormData, disabled }) => {
    const [chekedHighPressure, setChekedHighPressure] = useState(false);
    const questionareHighPressure =
        "Do you use pressure greater than 3,000 PSI?";

    const [classCodeArr, setClassCodeArr] = useState([164, 164]);

    const [checkedWindowCleaning, setCheckedWindowCleaning] = useState(false);
    const questionareWindowCleaning = "Do you perform window cleaning?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleHighPressureSwitch = (event) => {
        setChekedHighPressure(event.target.checked);
    };

    const handleWindowCleaningSwitch = (event) => {
        setCheckedWindowCleaning(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([
            questionareHighPressure,
            questionareWindowCleaning,
        ]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([chekedHighPressure, checkedWindowCleaning]);
    }, [setValueArray, chekedHighPressure, checkedWindowCleaning]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: classCodeArr,
        });
    }, [valueArray, questionareArray, setClassCodeFormData, classCodeArr]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="pressureWashingLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent="Do you use pressure greater than 3,000 PSI?" />
                        }
                    />,
                    <Column
                        key="pressureWashingCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleHighPressureSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
            ,
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="windowCleaningLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent="Do you perform window cleaning?" />
                        }
                    />,
                    <Column
                        key="windowCleaningCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleWindowCleaningSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default PressureWashingForm;
