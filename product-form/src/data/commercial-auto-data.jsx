import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const CommercialAutoData = () => {
    const [commercialAutoData, setCommercialAutoData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchCommercialAutoData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/commercial-auto-data/edit/${getLeadData?.data?.id}`
                );
                setCommercialAutoData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchCommercialAutoData();
    }, [getLeadData?.data?.id]);
    return { commercialAutoData };
};

export default CommercialAutoData;
