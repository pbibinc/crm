import { useEffect, useState } from "react";
import LeadDetails from "./lead-details";
import axios from "axios";
import axiosClient from "../api/axios.client";

const GeneralInformationData = () => {
    const [generalInformation, setGeneralInformation] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    useEffect(() => {
        const fetchGenerealInformation = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/general-information-data/edit/${getLeadData?.data?.id}`
                );

                setGeneralInformation(response);
            } catch (error) {
                console.error("Error fetching general information", error);
            }
        };
        fetchGenerealInformation();
    }, [getLeadData?.data?.id]);
    console.log(generalInformation);
    return { generalInformation };
};

export default GeneralInformationData;
