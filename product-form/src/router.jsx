import { createBrowserRouter } from "react-router-dom";
import AppointedLeadQuestionare from "./views/appoinnted-lead-questionare.jsx";
import GeneralLiabilitiesForm from "./product-form/general-liabilites-form.jsx";
import ContextDataProvider from "./contexts/context-data-provider.jsx";
import GeneralLiabilitiesFormEdit from "./views/general-liabilities-edit.jsx";
import WorkersCompensationFormEdit from "./views/workers-compensation-edit.jsx";
import GeneralInformationEdit from "./views/general-information-edit.jsx";
import CommercialAutoFormEdit from "./views/commercial-auto-form-edit.jsx";
import CommercialAutoPrevious from "./views/commercial-auto-previous.jsx";
import GeneralLiabilitiesPrevious from "./views/general-liabilities-previous.jsx";
import WorkersCompensationPrevious from "./views/workers-compensation-previous.jsx";
import ExcessLiabilityFormEdit from "./views/excess-liability-form-edit.jsx";
import ExcessLiabilityPrevious from "./views/excess-liability-previous.jsx";
import ToolsEquipmentFormEdit from "./views/tools-equipment-form-edit.jsx";
import ToolsEquipmentPrevious from "./views/tools-equipment-previous.jsx";
import BuildersRiskFormEdit from "./views/builders-risk-form-edit.jsx";
import BuildersRiskPrevious from "./views/builders-risk-previous.jsx";
import BusinessOwnersPolicyFormEdit from "./views/business-owners-form-edit.jsx";
import BusinessOwnersPolicyPrevious from "./views/business-owners-previous.jsx";
import AddProductForm from "./views/add-product-form.jsx";
import GeneralInformationDataProvider from "./providers/general-information-provider.jsx";
import GeneralLiabilitiesDataProvider from "./providers/general-liabilities-provider.jsx";
import WorkersCompensationDataProvider from "./providers/workers-compensation-provider.jsx";
import CommercialAutoDataProvider from "./providers/commercial-auto-provider.jsx";
import ExcessLiabilityDataProvider from "./providers/excess-liability-provider.jsx";
import ToolsEquipmentDataProvider from "./providers/tools-equipment-provider.jsx";
import BuildersRiskDataProvider from "./providers/builders-risk-provider.jsx";
import BusinessOwnersPolicyDataProvider from "./providers/business-owners-policy-provider.jsx";

const router = createBrowserRouter([
    {
        path: "/appoinnted-lead-questionare",
        element: <AppointedLeadQuestionare />,
    },
    {
        path: "/add-product-form",
        element: (
            <ContextDataProvider>
                <GeneralInformationDataProvider>
                    <GeneralLiabilitiesDataProvider>
                        <AddProductForm />
                    </GeneralLiabilitiesDataProvider>
                </GeneralInformationDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/general-liabilities-form",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesForm />
            </ContextDataProvider>
        ),
    },
    {
        path: "/general-information-form/edit",
        element: (
            <ContextDataProvider>
                <GeneralInformationDataProvider>
                    <GeneralInformationEdit />
                </GeneralInformationDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/general-liabilities-form/edit",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesDataProvider>
                    <GeneralLiabilitiesFormEdit />
                </GeneralLiabilitiesDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/workers-compensation-form/edit",
        element: (
            <ContextDataProvider>
                <WorkersCompensationDataProvider>
                    <WorkersCompensationFormEdit />
                </WorkersCompensationDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/commercial-auto-form/edit",
        element: (
            <ContextDataProvider>
                <CommercialAutoDataProvider>
                    <CommercialAutoFormEdit />
                </CommercialAutoDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/excess-liability-form/edit",
        element: (
            <ContextDataProvider>
                <ExcessLiabilityDataProvider>
                    <ExcessLiabilityFormEdit />
                </ExcessLiabilityDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/tools-equipment-form/edit",
        element: (
            <ContextDataProvider>
                <ToolsEquipmentDataProvider>
                    <ToolsEquipmentFormEdit />
                </ToolsEquipmentDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/builders-risk-form/edit",
        element: (
            <ContextDataProvider>
                <BuildersRiskDataProvider>
                    <BuildersRiskFormEdit />
                </BuildersRiskDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/business-owners-policy-form/edit",
        element: (
            <ContextDataProvider>
                <BusinessOwnersPolicyDataProvider>
                    <BusinessOwnersPolicyFormEdit />
                </BusinessOwnersPolicyDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/general-liabilities-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <GeneralLiabilitiesPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/workers-compensation-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <WorkersCompensationPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/commercial-auto-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <CommercialAutoPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/excess-liability-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <ExcessLiabilityPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/tools-equipment-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <ToolsEquipmentPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/builders-risk-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <BuildersRiskPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "/business-owners-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <BusinessOwnersPolicyPrevious />
            </ContextDataProvider>
        ),
    },
    {
        path: "*",
        element: <div>404</div>,
    },
]);

export default router;
