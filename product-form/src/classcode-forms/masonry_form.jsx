import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const MasonryForm = ({ setClassCodeFormData, disabled }) => {
    const [chekedWorkSwimmingPools, setChekedWorkSwimmingPools] =
        useState(false);
    const workSwimmingPoolsQuestionare =
        "Do you perfrom any work on swimming pools?";

    const [checkedTallWalls, setCheckedTallWalls] = useState(false);
    const tallWallsQuestionare =
        "Do you perfrom work on retaining walls greater than 6 feet in height?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleSwimmingPoolsSwitch = (event) => {
        setChekedWorkSwimmingPools(event.target.checked);
    };

    const handleTallWallsSwitch = (event) => {
        setCheckedTallWalls(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([
            workSwimmingPoolsQuestionare,
            tallWallsQuestionare,
        ]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([chekedWorkSwimmingPools, checkedTallWalls]);
    }, [setValueArray, chekedWorkSwimmingPools, checkedTallWalls]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [51, 51],
        });
    }, [valueArray, questionareArray, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="workSwimmingPoolsLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label
                                labelContent={workSwimmingPoolsQuestionare}
                            />
                        }
                    />,
                    <Column
                        key="workSwimmingPoolsCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleSwimmingPoolsSwitch}
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
                        key="tallWallsLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={tallWallsQuestionare} />
                        }
                    />,
                    <Column
                        key="tallWallsCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleTallWallsSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default MasonryForm;
