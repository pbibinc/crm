import React, { useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Select from "react-select";
import ClassCodeData from "../data/classcode-data";
import Input from "../element/input-element";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";

const GeneralLiabilitiesForm = () => {
    const [classCodePercentages, setClassCodePercentage] = useState([0]);
    const totalPercentage = classCodePercentages.reduce(
        (sum, percentage) => sum + percentage,
        0
    );

    const addNewBatch = () => {
        setClassCodePercentage([...classCodePercentages, 0]);
    };

    // Function to update a specific batch's percentage
    const updateClassCodePercentage = (index, value) => {
        const updatePercentage = [...classCodePercentages];
        updatePercentage[index] = value;
        setClassCodePercentage(updatePercentage);
    };

    // Handler for percentage input change
    const handlePercentageChange = (index, event) => {
        const percentage = parseInt(event.target.value);
        const updateClassCodePercentage = [...classCodePercentages];
        updateClassCodePercentage[index] = isNaN(percentage) ? 0 : percentage;
        setClassCodePercentage(updateClassCodePercentage);
        if (totalPercentage > 100) {
            const remainingPercentage = 100 - totalPercentage + percentage;
            setClassCodePercentage([
                ...updateClassCodePercentage,
                remainingPercentage,
            ]);
        }
    };

    const classCodeData = ClassCodeData();
    let classCodeArray = [];
    if (Array.isArray(classCodeData)) {
        classCodeArray = classCodeData;
    } else {
        classCodeArray = [classCodeArray];
    }
    let classCodeOptions = classCodeArray.map((code) => {
        if (code === null) {
            return null;
        }
        return {
            value: code.id,
            label: code.name,
        };
    });
    return (
        <div>
            <Row
                classValue="row"
                classValue2="col-6"
                rowContent={[
                    <Column
                        key="classCodeLabelColumn"
                        classValue="col-2"
                        colContent={<Label labelContent="Class Code" />}
                    />,
                    <Column
                        key="classCodeColumn"
                        classValue="col-8"
                        colContent={
                            <Select
                                className="basic=single"
                                classNamePrefix="select"
                                id="classCode"
                                name="classCode"
                                options={classCodeOptions}
                            />
                        }
                    />,
                    <Column
                        key="inputPercentageColumn"
                        classValue="col-2"
                        colContent={
                            <>
                                {classCodePercentages.map(
                                    (percentage, index) => (
                                        <Form.Control
                                            key={index}
                                            type="text"
                                            value={percentage}
                                            onChange={(event) =>
                                                handlePercentageChange(
                                                    index,
                                                    event
                                                )
                                            }
                                        />
                                    )
                                )}
                                {totalPercentage < 100 && (
                                    <Button onClick={addNewBatch}>+</Button>
                                )}
                            </>
                        }
                    />,
                ]}
            />
        </div>
    );
};
export default GeneralLiabilitiesForm;
