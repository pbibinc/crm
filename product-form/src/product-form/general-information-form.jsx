import React, { useContext, useEffect, useState } from "react";
import {
    useForm,
    FormProvider,
    useFormContext,
    Controller,
} from "react-hook-form";
import InputMask from "react-input-mask";
import Row from "../element/row-element";
import Column from "../element/column-element";

import Label from "../element/label-element";

import LeadZipcode from "../data/lead-zipcode";
import Select from "react-select";
// import LeadCity from "../data/lead-city";
// import LeadZipCodeCities from "../data/lead-city-zipcode";

import Form from "react-bootstrap/Form";

import SaveAsIcon from "@mui/icons-material/SaveAs";
console;
import SaveIcon from "@mui/icons-material/Save";
import { ContextData } from "../contexts/context-data-provider";
import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import Input from "../element/input-element";
import NumericFormatInput from "../element/numeric-format";
import "../style/general-information.css";
import { useGeneralInformation } from "../contexts/general-information-context";
// import GeneralInformationDataProvider from "../providers/general-information-provider";

const GeneralInformationForm = () => {
    const { lead, zipcodes, cities, zipCity } = useContext(ContextData);
    console.log(cities);
    const { generalInformation } = useGeneralInformation() || {};
    const methods = useForm();
    const getStoredGeneralInformation = () => {
        let storedData = sessionStorage.getItem("generalInformationStoredData");
        const storedDataJson = JSON.parse(storedData || "{}");
        return generalInformation
            ? generalInformation.data.data
            : storedDataJson;
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
    const [lastName, setLastName] = useState(() => {
        const storedGeneralInfo = getStoredGeneralInformation();
        return storedGeneralInfo && storedGeneralInfo.lastname
            ? storedGeneralInfo.lastname
            : "";
    });
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
    const [subOut, setSubOut] = useState(
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

    const [userId, setUserId] = useState(
        () => getStoredGeneralInformation().userId || 0
    );

    const [leadId, setLeadId] = useState(lead?.data?.id);

    useEffect(() => {
        setLeadId(lead?.data?.id);
    }, [lead?.data?.id]);

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
            userId: userId,
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
        userId,
    ]);

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
        const numericValue = parseFloat(
            event.target.value.replace(/\D/g, ""),
            10
        );
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
    const onSubmit = (data) => {
        const generalInfomrationFormData = {
            firstname: firstName,
            lastname: lastName,
            job_position: jobPosition,
            address: address,
            zipcode: selectedZipCode?.value,
            state: selectedCity?.value,
            alt_num: alternativeNumber,
            fax: fax,
            email: email,
            full_time_employee: fullTimeEmployee,
            part_time_employee: partTimeEmployee,

            // gross_receipt: parseInt(grossReceipt.replace(/\D/g, ""), 10),
            gross_receipt: grossReceipt,

            // employee_payroll: parseInt(employeePayroll.replace(/\D/g, ""), 10),
            employee_payroll: employeePayroll,

            // sub_out: parseFloat(subOut.replace(/\D/g, ""), 10),
            sub_out: subOut,

            // owners_payroll: parseInt(ownersPayroll.replace(/\D/g, ""), 10),
            owners_payroll: ownersPayroll,
            all_trade_work: allTradesAndWork,
            lead_id: lead?.data?.id,

            // material_cost: parseInt(amount.replace(/\D/g, ""), 10),
            material_cost: amount,

            //
            userId: userId,

            //productId
            productId: lead?.data?.productId ? lead?.data?.productId : 0,
        };
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
                if (error.request.status == 409) {
                    const generalInformation =
                        error.response.data.generalInformation;
                    const userProfile = error.response.data.userProfile;

                    // Styling for the tables
                    const tableStyle =
                        "border-collapse: collapse; width: 100%;";
                    const thStyle =
                        "border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2; color: black;";
                    const tdStyle = "border: 1px solid #ddd; padding: 8px;";

                    let generalInfoTableHtmlFullName = `<table style="${tableStyle}"><thead><tr><th style="${thStyle}">Contact Person:</th><td style="${tdStyle}">${generalInformation.firstname} ${generalInformation.lastname}</td></tr></thead></table>`;
                    let generalInfoTableHtml = `<table style="${tableStyle}"><thead><tr><th style="${thStyle}">Position:</th><td style="${tdStyle}">${generalInformation.job_position}</td></tr></thead></table>`;

                    let userProfileTableHtml = `<table style="${tableStyle}"><thead><tr><th style="${thStyle}">Appointer:</th><td style="${tdStyle}">${userProfile.firstname} ${userProfile.lastname}</td></tr></thead></table>`;

                    Swal.fire({
                        icon: "error",
                        title: "Oops...This Lead is Already Been Appointed",
                        html: `<br>${generalInfoTableHtmlFullName}<br>${generalInfoTableHtml}<br>${userProfileTableHtml}`,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error:: kindly call your IT and Refer to them this error",
                    });
                }
            });
    };
    const { formState } = methods;
    const { errors } = formState;
    return (
        /*Row for First Name And Lastname*/
        lead && LeadZipcode ? (
            <FormProvider {...methods}>
                <form onSubmit={methods.handleSubmit(onSubmit)} noValidate>
                    <Row
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="firstNameColumn"
                                classValue="col-md-6 col-sm-12"
                                colContent={
                                    <>
                                        <Label labelContent="First Name *" />
                                        <Input
                                            label="first name"
                                            type="text"
                                            id="firstName"
                                            inputValue={firstName}
                                            disabled={!isEditing}
                                            onChangeInput={(value) => {
                                                setFirstName(value);
                                            }}
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="lastNameColumn"
                                classValue="col-md-6 col-sm-12"
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
                                            inputValue={lastName}
                                            disabled={!isEditing}
                                            onChangeInput={(value) => {
                                                setLastName(value);
                                            }}
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
                                            inputValue={jobPosition}
                                            disabled={!isEditing}
                                            onChangeInput={(e) =>
                                                setJobPosition(e)
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
                                            isDisabled={true}
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
                                        <Label labelContent="Address *" />
                                        <Input
                                            label="address"
                                            type="text"
                                            id="address"
                                            value={address}
                                            inputValue={address}
                                            disabled={!isEditing}
                                            onChangeInput={(e) => setAddress(e)}
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
                                        <Form.Control
                                            type="text"
                                            id="alternativeNumber"
                                            value={alternativeNumber}
                                            disabled={!isEditing}
                                            onChange={(e) =>
                                                setAlternativeNumber(
                                                    e.target.value
                                                )
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
                                        <InputMask
                                            label="fax"
                                            mask="9-999999999"
                                            type="text"
                                            id="fax"
                                            name="fax"
                                            value={fax}
                                            disabled={!isEditing}
                                            onChange={(e) =>
                                                setFax(e.target.value)
                                            }
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
                                        <Label labelContent="Email *" />
                                        <Input
                                            label="email"
                                            type="email"
                                            id="email"
                                            value={email}
                                            inputValue={email}
                                            disabled={!isEditing}
                                            onChangeInput={(e) => setEmail(e)}
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
                                        <Label labelContent="Full Time Employee *" />
                                        <Input
                                            label="full time employee"
                                            type="number"
                                            id="fullTimeEmployee"
                                            value={fullTimeEmployee}
                                            inputValue={fullTimeEmployee}
                                            disabled={!isEditing}
                                            onChangeInput={(e) =>
                                                setFullTimeEmployee(e)
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
                                        <Label labelContent="Part Time Employee *" />
                                        <Input
                                            label="part time employee"
                                            type="number"
                                            id="partTimeEmployee"
                                            value={partTimeEmployee}
                                            inputValue={partTimeEmployee}
                                            disabled={!isEditing}
                                            onChangeInput={(e) =>
                                                setPartTimeEmployee(e)
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
                                        <Label labelContent="Gross Receipt *" />
                                        <NumericFormatInput
                                            label="gross receipt"
                                            id="grossReceipt"
                                            name="grossReceipt"
                                            inputValue={grossReceipt}
                                            value={grossReceipt}
                                            disabled={!isEditing}
                                            onChangeInput={(e) =>
                                                setGrossReceipt(e)
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
                                        <Label labelContent="Employee Payroll *" />
                                        <NumericFormatInput
                                            label="employee receipt"
                                            id="employeePayroll"
                                            name="employeePayroll"
                                            value={employeePayroll}
                                            disabled={!isEditing}
                                            inputValue={employeePayroll}
                                            onChangeInput={(e) =>
                                                setEmployeePayroll(e)
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
                                            name={"subOut"}
                                            id={"subOut"}
                                            value={subOut}
                                            inputValue={subOut}
                                            disabled={!isEditing}
                                            onChangeInput={(e) => setSubOut(e)}
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="ownersPayrollColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Owners Payroll *" />
                                        <NumericFormatInput
                                            label="owners payroll"
                                            id={"ownersPayroll"}
                                            name={"ownersPayroll"}
                                            value={ownersPayroll}
                                            inputValue={ownersPayroll}
                                            disabled={!isEditing}
                                            onChangeInput={(e) =>
                                                setOwnersPayroll(e)
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
                                <Form.Control
                                    as="textarea"
                                    value={allTradesAndWork}
                                    onChange={(e) =>
                                        setAllTradeAndWork(e.target.value)
                                    }
                                    rows={5}
                                    disabled={!isEditing}
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
                                colContent={
                                    <Label labelContent="Material Cost" />
                                }
                            />,
                            <Column
                                key="materialCostInput"
                                classValue="col-10"
                                colContent={
                                    <>
                                        <NumericFormatInput
                                            label="material cost"
                                            name="samount"
                                            id={"amount"}
                                            value={amount}
                                            inputValue={amount}
                                            disabled={!isEditing}
                                            onChangeInput={(e) => setAmount(e)}
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
                                key="generalLiabilitiesEditButtonColumn"
                                classValue="col-12 d-flex justify-content-center align-items-center"
                                colContent={
                                    <>
                                        <button
                                            size="lg"
                                            // onClick={onSubmit}
                                            type="submit"
                                            disabled={!isEditing}
                                            className="mx-2 form-button"
                                        >
                                            <SaveIcon />
                                            <span className="ms-2">Save</span>
                                        </button>

                                        <button
                                            size="lg"
                                            disabled={isEditing}
                                            onClick={() => setIsEditing(true)}
                                            className="mx-2 form-button-edit"
                                        >
                                            <SaveAsIcon />
                                            <span className="ms-2">Edit</span>
                                        </button>
                                    </>
                                }
                            />,
                        ]}
                    />
                </form>
            </FormProvider>
        ) : (
            <div>loading...</div>
        )
    );
};

export default GeneralInformationForm;
