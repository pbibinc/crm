import React, { useEffect, useState } from "react";
import InputMask from "react-input-mask";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Input from "../element/input-element";
import Label from "../element/label-element";

import LeadDetails from "../data/lead-details";
import LeadZipcode from "../data/lead-zipcode";
import Select from "react-select";
import LeadCity from "../data/lead-city";
import LeadZipCodeCities from "../data/lead-city-zipcode";
import { set } from "lodash";
import DescriptionBox from "../element/description-element";
import TextBox from "../element/description-element";

const GeneralInformationForm = () => {
    const [selectedZipCode, setSelectedZipCode] = useState(null);
    const [selectedCity, setSelectedCity] = useState(null);
    const Lead = LeadDetails();
    const zipcode = LeadZipcode();
    const city = LeadCity();
    const leadsZipCodeCity = LeadZipCodeCities();
    let zipCityArray = [];
    // const { control } = useForm();

    if (Array.isArray(leadsZipCodeCity)) {
        zipCityArray = leadsZipCodeCity;
    } else {
        zipCityArray = [leadsZipCodeCity];
    }

    const handleZipCodeChange = (selectedOption) => {
        setSelectedZipCode(selectedOption);
        const correspondingCity = zipCityArray.find(
            (item) => item.zipcode === selectedOption.value
        );
        if (correspondingCity) {
            setSelectedCity({
                value: correspondingCity.city,
                label: correspondingCity.city,
            });
        }
    };

    const handleCityChange = (selectedOption) => {
        setSelectedCity(selectedOption);

        const correspondingZipCode = zipCityArray.find(
            (item) => item.city === selectedOption.value
        );

        if (correspondingZipCode) {
            setSelectedZipCode({
                value: correspondingZipCode.zipcode,
                label: correspondingZipCode.zipcode,
            });
        }
    };

    let cityArray = Object.values(city.toString().split(","));
    let zipCodeArray = Object.values(zipcode.toString().split(","));

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
                                    validation={{ required: true }}
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
                                    validation={{ required: true }}
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
                                    validation={{ required: true }}
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
                                    type="text"
                                    classValue="form-control"
                                    id="address"
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
                                    type="text"
                                    classValue="form-control"
                                    id="alternativeNumber"
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
                                    mask="9 - 999999999"
                                    type="text"
                                    id="fax"
                                    name="fax"
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
                                    type="email"
                                    classValue="form-control"
                                    id="email"
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
                                    type="number"
                                    classValue="form-control"
                                    id="fullTimeEmployee"
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
                                    type="number"
                                    classValue="form-control"
                                    id="partTimeEmployee"
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
                                    defaultValue="0"
                                    prefix="$"
                                    placeholder="0"
                                    maskPlaceholder={null}
                                    id="grossReceipt"
                                    name="grossReceipt"
                                    className="form-control"
                                    inputMode="numeric"
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
                                    defaultValue="0"
                                    prefix="$"
                                    placeholder="0"
                                    maskPlaceholder={null}
                                    id="employeePayroll"
                                    name="employeePayroll"
                                    className="form-control"
                                    inputMode="numeric"
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
                                    defaultValue="0"
                                    prefix="$"
                                    placeholder="0"
                                    maskPlaceholder={null}
                                    id="subOut"
                                    name="subOut"
                                    className="form-control"
                                    inputMode="numeric"
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
                                    defaultValue="0"
                                    prefix="$"
                                    placeholder="0"
                                    maskPlaceholder={null}
                                    id="ownersPayroll"
                                    name="ownersPayroll"
                                    className="form-control"
                                    inputMode="numeric"
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={
                    <div>
                        <Label labelContent="List ALL trades and or work that you subcontract" />
                        <TextBox />
                    </div>
                }
            />
        </form>
    );
};

export default GeneralInformationForm;
