import { useState } from "react";
import Row from "../element/row-element";
import Column from "../element/column-element";
import Label from "../element/label-element";
import "flatpickr/dist/themes/material_green.css";
import Select from "react-select";
import Flatpickr from "react-flatpickr";
import DatePicker from "react-datepicker";
import Form from "react-bootstrap/Form";
import addYears from 'date-fns/addYears';

const ExcessLiabilitiesForm = () => {
 //setting for option of Excess limit
const [excessLimit, setExcessLimit] = useState([]);
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
const [excessEffectiveDate, setExcessEffectiveDate] = useState(new Date());


//setting for option of  excess Liability
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
const [effectiveDate, setEffectiveDate] = useState(null);
const [expirationDate, setExpirationDate] = useState(null);

const handleEffectiveDateChange = (date) => {
    setEffectiveDate(date);
    const newExpirationDate = addYears(date, 1);
    setExpirationDate(newExpirationDate);
  };

  //code for setting object excess liability
  const excessLiabilityFormData = {
    excessLimit: excessLimitOption,
    excessEffectiveDate: excessEffectiveDate,
    insuranceCarrier: "",
    policyNumber: "",
    policyPremium: "",
    generalLiabilityEffectiveDate: effectiveDate,
    generalLiabilityExpirationDate: expirationDate,
    callBackDate: "",
    generalLiabilitiesCrossSellDropdown: crossSellArray,
    remarks: "",
  }
  console.log(excessLiabilityFormData);
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
                         onChange={(e) => setExcessLimit(e.value)}
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
                                min-width: 475px;
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
                        <Form.Control type="text" placeholder="Insurance Carrier" />


                    </>
                  ]}
                />,
                <Column
                  key="policyNumber"
                  classValue="col-4"
                  colContent={[
                    <>
                        <Label labelContent="Policy No./ Quote No."/>
                        <Form.Control type="text" placeholder="Policy Number" />

                    </>

                  ]}
                />,
                <Column
                key="policyPremium"
                classValue="col-4"
                colContent={[
                  <>
                      <Label labelContent="Policy Premium"/>
                      <Form.Control type="text" placeholder="Policy Premium" />
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
                        //   selected={excessEffectiveDate}
                        //   onChange={date => setExcessEffectiveDate(date)}
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
                            // disabled={!isEditing}
                         />
                           </>
                        ]}
                     />

                }
            />
        </>

    )


};


export default ExcessLiabilitiesForm;
