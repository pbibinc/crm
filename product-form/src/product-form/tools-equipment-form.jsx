import { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import { NumericFormat } from "react-number-format";
import Card from "react-bootstrap/Card";
import Select from "react-select";

import InputMask from "react-input-mask";
import Form from "react-bootstrap/Form";
import Button from "react-bootstrap/Button";
import DatePicker from "react-datepicker";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import SaveIcon from "@mui/icons-material/Save";

import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";
import { ContextData } from "../contexts/context-data-provider";
import { useToolsEquipment } from "../contexts/tools-equipment-context";
const ToolsEquipmentForm = () => {
    //setting for getting values toolsequipment from sessionstorage
    const { toolsEquipmentData } = useToolsEquipment() || {};
    const storedToolsEquipment = () => {
        const localSessionStorage =
            sessionStorage.getItem("toolsEquipmentData") || "{}";
        return toolsEquipmentData
            ? toolsEquipmentData.data
            : JSON.parse(localSessionStorage);
    };

    //setting for getting values from sesssion storage
    const storedLeads = JSON.parse(sessionStorage.getItem("lead"));

    //setting for editing and updating
    const [isEditing, setIsEditing] = useState(() =>
        storedToolsEquipment()?.isUpdate == true ? false : true
    );
    const [isUpdate, setIsUpdate] = useState(
        () => storedToolsEquipment()?.isUpdate || false
    );

    //setting of most value
    const [miscellaneousTools, setMiscellaneousTools] = useState(
        () => storedToolsEquipment()?.miscellaneousTools || ""
    );
    const [rentedLeasedEquipment, setRentedLeasedEquipment] = useState(
        () => storedToolsEquipment()?.rentedLeasedEquipment || ""
    );
    const [scheduledEquipment, setScheduledEquipment] = useState(
        () => storedToolsEquipment()?.scheduledEquipment || ""
    );

    //setting for select equipment type
    const [typeOfEquipment, setTypeOfEquipment] = useState(() =>
        Array.isArray(storedToolsEquipment()?.typeOfEquipment)
            ? storedToolsEquipment().typeOfEquipment
            : []
    );
    const [fixedTypeOfEquipment, setFixedTypeOfEquipment] = useState(
        () => storedToolsEquipment()?.fixedTypeOfEquipment || {}
    );
    const equipmentType = [
        { value: 1, label: "Light/Medium Equipment" },
        { value: 2, label: "Heavy Equipment" },
    ];

    const lightMediumEquipment = [
        { value: "Boom lift", label: "Boom lift" },
        { value: "Compact Tract Loader", label: "Compact Tract Loader" },
        { value: "Fork lift", label: "Fork lift" },
        { value: "Generator", label: "Generator" },
        { value: "Jack Hammer", label: "Jack Hammer" },
        { value: "Lawn Mower", label: "Lawn Mower" },
        { value: "Mini Excavator", label: "Mini Excavator" },
        { value: "Mini Loader", label: "Mini Loader" },
        { value: "Scaff Loading", label: "Scaff Loading" },
        { value: "Scaffholding(Under 50k)", label: "Scaffholding(Under 50k)" },
        { value: "Skid Steer", label: "Skid Steer" },
        { value: "Spayer", label: "Spayer" },
        { value: "Trailer", label: "Trailer" },
        { value: "Other", label: "Other" },
    ];

    const heavyEquipment = [
        { value: "Backhoe", label: "Backhoe" },
        { value: "Crane", label: "Crane" },
        { value: "Forklift", label: "Forklift" },
        { value: "Excavator", label: "Excavator" },
        { value: "Loader", label: "Loader" },
        { value: "Scaffholding(Above 50k)", label: "Scaffholding(Above 50k)" },
        { value: "Wood Chippers", label: "Wood Chippers" },
        { value: "Other", label: "Other" },
    ];

    //setting for adding new form equipment
    const [equipmentInformation, setEquipmentInformation] = useState(
        () => storedToolsEquipment()?.equipmentInformation || [{}]
    );
    const [firstEquipmentInformation, setFirstEquipmentInformation] = useState(
        () => storedToolsEquipment()?.firstEquipmentInformation || [{}]
    );
    const allEquipmentInformation = [
        { ...firstEquipmentInformation, equipmentType: fixedTypeOfEquipment },
        ...equipmentInformation.map((info, index) => ({
            ...info,
            equipmentType: typeOfEquipment[index] || {},
        })),
    ];

    // const allType = [fixedTypeOfEquipment, ...typeOfEquipment];

    const handleAddEquipment = () => {
        setEquipmentInformation([...equipmentInformation, {}]);
    };

    const handleRemoveEquipment = (indexToRemove) => {
        setEquipmentInformation(
            equipmentInformation.filter((_, index) => index !== indexToRemove)
        );
    };

    const handleEquipmentInformationInput = (index, key, value) => {
        const updatedEquipmentInformation = [...equipmentInformation];
        if (!updatedEquipmentInformation[index]) {
            updatedEquipmentInformation[index] = {};
        }
        updatedEquipmentInformation[index][key] = value;
        setEquipmentInformation(updatedEquipmentInformation);
    };

    const handleFirstEquipmentInformation = (key, value) => {
        setFirstEquipmentInformation((prevInfo) => ({
            ...prevInfo,
            [key]: value,
        }));
    };

    //settings for deductible amount dropdown
    const [deductibleAmount, setDeductibleAmount] = useState(
        () => storedToolsEquipment()?.deductibleAmount || {}
    );
    const deductibleAmountOptions = [
        { value: "$500", label: "$500" },
        { value: "$1,000", label: "$1,000" },
        { value: "$2,500", label: "$2,500" },
        { value: "$5,000", label: "$5,000" },
        { value: "$10,000", label: "$10,000" },
    ];

    //setting for expiration of IM datepicker
    const [expirationOfIM, setExpirationOfIM] = useState(() =>
        storedToolsEquipment()?.expirationOfIM
            ? new Date(storedToolsEquipment()?.expirationOfIM)
            : new Date()
    );
    const [priorCarrier, setPriorCarrier] = useState(
        () => storedToolsEquipment()?.priorCarrier || ""
    );

    //setting for have loss click switch
    const [isHaveLossChecked, setIsHaveLossChecked] = useState(
        () => storedToolsEquipment()?.isHaveLossChecked || false
    );
    const [haveLossDateOption, setHaveLossDateOption] = useState(
        () => storedToolsEquipment()?.haveLossDateOption || 1
    );
    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };
    const [dateOfClaim, setDateOfClaim] = useState(() =>
        storedToolsEquipment().dateOfClaim
            ? new Date(storedToolsEquipment().dateOfClaim)
            : new Date()
    );
    const [lossAmount, setLossAmount] = useState(
        () => storedToolsEquipment()?.lossAmount || ""
    );

    const dateOptions = [
        { value: 1, label: "MM/DD/YYYY" },
        { value: 2, label: "MM/YYYY" },
    ];

    const handleDateOptionsChange = (selectedOption) => {
        setHaveLossDateOption({
            value: selectedOption.value,
            label: selectedOption.label,
        });
    };

    //setting for cross sell dropdown
    let crossSellArray = [
        { value: "General Liabilities", label: "General Liabilities" },
        { value: "Workers Compensation", label: "Workers Compensation" },
        { value: "Commercial Property", label: "Commercial Property" },
        { value: "Excess Liability", label: "Excess Liability" },
        { value: "Tools and Equipment", label: "Tools and Equipment" },
        { value: "Builders Risk", label: "Builders Risk" },
        { value: "Business Owner Policy", label: "Business Owner Policy" },
    ];
    const [crossSell, setCrossSell] = useState(
        () => storedToolsEquipment()?.crossSell || {}
    );

    //settings for object formdata

    const toolsEquipmentFormData = {
        miscellaneousTools: miscellaneousTools,
        rentedLeasedEquipment: rentedLeasedEquipment,
        scheduledEquipment: scheduledEquipment,
        deductibleAmount: deductibleAmount.value,

        allEquipmentInformation: allEquipmentInformation,

        expirationOfIM: expirationOfIM,
        priorCarrier: priorCarrier,

        isHaveLossChecked: isHaveLossChecked,
        dateOfClaim: dateOfClaim,
        lossAmount: lossAmount,

        crossSell: crossSell,

        leadId: storedLeads?.data?.id,
        userProfileId: storedLeads?.data?.userProfileId,
    };

    useEffect(() => {
        const ToolsEquipmentData = {
            miscellaneousTools: miscellaneousTools,
            rentedLeasedEquipment: rentedLeasedEquipment,
            scheduledEquipment: scheduledEquipment,
            deductibleAmount: deductibleAmount,

            equipmentInformation: equipmentInformation,
            firstEquipmentInformation: firstEquipmentInformation,
            fixedTypeOfEquipment: fixedTypeOfEquipment,
            typeOfEquipment: typeOfEquipment,

            expirationOfIM: expirationOfIM,
            priorCarrier: priorCarrier,

            isHaveLossChecked: isHaveLossChecked,
            dateOfClaim: dateOfClaim,
            lossAmount: lossAmount,
            haveLossDateOption: haveLossDateOption,

            crossSell: crossSell,

            isUpdate: isUpdate,
            isEditing: isEditing,
        };
        sessionStorage.setItem(
            "toolsEquipmentData",
            JSON.stringify(ToolsEquipmentData)
        );
    }, [
        miscellaneousTools,
        rentedLeasedEquipment,
        scheduledEquipment,
        deductibleAmount,
        expirationOfIM,
        priorCarrier,
        isHaveLossChecked,
        dateOfClaim,
        lossAmount,
        crossSell,
        isUpdate,
        isEditing,
        firstEquipmentInformation,
        equipmentInformation,
        fixedTypeOfEquipment,
        typeOfEquipment,
        haveLossDateOption,
    ]);

    useEffect(() => {
        const data = storedToolsEquipment();
        if (data) {
            setIsEditing(data.isUpdate == true ? false : true);
            setIsUpdate(data.isUpdate || false);
            setMiscellaneousTools(data.miscellaneousTools || "");
            setRentedLeasedEquipment(data.rentedLeasedEquipment || "");
            setScheduledEquipment(data.scheduledEquipment || "");
            setTypeOfEquipment(
                Array.isArray(data.typeOfEquipment) ? data.typeOfEquipment : []
            );
            setFixedTypeOfEquipment(data.fixedTypeOfEquipment || {});
            setEquipmentInformation(data.equipmentInformation || [{}]);
            setFirstEquipmentInformation(
                data.firstEquipmentInformation || [{}]
            );
            setDeductibleAmount(data.deductibleAmount || {});
            setExpirationOfIM(
                data.expirationOfIM ? new Date(data.expirationOfIM) : new Date()
            );
            setPriorCarrier(data.priorCarrier || "");
            setIsHaveLossChecked(data.isHaveLossChecked || false);
            setHaveLossDateOption(data.haveLossDateOption || 1);
            setDateOfClaim(
                data.dateOfClaim ? new Date(data.dateOfClaim) : new Date()
            );
            setLossAmount(data.lossAmount || "");
            setCrossSell(data.crossSell || {});
        }
    }, [toolsEquipmentData]);

    function submitToolsEquipmentForm() {
        const leadId = storedLeads?.data?.id;
        const method = isUpdate ? "put" : "post";
        const url = isUpdate
            ? `/api/tools-equipment/update/${leadId}`
            : `/api/tools-equipment/store`;
        axiosClient[method](url, toolsEquipmentFormData)
            .then((response) => {
                setIsEditing(false);
                setIsUpdate(true);
                if (method == "post") {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Tools Equipment has been saved",
                        showConfirmButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Tools and equipment has been updated",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: `error`,
                });
            });
    }
    return (
        <>
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="miscellaneousToolsColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Miscellaneous Tools Amount" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setMiscellaneousTools(e.target.value)
                                    }
                                    value={miscellaneousTools}
                                    disabled={!isEditing}
                                />
                            </>,
                        ]}
                    />,
                    <Column
                        key="rentedLeasedEquipementColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Rented/Leased Equipment Amount" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setRentedLeasedEquipment(e.target.value)
                                    }
                                    value={rentedLeasedEquipment}
                                    disabled={!isEditing}
                                />
                            </>,
                        ]}
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="scheduledEquipmentColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Scheduled Equipment" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setScheduledEquipment(e.target.value)
                                    }
                                    value={scheduledEquipment}
                                    disabled={!isEditing}
                                />
                            </>,
                        ]}
                    />,
                ]}
            />
            <Card body>
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="addEquipmnetButtonColumn"
                            classValue="col-10"
                        />,
                        <Column
                            key="addButtonColumn"
                            classValue="col-2"
                            colContent={
                                <Button
                                    variant="success"
                                    style={{ marginRight: "10px" }}
                                    onClick={handleAddEquipment}
                                    disabled={!isEditing}
                                >
                                    Add Equipment
                                </Button>
                            }
                        />,
                    ]}
                />
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="equipmentTypeColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Equipment Type" />
                                    <Select
                                        className="basic-single"
                                        classNamePrefix="select"
                                        options={equipmentType}
                                        onChange={(e) =>
                                            setFixedTypeOfEquipment({
                                                value: e.value,
                                                label: e.label,
                                            })
                                        }
                                        value={fixedTypeOfEquipment}
                                        isDisabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                        <Column
                            key="equipmentColumne"
                            classValue="col-6"
                            colContent={[
                                <>
                                    {fixedTypeOfEquipment.value === 1 && (
                                        <>
                                            <Label labelContent="Light/Medium Equipment" />
                                            <Select
                                                className="basic-single"
                                                classNamePrefix="select"
                                                options={lightMediumEquipment}
                                                onChange={(e) =>
                                                    handleFirstEquipmentInformation(
                                                        "equipment",
                                                        {
                                                            value: e.value,
                                                            label: e.label,
                                                        }
                                                    )
                                                }
                                                value={
                                                    firstEquipmentInformation.equipment
                                                }
                                                isDisabled={!isEditing}
                                            />
                                        </>
                                    )}
                                    {fixedTypeOfEquipment.value === 2 && (
                                        <>
                                            <Label labelContent="Heavy Equipment" />
                                            <Select
                                                className="basic-single"
                                                classNamePrefix="select"
                                                options={heavyEquipment}
                                                onChange={(e) =>
                                                    handleFirstEquipmentInformation(
                                                        "equipment",
                                                        {
                                                            value: e.value,
                                                            label: e.label,
                                                        }
                                                    )
                                                }
                                                value={
                                                    firstEquipmentInformation.equipment
                                                }
                                                isDisabled={!isEditing}
                                            />
                                        </>
                                    )}
                                </>,
                            ]}
                        />,
                    ]}
                />
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="equipmentYearColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Year" />
                                    <InputMask
                                        className="form-control"
                                        mask="9999"
                                        placeholder="Year"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "year",
                                                e.target.value
                                            )
                                        }
                                        value={firstEquipmentInformation.year}
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                        <Column
                            key="equipmentMakeColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Make" />
                                    <Form.Control
                                        type="text"
                                        placeholder="Make"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "make",
                                                e.target.value
                                            )
                                        }
                                        value={firstEquipmentInformation.make}
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                    ]}
                />
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="equipmentModelColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Model" />
                                    <Form.Control
                                        type="text"
                                        placeholder="Model"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "model",
                                                e.target.value
                                            )
                                        }
                                        value={firstEquipmentInformation.model}
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                        <Column
                            key="serialumberColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Serial Number/Identification Number" />
                                    <Form.Control
                                        type="text"
                                        placeholder="Serial Number/Identification Numbe"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "serialNo",
                                                e.target.value
                                            )
                                        }
                                        value={
                                            firstEquipmentInformation.serialNo
                                        }
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                    ]}
                />
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="equipmentValueColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Value" />
                                    <NumericFormat
                                        className="form-control"
                                        thousandSeparator={true}
                                        prefix={"$"}
                                        decimalScale={2}
                                        fixedDecimalScale={true}
                                        allowNegative={false}
                                        placeholder="$0.00"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "value",
                                                e.target.value
                                            )
                                        }
                                        value={firstEquipmentInformation.value}
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                        <Column
                            key="yearAcquiredColumn"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Year Acquired" />
                                    <InputMask
                                        className="form-control"
                                        mask="9999"
                                        placeholder="Year"
                                        onChange={(e) =>
                                            handleFirstEquipmentInformation(
                                                "yearAcquired",
                                                e.target.value
                                            )
                                        }
                                        value={
                                            firstEquipmentInformation.yearAcquired
                                        }
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                    ]}
                />
            </Card>
            {equipmentInformation.map((equipment, index) => (
                <Card body key={index}>
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key={`addColumn${index}`}
                                classValue="col-7"
                            />,
                            <Column
                                key={`addToolsEquipment${index}`}
                                classValue="col-5"
                                colContent={
                                    <>
                                        <Button
                                            variant="success"
                                            style={{ marginRight: "10px" }}
                                            onClick={handleAddEquipment}
                                            disabled={!isEditing}
                                        >
                                            Add Equipment
                                        </Button>
                                        <Button
                                            variant="danger"
                                            style={{ marginRight: "10px" }}
                                            onClick={() =>
                                                handleRemoveEquipment(index)
                                            }
                                            disabled={!isEditing}
                                        >
                                            Remove Equipment
                                        </Button>
                                    </>
                                }
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="equipmentTypeColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Equipment Type" />
                                        <Select
                                            className="basic-single"
                                            classNamePrefix="select"
                                            options={equipmentType}
                                            onChange={(e) =>
                                                setTypeOfEquipment({
                                                    ...typeOfEquipment,
                                                    [index]: {
                                                        value: e.value,
                                                        label: e.label,
                                                    },
                                                })
                                            }
                                            value={typeOfEquipment[index]}
                                            isDisabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="equipmentColumne"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        {typeOfEquipment[index]?.value ===
                                            1 && (
                                            <>
                                                <Label labelContent="Light/Medium Equipment" />
                                                <Select
                                                    className="basic-single"
                                                    classNamePrefix="select"
                                                    options={
                                                        lightMediumEquipment
                                                    }
                                                    onChange={(e) =>
                                                        handleEquipmentInformationInput(
                                                            index,
                                                            "equipment",
                                                            {
                                                                value: e.value,
                                                                label: e.label,
                                                            }
                                                        )
                                                    }
                                                    value={
                                                        equipmentInformation[
                                                            index
                                                        ]?.equipment
                                                    }
                                                    isDisabled={!isEditing}
                                                />
                                            </>
                                        )}
                                        {typeOfEquipment[index]?.value ===
                                            2 && (
                                            <>
                                                <Label labelContent="Heavy Equipment" />
                                                <Select
                                                    className="basic-single"
                                                    classNamePrefix="select"
                                                    options={heavyEquipment}
                                                    onChange={(e) =>
                                                        handleEquipmentInformationInput(
                                                            index,
                                                            "equipment",
                                                            {
                                                                value: e.value,
                                                                label: e.label,
                                                            }
                                                        )
                                                    }
                                                    value={
                                                        equipmentInformation[
                                                            index
                                                        ]?.equipment
                                                    }
                                                    isDisabled={!isEditing}
                                                />
                                            </>
                                        )}
                                    </>,
                                ]}
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="equipmentYearColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Year" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "year",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.year
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="equipmentMakeColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Make" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Make"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "make",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.make
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="equipmentModelColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Model" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Model"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "model",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.model
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="serialumberColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Serial Number/Identification Number" />
                                        <Form.Control
                                            type="text"
                                            placeholder="Serial Number/Identification Number"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "serialNo",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.serialNo
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                        ]}
                    />
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="equipmentValueColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Value" />
                                        <NumericFormat
                                            className="form-control"
                                            thousandSeparator={true}
                                            prefix={"$"}
                                            decimalScale={2}
                                            fixedDecimalScale={true}
                                            allowNegative={false}
                                            placeholder="$0.00"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "value",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.value
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="yearAcquiredColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Year Acquired" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                handleEquipmentInformationInput(
                                                    index,
                                                    "yearAcquired",
                                                    e.target.value
                                                )
                                            }
                                            value={
                                                equipmentInformation[index]
                                                    ?.yearAcquired
                                            }
                                            disabled={!isEditing}
                                        />
                                    </>,
                                ]}
                            />,
                        ]}
                    />
                </Card>
            ))}
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="yearAcquiredColumn"
                        //   classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Deductible Amount" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={deductibleAmountOptions}
                                    value={deductibleAmount}
                                    onChange={(e) =>
                                        setDeductibleAmount({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                />
                            </>,
                        ]}
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
                                <DatePicker
                                    className="custom-datepicker-input"
                                    placeholderText="MM/DD/YYYY"
                                    selected={expirationOfIM}
                                    onChange={(date) => setExpirationOfIM(date)}
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
                                        value={haveLossDateOption}
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

                                    {haveLossDateOption.value === 1 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
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

                                    {haveLossDateOption.value === 2 && (
                                        <Row
                                            rowContent={
                                                <DatePicker
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
                                    onClick={submitToolsEquipmentForm}
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

export default ToolsEquipmentForm;
