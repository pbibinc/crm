import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const LeadZipcode = () => {
    const [leadZipcode, setLeadZipcode] = useState(null);
    const [ziploading, setZipLoading] = useState(true);
    useEffect(() => {
        const fetchLeadZipcode = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/leads/lead-details/lead-address`
                );
                setLeadZipcode(response.data);
                setZipLoading(false);
            } catch (error) {
                console.error("Error fetching lead zipcode", error);

                setZipLoading(false);
            }
        };
        fetchLeadZipcode();
    }, []);

    const zipcodes = leadZipcode?.data?.map((address) => address.zipcode);

    return { ziploading, zipcodes };
};

export default LeadZipcode;
