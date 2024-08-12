import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const CommercialAutoData = () => {
    const [commercialAutoData, setCommercialAutoData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchCommercialAutoData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/commercial-auto-data/edit/${lead?.data?.id}`
                );
                setCommercialAutoData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchCommercialAutoData();
    }, [lead?.data?.id]);
    return { commercialAutoData };
};

export default CommercialAutoData;
