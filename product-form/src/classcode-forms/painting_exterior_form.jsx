import React, { useEffect, useState } from "react";

import Row from "../element/row-element";
import Label from "../element/label-element";
import Column from "../element/column-element";
import Form from "react-bootstrap/Form";
//import { set } from "lodash";
const PaintingExteriorForm = ({ setClassCodeFormData, disabled }) => {
    const [chekedTallWallBuilding, setChekedTallWallBuilding] = useState(false);
    const questionareWallBuilding =
        "Do you perfrom spray work above 3 stories?";

    const [checkedPaintingRoofDecks, setCheckedPaintingRoofDecks] =
        useState(false);
    const questionarePaintingRoofDecks =
        "Do you perform painting on roofs or roof decks, roads and highways?";

    const [checkedPerformAutomotive, setCheckedPerformAutomotive] =
        useState(false);
    const questionareAutomotive = "Do you perform any automotive painting?";

    const [questionareArray, setQuestionareArray] = useState([]);
    const [valueArray, setValueArray] = useState([]);

    const handleTallBuildingSwitch = (event) => {
        setChekedTallWallBuilding(event.target.checked);
    };

    const handlePaintingRoofDecksSwitch = (event) => {
        setCheckedPaintingRoofDecks(event.target.checked);
    };

    const handleAutomotiveSwitch = (event) => {
        setCheckedPerformAutomotive(event.target.checked);
    };

    useEffect(() => {
        setQuestionareArray([
            questionareWallBuilding,
            questionarePaintingRoofDecks,
            questionareAutomotive,
        ]);
    }, [setQuestionareArray]);

    useEffect(() => {
        setValueArray([
            chekedTallWallBuilding,
            checkedPaintingRoofDecks,
            checkedPerformAutomotive,
        ]);
    }, [
        setValueArray,
        chekedTallWallBuilding,
        checkedPaintingRoofDecks,
        checkedPerformAutomotive,
    ]);

    useEffect(() => {
        setClassCodeFormData({
            value: valueArray,
            description: questionareArray,
            classcodeId: [245, 245, 245],
        });
    }, [valueArray, questionareArray, setClassCodeFormData]);

    return (
        <>
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="wallBuildingLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={questionareWallBuilding} />
                        }
                    />,
                    <Column
                        key="wallBuildingCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleTallBuildingSwitch}
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
                        key="paintingRoofDecksLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label
                                labelContent={questionarePaintingRoofDecks}
                            />
                        }
                    />,
                    <Column
                        key="paintingRoofDecksCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handlePaintingRoofDecksSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
            .
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="automotiveLableColumn"
                        classValue="col-8"
                        colContent={
                            <Label labelContent={questionareAutomotive} />
                        }
                    />,
                    <Column
                        key="automotiveCheckboxColumn"
                        classValue="col-4"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleAutomotiveSwitch}
                                disabled={disabled}
                            />
                        }
                    />,
                ]}
            />
        </>
    );
};

export default PaintingExteriorForm;
