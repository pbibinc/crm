import React from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Input from "../element/input-element";
import Label from "../element/label-element";
import Select from "../element/select-elemt";
import LeadDetails from "../data/lead-details";
import LeadAddress from "../data/lead-address";

const GeneralInformationForm = () => {
    const Lead = LeadDetails();
    // const LeadAddress = LeadAddress();
    // console.log(LeadAddress);
    // const state = LeadAddress?.data?.state;
    return (
        <form action="">
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="firstNameColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label
                                    labelContent="First Name"
                                    forValue="firstName"
                                />
                                <Input
                                    type="text"
                                    classValue="form-control"
                                    id="firstName"
                                />
                            </>
                        }
                    />,
                    <Column
                        key="lastNameColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label
                                    labelContent="Last Name"
                                    forValue="lastName"
                                />
                                <Input
                                    type="text"
                                    classValue="form-control"
                                    id="lastName"
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="jobPostionColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label
                                    labelContent="Job Position"
                                    forValue="jobPosition"
                                />
                                <Input
                                    type="text"
                                    classValue="form-control"
                                    id="jobPosition"
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="zipCodeColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Zip Code" />
                                <Select
                                    classValue="form-select"
                                    id="zipCodeDropdown"
                                    name="zipCodeDropdown"
                                    optionContent="Choose..."
                                    optionValue=""
                                />
                            </>
                        }
                    />,
                    <Column
                        key="cityColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="State" />
                                <Input
                                    type="text"
                                    classValue="form-control"
                                    id="state"
                                    inputValue={Lead?.data?.state_abbr}
                                />
                            </>
                        }
                    />,
                ]}
            />
        </form>
    );
};

export default GeneralInformationForm;
