import { useEffect, useState } from "react";
import axios from "axios";
import axiosClient from "../api/axios.client";

const LeadCity = () => {
    const [leadCity, setLeadCity] = useState(null);
    const [cityLoading, setCityLoading] = useState(true);
    useEffect(() => {
        const fetchLeadCity = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/leads/lead-details/lead-address`
                );
                setLeadCity(response.data);
                setCityLoading(false);
            } catch (error) {
                console.error("Error fetching lead city", error);
                setCityLoading(false);
            }
        };
        fetchLeadCity();
    }, []);

    if (!leadCity || !leadCity.data) {
        return <div>Loading...</div>;
    }

    const cities = leadCity?.data?.map((address) => address.city);

    return { cityLoading, cities };
};

export default LeadCity;
