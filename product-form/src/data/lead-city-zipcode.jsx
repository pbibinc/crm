import { useEffect, useState } from "react";

const LeadZipCodeCities = () => {
    const [leadZipCodeCities, setLeadZipCodeCities] = useState(null);

    useEffect(() => {
        const fetchLeadZipCodeCities = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details/lead-address`
                );
                const data = await response.json();
                setLeadZipCodeCities(data);
            } catch (error) {
                console.error("Error fetching lead zipcode cities", error);
            }
        };
        fetchLeadZipCodeCities();
    }, []);

    if (!leadZipCodeCities || !leadZipCodeCities.data) {
        return <div>Loading...</div>;
    }

    let zipCityArray = [];

    if (Array.isArray(leadZipCodeCities.data)) {
        zipCityArray = leadZipCodeCities.data.map((address) => ({
            zipcode: address.zipcode,
            city: address.city,
        }));
    } else if (typeof leadZipCodeCities.data === "object") {
        zipCityArray = Object.entries(leadZipCodeCities.data).map(
            ([zipcode, city]) => ({
                zipcode,
                city,
            })
        );
    }

    return zipCityArray;
};

export default LeadZipCodeCities;
