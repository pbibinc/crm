import { useContext, useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import Form from "react-bootstrap/Form";
import Select from "react-select";
import InputMask from "react-input-mask";
import DatePicker from "react-datepicker";
import { NumericFormat } from "react-number-format";

import Button from "react-bootstrap/Button";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import SaveIcon from "@mui/icons-material/Save";

import Swal from "sweetalert2";
import axiosClient from "../api/axios.client";
import "../style/general-information.css";
import { ContextData } from "../contexts/context-data-provider";
import { useBuildersRiskPrevious } from "../contexts/builders-risk-previous-data-context";
const BuilderRiskPreviousForm = () => {
    const { buildersRiskPreviousData } = useBuildersRiskPrevious();

    //setting for getting stored buildersRiskData
    const storedBuildersRiskData = () => {
        const localBuildersRisk = JSON.parse(
            sessionStorage.getItem("buildersRiskData") || "{}"
        );
        return buildersRiskPreviousData
            ? buildersRiskPreviousData.data.changes
            : localBuildersRisk;
    };
    //setting for getting stored lead data
    const storedLeads = JSON.parse(sessionStorage.getItem("lead"));

    //setup most of the state varibles here
    const [isEditing, setIsEditing] = useState(() =>
        storedBuildersRiskData()?.isUpdate == true ? false : true
    );
    const [isUpdate, setIsUpdate] = useState(
        () => storedBuildersRiskData()?.isUpdate || false
    );

    const [propertyAddress, setPropertyAddress] = useState(
        () => storedBuildersRiskData()?.propertyAddress || ""
    );
    const [valueOfExistingStructure, setValueOfExistingStructure] = useState(
        () => storedBuildersRiskData()?.valueOfExistingStructure || ""
    );
    const [valueOfWorkBeingPerformed, setValueOfWorkBeingPerformed] = useState(
        () => storedBuildersRiskData()?.valueOfWorkBeingPerformed || ""
    );
    const [porjectStarted, setPorjectStarted] = useState(
        () => storedBuildersRiskData()?.porjectStarted || {}
    );
    const [operationDescription, setOperationDescription] = useState(
        () => storedBuildersRiskData()?.operationDescription || ""
    );
    const [propertyDescription, setPropertyDescription] = useState(
        () => storedBuildersRiskData()?.propertyDescription || ""
    );
    const [roofingUpdateYear, setRoofingUpdateYear] = useState(
        () => storedBuildersRiskData()?.roofingUpdateYear || ""
    );
    const [heatingUpdateYear, setHeatingUpdateYear] = useState(
        () => storedBuildersRiskData()?.heatingUpdateYear || ""
    );
    const [plumbingUpdateYear, setPlumbingUpdateYear] = useState(
        () => storedBuildersRiskData()?.plumbingUpdateYear || ""
    );
    const [electricalUpdateYear, setElectricalUpdateYear] = useState(
        () => storedBuildersRiskData()?.electricalUpdateYear || ""
    );
    const [
        structureOccupiedDuringRemodelRenovation,
        setStructureOccupiedDuringRemodelRenovation,
    ] = useState(
        () =>
            storedBuildersRiskData()
                ?.structureOccupiedDuringRemodelRenovation || ""
    );
    const [whenWasTheStructureBuilt, setWhenWasTheStructureBuilt] = useState(
        () => storedBuildersRiskData()?.whenWasTheStructureBuilt || ""
    );
    const [
        descriptionOfOperationsForTheProject,
        setDescriptionOfOperationsForTheProject,
    ] = useState(
        () =>
            storedBuildersRiskData()?.descriptionOfOperationsForTheProject || ""
    );

    const [constructionType, setConstructionType] = useState(
        () => storedBuildersRiskData()?.constructionType || {}
    );
    const [protectionClass, setProtectionClass] = useState(
        () => storedBuildersRiskData()?.protectionClass || {}
    );
    const [squareFootage, setSquareFootage] = useState(
        () => storedBuildersRiskData()?.squareFootage || ""
    );
    const [numberOfFloors, setNumberOfFloors] = useState(
        () => storedBuildersRiskData()?.numberOfFloors || ""
    );
    const [numberOfUnitsDwelling, setNumberOfUnitsDwelling] = useState(
        () => storedBuildersRiskData()?.numberOfUnitsDwelling || ""
    );
    const [jobSiteSecurity, setJobSiteSecurity] = useState(
        () => storedBuildersRiskData()?.jobSiteSecurity || {}
    );
    const [distanceToNearestFireHydrant, setDistanceToNearestFireHydrant] =
        useState(
            () => storedBuildersRiskData()?.distanceToNearestFireHydrant || ""
        );
    const [distanceToNearestFireStation, setDistanceToNearestFireStation] =
        useState(
            () => storedBuildersRiskData()?.distanceToNearestFireStation || ""
        );

    const [expirationOfIM, setExpirationOfIM] = useState(() =>
        storedBuildersRiskData()?.expirationOfIM
            ? new Date(storedBuildersRiskData()?.expirationOfIM)
            : new Date()
    );
    const [priorCarrier, setPriorCarrier] = useState(
        () => storedBuildersRiskData()?.priorCarrier || ""
    );

    const [dateOfClaim, setDateOfClaim] = useState(() =>
        storedBuildersRiskData()?.dateOfClaim
            ? new Date(storedBuildersRiskData()?.dateOfClaim)
            : new Date()
    );
    const [lossAmount, setLossAmount] = useState(
        () => storedBuildersRiskData()?.lossAmount || ""
    );
    const [dateProjectStarted, setDateProjectStarted] = useState(() =>
        storedBuildersRiskData()?.dateProjectStarted
            ? new Date(storedBuildersRiskData()?.dateProjectStarted)
            : new Date()
    );

    //code for settig renovation and new construction
    const [newConstructionRenovation, setNewConstructionRenovation] = useState(
        () => storedBuildersRiskData()?.newConstructionRenovation || ""
    );

    //setting for construction type option
    const constructionTypeOptions = [
        { value: "Frame", label: "Frame" },
        { value: "Joisted Masonry", label: "Joisted Masonry" },
        { value: "Non-Combustible", label: "Non-Combustible" },
        { value: "Masonry Non-Combustible", label: "Masonry Non-Combustible" },
        { value: "Modified Fire Resestive", label: "Modified Fire Resestive" },
        { value: "Fire Resestive", label: "Fire Resestive" },
    ];

    //protection class dropdown options
    const protectionClassOptions = [
        { value: "1", label: "1" },
        { value: "2", label: "2" },
        { value: "3", label: "3" },
        { value: "4", label: "4" },
        { value: "5", label: "5" },
        { value: "6", label: "6" },
        { value: "7", label: "7" },
        { value: "8", label: "8" },
    ];

    //setting for have loss click switch
    const [isHaveLossChecked, setIsHaveLossChecked] = useState(
        () => storedBuildersRiskData()?.isHaveLossChecked || false
    );
    const [haveLossDateOption, setHaveLossDateOption] = useState(
        () =>
            storedBuildersRiskData()?.haveLossDateOption || {
                value: 1,
                label: "MM/DD/YYYY",
            }
    );
    const handleHaveLossChange = (event) => {
        setIsHaveLossChecked(event.target.checked);
    };

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

    const builderRiskFormData = {
        propertyAddress: propertyAddress,
        valueOfExistingStructure: valueOfExistingStructure,
        valueOfWorkBeingPerformed: valueOfWorkBeingPerformed,
        porjectStarted: porjectStarted.value,
        dateProjectStarted: dateProjectStarted,
        newConstructionRenovation: newConstructionRenovation.value,

        operationDescription: operationDescription,

        propertyDescription: propertyDescription,
        roofingUpdateYear: roofingUpdateYear,
        heatingUpdateYear: heatingUpdateYear,
        plumbingUpdateYear: plumbingUpdateYear,
        electricalUpdateYear: electricalUpdateYear,
        structureOccupiedDuringRemodelRenovation:
            structureOccupiedDuringRemodelRenovation,
        whenWasTheStructureBuilt: whenWasTheStructureBuilt,
        descriptionOfOperationsForTheProject:
            descriptionOfOperationsForTheProject,

        constructionType: constructionType.value,
        protectionClass: protectionClass.value,
        squareFootage: squareFootage,
        numberOfFloors: numberOfFloors,
        numberOfUnitsDwelling: numberOfUnitsDwelling,
        jobSiteSecurity: jobSiteSecurity.value,
        distanceToNearestFireHydrant: distanceToNearestFireHydrant,
        distanceToNearestFireStation: distanceToNearestFireStation,

        expirationOfIM: expirationOfIM,
        priorCarrier: priorCarrier,

        isHaveLossChecked: isHaveLossChecked,
        dateOfClaim: dateOfClaim,
        lossAmount: lossAmount,
        haveLossDateOption: haveLossDateOption,

        leadId: storedLeads?.data?.id,
        userProfileId: storedLeads?.data?.userProfileId,
    };

    useEffect(() => {
        const buildersRiskData = {
            propertyAddress: propertyAddress,
            valueOfExistingStructure: valueOfExistingStructure,
            valueOfWorkBeingPerformed: valueOfWorkBeingPerformed,
            porjectStarted: porjectStarted,
            dateProjectStarted: dateProjectStarted,
            newConstructionRenovation: newConstructionRenovation,

            operationDescription: operationDescription,

            propertyDescription: propertyDescription,
            roofingUpdateYear: roofingUpdateYear,
            heatingUpdateYear: heatingUpdateYear,
            plumbingUpdateYear: plumbingUpdateYear,
            electricalUpdateYear: electricalUpdateYear,
            structureOccupiedDuringRemodelRenovation:
                structureOccupiedDuringRemodelRenovation,
            whenWasTheStructureBuilt: whenWasTheStructureBuilt,
            descriptionOfOperationsForTheProject:
                descriptionOfOperationsForTheProject,

            constructionType: constructionType,
            protectionClass: protectionClass,
            squareFootage: squareFootage,
            numberOfFloors: numberOfFloors,
            numberOfUnitsDwelling: numberOfUnitsDwelling,
            jobSiteSecurity: jobSiteSecurity,
            distanceToNearestFireHydrant: distanceToNearestFireHydrant,
            distanceToNearestFireStation: distanceToNearestFireStation,

            expirationOfIM: expirationOfIM,
            priorCarrier: priorCarrier,

            isHaveLossChecked: isHaveLossChecked,
            dateOfClaim: dateOfClaim,
            lossAmount: lossAmount,
            haveLossDateOption: haveLossDateOption,

            isUpdate: isUpdate,
            isEditing: isEditing,
        };
        sessionStorage.setItem(
            "buildersRiskData",
            JSON.stringify(buildersRiskData)
        );
    }, [
        propertyAddress,
        valueOfExistingStructure,
        valueOfWorkBeingPerformed,
        porjectStarted,
        newConstructionRenovation,
        operationDescription,
        propertyDescription,
        roofingUpdateYear,
        heatingUpdateYear,
        plumbingUpdateYear,
        electricalUpdateYear,
        structureOccupiedDuringRemodelRenovation,
        whenWasTheStructureBuilt,
        descriptionOfOperationsForTheProject,
        constructionType,
        protectionClass,
        squareFootage,
        numberOfFloors,
        numberOfUnitsDwelling,
        jobSiteSecurity,
        distanceToNearestFireHydrant,
        distanceToNearestFireStation,
        expirationOfIM,
        priorCarrier,
        isHaveLossChecked,
        dateOfClaim,
        lossAmount,
        haveLossDateOption,
        isUpdate,
        isEditing,
        dateProjectStarted,
    ]);

    function submitBuilderRiskForm() {
        const leadId = storedLeads?.data?.id;
        const url = isUpdate
            ? `/api/builders-risk/update/${leadId}`
            : `/api/builders-risk/store`;
        const method = isUpdate ? "put" : "post";
        axiosClient[method](url, builderRiskFormData)
            .then((response) => {
                setIsEditing(false);
                setIsUpdate(true);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "builders risk form has been saved",
                    showConfirmButton: true,
                });
            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Something went wrong",
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
                        key="propertyAddress"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Property Address" />
                                <Form.Control
                                    type="text"
                                    onChange={(e) =>
                                        setPropertyAddress(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={propertyAddress}
                                />
                            </>,
                        ]}
                    />,
                    <Column
                        key="valueOfExistingStructure"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Value of Existing Structure" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setValueOfExistingStructure(
                                            e.target.value
                                        )
                                    }
                                    value={valueOfExistingStructure}
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
                        key="valueOfWorkBeingPerformed"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Value of work being performed" />
                                <NumericFormat
                                    className="form-control"
                                    thousandSeparator={true}
                                    prefix={"$"}
                                    decimalScale={2}
                                    fixedDecimalScale={true}
                                    allowNegative={false}
                                    placeholder="$0.00"
                                    onChange={(e) =>
                                        setValueOfWorkBeingPerformed(
                                            e.target.value
                                        )
                                    }
                                    value={valueOfWorkBeingPerformed}
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
                        key="porjectStartedColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Has the project Started" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    onChange={(e) =>
                                        setPorjectStarted({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    options={[
                                        { value: "yes", label: "Yes" },
                                        { value: "no", label: "No" },
                                    ]}
                                    isDisabled={!isEditing}
                                    value={porjectStarted}
                                />
                            </>,
                        ]}
                    />,
                    <Column
                        key="newConstructionRenovationColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="New Construction or Renovation" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        {
                                            value: "New Construction",
                                            label: "New Construction",
                                        },
                                        {
                                            value: "Renovation",
                                            label: "Renovation",
                                        },
                                    ]}
                                    onChange={(e) =>
                                        setNewConstructionRenovation({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={newConstructionRenovation}
                                />
                            </>,
                        ]}
                    />,
                ]}
            />
            {porjectStarted.value === "no" && (
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="projectDateColumng"
                            classValue="col-6"
                            colContent={[
                                <>
                                    <Label labelContent="Project Date " />
                                    <DatePicker
                                        selected={dateProjectStarted}
                                        placeholderText="MM/DD/YYYY"
                                        showMonthDropdown
                                        showYearDropdown
                                        className="form-control form-date-picker"
                                        onChange={(date) =>
                                            setDateProjectStarted(date)
                                        }
                                        disabled={!isEditing}
                                    />
                                </>,
                            ]}
                        />,
                    ]}
                />
            )}

            {newConstructionRenovation.value === "New Construction" && (
                <Row
                    classValue="mb-4"
                    rowContent={[
                        <Column
                            key="newConstuctionQuestionare"
                            classValue="col-12"
                            colContent={[
                                <>
                                    <Label labelContent="Complete descriptions of operations for the project:" />
                                    <Form.Control
                                        as={"textarea"}
                                        rows={6}
                                        onChange={(e) =>
                                            setOperationDescription(
                                                e.target.value
                                            )
                                        }
                                        disabled={!isEditing}
                                        value={operationDescription}
                                    />
                                </>,
                            ]}
                        />,
                    ]}
                />
            )}
            {newConstructionRenovation.value === "Renovation" && (
                <>
                    <Row
                        classValue="mb-4"
                        rowContent={[
                            <Column
                                key="renovationQuestionare"
                                classValue="col-12"
                                colContent={[
                                    <>
                                        <Label labelContent="Description of property Use Prior to construction:" />
                                        <Form.Control
                                            as={"textarea"}
                                            rows={6}
                                            onChange={(e) =>
                                                setPropertyDescription(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={propertyDescription}
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
                                key="lastUpdateRoofingYearColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Last Update to Roofing Year" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                setRoofingUpdateYear(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={roofingUpdateYear}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="lastUpdateHeartingYearColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Last Update to Heating Year" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                setHeatingUpdateYear(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={heatingUpdateYear}
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
                                key="lastUpdatePlumbingYearColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Last Update to Plumbing Year" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                setPlumbingUpdateYear(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={plumbingUpdateYear}
                                        />
                                    </>,
                                ]}
                            />,
                            <Column
                                key="lastUpdateElectricalYearColumn"
                                classValue="col-6"
                                colContent={[
                                    <>
                                        <Label labelContent="Last Update to Electrical Year" />
                                        <InputMask
                                            className="form-control"
                                            mask="9999"
                                            placeholder="Year"
                                            onChange={(e) =>
                                                setElectricalUpdateYear(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={electricalUpdateYear}
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
                                key="structureOccupiedDuringRemodelRenovation"
                                classValue="col-12"
                                colContent={[
                                    <>
                                        <Label labelContent="Will the Structure be Occupied During the Remodel/Renovation?:" />
                                        <Form.Control
                                            as={"textarea"}
                                            rows={6}
                                            onChange={(e) =>
                                                setStructureOccupiedDuringRemodelRenovation(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                structureOccupiedDuringRemodelRenovation
                                            }
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
                                key="whenWasTheStructureBuilt"
                                classValue="col-12"
                                colContent={[
                                    <>
                                        <Label labelContent="When was the structure built?:" />
                                        <Form.Control
                                            tabIndex="text"
                                            onChange={(e) =>
                                                setWhenWasTheStructureBuilt(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={whenWasTheStructureBuilt}
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
                                key="descriptionOfOperationsForTheProject"
                                classValue="col-12"
                                colContent={[
                                    <>
                                        <Label labelContent="Complete description of operations for the projects?:" />
                                        <Form.Control
                                            as={"textarea"}
                                            rows={6}
                                            onChange={(e) =>
                                                setDescriptionOfOperationsForTheProject(
                                                    e.target.value
                                                )
                                            }
                                            disabled={!isEditing}
                                            value={
                                                descriptionOfOperationsForTheProject
                                            }
                                        />
                                    </>,
                                ]}
                            />,
                        ]}
                    />
                </>
            )}
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="constructionType"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Construction Type" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={constructionTypeOptions}
                                    onChange={(e) =>
                                        setConstructionType({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={constructionType}
                                />
                            </>,
                        ]}
                    />,
                    <Column
                        key="protectionClassColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Protection Class" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={protectionClassOptions}
                                    onChange={(e) =>
                                        setProtectionClass({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={protectionClass}
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
                        key="squareFootageColumn"
                        classValue="col-6"
                        colContent={[
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
                            </>,
                        ]}
                    />,
                    <Column
                        key="numberOfFlooersColumn"
                        classValue="col-6"
                        colContent={[
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
                            </>,
                        ]}
                    />,
                ]}
            />
            <Row
                classValue="mb-4"
                rowContent={[
                    <Column
                        key="numberOfUnitsDwellingColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Number of Units Dwelling" />
                                <Form.Control
                                    type="number"
                                    onChange={(e) =>
                                        setNumberOfUnitsDwelling(e.target.value)
                                    }
                                    disabled={!isEditing}
                                    value={numberOfUnitsDwelling}
                                />
                            </>,
                        ]}
                    />,
                    <Column
                        key="jobSiteSecurtyColumn"
                        classValue="col-6"
                        colContent={[
                            <>
                                <Label labelContent="Jobsite Security" />
                                <Select
                                    className="basic-single"
                                    classNamePrefix="select"
                                    options={[
                                        { value: "Alarm", label: "Alarm" },
                                        {
                                            value: "CCTV/Security Camera",
                                            label: "CCTV/Security Camera",
                                        },
                                        { value: "Fenced", label: "Fenced" },
                                    ]}
                                    onChange={(e) =>
                                        setJobSiteSecurity({
                                            value: e.value,
                                            label: e.label,
                                        })
                                    }
                                    isDisabled={!isEditing}
                                    value={jobSiteSecurity}
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
                        key="distanceToNearestFireHydrantColumn"
                        classValue="col-6"
                        colContent={[
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
                            </>,
                        ]}
                    />,
                    <Column
                        key="distanceToNearestFireStationColumn"
                        classValue="col-6"
                        colContent={[
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
                                                    selected={dateOfClaim}
                                                    placeholderText="MM/DD/YYYY"
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="form-control form-date-picker"
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
                                                    selected={dateOfClaim}
                                                    dateFormat="MM/yyyy"
                                                    placeholderText="MM/YYYY"
                                                    showMonthYearPicker
                                                    showMonthDropdown
                                                    showYearDropdown
                                                    className="form-control form-date-picker"
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
                                    onClick={submitBuilderRiskForm}
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

export default BuilderRiskPreviousForm;
