import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
import { set } from "lodash";
const PlumbingResidentialForm = ({ setClassCodeFormData, disabled }) => {
    const [checkedInstallLPGSystem, setCheckedInstallLPGSystem] =
        useState(false);
    const questionareLpgSystem =
        "Do you perform or install LPG systems and piping?";

    const [
        checkedFireSuspensionBoilingWork,
        setCheckedFireSuspensionBoilingWork,
    ] = useState(false);
    const questionareBoilingWork =
        "Do you perform work on fire suppression systems, boiling work or swimming pools?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleInstallationLPGSystemSwitch = (event) => {
        setCheckedInstallLPGSystem(event.target.checked);
    };

    const handleFireSuspensionBoilingWorkSwitch = (event) => {
        setCheckedFireSuspensionBoilingWork(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([questionareLpgSystem, questionareBoilingWork]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([
            checkedInstallLPGSystem,
            checkedFireSuspensionBoilingWork,
        ]);
    }, [
        setValueArray,
        checkedInstallLPGSystem,
        checkedFireSuspensionBoilingWork,
    ]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [191, 191],
        });
    }, [valueArray, questionareArray, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="questionareLpgSystemLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={questionareLpgSystem} />
                        }
                    />,
                    <Column
                        key="questionareLpgSystemCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleInstallationLPGSystemSwitch}
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
                        key="questionareBoilingWorkLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={questionareBoilingWork} />
                        }
                    />,
                    <Column
                        key="boilingWorkCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleFireSuspensionBoilingWorkSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default PlumbingResidentialForm;
