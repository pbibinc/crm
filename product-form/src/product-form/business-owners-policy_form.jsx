import React, { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";
import Select from "react-select";
import { NumericFormat } from "react-number-format";
import InputMask from "react-input-mask";
import DatePicker from "react-datepicker";

import Button from "react-bootstrap/Button";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import SaveIcon from "@mui/icons-material/Save";
import axios from "axios";
import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";
import { ContextData } from "../contexts/context-data-provider";
import { useBusinessOwnersPolicy } from "../contexts/business-owners-policy-context";
const BusinessOwnersPolicyForm = () => {
    const { businessOwnersPolicyData } = useBusinessOwnersPolicy() || {};
    //setting for getting lead data from session stroage
    const storedLeads = JSON.parse(sessionStorage.getItem("lead"));

    //setting for getting the businessOwnersPolicyData from session storage
    const storedBusinessOwnersPolicyData = () => {
        const businessOwnersStoredData =
            JSON.parse(sessionStorage.getItem("BusinessOwnersPolicyData")) ||
            {};
        return businessOwnersPolicyData
            ? businessOwnersPolicyData.data
            : businessOwnersStoredData;
    };

    // setting for most of the variables
    const [propertyAddress, setPropertyAddress] = useState(
        () => storedBusinessOwnersPolicyData().propertyAddress || ""
    );
    const [lossPayeeInformation, setLossPayeeInformation] = useState(
        () => storedBusinessOwnersPolicyData().lossPayeeInformation || ""
    );
    const [buildingIndustry, setBuildingIndustry] = useState(
        () => storedBusinessOwnersPolicyData().buildingIndustry || ""
    );
    const [occupancy, setOccupancy] = useState(
        () => storedBusinessOwnersPolicyData().occupancy || {}
    );
    const [costOfBuilding, setCostOfBuilding] = useState(
        () => storedBusinessOwnersPolicyData().costOfBuilding || ""
    );
    const [buildingPropertyLimit, setBuildingPropertyLimit] = useState(
        () => storedBusinessOwnersPolicyData().buildingPropertyLimit || ""
    );
    const [buildingConstructionType, setBuildingConstructionType] = useState(
        () => storedBusinessOwnersPolicyData().buildingConstructionType || {}
    );
    const [yearBuilt, setYearBuilt] = useState(
        () => storedBusinessOwnersPolicyData().yearBuilt || ""
    );
    const [squareFootage, setSquareFootage] = useState(
        () => storedBusinessOwnersPolicyData().squareFootage || ""
    );
    const [numberOfFloors, setNumberOfFloors] = useState(
        () => storedBusinessOwnersPolicyData().numberOfFloors || ""
    );
    const [automaticSprinklerSystem, setAutomaticSprinklerSystem] = useState(
        () => storedBusinessOwnersPolicyData().automaticSprinklerSystem || ""
    );
    const [automaticFireAlarm, setAutomaticFireAlarm] = useState(
        () => storedBusinessOwnersPolicyData().automaticFireAlarm || ""
    );
    const [distanceToNearestFireHydrant, setDistanceToNearestFireHydrant] =
        useState(
            () =>
                storedBusinessOwnersPolicyData().distanceToNearestFireHydrant ||
                ""
        );
    const [distanceToNearestFireStation, setDistanceToNearestFireStation] =
        useState(
            () =>
                storedBusinessOwnersPolicyData().distanceToNearestFireStation ||
                ""
        );
    const [
        automaticCommercialCookingExtinguishingSystem,
        setAutomaticCommercialCookingExtinguishingSystem,
    ] = useState(
        () =>
            storedBusinessOwnersPolicyData()
                .automaticCommercialCookingExtinguishingSystem || {}
    );
    const [automaticBurglarAlarm, setAutomaticBurglarAlarm] = useState(
        () => storedBusinessOwnersPolicyData().automaticBurglarAlarm || {}
    );
    const [securityCamera, setSecurityCamera] = useState(
        () => storedBusinessOwnersPolicyData().securityCamera || {}
    );
    const [lastUpdateRoofingYear, setLastUpdateRoofingYear] = useState(
        () => storedBusinessOwnersPolicyData().lastUpdateRoofingYear || ""
    );
    const [lastUpdateHeatingYear, setLastUpdateHeatingYear] = useState(
        () => storedBusinessOwnersPolicyData().lastUpdateHeatingYear || ""
    );
    const [lastUpdatePlumbingYear, setLastUpdatePlumbingYear] = useState(
        () => storedBusinessOwnersPolicyData().lastUpdatePlumbingYear || ""
    );
    const [lastUpdateElectricalYear, setLastUpdateElectricalYear] = useState(
        () => storedBusinessOwnersPolicyData().lastUpdateElectricalYear || ""
    );
    const [expirationOfIM, setExpirationOfIM] = useState(() =>
        storedBusinessOwnersPolicyData().expirationOfIM
            ? new Date(storedBusinessOwnersPolicyData().expirationOfIM)
            : new Date()
    );
    const [priorCarrier, setPriorCarrier] = useState(
        () => storedBusinessOwnersPolicyData().priorCarrier || ""
    );
    const [amountOfBusinessOwnersPolicy, setAmountOfBusinessOwnersPolicy] =
        useState(
            () =>
                storedBusinessOwnersPolicyData().amountOfBusinessOwnersPolicy ||
                ""
        );

    const [dateOfLoss, setDateOfLoss] = useState(() =>
        storedBusinessOwnersPolicyData().dateOfLoss
            ? new Date(storedBusinessOwnersPolicyData().dateOfLoss)
            : new Date()
    );
    const [lossAmount, setLossAmount] = useState(
        () => storedBusinessOwnersPolicyData().lossAmount || ""
    );

    const [isEditing, setIsEditing] = useState(() =>
        storedBusinessOwnersPolicyData().isUpdate == true ? false : true
    );
    const [isUpdate, setIsUpdate] = useState(
        () => storedBusinessOwnersPolicyData().isUpdate || false
    );

    // setting for building industry option
    const buildingIndustryOptions = [
        {
            value: "Apartment and Condo Assoc",
            label: "Apartment and Condo Assoc",
        },
        {
            value: "Auto Repair/Service and Car Washes",
            label: "Auto Repair/Service and Car Washes",
        },
        {
            value: "Contractor and Landscaper",
            label: "Contractor and Landscaper",
        },
        {
            value: "Grocery, Convenience Store",
            label: "Grocery, Convenience Store",
        },
        { value: "Gas Station", label: "Gas Station" },
        { value: "Offices", label: "Offices" },
        { value: "Restaurants and Hotels", label: "Restaurants and Hotels" },
        { value: "Retail Stores", label: "Retail Stores" },
        { value: "Service Providers", label: "Service Providers" },
        { value: "Whole Salers", label: "Whole Salers" },
    ];

    //setting for construction type option
    const constructionTypeOptions = [
        { value: "Frame", label: "Frame" },
        { value: "Joisted Masonry", label: "Joisted Masonry" },
        { value: "Non-Combustible", label: "Non-Combustible" },
        { value: "Masonry Non-Combustible", label: "Masonry Non-Combustible" },
        { value: "Modified Fire Resestive", label: "Modified Fire Resestive" },
        { value: "Fire Resestive", label: "Fire Resestive" },
    ];

    //setting for have loss click switch
    const [isHaveLossChecked, setIsHaveLossChecked] = useState(
        () => storedBusinessOwnersPolicyData().isHaveLossChecked || false
    );
    const [haveLossDateOption, setHaveLossDateOption] = useState(
        () =>
            storedBusinessOwnersPolicyData().haveLossDateOption || {
                value: 1,
                label: "MM/DD/YYYY",
            }
    );
    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };

    const handleDateOptionsChange = (selectedOption) => {
        setHaveLossDateOption({
            value: selectedOption.value,
            label: selectedOption.label,
        });
    };

    const dateOptions = [
        { value: 1, label: "MM/DD/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];

    const BusinessOwnersPolicyFormData = {
        propertyAddress,
        lossPayeeInformation,
        buildingIndustry: buildingIndustry?.value,
        occupancy: occupancy?.value,
        costOfBuilding,
        buildingPropertyLimit,
        buildingConstructionType: buildingConstructionType?.value,
        yearBuilt,
        squareFootage,
        numberOfFloors,
        automaticSprinklerSystem: automaticSprinklerSystem?.value,
        automaticFireAlarm: automaticFireAlarm?.value,
        distanceToNearestFireHydrant,
        distanceToNearestFireStation,
        automaticCommercialCookingExtinguishingSystem:
            automaticCommercialCookingExtinguishingSystem?.value,
        automaticBurglarAlarm: automaticBurglarAlarm?.value,
        securityCamera: securityCamera?.value,
        lastUpdateRoofingYear,
        lastUpdateHeatingYear,
        lastUpdatePlumbingYear,
        lastUpdateElectricalYear,
        expirationOfIM,
        priorCarrier,
        amountOfBusinessOwnersPolicy,
        userProfileId: storedLeads?.data?.userProfileId,

        isHaveLossChecked,
        dateOfLoss: dateOfLoss,
        lossAmount,

        leadId: storedLeads?.data?.id,
    };

    useEffect(() => {
        const BusinessOwnersPolicyData = {
            propertyAddress,
            lossPayeeInformation,
            buildingIndustry,
            occupancy,
            costOfBuilding,
            buildingPropertyLimit,
            buildingConstructionType,
            yearBuilt,
            squareFootage,
            numberOfFloors,
            automaticSprinklerSystem,
            automaticFireAlarm,
            distanceToNearestFireHydrant,
            distanceToNearestFireStation,
            automaticCommercialCookingExtinguishingSystem,
            automaticBurglarAlarm,
            securityCamera,
            lastUpdateRoofingYear,
            lastUpdateHeatingYear,
            lastUpdatePlumbingYear,
            lastUpdateElectricalYear,
            expirationOfIM,
            priorCarrier,
            amountOfBusinessOwnersPolicy,

            isHaveLossChecked,
            dateOfLoss: dateOfLoss,
            lossAmount,
            isEditing,
            isUpdate,
        };
        sessionStorage.setItem(
            "BusinessOwnersPolicyData",
            JSON.stringify(BusinessOwnersPolicyData)
        );
    }, [
        propertyAddress,
        lossPayeeInformation,
        buildingIndustry,
        occupancy,
        costOfBuilding,
        buildingPropertyLimit,
        buildingConstructionType,
        yearBuilt,
        squareFootage,
        numberOfFloors,
        automaticSprinklerSystem,
        automaticFireAlarm,
        distanceToNearestFireHydrant,
        distanceToNearestFireStation,
        automaticCommercialCookingExtinguishingSystem,
        automaticBurglarAlarm,
        securityCamera,
        lastUpdateRoofingYear,
        lastUpdateHeatingYear,
        lastUpdatePlumbingYear,
        lastUpdateElectricalYear,
        expirationOfIM,
        priorCarrier,
        amountOfBusinessOwnersPolicy,
        isHaveLossChecked,
        dateOfLoss,
        lossAmount,
        isEditing,
        isUpdate,
    ]);

    function submitBusinessOwnersPolicy() {
        const leadId = storedLeads?.data?.id;
        const method = isUpdate ? "put" : "post";
        const url = isUpdate
            ? `/api/business-owners-policy/update/${leadId}`
            : `/api/business-owners-policy/store`;
        axiosClient[method](url, BusinessOwnersPolicyFormData)
            .then((response) => {
                setIsEditing(false);
                setIsUpdate(true);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Business Owners Policy Form has been saved",
                    showConfirmButton: true,
                });
            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Business Owners Policy Form has not been saved",
                    showConfirmButton: true,
                });
            });
    }
    return (
        <>
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="propertyAddressColumn"
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Property Address" />
                                <Form.Control
                                    as={"textarea"}
                                    rows={6}
                                    onChange={(e) =>
                                        setPropertyAddress(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={propertyAddress}
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
                        key="lossPayeeInformation"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Loss Payee Information" />
                                <Form.Control
                                    type="text"
                                    onChange={(e) =>
                                        setLossPayeeInformation(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={lossPayeeInformation}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="buildingIndustry"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Building Industry" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={buildingIndustryOptions}
                                    onChange={(selectedOption) =>
                                        setBuildingIndustry({
                                            value: selectedOption.value,
                                            label: selectedOption.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={buildingIndustry}
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
                        key="occupancyColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Occupancy (Who owns the building?)" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={buildingIndustryOptions}
                                    onChange={(selectedOption) =>
                                        setOccupancy({
                                            value: selectedOption.value,
                                            label: selectedOption.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={occupancy}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="costOfBuildingColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Value of Cost of the Building" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setCostOfBuilding(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={costOfBuilding}
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
                        key="businessPropertyLimitColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="What is the business property limit" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setBuildingPropertyLimit(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={buildingPropertyLimit}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="buildingConstructionTypeColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Building Construction Type" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={constructionTypeOptions}
                                    onChange={(selectedOption) =>
                                        setBuildingConstructionType({
                                            value: selectedOption.value,
                                            label: selectedOption.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={buildingConstructionType}
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
                        key="yearBuiltColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Year Built" />
                                <InputMask
                                    className="form-control"
                                    mask="9999"
                                    placeholder="Year"
                                    onChange={(e) =>
                                        setYearBuilt(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={yearBuilt}
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
                        key="squareFootageColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Square Footage" />
                                <Form.Control
                                    type="number"
                                    onChange={(e) =>
                                        setSquareFootage(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={squareFootage}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="numberOfFlooersColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Number of Floors" />
                                <Form.Control
                                    type="number"
                                    onChange={(e) =>
                                        setNumberOfFloors(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={numberOfFloors}
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
                        key="automaticSprinklerSystemColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Automatic Sprinkler System" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "Yes", label: "Yes" },
                                        { value: "No", label: "No" },
                                    ]}
                                    onChange={(e) =>
                                        setAutomaticSprinklerSystem({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={automaticSprinklerSystem}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="automaticFireAlarmColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Automatic Fire Alarm" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "Yes", label: "Yes" },
                                        { value: "No", label: "No" },
                                    ]}
                                    onChange={(e) =>
                                        setAutomaticFireAlarm({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={automaticFireAlarm}
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
                        key="distanceToNearestFireHydrantColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Distance to Nearest Fire Hydrant" />
                                <Form.Control
                                    type="number"
                                    onChange={(e) =>
                                        setDistanceToNearestFireHydrant(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                    value={distanceToNearestFireHydrant}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="distanceToNearestFireStationColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Distance to Nearest Fire Station" />
                                <Form.Control
                                    type="number"
                                    onChange={(e) =>
                                        setDistanceToNearestFireStation(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                    value={distanceToNearestFireStation}
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
                        key="commercialCoockingColumn"
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Automatic Commercial Cooking Extinguishing System" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "Yes", label: "Yes" },
                                        { value: "No", label: "No" },
                                    ]}
                                    onChange={(selectedOption) =>
                                        setAutomaticCommercialCookingExtinguishingSystem(
                                            {
                                                value: selectedOption.value,
                                                label: selectedOption.label,
                                            }
                                        )
                                    }
                                    isDisabled={!isEditing}
                                    value={
                                        automaticCommercialCookingExtinguishingSystem
                                    }
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
                        key="automaticBurglarAlarmColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Automatic Burglar Alarm" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "None", label: "None" },
                                        {
                                            value: "Central or Police Station",
                                            label: "Central or Police Station",
                                        },
                                        {
                                            value: "Outside Siren Only",
                                            label: "Outside Siren Only",
                                        },
                                    ]}
                                    onChange={(selectedOption) =>
                                        setAutomaticBurglarAlarm({
                                            value: selectedOption.value,
                                            label: selectedOption.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={automaticBurglarAlarm}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="securityCameraColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Security Camera" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "Yes", label: "Yes" },
                                        { value: "No", label: "No" },
                                    ]}
                                    onChange={(selectedOption) =>
                                        setSecurityCamera({
                                            value: selectedOption.value,
                                            label: selectedOption.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={securityCamera}
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
                        key="lastUpdateRoofingYearColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Last Update to Roofing Year" />
                                <InputMask
                                    className="form-control"
                                    mask="9999"
                                    placeholder="Year"
                                    onChange={(e) =>
                                        setLastUpdateRoofingYear(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={lastUpdateRoofingYear}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="lastUpdateHeartingYearColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Last Update to Heating Year" />
                                <InputMask
                                    className="form-control"
                                    mask="9999"
                                    placeholder="Year"
                                    onChange={(e) =>
                                        setLastUpdateHeatingYear(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={lastUpdateHeatingYear}
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
                        key="lastUpdatePlumbingYearColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Last Update to Plumbing Year" />
                                <InputMask
                                    className="form-control"
                                    mask="9999"
                                    placeholder="Year"
                                    onChange={(e) =>
                                        setLastUpdatePlumbingYear(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                    value={lastUpdatePlumbingYear}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="lastUpdateElectricalYearColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Last Update to Electrical Year" />
                                <InputMask
                                    className="form-control"
                                    mask="9999"
                                    placeholder="Year"
                                    onChange={(e) =>
                                        setLastUpdateElectricalYear(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                    value={lastUpdateElectricalYear}
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
                        key="expirationOfToolsEquipemntColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Expiration of IM" />
                                <br></br>
                                <style>{`
                    .react-datepicker-wrapper
                    .react-datepicker__input-container::after {
                    content: "";
                    }
                    .form-date-picker {
                    // background-color: #f2f2f2;
                    // color: #333;
                     min-width: 450px;
                     }
                    @media (max-width: 768px) {
                   .form-date-picker {
                    min-width: 100%;
                     }
                    }
                    `}</style>
                                <DatePicker
                                    className="form-control form-date-picker"
                                    placeholderText="MM/DD/YYYY"
                                    onChange={(date) => setExpirationOfIM(date)}
                                    disabled={!isEditing}
                                    value={expirationOfIM}
                                    selected={expirationOfIM}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="priorCarrierColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Prior Carrier" />
                                <Form.Control
                                    type="text"
                                    placeholder="Prior Carrier"
                                    onChange={(e) =>
                                        setPriorCarrier(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={priorCarrier}
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
                        key="amountOfBusinessOwnersPolicyColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Amount of Business Owners Policy" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setAmountOfBusinessOwnersPolicy(
                                            e.target.value
                                        )
                                    }
                                    disabled={!isEditing}
                                    value={amountOfBusinessOwnersPolicy}
                                />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={
                    <Column
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Have Loss" />
                                <Form.Check
                                    type="switch"
                                    id="haveLossCheckSwitch"
                                    onChange={handleHaveLossChange}
                                    disabled={!isEditing}
                                    checked={isHaveLossChecked}
                                    value={isHaveLossChecked}
                                />
                            </>
                        }
                    />
                }
            />
            {isHaveLossChecked && (
                <Row
                    classValue="mb-3"
                    rowContent={
                        <Column
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Choose Format" />
                                    <Select
                                        className="basic=single"
                                        classNamePrefix="select"
                                        options={dateOptions}
                                        onChange={handleDateOptionsChange}
                                        isDisabled={!isEditing}
                                        value={haveLossDateOption}
                                    />
                                </>
                            }
                        />
                    }
                />
            )}
            {isHaveLossChecked && (
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="dateOfLossColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Row
                                        classValue="mb-1"
                                        rowContent={
                                            <Label labelContent="Date of Claim" />
                                        }
                                    />

                                    {haveLossDateOption.value === 1 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    selected={dateOfLoss}
                                                    placeholderText="MM/DD/YYYY"
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="form-control form-date-picker"
                                                    onChange={(date) =>
                                                        setDateOfLoss(date)
                                                    }
                                                    disabled={!isEditing}
                                                />
                                            }
                                        />
                                    )}

                                    {haveLossDateOption.value === 2 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    selected={dateOfLoss}
                                                    dateFormat="MM/yyyy"
                                                    placeholderText="MM/YYYY"
                                                    showMonthYearPicker
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="form-control form-date-picker"
                                                    onChange={(date) =>
                                                        setDateOfLoss(date)
                                                    }
                                                    disabled={!isEditing}
                                                />
                                            }
                                        />
                                    )}
                                </>
                            }
                        />,
                        <Column
                            key="lossAmountColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Loss Amount" />
                                    <NumericFormat
                                        value={lossAmount}
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        onChange={(e) =>
                                            setLossAmount(e.target.value)
                                        }
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                    ]}
                />
            )}

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
                                    onClick={submitBusinessOwnersPolicy}
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
        </>
    );
};

export default BusinessOwnersPolicyForm;
