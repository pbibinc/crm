import { useEffect, useState } from "react";
import axios from "axios";

const LeadZipCodeCities = () => {
    const [leadZipCodeCities, setLeadZipCodeCities] = useState(null);

    useEffect(() => {
        const fetchLeadZipCodeCities = async () => {
            try {
                const response = await axios.get(
                    `http://crm.pbibinc.com/api/leads/lead-details/lead-address`
                );
                setLeadZipCodeCities(response.data);
            } catch (error) {
                console.error("Error fetching lead zipcode cities", error);
            }
        };
        fetchLeadZipCodeCities();
    }, []);

    if (!leadZipCodeCities || !leadZipCodeCities.data) {
        return <div>Loading...</div>;
    }

    let zipCity = [];

    if (Array.isArray(leadZipCodeCities.data)) {
        zipCity = leadZipCodeCities.data.map((address) => ({
            zipcode: address.zipcode,
            city: address.city,
        }));
    } else if (typeof leadZipCodeCities.data === "object") {
        zipCity = Object.entries(leadZipCodeCities.data).map(
            ([zipcode, city]) => ({
                zipcode,
                city,
            })
        );
    }


    return { zipCity };
};

export default LeadZipCodeCities;
