import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";

const ElectricalWorkForm = ({ setClassCodeFormData, disabled }) => {
    const [checkedElectrical, setCheckedElectrical] = useState(false);
    const checkedElectricalQuestionare = "Do you install Electrical Machinery?";

    const [checkedBulgarAlarm, setCheckedBulgarAlarm] = useState(false);
    const checkedBulgarAlarmQuestionare =
        "Do you install burglar or fire alarms, emergency systems work or generators?";

    const [classCodeId, setClassCodeId] = useState([226, 226]);

    const handleCheckedElectricalSwitched = (event) => {
        setCheckedElectrical(event.target.checked);
    };

    const handleBulgarAlarmSwitched = (event) => {
        setCheckedBulgarAlarm(event.target.checked);
    };

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    useEffect(() => {
        setQuestionareArray({
            checkedBulgarAlarmQuestionare,
            checkedElectricalQuestionare,
        });
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray({
            checkedElectrical,
            checkedBulgarAlarm,
        });
    }, [setQuestionareArray, checkedElectrical, checkedBulgarAlarm]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: classCodeId,
        });
    }, [setClassCodeFormData, valueArray, questionareArray, classCodeId]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="checkedElectricalLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label
                                labelContent={checkedElectricalQuestionare}
                            />
                        }
                    />,
                    <Column
                        key="checkedElectricalCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleCheckedElectricalSwitched}
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
                        key="checkBulgarLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label
                                labelContent={checkedBulgarAlarmQuestionare}
                            />
                        }
                    />,
                    <Column
                        key="checkBulgarCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleBulgarAlarmSwitched}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default ElectricalWorkForm;
