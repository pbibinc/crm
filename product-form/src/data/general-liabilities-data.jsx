import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const GeneralLiabilitiesData = () => {
    const [generalLiabilitiesData, setGeneralLiabilitiesData] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchGeneralLiabitiesData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/general-liabilities-data/edit/${getLeadData?.data?.id}`
                );
                setGeneralLiabilitiesData(response.data);
            } catch (error) {
                console.error("Error fetching general liabilities data", error);
            }
        };
        fetchGeneralLiabitiesData();
    }, [getLeadData?.data?.id]);
    return { generalLiabilitiesData };
};

export default GeneralLiabilitiesData;
