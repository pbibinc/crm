import { useEffect, useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import "flatpickr/dist/themes/material_green.css";
import Select from "react-select";
import Flatpickr from "react-flatpickr";
import DatePicker from "react-datepicker";
import Form from "react-bootstrap/Form";
import addYears from 'date-fns/addYears';
import Button from 'react-bootstrap/Button';
import SaveIcon from "@mui/icons-material/Save";
import SaveAsIcon from "@mui/icons-material/SaveAs";
import axios from "axios";
import Swal from "sweetalert2";
import { set } from "lodash";

const ExcessLiabilitiesForm = () => {
const GetExcessLiabilityData = () => {
    const excessLiabilityData = sessionStorage.getItem("excessLiabilityData");
    if(excessLiabilityData) {
        return JSON.parse(sessionStorage.getItem("excessLiabilityData"));
    } else {
        return [];
    }
}
//setting for update and edit
const [isEditing, setIsEditing] = useState(() => GetExcessLiabilityData()?.isUpdate == true ? false : true);
const [isUpdate, setIsUpdate] = useState(() => GetExcessLiabilityData()?.isUpdate || false);

//setting for getting the data value from session storage
const getLeadData = () =>{
    const leadData = sessionStorage.getItem("lead");
    if(leadData) {
        return JSON.parse(sessionStorage.getItem("lead"));
    } else {
        return [];
    }
}


 //setting for option of Excess limit
const [excessLimit, setExcessLimit] = useState(() => GetExcessLiabilityData()?.excessLimit || []);
const excessLimitOption= [
    {value: "$1,000,000", label: "$1,000,000"},
    {value: "$2,000,000", label: "$2,000,000"},
    {value: "$3,000,000", label: "$3,000,000"},
    {value: "$4,000,000", label: "$4,000,000"},
    {value: "$5,000,000", label: "$5,000,000"},
    {value: "$6,000,000", label: "$6,000,000"},
    {value: "$7,000,000", label: "$7,000,000"},
    {value: "$8,000,000", label: "$8,000,000"},
    {value: "$9,000,000", label: "$9,000,000"},
    {value: "$10,000,000", label: "$10,000,000"},

];

//setting for option of Excess Effective date
const [excessEffectiveDate, setExcessEffectiveDate] = useState(() => GetExcessLiabilityData()?.excessEffectiveDate ? new Date(GetExcessLiabilityData()?.excessEffectiveDate) : new Date());


//setting for value of insurance carrier policy no and policy premium
const [insuranceCarrier, setInsuranceCarrier] = useState(() => GetExcessLiabilityData()?.insuranceCarrier ||"");
const [policyNumber, setPolicyNumber] = useState(() => GetExcessLiabilityData()?.policyNumber ||"");
const [policyPremium, setPolicyPremium] = useState(() => GetExcessLiabilityData()?.policyPremium ||"");


//setting for option of  excess Liability
const [crossSell, setCrossSell] = useState(() => GetExcessLiabilityData()?.crossSell || []);
let crossSellArray = [
    { value: "General Liabilities", label: "General Liabilities" },
    { value: "Workers Compensation", label: "Workers Compensation" },
    { value: "Commercial Auto", label: "Commercial Auto" },
    { value: "Commercial Property", label: "Commercial Property" },
    { value: "Tools and Equipment", label: "Tools and Equipment" },
    { value: "Builders Risk", label: "Builders Risk" },
    { value: "Business Owner Policy", label: "Business Owner Policy" },
];

//setting for generalLiabilities effective date and expiration date
const [effectiveDate, setEffectiveDate] = useState(() => GetExcessLiabilityData()?.generalLiabilityEffectiveDate ? new Date(GetExcessLiabilityData()?.generalLiabilityEffectiveDate): null);
const [expirationDate, setExpirationDate] = useState(() => GetExcessLiabilityData()?.generalLiabilityExpirationDate ? new Date(GetExcessLiabilityData()?.generalLiabilityExpirationDate) : null);

const handleEffectiveDateChange = (date) => {
    setEffectiveDate(date);
    const newExpirationDate = addYears(date, 1);
    setExpirationDate(newExpirationDate);
  };


  //setting for call back date
    const [callBackDate, setCallBackDate] = useState(() => GetExcessLiabilityData()?.callBackDate ? new Date(GetExcessLiabilityData()?.callBackDate) : new Date());
    const [remarks, setRemarks] = useState(() => GetExcessLiabilityData()?.remarks || "");

  //code for setting object excess liability
  const excessLiabilityFormData = {
    excessLimit: excessLimit.value,
    excessEffectiveDate: excessEffectiveDate,
    insuranceCarrier: insuranceCarrier,
    policyNumber: policyNumber,
    policyPremium: policyPremium,
    generalLiabilityEffectiveDate: effectiveDate,
    generalLiabilityExpirationDate: expirationDate,
    crossSell: crossSell.value,
    callBackDate: callBackDate,
    leadId: getLeadData()?.data?.id,
    remarks:remarks
  }
  console.log(excessLiabilityFormData);

useEffect(() => {
    const excessLiabilitData = {
        excessLimit: excessLimit,
        effectiveDate: effectiveDate,
        excessEffectiveDate: excessEffectiveDate,
        insuranceCarrier: insuranceCarrier,
        policyNumber: policyNumber,
        policyPremium: policyPremium,
        generalLiabilityEffectiveDate: effectiveDate,
        generalLiabilityExpirationDate: expirationDate,
        crossSell: crossSell,
        callBackDate: callBackDate,
        leadId: getLeadData()?.data?.id,
        remarks:remarks,
        isUpdate: isUpdate,
        isEditing: isEditing
      }
      sessionStorage.setItem("excessLiabilityData", JSON.stringify(excessLiabilitData));
}, [
    excessLimit,
    effectiveDate,
    excessEffectiveDate,
    insuranceCarrier,
    policyNumber,
    policyPremium,
    expirationDate,
    crossSell,
    callBackDate,
    remarks,
    isUpdate,
    isEditing

])


  function submitExcessliabilityForm(){
    const leadId = getLeadData()?.data?.id;
    const url = isUpdate ? `http://insuraprime_crm.test/api/excess-liability-data/update/${leadId} ` : `http://insuraprime_crm.test/api/excess-liability-data/store`
    const method = isUpdate ? "put" : "post";
    axios[method](url, excessLiabilityFormData)
          .then(response => {
             console.log(response);
             setIsEditing(false);
             setIsUpdate(true);
             Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Excess Liability Data Saved Successfully',
                showConfirmButton: true,
             })
            })
          .catch((error) => {
            console.log(error);
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Excess Liability Data Not Saved',
                showConfirmButton: true,
             })
          });
  }
    return(
        <>
         <Row
            classValue="mb-4"
            rowContent={[
                <Column
                  key="excessLimit"
                  classValue="col-6"
                  colContent={[
                    <>
                        <Label labelContent="Excess Limit"/>
                        <Select
                         className="basic-single"
                         classNamePrefix="select"
                         options={excessLimitOption}
                         onChange={(e) => setExcessLimit({value: e.value, label: e.label})}
                         isDisabled={!isEditing}
                         value={excessLimit}
                        />
                    </>
                  ]}
                />,
                <Column
                  key="excessEffectiveDate"
                  classValue="col-6"
                  colContent={[
                    <>
                        <Label labelContent="Excess Effective Date"/>
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
                          selected={excessEffectiveDate}
                          onChange={date => setExcessEffectiveDate(date)}
                          disabled={!isEditing}
                          value={excessEffectiveDate}
                        />

                    </>

                  ]}
                />,
            ]}
        />
        <Row
            classValue="mb-4"
            rowContent={[
                <Column
                  key="insuranceCarrier"
                  classValue="col-4"
                  colContent={[
                    <>
                        <Label labelContent="Insurance Carrier"/>
                        <Form.Control
                          type="text"
                          placeholder="Insurance Carrier"
                          onChange={(e) => setInsuranceCarrier(e.target.value)}
                          disabled={!isEditing}
                          value={insuranceCarrier}
                        />


                    </>
                  ]}
                />,
                <Column
                  key="policyNumber"
                  classValue="col-4"
                  colContent={[
                    <>
                        <Label labelContent="Policy No./ Quote No."/>
                        <Form.Control
                          type="text"
                          placeholder="Policy Number"
                          onChange={(e) => setPolicyNumber(e.target.value)}
                          disabled={!isEditing}
                          value={policyNumber}
                        />

                    </>

                  ]}
                />,
                <Column
                key="policyPremium"
                classValue="col-4"
                colContent={[
                  <>
                      <Label labelContent="Policy Premium"/>
                      <Form.Control
                         type="text"
                         placeholder="Policy Premium"
                         onChange={(e) => setPolicyPremium(e.target.value)}
                         disabled={!isEditing}
                         value={policyPremium}
                      />
                  </>

                ]}
              />,
            ]}
        />
        <Row
            classValue="mb-4"
            rowContent={[
                <Column
                  key="generalLiabilityEffectiveDate"
                  classValue="col-6"
                  colContent={[
                    <>
                        <Label labelContent="General Libiality Effective Date"/>
                        <DatePicker
                          className="form-control form-date-picker"
                          placeholderText="MM/DD/YYYY"
                          selected={effectiveDate}
                          onChange={handleEffectiveDateChange}
                          disabled={!isEditing}
                        />
                    </>
                  ]}
                />,
                <Column
                  key="generalLiabilityExpirationDate"
                  classValue="col-6"
                  colContent={[
                    <>
                        <Label labelContent="General Liability Expiration Date"/>
                        <br></br>
                        <DatePicker
                          className="form-control form-date-picker"
                          placeholderText="MM/DD/YYYY"
                          selected={expirationDate}
                          disabled={!isEditing}

                        />
                    </>

                  ]}
                />,
            ]}
        />
        <Row
            classValue="mb-4"
            rowContent={[
                <Column
                  key="callBackDate"
                  classValue="col-6"
                  colContent={[
                    <>
                        <Label labelContent="Call Back"/>
                        <DatePicker
                          className="form-control form-date-picker"
                          placeholderText="MM/DD/YYYY"
                          showTimeSelect
                          timeFormat="HH:mm"
                          timeIntervals={15}
                          dateFormat="MM/dd/yyyy h:mm aa"
                          selected={callBackDate}
                          onChange={date => setCallBackDate(date)}
                          disabled={!isEditing}
                        />
                    </>
                  ]}
                />,
                <Column
                  key="generalLiabilityExpirationDate"
                  classValue="col-6"
                  colContent={[
                    <>
                      <Label labelContent="Cross Sell" />
                      <Select
                           className="basic=single"
                           classNamePrefix="select"
                           id="generalLiabilitiesCrossSellDropdown"
                           name="generalLiabilitiesCrossSellDropdown"
                          options={crossSellArray}
                          onChange={(e) => setCrossSell({value: e.value, label: e.label})}
                          isDisabled={!isEditing}
                          value={crossSell}
                       />
                    </>
                  ]}
                />,
            ]}
        />
            <Row
                classValue="mb-3"
                rowContent={

                    <Column
                       colContent={[
                        <>
                          <Label labelContent="Remarks" />
                          <Form.Control
                            as={"textarea"}
                            rows={6}
                            onChange={(e) => setRemarks(e.target.value)}
                            disabled={!isEditing}
                            value={remarks}
                         />
                           </>
                        ]}
                     />

                }
            />
              <Row
                classValue="mb-3"
                rowContent={[
                    <Column
                        key="workersCompAddButtonColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <div className="d-grid gap-2">
                                    <Button
                                        variant="success"
                                        size="lg"
                                        onClick={submitExcessliabilityForm}
                                        disabled={!isEditing}
                                    >
                                        <SaveIcon />
                                    </Button>
                                </div>
                            </>
                        }
                    />,
                    <Column
                        key="workersCompEditButtonColumn"
                        classValue="col-6"
                        colContent={
                            <>
                                <div className="d-grid gap=2">
                                    <Button
                                        variant="primary"
                                        size="lg"
                                        disabled={isEditing}
                                        onClick={() => setIsEditing(true)}
                                    >
                                        <SaveAsIcon />
                                    </Button>
                                </div>
                            </>
                        }
                    />,
                ]}
            />
        </>

    )


};


export default ExcessLiabilitiesForm;