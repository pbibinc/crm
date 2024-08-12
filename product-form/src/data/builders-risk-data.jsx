import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const BuildersRiskData = () => {
    const [buildersRiskData, setBuildersRiskData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchBuildersRiskData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/builders-risk/edit/${lead?.data?.id}`
                );
                setBuildersRiskData(response.data);
            } catch (error) {
                console.error("Error fetching builders risk data", error);
            }
        };
        fetchBuildersRiskData();
    }, [lead?.data?.id]);
    return { buildersRiskData };
};

export default BuildersRiskData;
