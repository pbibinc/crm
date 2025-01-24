import Column from "../element/column-element";
import DateDay from "../element/date-day";
import Label from "../element/label-element";
import Row from "../element/row-element";
import Form from "react-bootstrap/Form";
import Select from "react-select";
import NumericFormatInput from "../element/numeric-format";
const BondForm = () => {
    var bondTypeOptions = [
        { value: "Contractor's License", label: "Contractor's License" },
        {
            value: "Performance / Contract Bond",
            label: "Performance / Contract Bond",
        },
        { value: "Commercial Bond", label: "Commercial Bond" },
        { value: "Bid Bond", label: "Bid Bond" },
        { value: "Payment Bond", label: "Payment Bond" },
    ];

    var bondStatesOptions = [
        { value: "ALABAMA", label: "ALABAMA" },
        { value: "ALASKA", label: "ALASKA" },
        { value: "ARIZONA", label: "ARIZONA" },
        { value: "ARKANSAS", label: "ARKANSAS" },
        { value: "CALIFORNIA", label: "CALIFORNIA" },
        { value: "COLORADO", label: "COLORADO" },
        { value: "CONNECTICUT", label: "CONNECTICUT" },
        { value: "DELAWARE", label: "DELAWARE" },
        { value: "FLORIDA", label: "FLORIDA" },
        { value: "GEORGIA", label: "GEORGIA" },
        { value: "FLORIDA", label: "FLORIDA" },
        { value: "HAWAII", label: "HAWAII" },
        { value: "FLORIDA", label: "FLORIDA" },
        { value: "IDAHO", label: "IDAHO" },
        { value: "FLORIDA", label: "FLORIDA" },
        { value: "ILLINOIS", label: "ILLINOIS" },
        { value: "INDIANA", label: "INDIANA" },
        { value: "IOWA", label: "IOWA" },
        { value: "KANSAS", label: "KANSAS" },
        { value: "KENTUCKY", label: "KENTUCKY" },
        { value: "LOUISIANA", label: "LOUISIANA" },
        { value: "MAINE", label: "MAINE" },
        { value: "MARYLAND", label: "MARYLAND" },
        { value: "MASSACHUSETTS", label: "MASSACHUSETTS" },
        { value: "MICHIGAN", label: "MICHIGAN" },
        { value: "MINNESOTA", label: "MINNESOTA" },
        { value: "MISSISSIPPI", label: "MISSISSIPPI" },
        { value: "MISSOURI", label: "MISSOURI" },
        { value: "MONTANA", label: "MONTANA" },
        { value: "NEBRASKA", label: "NEBRASKA" },
        { value: "NEVADA", label: "NEVADA" },
        { value: "NEW HAMPSHIRE", label: "NEW HAMPSHIRE" },
        { value: "NEW JERSEY", label: "NEW JERSEY" },
        { value: "NEW MEXICO", label: "NEW MEXICO" },
        { value: "NEW YORK", label: "NEW YORK" },
        { value: "NORTH CAROLINA", label: "NORTH CAROLINA" },
        { value: "NORTH DAKOTA", label: "NORTH DAKOTA" },
        { value: "OHIO", label: "OHIO" },
        { value: "OKLAHOMA", label: "OKLAHOMA" },
        { value: "OREGON", label: "OREGON" },
        { value: "PENNSYLVANIA", label: "PENNSYLVANIA" },
        { value: "RHODE ISLAND", label: "RHODE ISLAND" },
        { value: "SOUTH CAROLINA", label: "SOUTH CAROLINA" },
        { value: "TENNESSEE", label: "TENNESSEE" },
        { value: "TEXAS", label: "TEXAS" },
        { value: "UTAH", label: "UTAH" },
        { value: "VERMONT", label: "VERMONT" },
        { value: "VIRGINIA", label: "VIRGINIA" },
        { value: "WASHINGTON", label: "WASHINGTON" },
        { value: "WEST VIRGINIA", label: "WEST VIRGINIA" },
        { value: "WISCONSIN", label: "WISCONSIN" },
        { value: "WYOMING", label: "WYOMING" },
        { value: "Washington", label: "Washington" },
    ];

    const maritalStatus = [
        { value: "Single", label: "Single" },
        { value: "Married", label: "Married" },
        { value: "Married", label: "Married" },
    ];

    return (
        <>
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="bondStates"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Bond State" />
                                <Select
                                    className="basic-single"
                                    clasNamePrefix="select"
                                    options={bondStatesOptions}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="bondType"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Bond Type" />
                                <Select
                                    className="basic-single"
                                    clasNamePrefix="select"
                                    options={bondTypeOptions}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="ssn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="SSN#" />
                                <Form.Control type="text" />
                            </>
                        }
                    />,
                    <Column
                        key="dateOfBirth"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Date of Birth" />
                                <Form.Control type="date" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="maritalStatus"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Marital Status" />
                                <Select
                                    className="basic-single"
                                    clasNamePrefix="select"
                                    options={maritalStatus}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="contractLicense"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Contract License" />
                                <Form.Control type="text" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="bondObligee"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Bond Obligee" />
                                <Form.Control type="text" />
                            </>
                        }
                    />,
                    <Column
                        key="costOfBond"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Cost of Bond" />
                                <NumericFormatInput />
                            </>
                        }
                    />,
                ]}
            />
        </>
    );
};

export default BondForm;
