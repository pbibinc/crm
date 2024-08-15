import { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import InputMask from "react-input-mask";

import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import { NumericFormat } from "react-number-format";

import DatePicker from "react-datepicker";
import Select from "react-select";
import SaveIcon from "@mui/icons-material/Save";
import SaveAsIcon from "@mui/icons-material/SaveAs";

import Swal from "sweetalert2";
// import { get } from "lodash";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";

import Button from "react-bootstrap/Button";
import { ContextData } from "../contexts/context-data-provider";
import { isArray, isEmpty } from "lodash";
import { useCommercialAutoPrevious } from "../contexts/commercial-auto-previous-data-context";
const CommercialAutoPreviousForm = () => {
    const { commercialAutoPreviousData } = useCommercialAutoPrevious();
    const storeWorkersCompData = JSON.parse(
        sessionStorage.getItem("storeWorkersCompData")
    );
    const storedLeads = JSON.parse(sessionStorage.getItem("lead"));
    const getCommercialAutoData = () => {
        let storeData =
            JSON.parse(sessionStorage.getItem("commercialAutoStoredData")) ||
            {};
        return commercialAutoPreviousData
            ? commercialAutoPreviousData.data.changes
            : storeData;
    };
    // console.log(getCommercialAutoData());

    // setting for update and edit
    const [isEditing, setIsEditing] = useState(() =>
        getCommercialAutoData()?.isUpdate == true ? false : true
    );
    const [isUpdate, setIsUpdate] = useState(
        () => getCommercialAutoData()?.isUpdate || false
    );

    // setting Fein and SSN values
    const [fein, setFein] = useState(() =>
        storeWorkersCompData?.feinValue
            ? storeWorkersCompData?.feinValue
            : getCommercialAutoData()?.feinValue
    );

    const [ssn, setSsn] = useState(() =>
        storeWorkersCompData?.ssnValue
            ? storeWorkersCompData?.ssnValue
            : getCommercialAutoData()?.ssnValue
    );

    const [isFeinDisabled, SetIsFeinDisabled] = useState(() =>
        fein == 0 ? false : true
    );
    const [isSsnDisabled, SetIsSsnDisabled] = useState(() =>
        ssn == 0 ? false : true
    );

    //setting for dynamic vehicle information
    const [vehicleInformation, setVehicleInformation] = useState(() => {
        const vehicleInfo = getCommercialAutoData()?.vehicleInformation || [{}];
        return vehicleInfo;
    });

    const [firstVehicleInformation, setFirstVehicleInformation] = useState(
        () => getCommercialAutoData()?.firstVehicleInformation || {}
    );

    const allVehicleInformation = [
        firstVehicleInformation,
        ...vehicleInformation,
    ];
    const [allVehicleInformationData, setAllVehicleInformationData] = useState(
        () => getCommercialAutoData()?.allVehicleInformation || []
    );
    const handleAddVehicle = () => {
        setVehicleInformation([...vehicleInformation, {}]); //Add a new vehicle object
    };
    const handleRemoveVehicle = (indexToRemove) => {
        setVehicleInformation(
            vehicleInformation.filter((_, index) => index !== indexToRemove)
        );
    };

    const handleVehicleInformationInput = (index, key, value) => {
        const updatedVehicleInformation = [...vehicleInformation];
        if (!updatedVehicleInformation[index]) {
            updatedVehicleInformation[index] = {};
        }
        updatedVehicleInformation[index][key] = value;
        setVehicleInformation(updatedVehicleInformation);
    };
    const handleFirstVehicleInformationInput = (key, value) => {
        setFirstVehicleInformation((prevInfo) => ({
            ...prevInfo,
            [key]: value,
        }));
    };

    //setting up for dynamic driver information group form
    const [numberOfDriverToBeInsured, setNumberOfDriverToBeInsured] = useState(
        () => {
            const storedDriverInformation =
                getCommercialAutoData()?.driverInformation;
            return storedDriverInformation ? storedDriverInformation : [{}];
        }
    );
    const [driverInformation, setDriverInformation] = useState(() => {
        let storedData = getCommercialAutoData()?.driverInformation || [{}];
        setNumberOfDriverToBeInsured(storedData);
        return storedData;
    });
    const [driverQuantity, setDriverQuantity] = useState(
        () => getCommercialAutoData()?.driverQuantity || 0
    );
    const [selectedDateOfBirth, setSelectedDateOfBirth] = useState([
        new Date(),
    ]);
    const handleNumberOfDriverToBeInsured = (e) => {
        const numberOfDriver = parseInt(e.target.value, 10) || 0;
        setDriverQuantity(numberOfDriver);
        // const driverInformationArr = Array.from(
        //     { length: numberOfDriver },
        //     () => ({})
        // );

        // setNumberOfDriverToBeInsured(driverInformationArr);
        // setDriverInformation(driverInformationArr);
        setNumberOfDriverToBeInsured((prevDrivers) => {
            const driverInformationArr = Array.from(
                { length: numberOfDriver },
                (_, index) => prevDrivers[index] || {}
            );
            return driverInformationArr;
        });
    };

    useEffect(() => {
        const mappedDateOfBirth = numberOfDriverToBeInsured.map((driver) => {
            return driver.date_of_birth;
        });
        setSelectedDateOfBirth(mappedDateOfBirth);
    }, [numberOfDriverToBeInsured]);

    const handleRemoveDriverInformation = (indexToRemove) => {
        setNumberOfDriverToBeInsured(
            numberOfDriverToBeInsured.filter(
                (_, index) => index !== indexToRemove
            )
        );
    };
    const [selectedMaritalStatus, setSelectedMaritalStatus] =
        useState("single");
    const handleMaritalStatusChange = (e, index) => {
        const newMaritalStatuses = [...selectedMaritalStatus];
        newMaritalStatuses[index] = e.value;
        setSelectedMaritalStatus(newMaritalStatuses);
    };

    const handlDriverInformationInput = (index, key, value) => {
        const updatedDriverInformation = [...numberOfDriverToBeInsured];
        if (!updatedDriverInformation[index]) {
            updatedDriverInformation[index] = {};
        }
        updatedDriverInformation[index][key] = value;
        setNumberOfDriverToBeInsured(updatedDriverInformation);
    };

    //setting garage address
    const [garageAddress, setGarageAddress] = useState(
        () => getCommercialAutoData()?.garageAddress || ""
    );

    //setting for Marital Status Dropdown

    const maritalStatusOptions = [
        { value: "single", label: "Single" },
        { value: "married", label: "Married" },
        { value: "separated", label: "Separated" },
        { value: "divorced", label: "Divorced" },
        { value: "widowed", label: "Widowed" },
    ];

    //settings for vechicle dyanami suplemental questionare
    const [
        isVehiceMaintenanceProgramChecked,
        setIsVehiceMaintenanceProgramChecked,
    ] = useState(
        () => getCommercialAutoData()?.vehicle_maintenance_program || false
    );
    const [isVehicleCustomizedChecked, setIsVehicleCustomizedChecked] =
        useState(() => getCommercialAutoData()?.is_vehicle_customized || false);
    const [isVehicleOwnedProspect, setIsVehicleOwnedProspect] = useState(
        () => getCommercialAutoData()?.is_vehicle_owned_by_prospect || false
    );
    const [isDeclinedCanceledNonRenewed, setIsDeclinedCanceledNonRenewed] =
        useState(
            () =>
                getCommercialAutoData()?.declined_canceled_nonrenew_policy ||
                false
        );
    const [isProspectLoss, setIsProspectLoss] = useState(
        () => getCommercialAutoData()?.prospect_loss || false
    );
    const [isVehicleUsedTowing, setIsVehicleUsedTowing] = useState(
        () => getCommercialAutoData()?.vehicle_use_for_towing || false
    );
    const [vehicleMaintenanceDescription, setVehicleMaintenanceDescription] =
        useState(
            () => getCommercialAutoData()?.vehicle_maintenace_description || ""
        );
    const [vehicleCustomizedDescription, setVehicleCustomizedDescription] =
        useState(
            () => getCommercialAutoData()?.vehicle_customized_description || ""
        );

    const handleVehicleMaintenanceProgramSwitch = (event) => {
        setIsVehiceMaintenanceProgramChecked(event.target.checked);
    };
    const handleVehicleCustomizedSwitch = (event) => {
        setIsVehicleCustomizedChecked(event.target.checked);
    };

    //setting for have loss switch
    const [isHaveLossChecked, setIsHaveLossChecked] = useState(
        () => getCommercialAutoData()?.isHaveLossChecked || false
    );
    const [dateOfClaim, setDateOfClaim] = useState(() =>
        getCommercialAutoData()?.dateOfClaim
            ? new Date(getCommercialAutoData()?.dateOfClaim)
            : new Date()
    );
    const [lossAmount, setLossAmount] = useState(
        () => getCommercialAutoData()?.lossAmount || ""
    );

    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };
    const dateOptions = [
        { value: 1, label: "MM/DD/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];
    const [haveLossDateOption, setHaveLossDateOption] = useState(
        () => getCommercialAutoData()?.haveLossDateOption || 1
    );
    const handleDateOptionsChange = (selectedOption) => {
        setHaveLossDateOption(selectedOption.value);
    };

    //handeling cross sell drodown data
    let crossSellArray = [
        { value: "General Liabilities", label: "General Liabilities" },
        { value: "Workers Compensation", label: "Workers Compensation" },
        { value: "Commercial Property", label: "Commercial Property" },
        { value: "Excess Liability", label: "Excess Liability" },
        { value: "Tools and Equipment", label: "Tools and Equipment" },
        { value: "Builders Risk", label: "Builders Risk" },
        { value: "Business Owner Policy", label: "Business Owner Policy" },
    ];
    let workersCompensationOption = crossSellArray.map(({ value, label }) => ({
        value,
        label,
    }));

    const [crossSell, setCrossSell] = useState(
        () => getCommercialAutoData()?.crossSell || []
    );
    // const [defaultCrossSell, setDefaultCrossSell] = useState(() => getCommercialAutoData()?.crossSell ? getCommercialAutoData()?.crossSell : {});

    //setting for expiration of auto
    const [expirationOfAuto, setExpirationOfAuto] = useState(() =>
        getCommercialAutoData()?.expirationOfAuto
            ? new Date(getCommercialAutoData()?.expirationOfAuto)
            : new Date()
    );
    const [priorCarrier, setPriorCarrier] = useState(
        () => getCommercialAutoData()?.priorCarrier || ""
    );

    const commercialAutoFormData = {
        feinValue: fein,
        ssnValue: ssn,
        year: allVehicleInformation.map((vehicle) => {
            return vehicle.year;
        }),
        make: allVehicleInformation.map((vehicle) => {
            return vehicle.make;
        }),
        model: allVehicleInformation.map((vehicle) => {
            return vehicle.model;
        }),
        vin: allVehicleInformation.map((vehicle) => {
            return vehicle.vin;
        }),
        radius: allVehicleInformation.map((vehicle) => {
            return vehicle.radius;
        }),
        cost: allVehicleInformation.map((vehicle) => {
            return vehicle.cost;
        }),
        vehicle_information: allVehicleInformation,
        garage_address: garageAddress,
        driver_information: numberOfDriverToBeInsured,
        vehicle_maintenance_program: isVehiceMaintenanceProgramChecked,
        is_vehicle_customized: isVehicleCustomizedChecked,
        is_vehicle_owned_by_prospect: isVehicleOwnedProspect,
        declined_canceled_nonrenew_policy: isDeclinedCanceledNonRenewed,
        prospect_loss: isProspectLoss,
        vehicle_use_for_towing: isVehicleUsedTowing,
        vehicle_maintenace_description: vehicleMaintenanceDescription
            ? vehicleMaintenanceDescription
            : "null",
        vehicle_customized_description: vehicleCustomizedDescription
            ? vehicleCustomizedDescription
            : "null",

        leadId: storedLeads?.data?.id,
        expirtaion_of_auto: expirationOfAuto,
        prior_carrier: priorCarrier,

        cross_sell: crossSell,

        have_loss: isHaveLossChecked,
        date_of_claim: dateOfClaim,
        loss_amount: lossAmount,
        userProfileId: storedLeads?.data?.userProfileId,
    };
    useEffect(() => {
        const storedCommercialAutoData = {
            isUpdate: isUpdate,
            isEditing: isEditing,
            firstVehicleInformation: firstVehicleInformation,
            vehicleInformation: vehicleInformation,
            garageAddress: garageAddress,
            driverQuantity: driverQuantity,
            driverInformation: numberOfDriverToBeInsured,
            vehicle_maintenance_program: isVehiceMaintenanceProgramChecked,
            is_vehicle_customized: isVehicleCustomizedChecked,
            is_vehicle_owned_by_prospect: isVehicleOwnedProspect,
            declined_canceled_nonrenew_policy: isDeclinedCanceledNonRenewed,
            prospect_loss: isProspectLoss,
            vehicle_use_for_towing: isVehicleUsedTowing,
            vehicle_maintenace_description: vehicleMaintenanceDescription
                ? vehicleMaintenanceDescription
                : "null",
            vehicle_customized_description: vehicleCustomizedDescription
                ? vehicleCustomizedDescription
                : "null",
            expirationOfAuto: expirationOfAuto,
            priorCarrier: priorCarrier,
            dateOfClaim: dateOfClaim,
            lossAmount: lossAmount,
            crossSell: crossSell,
            isHaveLossChecked: isHaveLossChecked,
            haveLossDateOption: haveLossDateOption,
            userProfileId: storedLeads?.data?.userProfileId,
        };

        sessionStorage.setItem(
            "commercialAutoStoredData",
            JSON.stringify(storedCommercialAutoData)
        );
    }, [
        isEditing,
        isUpdate,
        firstVehicleInformation,
        vehicleInformation,
        garageAddress,
        driverQuantity,
        numberOfDriverToBeInsured,
        isVehiceMaintenanceProgramChecked,
        isVehicleCustomizedChecked,
        isVehicleOwnedProspect,
        isDeclinedCanceledNonRenewed,
        isProspectLoss,
        isVehicleUsedTowing,
        vehicleMaintenanceDescription,
        vehicleCustomizedDescription,
        expirationOfAuto,
        priorCarrier,
        isHaveLossChecked,
        dateOfClaim,
        lossAmount,
        crossSell,
        haveLossDateOption,
        storedLeads?.data?.userProfileId,
    ]);

    function submitCommercialAutoForm() {
        const leadId = storedLeads?.data?.id;
        const url = isUpdate
            ? `/api/commercial-auto-data/update/${leadId}`
            : `/api/commercial-auto-data/store`;
        const method = isUpdate ? "put" : "post";
        axiosClient[method](url, commercialAutoFormData)
            .then((response) => {
                setIsEditing(false);
                setIsUpdate(true);
                if (method == "post") {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Commercial Auto has been saved",
                        showConfirmButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Commercial Auto has been updated",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                if (error.response.status == 409) {
                    Swal.fire({
                        icon: "warning",
                        title: `${error.response.data.error}`,
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: `Error:: kindly call your IT and Refer to them this error ${error.response.data.error}`,
                    });
                }
            });
    }

    return (
        <>
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="feinColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="FEIN#" />
                                <InputMask
                                    value={fein}
                                    mask="99-9999999"
                                    className="form-control"
                                    onChange={(e) => setFein(e.target.value)}
                                    disabled={isFeinDisabled}
                                />
                            </>
                        }
                    />,
                    <Column
                        key="ssnColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="SSN#" />
                                <InputMask
                                    mask="999-99-9999"
                                    value={ssn}
                                    className="form-control"
                                    onChange={(e) => setSsn(e.target.value)}
                                    disabled={isSsnDisabled}
                                />
                            </>
                        }
                    />,
                ]}
            />

            <Card body>
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="vehicleInformationColumn"
                            classValue="col-10"
                            colContent={
                                <>
                                    <Label labelContent="Vehicle Information" />
                                </>
                            }
                        />,
                        <Column
                            key="vehicleAddButtonColumn"
                            classValue="col-2"
                            colContent={
                                <>
                                    <Button
                                        variant="success"
                                        onClick={handleAddVehicle}
                                        disabled={!isEditing}
                                    >
                                        Add Vehicle
                                    </Button>
                                </>
                            }
                        />,
                    ]}
                />
                <Row
                    classValue="mb-3"
                    rowContent={[
                        <Column
                            key="vehicleYearColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Year" />
                                    <InputMask
                                        mask="9999"
                                        className="form-control"
                                        placeholder="Year"
                                        value={firstVehicleInformation?.year}
                                        onChange={(e) =>
                                            handleFirstVehicleInformationInput(
                                                "year",
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="vehicleMakeColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Make" />
                                    <Form.Control
                                        type="text"
                                        placeholder="Make"
                                        onChange={(e) =>
                                            handleFirstVehicleInformationInput(
                                                "make",
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={firstVehicleInformation?.make}
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
                            key="vehicleModelColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Model" />
                                    <Form.Control
                                        type="text"
                                        placeholder="Model"
                                        onChange={(e) =>
                                            handleFirstVehicleInformationInput(
                                                "model",
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={firstVehicleInformation?.model}
                                    />
                                </>
                            }
                        />,
                        <Column
                            key="vehicleVinColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="VIN" />
                                    <Form.Control
                                        type="text"
                                        placeholder="VIN"
                                        onChange={(e) =>
                                            handleFirstVehicleInformationInput(
                                                "vin",
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={firstVehicleInformation?.vin}
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
                            key="vehicleRadiusMileageColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Radius Mileage" />
                                    <div className="input-group">
                                        <Form.Control
                                            type="text"
                                            placeholder="Radius Mileage"
                                            onChange={(e) =>
                                                handleFirstVehicleInformationInput(
                                                    "radius",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                firstVehicleInformation?.radius
                                            }
                                        />
                                        <span className="input-group-text">
                                            KM
                                        </span>
                                    </div>
                                </>
                            }
                        />,
                        <Column
                            key="vehicleCostNewColumn"
                            classValue="col-6"
                            colContent={
                                <>
                                    <Label labelContent="Cost New" />
                                    <NumericFormat
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        onChange={(e) =>
                                            handleFirstVehicleInformationInput(
                                                "cost",
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={firstVehicleInformation?.cost}
                                    />
                                </>
                            }
                        />,
                    ]}
                />
            </Card>
            {vehicleInformation.map((vehicle, index) => (
                <Card body key={index}>
                    <Row
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="vehicleInformationColumn"
                                classValue="col-8"
                                colContent={
                                    <>
                                        <Label labelContent="Vehicle Information" />
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleAddButtonColumn"
                                classValue="col-4"
                                colContent={
                                    <>
                                        <Button
                                            variant="success"
                                            onClick={handleAddVehicle}
                                            style={{ marginRight: "10px" }}
                                            disabled={!isEditing}
                                        >
                                            Add Vehicle
                                        </Button>

                                        <Button
                                            variant="danger"
                                            onClick={() =>
                                                handleRemoveVehicle(index)
                                            }
                                            disabled={!isEditing}
                                        >
                                            Remove Vehicle
                                        </Button>
                                    </>
                                }
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="vehicleYearColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Year" />
                                        <InputMask
                                            mask="9999"
                                            className="form-control"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                handleVehicleInformationInput(
                                                    index,
                                                    "year",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                vehicleInformation[index]?.year
                                            }
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleMakeColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Make" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Make"
                                            onChange={(e) =>
                                                handleVehicleInformationInput(
                                                    index,
                                                    "make",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                vehicleInformation[index]?.make
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
                                key="vehicleModelColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Model" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Model"
                                            onChange={(e) =>
                                                handleVehicleInformationInput(
                                                    index,
                                                    "model",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                vehicleInformation[index]?.model
                                            }
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleVinColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="VIN" />
                                        <Form.Control
                                            type="text"
                                            placeholder="VIN"
                                            onChange={(e) =>
                                                handleVehicleInformationInput(
                                                    index,
                                                    "vin",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                vehicleInformation[index]?.vin
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
                                key="vehicleRadiusMileageColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Radius Mileage" />
                                        <div className="input-group">
                                            <Form.Control
                                                type="text"
                                                placeholder="Radius Mileage"
                                                onChange={(e) =>
                                                    handleVehicleInformationInput(
                                                        index,
                                                        "radius",
                                                        e.target.value
                                                    )
                                                }
                                                disabled={!isEditing}
                                                value={
                                                    vehicleInformation[index]
                                                        ?.radius
                                                }
                                            />
                                            <span className="input-group-text">
                                                KM
                                            </span>
                                        </div>
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleCostNewColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Cost New" />
                                        <NumericFormat
                                            className="form-control"
                                            thousandSeparator={true}
                                            prefix={"$"}
                                            decimalScale={2}
                                            fixedDecimalScale={true}
                                            allowNegative={false}
                                            placeholder="$0.00"
                                            onChange={(e) =>
                                                handleVehicleInformationInput(
                                                    index,
                                                    "cost",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                vehicleInformation[index]?.cost
                                            }
                                        />
                                    </>
                                }
                            />,
                        ]}
                    />
                </Card>
            ))}

            <Row
                classValue="mb-3"
                rowContent={
                    <Column
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Garage Address" />
                                <Form.Control
                                    type="text"
                                    placeholder="Garage Address"
                                    onChange={(e) =>
                                        setGarageAddress(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={garageAddress}
                                />
                            </>
                        }
                    />
                }
            />
            <Row
                classValue="mb-3"
                rowContent={
                    <Column
                        classValue="col-12"
                        colContent={
                            <>
                                <Label labelContent="Number of Driver to be Insured" />
                                <Form.Control
                                    type="number"
                                    onChange={handleNumberOfDriverToBeInsured}
                                    disabled={!isEditing}
                                    value={driverQuantity}
                                />
                            </>
                        }
                    />
                }
            />
            {numberOfDriverToBeInsured.map((driver, index) => (
                <Card body key={index}>
                    <Row
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="DriverInformationColumn"
                                classValue="col-10"
                                colContent={
                                    <>
                                        <Label labelContent="Driver Information" />
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleAddButtonColumn"
                                classValue="col-2"
                                colContent={
                                    <>
                                        <Button
                                            variant="danger"
                                            onClick={() =>
                                                handleRemoveDriverInformation(
                                                    index
                                                )
                                            }
                                            disabled={!isEditing}
                                        >
                                            Remove
                                        </Button>
                                    </>
                                }
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-3"
                        rowContent={[
                            <Column
                                key="driverFirsNameColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="First Name" />
                                        <Form.Control
                                            type="text"
                                            placeholder="First Name"
                                            onChange={(e) =>
                                                handlDriverInformationInput(
                                                    index,
                                                    "firstName",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                numberOfDriverToBeInsured[index]
                                                    ?.firstName
                                            }
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="vehicleAddButtonColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Last Name" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Last Name"
                                            onChange={(e) =>
                                                handlDriverInformationInput(
                                                    index,
                                                    "lastname",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                numberOfDriverToBeInsured[index]
                                                    ?.lastname
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
                                key="driverDateOfBirthColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Date of Birth" />
                                        <br></br>
                                        <DatePicker
                                            className="custom-datepicker-input"
                                            placeholderText="MM/DD/YYYY"
                                            selected={
                                                numberOfDriverToBeInsured[index]
                                                    ?.date_of_birth
                                                    ? new Date(
                                                          numberOfDriverToBeInsured[
                                                              index
                                                          ]?.date_of_birth
                                                      )
                                                    : new Date()
                                            }
                                            onChange={(e) =>
                                                handlDriverInformationInput(
                                                    index,
                                                    "date_of_birth",
                                                    e
                                                )
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="maritalStatusColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Marital Status" />
                                        <Select
                                            className="basic-single"
                                            classNamePrefix="select"
                                            options={maritalStatusOptions}
                                            onChange={(e) => {
                                                handlDriverInformationInput(
                                                    index,
                                                    "martial_status",
                                                    {
                                                        value: e.value,
                                                        label: e.label,
                                                    }
                                                );
                                                handleMaritalStatusChange(
                                                    e,
                                                    index
                                                );
                                            }}
                                            value={
                                                numberOfDriverToBeInsured[index]
                                                    ?.martial_status
                                            }
                                            isDisabled={!isEditing}
                                        />
                                    </>
                                }
                            />,
                        ]}
                    />
                    {(selectedMaritalStatus[index] === "married" ||
                        numberOfDriverToBeInsured[index]?.martial_status
                            ?.value === "married") && (
                        <Row
                            classValue="mb-3"
                            rowContent={[
                                <Column key="column1" classValue="col-6" />,
                                <Column
                                    key="spouseNameColumn"
                                    classValue="col-6"
                                    colContent={
                                        <>
                                            <Label labelContent="Spouse Name" />
                                            <Form.Control
                                                type="text"
                                                placeholder="Spouse Name"
                                                onChange={(e) =>
                                                    handlDriverInformationInput(
                                                        index,
                                                        "spouse_name",
                                                        e.target.value
                                                    )
                                                }
                                                disabled={!isEditing}
                                                value={
                                                    numberOfDriverToBeInsured[
                                                        index
                                                    ]?.spouse_name
                                                }
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
                                key="driverLicenseNumberColumn"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Driver License Number" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Driver License Number"
                                            onChange={(e) =>
                                                handlDriverInformationInput(
                                                    index,
                                                    "driver_license_number",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                numberOfDriverToBeInsured[index]
                                                    ?.driver_license_number
                                            }
                                        />
                                    </>
                                }
                            />,
                            <Column
                                key="yearsOfDrivingExprience"
                                classValue="col-6"
                                colContent={
                                    <>
                                        <Label labelContent="Years of Driving Exprience" />
                                        <Form.Control
                                            type="number"
                                            onChange={(e) =>
                                                handlDriverInformationInput(
                                                    index,
                                                    "years_driving_experience",
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                numberOfDriverToBeInsured[index]
                                                    ?.years_driving_experience
                                            }
                                        />
                                    </>
                                }
                            />,
                        ]}
                    />
                </Card>
            ))}

            <Row
                classValue="mb-3"
                rowContent={
                    <Column
                        classValue="col-6"
                        colContent={
                            <Label labelContent="Supplemental Questions:" />
                        }
                    />
                }
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="vehicleMaintenanceProgramColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Is There a vehicle maintenance program in operation" />
                            </>
                        }
                    />,
                    <Column
                        key="vehicleMaintenanceProgramSwitchColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Are any vehicle customized, altered or have special equipment?" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="vehicleMaintenanceProgramSwitchColumn"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleVehicleMaintenanceProgramSwitch}
                                disabled={!isEditing}
                                checked={isVehiceMaintenanceProgramChecked}
                            />
                        }
                    />,
                    <Column
                        key="vehicleCustomiedSwitchColumn"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={handleVehicleCustomizedSwitch}
                                disabled={!isEditing}
                                checked={isVehicleCustomizedChecked}
                            />
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="vehicleMaintenanceProgramDescriptionColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                {isVehiceMaintenanceProgramChecked && (
                                    <Form.Control
                                        as={"textarea"}
                                        rows={3}
                                        onChange={(e) =>
                                            setVehicleMaintenanceDescription(
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={vehicleMaintenanceDescription}
                                    />
                                )}
                            </>
                        }
                    />,
                    <Column
                        key="vehicleCustomiedDescriptionColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                {isVehicleCustomizedChecked && (
                                    <Form.Control
                                        as={"textarea"}
                                        rows={3}
                                        onChange={(e) =>
                                            setVehicleCustomizedDescription(
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={vehicleCustomizedDescription}
                                    />
                                )}
                            </>
                        }
                    />,
                ]}
            />

            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="vehicleOwnedByTheProspectColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Are any vehicles owned by the prospect not to be scheduled on this application?" />
                            </>
                        }
                    />,
                    <Column
                        key="vehicleOwnedCoverageDeclinedColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Has any policy or coverage been declined, canceled or non-renewed during the prior 3 years?" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="vehicleOwnedByTheProspectSwitch"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={(e) =>
                                    setIsVehicleOwnedProspect(e.target.checked)
                                }
                                disabled={!isEditing}
                                checked={isVehicleOwnedProspect}
                            />
                        }
                    />,
                    <Column
                        key="vehicleOwnedCoverageDeclinedSwitch"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={(e) =>
                                    setIsDeclinedCanceledNonRenewed(
                                        e.target.checked
                                    )
                                }
                                disabled={!isEditing}
                                checked={isDeclinedCanceledNonRenewed}
                            />
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="prospectHasLossPast4YearsColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Has the prospect had any losses in the past 4 years?" />
                            </>
                        }
                    />,
                    <Column
                        key="ownedVehicleUsedForTowingColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Are owned vehicles used for towing special equipment?" />
                            </>
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="prospectHasLossPast4YearsSwitch"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={(e) =>
                                    setIsProspectLoss(e.target.checked)
                                }
                                disabled={!isEditing}
                                checked={isProspectLoss}
                            />
                        }
                    />,
                    <Column
                        key="ownedVehicleUsedForTowingSwitch"
                        classValue="col-6"
                        colContent={
                            <Form.Check
                                type="switch"
                                id="custom-switch"
                                onChange={(e) =>
                                    setIsVehicleUsedTowing(e.target.checked)
                                }
                                disabled={!isEditing}
                                checked={isVehicleUsedTowing}
                            />
                        }
                    />,
                ]}
            />
            <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="expirationOfAutoColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <Label labelContent="Expiration of Auto" />
                                <br></br>
                                <DatePicker
                                    className="custom-datepicker-input"
                                    placeholderText="MM/DD/YYYY"
                                    selected={expirationOfAuto}
                                    onChange={(date) =>
                                        setExpirationOfAuto(date)
                                    }
                                    disabled={!isEditing}
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
                                    value={priorCarrier}
                                    disabled={!isEditing}
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
                                        //   value={handleDateOptionsChange}
                                        onChange={handleDateOptionsChange}
                                        isDisabled={!isEditing}
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

                                    {haveLossDateOption === 1 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    //   selected={dateofClaim}
                                                    placeholderText="MM/DD/YYYY"
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="custom-datepicker-input"
                                                    selected={dateOfClaim}
                                                    onChange={(date) =>
                                                        setDateOfClaim(date)
                                                    }
                                                    disabled={!isEditing}
                                                />
                                            }
                                        />
                                    )}

                                    {haveLossDateOption === 2 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
                                                    //   selected={dateofClaim}
                                                    dateFormat="MM/yyyy"
                                                    placeholderText="MM/YYYY"
                                                    showMonthYearPicker
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="custom-datepicker-input"
                                                    selected={dateOfClaim}
                                                    onChange={(date) =>
                                                        setDateOfClaim(date)
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
                                        //   value={lossAmount}
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        value={lossAmount}
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
                                    onClick={submitCommercialAutoForm}
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

export default CommercialAutoPreviousForm;
