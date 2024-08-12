import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const GeneralLiabilitiesData = () => {
    const [generalLiabilitiesData, setGeneralLiabilitiesData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchGeneralLiabitiesData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/general-liabilities-data/edit/${lead?.data?.id}`
                );
                setGeneralLiabilitiesData(response.data);
            } catch (error) {
                console.error("Error fetching general liabilities data", error);
            }
        };
        fetchGeneralLiabitiesData();
    }, [lead?.data?.id]);
    return { generalLiabilitiesData };
};

export default GeneralLiabilitiesData;
