import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const JanitorialServicesForm = ({ setClassCodeFormData, disabled }) => {
    const [chekedRetail, setChekedRetail] = useState(false);
    const retailQuestionare =
        "Do you do any retail work or sales on cleaning supplies?";

    const [checkedCommercialFloorWaxing, setCheckedCommercialFloorWaxing] =
        useState(false);
    const commercialFloorWaxingQuestionare =
        "How about Commercial Floor Waxing?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleCheckBoxColumn = (event) => {
        setChekedRetail(event.target.checked);
    };

    const handleCommercialFloorWaxingSwitch = (event) => {
        setCheckedCommercialFloorWaxing(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([
            retailQuestionare,
            commercialFloorWaxingQuestionare,
        ]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([chekedRetail, checkedCommercialFloorWaxing]);
    }, [setValueArray, chekedRetail, checkedCommercialFloorWaxing]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [17, 17],
        });
    }, [valueArray, questionareArray, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="retailLabelColumn"
                        classValue="col-8"
                        colContent={<Label labelContent={retailQuestionare} />}
                    />,
                    <Column
                        key="retailCheckBoxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleCheckBoxColumn}
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
                        key="commercialWindowLabelColumn"
                        classValue="col-8"
                        colContent={
                            <Label
                                labelContent={commercialFloorWaxingQuestionare}
                            />
                        }
                    />,
                    <Column
                        key="windowCleaningCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleCommercialFloorWaxingSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default JanitorialServicesForm;
