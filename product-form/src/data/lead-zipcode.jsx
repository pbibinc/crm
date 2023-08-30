import { useEffect, useState } from "react";

const LeadZipcode = () => {
    const [leadZipcode, setLeadZipcode] = useState(null);
    const [ziploading, setZipLoading] = useState(true);
    useEffect(() => {
        const fetchLeadZipcode = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details/lead-address`
                );
                const data = await response.json();
                setLeadZipcode(data);
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
