import React, { useContext, useEffect, useState } from "react";
import { useForm, FormProvider } from "react-hook-form";
import InputMask from "react-input-mask";
import Row from "../element/row-element";
import Column from "../element/column-element";

import Label from "../element/label-element";

import LeadZipcode from "../data/lead-zipcode";
import Select from "react-select";
// import LeadCity from "../data/lead-city";
// import LeadZipCodeCities from "../data/lead-city-zipcode";

import Form from "react-bootstrap/Form";
import axios from "axios";
import Button from "react-bootstrap/Button";
import SaveAsIcon from "@mui/icons-material/SaveAs";
console;
import SaveIcon from "@mui/icons-material/Save";
import { ContextData } from "../contexts/context-data-provider";
import { NumericFormat } from "react-number-format";
import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import Input from "../element/input-element";
import NumericFormatInput from "../element/numeric-format";
import InputMaskElement from "../element/input-mask-element";
import InputTextArea from "../element/input-textarea";
import SelectDropdownElement from "../element/select-dropdown-element";
const GeneralInformationForm = () => {
    const { lead, zipcodes, cities, zipCity } = useContext(ContextData);

    const methods = useForm();

    const getStoredGeneralInformation = () => {
        let storedData = sessionStorage.getItem("generalInformationStoredData");
        if (storedData === null) {
            storedData = localStorage.getItem("generalInformationStoredData");
        }
        return JSON.parse(storedData || "{}");
    };

    const [amount, setAmount] = useState(
        () => getStoredGeneralInformation().amount || ""
    );
    const [selectedZipCode, setSelectedZipCode] = useState(
        () => getStoredGeneralInformation().zipcode || ""
    );
    const [selectedCity, setSelectedCity] = useState(
        () => getStoredGeneralInformation().state || ""
    );
    const [firstName, setFirstName] = useState(
        () => getStoredGeneralInformation().firstname || ""
    );
    const [lastName, setLastName] = useState(
        () => getStoredGeneralInformation().lastname || ""
    );
    const [jobPosition, setJobPosition] = useState(
        () => getStoredGeneralInformation().job_position || ""
    );
    const [address, setAddress] = useState(
        () => getStoredGeneralInformation().address || ""
    );
    const [alternativeNumber, setAlternativeNumber] = useState(
        () => getStoredGeneralInformation().alt_num || ""
    );
    const [fax, setFax] = useState(
        () => getStoredGeneralInformation().fax || ""
    );
    const [email, setEmail] = useState(
        () => getStoredGeneralInformation().email || ""
    );
    const [fullTimeEmployee, setFullTimeEmployee] = useState(
        () => getStoredGeneralInformation().full_time_employee || ""
    );
    const [partTimeEmployee, setPartTimeEmployee] = useState(
        () => getStoredGeneralInformation().part_time_employee || ""
    );
    const [grossReceipt, setGrossReceipt] = useState(
        () => getStoredGeneralInformation().gross_receipt || ""
    );
    const [employeePayroll, setEmployeePayroll] = useState(
        () => getStoredGeneralInformation().employee_payroll || ""
    );
    const [subOut, setSubOUt] = useState(
        () => getStoredGeneralInformation().sub_out || ""
    );
    const [ownersPayroll, setOwnersPayroll] = useState(
        () => getStoredGeneralInformation().owners_payroll || ""
    );
    const [allTradesAndWork, setAllTradeAndWork] = useState(
        () => getStoredGeneralInformation().all_trade_work || ""
    );
    const [isEditing, setIsEditing] = useState(() =>
        getStoredGeneralInformation().isUpdate == true ? false : true
    );
    const [isUpdate, SetIsUpdate] = useState(
        () => getStoredGeneralInformation().isUpdate || false
    );

    // const [storedLeadId, setStoredLeadId] = useState(() => {
    //     const storedgeneralInformationStoredData = JSON.parse(
    //         sessionStorage.getItem("generalInformationStoredData") || "{}"
    //     );
    //     return storedgeneralInformationStoredData.leadId || "";
    // });

    // const [isTheSameLead, setIsTheSameLead] = useState(() => {
    //     const storedIsTheSameLead = JSON.parse(
    //         sessionStorage.getItem("isTheSameLead") || "{}"
    //     );
    //     return storedIsTheSameLead || true;
    // });

    const [leadId, setLeadId] = useState(lead?.data?.id);

    // const [generalInformationStoredData, setgeneralInformationStoredData] = useState({});

    useEffect(() => {
        setLeadId(lead?.data?.id);
    }, [lead?.data?.id]);

    // if(isTheSameLead == false) {
    //     sessionStorage.removeItem("generalInformationStoredData");
    // }

    useEffect(() => {
        const newgeneralInformationStoredData = {
            leadId: leadId,
            firstname: firstName,
            lastname: lastName,
            job_position: jobPosition,
            address: address,
            zipcode: {
                value: selectedZipCode?.value,
                label: selectedZipCode?.value,
            },
            state: { value: selectedCity?.value, label: selectedCity?.value },
            alt_num: alternativeNumber,
            fax: fax,
            email: email,
            full_time_employee: fullTimeEmployee,
            part_time_employee: partTimeEmployee,
            gross_receipt: grossReceipt,
            employee_payroll: employeePayroll,
            sub_out: subOut,
            owners_payroll: ownersPayroll,
            all_trade_work: allTradesAndWork,
            isEditing: isEditing,
            isUpdate: isUpdate,
            amount: amount,
        };
        sessionStorage.setItem(
            "generalInformationStoredData",
            JSON.stringify(newgeneralInformationStoredData)
        );

        localStorage.setItem(
            "generalInformationStoredData",
            JSON.stringify(newgeneralInformationStoredData)
        );
    }, [
        leadId,
        firstName,
        lastName,
        jobPosition,
        address,
        selectedZipCode,
        selectedCity,
        alternativeNumber,
        fax,
        email,
        fullTimeEmployee,
        partTimeEmployee,
        grossReceipt,
        employeePayroll,
        subOut,
        ownersPayroll,
        allTradesAndWork,
        isEditing,
        isUpdate,
        amount,
    ]);

    const generalInfomrationFormData = {
        firstname: firstName,
        lastname: lastName,
        job_position: jobPosition,
        address: address,
        zipcode: selectedZipCode?.value,
        state: selectedCity?.value,
        alt_num: alternativeNumber,
        fax: parseInt(fax.replace(/\D/g, ""), 10),
        email: email,
        full_time_employee: fullTimeEmployee,
        part_time_employee: partTimeEmployee,
        gross_receipt: parseInt(grossReceipt.replace(/\D/g, ""), 10),
        employee_payroll: parseInt(employeePayroll.replace(/\D/g, ""), 10),
        sub_out: parseFloat(subOut.replace(/\D/g, ""), 10),
        owners_payroll: parseInt(ownersPayroll.replace(/\D/g, ""), 10),
        all_trade_work: allTradesAndWork,
        lead_id: lead?.data?.id,
        material_cost: parseInt(amount.replace(/\D/g, ""), 10),
    };

    function submitGeneralInformationForm() {
        const leadIdTobeUpdates = lead?.data?.id;

        const url = isUpdate
            ? `/api/general-information-data/${leadIdTobeUpdates}`
            : "/api/general-information-data";

        const method = isUpdate ? "put" : "post";

        axiosClient[method](url, generalInfomrationFormData)
            .then((response) => {
                setIsEditing(false);
                SetIsUpdate(true);
                if (isUpdate) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "General Information has been updated",
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "General Information has been saved",
                    });
                }
            })
            .catch((error) => {
                console.log("Error::", error);
            });
    }

    // const Lead = LeadDetails();

    const leadsZipCodeCity = zipCity;
    let zipCityArray = [];

    if (Array.isArray(leadsZipCodeCity)) {
        zipCityArray = leadsZipCodeCity;
    } else {
        zipCityArray = [leadsZipCodeCity];
    }
    //handle change for zipcode
    const handleZipCodeChange = (selectedOption) => {
        setSelectedZipCode(selectedOption);
        const correspondingCity = zipCityArray.find(
            (item) => item.zipcode === selectedOption.value
        );
        if (correspondingCity) {
            const citySelected = {
                value: correspondingCity.city,
                label: correspondingCity.city,
            };
            setSelectedCity(citySelected);
            sessionStorage.setItem("city", JSON.stringify(citySelected));
            sessionStorage.setItem("zipcode", JSON.stringify(selectedOption));
        }
    };

    //handle change for city
    const handleCityChange = (selectedOption) => {
        setSelectedCity(selectedOption);

        const correspondingZipCode = zipCityArray.find(
            (item) => item.city === selectedOption.value
        );

        if (correspondingZipCode) {
            const zipCodeSelected = {
                value: correspondingZipCode.zipcode,
                label: correspondingZipCode.zipcode,
            };
            setSelectedZipCode(zipCodeSelected);

            sessionStorage.setItem("zipcode", JSON.stringify(zipCodeSelected));
            sessionStorage.setItem("city", JSON.stringify(selectedOption));
        }
    };

    // Hande Amount change for Material Cost
    const handleAmountChange = (event) => {
        setAmount(event.target.value);
    };

    //script for city and zipcode dropdown

    let zipCodeArray = [];
    if (zipcodes !== undefined && zipcodes !== null) {
        zipCodeArray = Object.values(zipcodes.toString().split(","));
    }

    let cityArray = [];
    if (cities !== undefined && cities !== null) {
        cityArray = Object.values(cities.toString().split(","));
    }
    let zipCodeOptions = zipCodeArray.map((zip) => {
        if (zip === null) {
            return null;
        }
        return {
            value: zip,
            label: zip,
        };
    });

    let cityDropdown = cityArray.map((city) => {
        if (city === null) {
            return null;
        }
        return {
            value: city,
            label: city,
        };
    });
    const onSubmit = methods.handleSubmit((data) => {
        console.log(data);
    });

    return (
        /*Row for First Name And Lastname*/
        lead && LeadZipcode ? (
            <FormProvider {...methods}>
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="firstNameColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="First Name *" />
                                    <Input
                                        label="first name"
                                        type="text"
                                        id="firstName"
                                        value={firstName}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setFirstName(e.target.value)
                                        }
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
                                        labelContent="Last Name *"
                                        forValue="lastName"
                                    />
                                    <Input
                                        label="last name"
                                        type="text"
                                        id="lastName"
                                        value={lastName}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setLastName(e.target.value)
                                        }
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
                                        labelContent="Job Position *"
                                        forValue="jobPosition"
                                    />
                                    <Input
                                        label="job position"
                                        type="text"
                                        id="jobPosition"
                                        value={jobPosition}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setJobPosition(e.target.value)
                                        }
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
                                    <Label labelContent="Zip Code *" />
                                    <Select
                                        label="zip code"
                                        // isSearchable={isSearchable}
                                        id="zipCodeDropdown"
                                        name="zipCodeDropdown"
                                        options={zipCodeOptions}
                                        value={selectedZipCode}
                                        isDisabled={!isEditing}
                                        onChange={handleZipCodeChange}
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="cityColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="City" />
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
                                        // isSearchable={isSearchable}
                                        id="zipCodeDropdown"
                                        name="zipCodeDropdown"
                                        options={cityDropdown}
                                        value={selectedCity}
                                        isDisabled="true"
                                        onChange={handleCityChange}
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
                            key="addressColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Address" />
                                    <Input
                                        label="address"
                                        type="text"
                                        id="address"
                                        value={address}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setAddress(e.target.value)
                                        }
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
                                    <Form.Control
                                        type="text"
                                        disabled
                                        readOnly
                                        value={lead?.data?.state_abbr || ""}
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
                            key="alternativeNumColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Alternative Number" />
                                    <Input
                                        label="alternative number"
                                        type="text"
                                        id="alternativeNumber"
                                        value={alternativeNumber}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setAlternativeNumber(e.target.value)
                                        }
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="faxColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Fax" />
                                    <InputMaskElement
                                        label="fax"
                                        mask="9-999999999"
                                        type="text"
                                        id="fax"
                                        name="fax"
                                        value={fax}
                                        disabled={!isEditing}
                                        onChange={(e) => setFax(e.target.value)}
                                        className="form-control"
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
                            key="emailColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Email" />
                                    <Input
                                        label="email"
                                        type="email"
                                        id="email"
                                        value={email}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setEmail(e.target.value)
                                        }
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
                            key="fullTimeEmployeeColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Full Time Employee" />
                                    <Input
                                        label="full time employee"
                                        type="number"
                                        id="fullTimeEmployee"
                                        value={fullTimeEmployee}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setFullTimeEmployee(e.target.value)
                                        }
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="partTimeEmployeeColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Part Time Employee" />
                                    <Input
                                        label="part time employee"
                                        type="number"
                                        id="partTimeEmployee"
                                        value={partTimeEmployee}
                                        disabled={isEditing}
                                        onChange={(e) =>
                                            setPartTimeEmployee(e.target.value)
                                        }
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
                            key="grossReceiptColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Gross Receipt" />
                                    <NumericFormatInput
                                        label="gross receipt"
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        value={grossReceipt}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setGrossReceipt(e.target.value)
                                        }
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="employeePayrollColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Employee Payroll" />
                                    <NumericFormatInput
                                        label="employee receipt"
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        value={employeePayroll}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setEmployeePayroll(e.target.value)
                                        }
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
                            key="subOutColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Sub Out/1099" />
                                    <NumericFormatInput
                                        label="sub out"
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        value={subOut}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setSubOUt(e.target.value)
                                        }
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="ownersPayrollColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Owners Payroll" />
                                    <NumericFormatInput
                                        label="owners payroll"
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        value={ownersPayroll}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setOwnersPayroll(e.target.value)
                                        }
                                    />
                                </>
                            }
                        />,
                    ]}
                />
                <Row
                    classValue="mb-4"
                    rowContent={
                        <div>
                            <Label labelContent="List ALL trades and or work that you subcontract" />
                            <InputTextArea
                                label="all trade work"
                                value={allTradesAndWork}
                                onChange={(e) =>
                                    setAllTradeAndWork(e.target.value)
                                }
                                rows={5}
                                disabled={isEditing}
                            />
                        </div>
                    }
                />

                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="materialCostLableColumn"
                            classValue="col-2"
                            colContent={<Label labelContent="Material Cost" />}
                        />,
                        <Column
                            key="materialCostInput"
                            classValue="col-10"
                            colContent={
                                <NumericFormatInput
                                    label="material cost"
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    value={`$${amount}`}
                                    disabled={!isEditing}
                                    onChange={handleAmountChange}
                                />
                            }
                        />,
                    ]}
                />

                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="generalLiabilitiesEditButtonColumn"
                            classValue="col-12 d-flex justify-content-center align-items-center"
                            colContent={
                                <>
                                    <Button
                                        variant="success"
                                        size="lg"
                                        onClick={onSubmit}
                                        disabled={!isEditing}
                                        className="mx-2"
                                    >
                                        <SaveIcon />
                                        <span className="ms-2">Save</span>
                                    </Button>
                                    <Button
                                        variant="primary"
                                        size="lg"
                                        disabled={isEditing}
                                        onClick={() => setIsEditing(true)}
                                        className="mx-2"
                                    >
                                        <SaveAsIcon />
                                        <span className="ms-2">Edit</span>
                                    </Button>
                                </>
                            }
                        />,
                    ]}
                />
            </FormProvider>
        ) : (
            <div>loading...</div>
        )
    );
};

export default GeneralInformationForm;
