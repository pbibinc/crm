import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const ToolsEquipmentData = () => {
    const [toolsEquipmentData, setToolsEquipmentData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchToolsEquipment = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/tools-equipment-data/edit/${lead?.data?.id}`
                );
                setToolsEquipmentData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchToolsEquipment();
    }, [lead?.data?.id]);
    return { toolsEquipmentData };
};

export default ToolsEquipmentData;
