import React, { useContext, useEffect, useState } from "react";
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
import SaveAsiCon from "@mui/icons-material/SaveAs";
console
import SaveIcon from "@mui/icons-material/Save";
import { ContextData } from "../contexts/context-data-provider";

const GeneralInformationForm = () => {
    const { lead, zipcodes, cities, zipCity } = useContext(ContextData);

    const getStoredGeneralInformation = () => {
        let storedData = sessionStorage.getItem("generalInformationStoredData");
        if (storedData === null) {
            storedData = localStorage.getItem("generalInformationStoredData");
        }
        return JSON.parse(storedData || "{}");
    };

    const [amount, setAmount] = useState(() => getStoredGeneralInformation().amount || "");
    const [selectedZipCode, setSelectedZipCode] = useState(() => getStoredGeneralInformation().zipcode || "");
    const [selectedCity, setSelectedCity] = useState(() => getStoredGeneralInformation().state || "");
    const [firstName, setFirstName] = useState(() => getStoredGeneralInformation().firstname || "");
    const [lastName, setLastName] = useState(() => getStoredGeneralInformation().lastname || "");
    const [jobPosition, setJobPosition] = useState(() => getStoredGeneralInformation().job_position || "");
    const [address, setAddress] = useState(() => getStoredGeneralInformation().address || "");
    const [alternativeNumber, setAlternativeNumber] = useState(() => getStoredGeneralInformation().alt_num || "");
    const [fax, setFax] = useState(() => getStoredGeneralInformation().fax || "");
    const [email, setEmail] = useState(() => getStoredGeneralInformation().email || "");
    const [fullTimeEmployee, setFullTimeEmployee] = useState(() => getStoredGeneralInformation().full_time_employee || "");
    const [partTimeEmployee, setPartTimeEmployee] = useState(() => getStoredGeneralInformation().part_time_employee || "");
    const [grossReceipt, setGrossReceipt] = useState(() => getStoredGeneralInformation().gross_receipt || "");
    const [employeePayroll, setEmployeePayroll] = useState(() => getStoredGeneralInformation().employee_payroll || "");
    const [subOut, setSubOUt] = useState(() => getStoredGeneralInformation().sub_out || "");
    const [ownersPayroll, setOwnersPayroll] = useState(() => getStoredGeneralInformation().owners_payroll || "");
    const [allTradesAndWork, setAllTradeAndWork] = useState(() => getStoredGeneralInformation().all_trade_work || "");
    const [isEditing, setIsEditing] = useState(() => getStoredGeneralInformation().isUpdate == true ? false : true);
    const [isUpdate, SetIsUpdate] = useState(() => getStoredGeneralInformation().isUpdate || false);

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
        sessionStorage.setItem("generalInformationStoredData", JSON.stringify(newgeneralInformationStoredData));

        localStorage.setItem("generalInformationStoredData", JSON.stringify(newgeneralInformationStoredData));
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
            ? `http://insuraprime_crm.test/api/general-information-data/${leadIdTobeUpdates}`
            : "http://insuraprime_crm.test/api/general-information-data";

        const method = isUpdate ? "put" : "post";

        axios[method](url, generalInfomrationFormData)
            .then((response) => {
                alert(JSON.stringify(response.data));
                setIsEditing(false);
                SetIsUpdate(true);

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
        const numbericValue = event.target.value.replace(/[^0-9]/g, "");
        const formattedValue = numbericValue.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ","
        );
        setAmount(formattedValue);
    };



    //script for city and zipcode dropdown


    let zipCodeArray = []
    if (zipcodes !== undefined && zipcodes !== null) {
        zipCodeArray = Object.values(zipcodes.toString().split(","));
      }

    let cityArray = []
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

    return (
        /*Row for First Name And Lastname*/
        lead && LeadZipcode ? (
            <form action="">
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="firstNameColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="First Name" />
                                    <Form.Control
                                        type="text"
                                        id="firstName"
                                        value={firstName}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setFirstName(e.target.value)
                                        }
                                        required
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
                                    <Form.Control
                                        type="text"
                                        id="lastName"
                                        value={lastName}
                                        disabled={!isEditing}
                                        onChange={(e) =>
                                            setLastName(e.target.value)
                                        }
                                        required
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
                                    <Form.Control
                                        type="text"
                                        id="jobPosition"
                                        value={jobPosition}
                                        disabled={!isEditing}
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
                                    <Label labelContent="Zip Code" />
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
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
                                        isDisabled={!isEditing}
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
                                    <Form.Control
                                        type="text"
                                        id="address"
                                        value={address}
                                        disabled={!isEditing}
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
                                    <Form.Control
                                        type="text"
                                        id="alternativeNumber"
                                        value={alternativeNumber}
                                        disabled={!isEditing}
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
                                    <InputMask
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
                                    <Form.Control
                                        type="email"
                                        id="email"
                                        value={email}
                                        disabled={!isEditing}
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
                                    <Form.Control
                                        type="number"
                                        id="fullTimeEmployee"
                                        value={fullTimeEmployee}
                                        disabled={!isEditing}
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
                                    <Form.Control
                                        type="number"
                                        id="partTimeEmployee"
                                        value={partTimeEmployee}
                                        disabled={!isEditing}
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
                                    <InputMask
                                        mask="999,999,999.99"
                                        prefix="$"
                                        placeholder="0"
                                        maskPlaceholder={null}
                                        id="grossReceipt"
                                        name="grossReceipt"
                                        className="form-control"
                                        inputMode="numeric"
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
                                    <InputMask
                                        mask="999,999,999.99"
                                        prefix="$"
                                        placeholder="0"
                                        maskPlaceholder={null}
                                        id="employeePayroll"
                                        name="employeePayroll"
                                        className="form-control"
                                        inputMode="numeric"
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
                                    <InputMask
                                        mask="999,999,999.99"
                                        prefix="$"
                                        placeholder="0"
                                        maskPlaceholder={null}
                                        id="subOut"
                                        name="subOut"
                                        className="form-control"
                                        inputMode="numeric"
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
                                    <InputMask
                                        mask="999,999,999.99"
                                        alwaysShowMask={false}
                                        prefix="$"
                                        placeholder="0"
                                        maskPlaceholder={null}
                                        id="ownersPayroll"
                                        name="ownersPayroll"
                                        className="form-control"
                                        inputMode="numeric"
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
                            colContent={<Label labelContent="Material Cost" />}
                        />,
                        <Column
                            key="materialCostInput"
                            classValue="col-10"
                            colContent={
                                <Form.Control
                                    type="text"
                                    id="materialCost"
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
                            key="saveButtonColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <div className="d-grid gap-2">
                                        {" "}
                                        <Button
                                            variant="success"
                                            size="lg"
                                            style={{ marginRight: "10px" }}
                                            onClick={
                                                submitGeneralInformationForm
                                            }
                                            disabled={!isEditing}
                                        >
                                            <SaveIcon />
                                        </Button>
                                    </div>
                                </>
                            }
                        />,
                        <Column
                            key="editButtonColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <div className="d-grid gap-2">
                                        <Button
                                            variant="primary"
                                            size="lg"
                                            disabled={isEditing}
                                            onClick={() => setIsEditing(true)}
                                        >
                                            <SaveAsiCon />
                                        </Button>{" "}
                                    </div>
                                </>
                            }
                        />,
                    ]}
                />
            </form>
        ) : (
            <div>loading...</div>
        )
    );
};

export default GeneralInformationForm;
