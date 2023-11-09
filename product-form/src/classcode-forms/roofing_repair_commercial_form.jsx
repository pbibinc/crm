import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const RoofingRepairCommercial = ({ setClassCodeFormData, disabled }) => {
    const [chekedHotWork, setChekedHotWork] = useState(false);
    const questionareHotWork =
        "Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO, waterproofing, waterproof decks?";

    const [checkedWaterproofing, setCheckedWaterproofing] = useState(false);
    const questionareWaterproofing = "waterproofing, waterproof decks?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleHotWorkSwitch = (event) => {
        setChekedHotWork(event.target.checked);
    };

    const hanldeWaterProofingSwitch = (event) => {
        setCheckedWaterproofing(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([questionareHotWork, questionareWaterproofing]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([chekedHotWork, checkedWaterproofing]);
    }, [setValueArray, chekedHotWork, checkedWaterproofing]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [254, 254],
        });
    }, [valueArray, questionareArray, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="questionareHotWorkLableColumn"
                        classValue="col-8"
                        colContent={<Label labelContent={questionareHotWork} />}
                    />,
                    <Column
                        key="questionareHotWorkCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleHotWorkSwitch}
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
                        key="questionareWaterproofingLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={questionareWaterproofing} />
                        }
                    />,
                    <Column
                        key="questionareWaterproofingCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={hanldeWaterProofingSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default RoofingRepairCommercial;
