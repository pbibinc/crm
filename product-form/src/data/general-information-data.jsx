import { useEffect, useState } from "react";
import LeadDetails from "./lead-details";
import axios from "axios";
import axiosClient from "../api/axios.client";

const GeneralInformationData = () => {
    const [generalInformation, setGeneralInformation] = useState(null);
    const leadDetailsInstance = LeadDetails();
    useEffect(() => {
        const fetchGenerealInformation = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/general_information`
                );
                setGeneralInformation(response.data);
            } catch (error) {
                console.error("Error fetching general information", error);
            }
        };
        fetchGenerealInformation();
    }, []);

    const leadId = leadDetailsInstance?.data?.id;
    const generalInformationMapped = generalInformation?.data?.filter(
        (item) => item.leads_id === leadId
    );
    return generalInformationMapped;
};

export default GeneralInformationData;
