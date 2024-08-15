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
import { GeneralLiabilitiesPreviousDataContext } from "./contexts/general-liabilities-previous-data-context.jsx";
import GeneralLiabilitiPreviousData from "./data/general-liabilities-previous-data.jsx";
import GeneralLiabilitiesPreviousDataProvider from "./providers/general-liabilities-previous-provider.jsx";
import WorkersCompensationPreviousDataProvider from "./providers/workers-compensation-previous-data-provider.jsx";
import CommercialAutoPreviousDataProvider from "./providers/commercial-auto-previous-data-provider.jsx";
import ExcessLiabilityPreviousDataProvider from "./providers/excess-liability-previous-data-provider.jsx";
import ToolsEquipmentPreviousDataProvider from "./providers/tools-equipment-previous-data-provider.jsx";
import BuildersRiskPreviousDataProvider from "./providers/builders-risk-previous-data-provider.jsx";
import BusinessOwnersPreviousDataProvider from "./providers/business-owners-previous-data-provider.jsx";

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
                <GeneralLiabilitiesPreviousDataProvider>
                    <GeneralLiabilitiesPrevious />
                </GeneralLiabilitiesPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/workers-compensation-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <WorkersCompensationPreviousDataProvider>
                    <WorkersCompensationPrevious />
                </WorkersCompensationPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/commercial-auto-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <CommercialAutoPreviousDataProvider>
                    <CommercialAutoPrevious />
                </CommercialAutoPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/excess-liability-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <ExcessLiabilityPreviousDataProvider>
                    <ExcessLiabilityPrevious />
                </ExcessLiabilityPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/tools-equipment-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <ToolsEquipmentPreviousDataProvider>
                    <ToolsEquipmentPrevious />
                </ToolsEquipmentPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/builders-risk-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <BuildersRiskPreviousDataProvider>
                    <BuildersRiskPrevious />
                </BuildersRiskPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "/business-owners-form/previous-product-information",
        element: (
            <ContextDataProvider>
                <BusinessOwnersPreviousDataProvider>
                    <BusinessOwnersPolicyPrevious />
                </BusinessOwnersPreviousDataProvider>
            </ContextDataProvider>
        ),
    },
    {
        path: "*",
        element: <div>404</div>,
    },
]);

export default router;
